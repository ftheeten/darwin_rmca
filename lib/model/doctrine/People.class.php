<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class People extends BasePeople
{
  private static $type = array(
      'author' => 'Author',
      'identifier' => 'Identifier',
      'expert' => 'Expert',
      'collector' => 'Collector',
      'preparator' => 'Preparator',
      'donator' => 'Donator',
      'member' => 'Expedition member'
  );

  
  public static function getTypes()
  {
    try{
        $i18n_object = sfContext::getInstance()->getI18n();
    }
    catch( Exception $e )
    {
        return self::$type;
    }
    return array_map(array($i18n_object, '__'), self::$type);
  }  

  public function __toString()
  {
    return $this->getFormatedName();
  }

  public function setBirthDate($fd)
  {
     if(is_string($fd))
     {
      $this->_set('birth_date',$fd);
     }
     elseif ($fd instanceof FuzzyDateTime)
     {
      $this->_set('birth_date', $fd->format('Y/m/d'));
      $this->_set('birth_date_mask', $fd->getMask());
     }
     else
     {
      $dateTime = new FuzzyDateTime($fd, 56, false); 
      $this->_set('birth_date', $dateTime->format('Y/m/d'));
      $this->_set('birth_date_mask', $dateTime->getMask());
     }
     return $this;
  }


  public function setEndDate($fd)
  {
     if(is_string($fd))
     {
      $this->_set('end_date',$fd);
     }
     elseif ($fd instanceof FuzzyDateTime)
     {
      $this->_set('end_date', $fd->format('Y/m/d'));
      $this->_set('end_date_mask', $fd->getMask());
     }
     else
     {
      $dateTime = new FuzzyDateTime($fd, 56, false); 
      $this->_set('end_date', $dateTime->format('Y/m/d'));
      $this->_set('end_date_mask', $dateTime->getMask());
     }
     return $this;
  }

  public function getEndDateObject()
  {
    $date = new FuzzyDateTime($this->_get('end_date'),$this->_get('end_date_mask'),true);
    return $date;
  }

  public function getBirthDateObject()
  {
    $date = new FuzzyDateTime($this->_get('birth_date'),$this->_get('birth_date_mask'),true);
    return $date;
  }
 
  public function getBirthDateMasked($tag='em')
  {
    return $this->getBirthDateObject()->getDateMasked($tag);
  }
 
  public function getEndDateMasked($tag='em')
  {
    return $this->getEndDateObject()->getDateMasked($tag);
  }

  public function getBirthDate()
  {
    return $this->getBirthDateObject()->getDateTimeMaskedAsArray();
  }

  public function getEndDate()
  {
    return $this->getEndDateObject()->getDateTimeMaskedAsArray();
  }


  public function setActivityDateFrom($fd)
  {
     if(is_string($fd))
     {
      $this->_set('activity_date_from',$fd);
     }
     elseif ($fd instanceof FuzzyDateTime)
     {
      $this->_set('activity_date_from', $fd->format('Y/m/d'));
      $this->_set('activity_date_from_mask', $fd->getMask());
     }
     else
     {
      if(empty($fd['day']) && empty($fd['month']) && empty($fd['year'])) return ;
      $dateTime = new FuzzyDateTime($fd, 56, false); 
      $this->_set('activity_date_from', $dateTime->format('Y/m/d'));
      $this->_set('activity_date_from_mask', $dateTime->getMask());
     }
  }


  public function setActivityDateTo($fd)
  {
     if(is_string($fd))
     {
      $this->_set('activity_date_to',$fd);
     }
     elseif ($fd instanceof FuzzyDateTime)
     {
      $this->_set('activity_date_to', $fd->format('Y/m/d'));
      $this->_set('activity_date_to_mask', $fd->getMask());
     }
     else
     {
      if(empty($fd['day']) && empty($fd['month']) && empty($fd['year'])) return ;     
      $dateTime = new FuzzyDateTime($fd, 56, false); 
      $this->_set('activity_date_to', $dateTime->format('Y/m/d'));
      $this->_set('activity_date_to_mask', $dateTime->getMask());
     }
  }
 
  public function getActivityDateToObject()
  {
    $date = new FuzzyDateTime($this->_get('activity_date_to'),$this->_get('activity_date_to_mask'),true);
    return $date;
  }

  public function getActivityDateFromObject()
  {
    $date = new FuzzyDateTime($this->_get('activity_date_from'),$this->_get('activity_date_from_mask'),true);
    return $date;
  }

  public function getActivityDateFromMasked($tag='em')
  {
    return $this->getActivityDateFromObject()->getDateMasked($tag);
  }

  public function getActivityDateToMasked($tag='em')
  {
    return $this->getActivityDateToObject()->getDateMasked($tag);
  }

  public function getActivityDateFrom()
  {
    return $this->getActivityDateFromObject()->getDateTimeMaskedAsArray();
  }

  public function getActivityDateTo()
  {
    return $this->getActivityDateToObject()->getDateTimeMaskedAsArray();
  }
  
  public function getCorrespondingImage()
  {
    if(!$this->getIsPhysical()) return "user_suit_moral.png" ;
    if($this->getGender() == 'M') return "user_suit_m.png" ;
    return "user_suit_f.png" ;
  }
  
  //jim 2018 03 37
  public function getCorrespondingInstitutionandAddress()
  {
	$conn = Doctrine_Manager::connection();
	$sql = "select * from fct_rmca_instit_address_from_loan_actor(:id)";
	$q = $conn->prepare($sql);
	$q->execute(array(':id' => $this->getId()));
	return json_encode($q->fetchAll());	  
	
	
  }
}
