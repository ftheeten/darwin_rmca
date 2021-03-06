<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CatalogueLevelsTable extends DarwinTable
{
  //ftheeten 2018 03 14 added sort order
  public function getLevelsByTypes(array $parameters, $q = null)
  {
    if (is_null($q))
    {
      $q = Doctrine_Query::create()
	 ->from('CatalogueLevels cl');
    }
    if (isset($parameters['level']) && $parameters['level'] != '')
    {
      $q->innerJoin('cl.PossibleUpperLevels pul ON cl.id = pul.level_upper_ref')
        ->addWhere('pul.level_ref = ?', $parameters['level']);
    }
    if (isset($parameters['table']))
    {
      $q->addWhere('cl.level_type = ?', $parameters['table']);
    }
    //ftheeten 2018 03 14
    $orderBy='cl.id';
    if( isset($parameters['sort']))
    {
        if(strtolower($parameters['sort'])=="desc")
        {
            $q->addOrderBy('cl.id DESC') ;
        }
    }

   $q->addOrderBy($orderBy) ;
    
    return $q->execute();
  }
}
