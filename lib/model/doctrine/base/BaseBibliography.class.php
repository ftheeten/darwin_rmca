<?php

/**
 * BaseBibliography
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $title
 * @property string $title_indexed
 * @property string $type
 * @property string $abstract
 * @property integer $year
 * @property string $reference
 * @property string $doi
 * @property CataloguePeople $CataloguePeople
 * @property Doctrine_Collection $CatalogueBibliography
 * 
 * @method integer             getId()                    Returns the current record's "id" value
 * @method string              getTitle()                 Returns the current record's "title" value
 * @method string              getTitleIndexed()          Returns the current record's "title_indexed" value
 * @method string              getType()                  Returns the current record's "type" value
 * @method string              getAbstract()              Returns the current record's "abstract" value
 * @method integer             getYear()                  Returns the current record's "year" value
 * @method string              getReference()             Returns the current record's "reference" value
 * @method string              getDoi()                   Returns the current record's "doi" value
 * @method CataloguePeople     getCataloguePeople()       Returns the current record's "CataloguePeople" value
 * @method Doctrine_Collection getCatalogueBibliography() Returns the current record's "CatalogueBibliography" collection
 * @method Bibliography        setId()                    Sets the current record's "id" value
 * @method Bibliography        setTitle()                 Sets the current record's "title" value
 * @method Bibliography        setTitleIndexed()          Sets the current record's "title_indexed" value
 * @method Bibliography        setType()                  Sets the current record's "type" value
 * @method Bibliography        setAbstract()              Sets the current record's "abstract" value
 * @method Bibliography        setYear()                  Sets the current record's "year" value
 * @method Bibliography        setReference()             Sets the current record's "reference" value
 * @method Bibliography        setDoi()                   Sets the current record's "doi" value
 * @method Bibliography        setCataloguePeople()       Sets the current record's "CataloguePeople" value
 * @method Bibliography        setCatalogueBibliography() Sets the current record's "CatalogueBibliography" collection
 * 
 * @package    darwin
 * @subpackage model
 * @author     DB team <darwin-ict@naturalsciences.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBibliography extends DarwinModel
{
    public function setTableDefinition()
    {
        $this->setTableName('bibliography');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('title', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('title_indexed', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('type', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('abstract', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('year', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('reference', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('doi', 'string', null, array(
             'type' => 'string',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('CataloguePeople', array(
             'local' => 'id',
             'foreign' => 'record_id'));

        $this->hasMany('CatalogueBibliography', array(
             'local' => 'id',
             'foreign' => 'bibliography_ref'));
    }
}