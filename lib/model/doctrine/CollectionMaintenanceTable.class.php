<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CollectionMaintenanceTable extends DarwinTable
{
  public function getDistinctActions()
  {
    return $this->createFlatDistinct('collection_maintenance', 'action_observation', 'action')->execute();
  }
  
  /**
  * Get Number of maintenances for an array of records
  * @param $table Referenced relation
  * @param $ids array of ids
  * @return array with count and record_id in keys
  */
  public function getCountRelated($table, $ids)
  {
    $q = Doctrine_Query::create()->
 		select('COUNT(m.id) AS cnt, m.record_id')->
		from('CollectionMaintenance m')->
		where('m.referenced_relation = ?', $table)->
		andWhereIn('m.record_id', $ids)->
		groupBy('m.referenced_relation, m.record_id');
    return $q->execute(array(), Doctrine_Core::HYDRATE_NONE);
  }

  /**
  * Get Related maintenances for a record
  * @param table the referenced relation
  * @param $ids array of refereced id
  * @return Doctrine_Collection of Maintenances
  */
  public function getRelatedArray($table, $ids = array())
  {
    if(!is_array($ids))
      $ids = array($ids);
    if(empty($ids)) return array();
    $q = Doctrine_Query::create()->
         from('CollectionMaintenance m')->
         leftJoin('m.People')->
         where('referenced_relation = ?', $table)->
         andWhereIn('record_id', $ids)->
         orderBy('referenced_relation ASC, record_id ASC, modification_date_time DESC, id ASC');
    return $q->execute();
  }

  public function getMergedMaintenances($table, $id)
  { 
    if($table == 'loans')
    {
      $sql = "SELECT * , exists( select 1 from multimedia where referenced_relation='collection_maintenance' and record_id = cm.id) as with_multimedia
        FROM collection_maintenance cm where referenced_relation='loans' and record_id = :id 

      UNION ALL

      SELECT * , exists( select 1 from multimedia where referenced_relation='collection_maintenance' and record_id = cm.id) as with_multimedia
        FROM collection_maintenance cm where referenced_relation='loan_items' and 
          record_id in (select id from loan_items where loan_ref = :id)
      ORDER BY modification_date_time DESC
      ";
      $conn_MGR = Doctrine_Manager::connection();
      $conn = $conn_MGR->getDbh();
      $statement = $conn->prepare($sql);
      $statement->execute(array(':id' => $id));
      $res = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    if($table == 'loan_items')
    {
      $sql = "SELECT * , exists( select 1 from multimedia where referenced_relation='collection_maintenance' and record_id = cm.id) as with_multimedia
        FROM collection_maintenance cm where referenced_relation='loans' and record_id = (select loan_ref from loan_items where id = :id) 

      UNION ALL

      SELECT * , exists( select 1 from multimedia where referenced_relation='collection_maintenance' and record_id = cm.id) as with_multimedia
        FROM collection_maintenance cm where referenced_relation='loan_items' and 
          record_id = :id
      ORDER BY modification_date_time DESC
      ";
      $conn_MGR = Doctrine_Manager::connection();
      $conn = $conn_MGR->getDbh();
      $statement = $conn->prepare($sql);
      $statement->execute(array(':id' => $id));
      $res = $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    $array_results = array();
    foreach($res as $item)
    {
      $m = new CollectionMaintenance();
      $m->hydrate($item);
      $array_results[] = $m;
    }
    return $array_results;
  }
  
  public function getStagingIds($id)
  {
     $q = Doctrine_Query::create()->
         from('CollectionMaintenance')->
         where('referenced_relation = \'staging\'')->
         andWhere('record_id = ?', $id);
    $result = $q->execute(); 
    $maintenance_ids = array() ;
    foreach($result as $maintenance) $maintenance_ids[] = $maintenance->getId() ;
    return $maintenance_ids ;
  }
  
  public function UpdatePeopleRef($people)
  {
      $q = Doctrine_Query::create()
      ->update('CollectionMaintenance c')
      ->set('c.people_ref',$people['people_ref'])
      ->where('s.id = ?',$people['record_id']) ;
    return $q->execute() ;
      $q = Doctrine_Query::create()
      ->delete('Stagin')
      ->set('c.people_ref',$people['people_ref'])
      ->where('s.id = ?',$people['record_id']) ;
    return $q->execute() ;
  }
}