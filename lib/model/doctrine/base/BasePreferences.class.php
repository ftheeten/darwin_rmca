<?php

/**
 * BasePreferences
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $pref_key
 * @property string $pref_value
 * @property integer $user_ref
 * @property Users $User
 * 
 * @method integer     getId()         Returns the current record's "id" value
 * @method string      getPrefKey()    Returns the current record's "pref_key" value
 * @method string      getPrefValue()  Returns the current record's "pref_value" value
 * @method integer     getUserRef()    Returns the current record's "user_ref" value
 * @method Users       getUser()       Returns the current record's "User" value
 * @method Preferences setId()         Sets the current record's "id" value
 * @method Preferences setPrefKey()    Sets the current record's "pref_key" value
 * @method Preferences setPrefValue()  Sets the current record's "pref_value" value
 * @method Preferences setUserRef()    Sets the current record's "user_ref" value
 * @method Preferences setUser()       Sets the current record's "User" value
 * 
 * @package    darwin
 * @subpackage model
 * @author     DB team <darwin-ict@naturalsciences.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePreferences extends DarwinModel
{
    public function setTableDefinition()
    {
        $this->setTableName('preferences');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('pref_key', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('pref_value', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('user_ref', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Users as User', array(
             'local' => 'user_ref',
             'foreign' => 'id'));
    }
}