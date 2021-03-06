<?php

/**
 * SpecimensRelationshipsTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class SpecimensRelationshipsTable extends DarwinTable
{
  /**
  * Returns an instance of this class.
  *
  * @return object SpecimensRelationshipsTable
  */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('SpecimensRelationships');
  }

  /**
  * Get Distincts Forms
  * @return array an Array of forms in keys
  */
  public function getDistinctType()
  {
    return $this->createFlatDistinct('specimens_relationships', 'relationship_type', 'relationship_type')->execute();
  }

  public function findBySpecimen($spec_id)
  {
    $q = Doctrine_Query::create()->
         from('SpecimensRelationships')->
         where('specimen_ref = ?', $spec_id);
    return $q->execute();
  }

  public function findByRelatedSpecimenRef($spec_id){
    $q = Doctrine_Query::create()->
         from('SpecimensRelationships')->
         where('unit_type= ? ', 'specimens')->
         andWhere('specimen_related_ref = ?', $spec_id);
    return $q->execute();
  }
  
  public function getAllRelated($spec_id)
  {
	  
	  $conn = Doctrine_Manager::connection();
		$q = $conn->prepare("SELECT id  FROM fct_rmca_look_related_specimens(:id)");
		 $q->bindParam(":id", $spec_id, PDO::PARAM_INT);
		$q->execute();
		$items=$q->fetchAll(PDO::FETCH_NUM);
		
		return $items;
  }
}