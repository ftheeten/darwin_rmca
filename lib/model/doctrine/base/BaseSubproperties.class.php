<?php

/**
 * BaseSubProperties
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property Doctrine_Collection $Specimens
 * @property Doctrine_Collection $SpecimensStoragePartsView
 * 
 * @method Doctrine_Collection getSpecimens()                 Returns the current record's "Specimens" collection
 * @method Doctrine_Collection getSpecimensStoragePartsView() Returns the current record's "SpecimensStoragePartsView" collection
 * @method SubProperties       setSpecimens()                 Sets the current record's "Specimens" collection
 * @method SubProperties       setSpecimensStoragePartsView() Sets the current record's "SpecimensStoragePartsView" collection
 * 
 * @package    darwin
 * @subpackage model
 * @author     DB team <darwin-ict@naturalsciences.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSubProperties extends Properties
{
    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Specimens', array(
             'local' => 'record_id',
             'foreign' => 'id'));

        $this->hasMany('SpecimensStoragePartsView', array(
             'local' => 'record_id',
             'foreign' => 'id'));
    }
}