<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Codes extends BaseCodes
{
  private static $category = array('main'=> 'Main',
				 'additional id' => 'Addition.',
                 'secondary' => 'Second.',
                 'temporary' => 'Temp.',
                 'inventory'=> 'Invent.'
                );

   //ftheeten 2018 06 14 (add all)
  public static function getCategories($add_all=false)
  {
    try{
        $i18n_object = sfContext::getInstance()->getI18n();
    }
    catch( Exception $e )
    {
        return self::$category;
    }
	if(!$add_all)
	{
		return array_map(array($i18n_object, '__'), self::$category);
	}
	else
	{
		return array_map(array($i18n_object, '__'), array_merge( array("all"=>"All"), self::$category));
		
	}	
  }  
  
  public function getCodeFormated()
  {
    $code_prefix = $this->_get('code_prefix');
    $code_prefix_separator = (strlen($this->_get('code_prefix_separator')))?$this->_get('code_prefix_separator'):' ';
    $code = (strlen($this->_get('code')))?$this->_get('code'):'-';
    $code_suffix = $this->_get('code_suffix');
    $code_suffix_separator = (strlen($this->_get('code_suffix_separator')))?$this->_get('code_suffix_separator'):' ';

    if (strlen($code_prefix))
      $code_prefix .= $code_prefix_separator;

    if (strlen($code_suffix))
      $code_suffix = $code_suffix_separator.$code_suffix;

    return $code_prefix.$code.$code_suffix;
  }
}
