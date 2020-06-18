<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PeopleLanguagesTable extends DarwinTable
{
    public function removeOldPreferredLang($user_id)
    {
	$q = Doctrine_Query::create()
            ->update('PeopleLanguages')
            ->set('preferred_language','?',false)
            ->addWhere('people_ref = ?', $user_id);
      return $q->execute();
    }

  public function fetchByPeople($id)
  {
    $q = Doctrine_Query::create()
	  ->from('PeopleLanguages r')
	  ->where('r.people_ref = ?',$id)
	  ->orderBy('r.language_country ASC');
    return $q->execute();
  }
}