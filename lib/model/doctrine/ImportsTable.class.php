<?php

/**
 * ImportsTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ImportsTable extends Doctrine_Table
{
  /**
    * Returns an instance of this class.
    *
    * @return object ImportsTable
    */
  public static function getInstance()
  {
      return Doctrine_Core::getTable('Imports');
  }

  public function markOk($id)
  {
    //print("\n MARK OK \n");
    //print($id);
    $conn = Doctrine_Manager::connection();
    $prepared_sql = $conn->prepare("UPDATE staging s1
                                    SET to_import = TRUE
                                    WHERE status = ''
                                      AND import_ref = ?"
    );
    //print("AAAAAA");
    //$debug=Doctrine_Core::getTable('Imports')->findOneById($id);
    //print($debug->getState());
    $prepared_sql->execute(array(intval($id)));
    $q = Doctrine_Query::create()->update('Imports');
    $q->andwhere('id = ? ',$id)
      ->set('state', '?','processing')
      ->execute();
      // print("BBBBB");
         //$debug=Doctrine_Core::getTable('Imports')->findOneById($id);
    //print($debug->getState());
  }

  public function getNumberOfLines($record_ids)
  {
    if(! count($record_ids)) return array();
    $conn = Doctrine_Manager::connection();
    $ids_list_as_string = implode(',',$record_ids);
    $result = $conn->fetchAssoc("SELECT import_ref as id, COUNT(*) as cnt
                                  FROM staging r
                                  WHERE import_ref = ANY('{ $ids_list_as_string }'::int[])
                                  GROUP BY import_ref");
    return $result;
  }

  /**
   * Clear a given import
   * @param integer $id Id of import to clear
   */
  public function clearImport($id)
  {
    Doctrine_Query::create()->Delete('staging s')
      ->andwhere('import_ref = ? ',$id)
      ->execute();
    Doctrine_Query::create()->update('Imports')
      ->andwhere('id = ? ',$id)
      ->set('state', '?','aborted')
      ->set('is_finished', '?',true)
      ->execute();
  }

  public function getWithImports($id, $mode="AND")
  {    
  
    $q = Doctrine_Query::create()
      ->From('Imports i')
     //->andwhere('exists(select 1 from staging where to_import = true and import_ref = i.id)')
	  //ftheeten 2017 09 30
	  ->andwhere('exists(select 1 from staging where import_ref = i.id)')
      ;
    if(!empty($id) && ctype_digit($id) && $id > 0) 
	{
	  if($mode=="OR")
	  {
		  $q->andWhere("i.id = ?", $id);
	  }
	  else
      {
		 $q->andWhere("state = 'aprocessing'")->andWhere("i.id = ?", $id);
      }
	}

    return $q->execute();
  }


  // function used by check import task to flag the state of checked line to avoid twice check
  public function tagProcessing($state, $id)
  {
    $q =  Doctrine_Query::create()->from('Imports i') ;
    if($state == 'taxon')
    {
      $q->andwhere('i.format = \'taxon\'')
        ->andWhere("state = ?",'loaded');
    }
    else
    {
      $q->andwhere('i.format = \'abcd\'')
        ->andWhereIn("state",$state);
    }

    // If specific id is passed, restrict the retrieval of imports and set of imports state to the selected one
    if(!empty($id) && ctype_digit($id) && $id > 0) {
      $q->andWhere("i.id = ?", $id);
    }

    $items = $q->execute();

    $ids = $items->toKeyValueArray("id", "id");
    
    if(count($ids))
    {
      $ids_list_as_string = implode(',', $ids);
      $conn = Doctrine_Manager::connection();
      $conn->exec("UPDATE imports
                   SET state = CASE
                                WHEN state='loaded' THEN 'aloaded'
                                WHEN state='processing' THEN 'aprocessing'
                                ELSE 'apending'
                               END
                   WHERE id = ANY('{ $ids_list_as_string }'::int[])"
      );
    }

    // Return the items object retrieved
    return $items;
  }
  
  public function updateStatus($id)
  {
    Doctrine_Query::create()
      ->update('Imports i')
      ->set('state', '?','loaded')
      ->update('Imports i')
      ->andwhere('id = ? ',$id)
      ->execute() ;
  }
  
      //2019 03 14
    public function updateGtuInStaging($import_ref, $old_gtu_code, $new_gtu_id)
    {
        
        Doctrine_Query::create()
              ->update('imports p')
              ->set('p.state','?','aprocessing')
               ->where('p.id = ? ', $import_ref)
              ->execute();     
        $conn = Doctrine_Manager::connection();
        $sql = "UPDATE staging set gtu_ref=:new, status = status - 'gtu'::text  WHERE import_ref =:import AND gtu_code= :old;";
        $q = $conn->prepare($sql);
		$q->execute(array(':import'=> $import_ref, ':old' => $old_gtu_code, ':new' => $new_gtu_id ));
        
        Doctrine_Query::create()
              ->update('imports p')
              ->set('p.state','?','pending')
               ->where('p.id = ? ', $import_ref)
              ->execute();
	     
    }
}