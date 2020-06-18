<?php

/**
 * StagingPeopleTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class StagingPeopleTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object StagingPeopleTable
   */
  public static function getInstance()
  {
      return Doctrine_Core::getTable('StagingPeople');
  }

  public function getPeopleInError($staging_ref,$type)
  {
    // if $staging ref is an array, then it's an list of identification
    switch ($type)
    {
      case "identification" : $relation = 'identifications' ; break ;;
      case "maintenance" : $relation = "collection_maintenance" ; break ;;
      case "relationship" : $relation = "staging_relationship" ; break ;;
      default : $relation = "staging" ; break ;;
    }
    $q = Doctrine_Query::create()
      ->from('StagingPeople s')
      ->where('s.referenced_relation = ?',$relation) 
      ->addWhere('s.people_ref is null') ;
    if(is_array($staging_ref)) $q->andWhereIn('s.record_id',$staging_ref) ;
    else $q->addWhere('s.record_id = ?',$staging_ref) ;
    return $q->execute() ;
  }

  public function UpdatePeopleRef($people)
  {
    if($people['people_ref'] != -1)
    {
      $q = Doctrine_Query::create()
        ->update('StagingPeople s')
        ->set('s.people_ref',$people['people_ref'])
        ->where('s.id = ?',$people['id']) ;
    }
    else
    {
      $q = Doctrine_Query::create()
        ->delete('StagingPeople s')
        ->where('s.id = ?',$people['id']) ;
    }
    return $q->execute() ;
  }
}