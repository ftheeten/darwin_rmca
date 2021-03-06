<?php

/**
 * BaseImports
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $filename
 * @property integer $user_ref
 * @property string $format
 * @property integer $collection_ref
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property integer $initial_count
 * @property boolean $is_finished
 * @property string $errors_in_import
 * @property string $template_version
 * @property boolean $exclude_invalid_entries
 * @property string $taxonomy_name
 * @property boolean $is_reference_taxonomy
 * @property string $source_taxonomy
 * @property string $creation_date
 * @property integer $creation_date_mask
 * @property string $definition_taxonomy
 * @property string $url_website_taxonomy
 * @property string $url_webservice_taxonomy
 * @property integer $specimen_taxonomy_ref
 * @property boolean $working
 * @property string $mime_type
 * @property string $taxonomy_kingdom
 * @property boolean $merge_gtu
 * @property Collections $Collections
 * @property Users $Users
 * @property Doctrine_Collection $Staging
 * @property Doctrine_Collection $StagingCatalogue
 * 
 * @method integer             getId()                      Returns the current record's "id" value
 * @method string              getFilename()                Returns the current record's "filename" value
 * @method integer             getUserRef()                 Returns the current record's "user_ref" value
 * @method string              getFormat()                  Returns the current record's "format" value
 * @method integer             getCollectionRef()           Returns the current record's "collection_ref" value
 * @method string              getState()                   Returns the current record's "state" value
 * @method string              getCreatedAt()               Returns the current record's "created_at" value
 * @method string              getUpdatedAt()               Returns the current record's "updated_at" value
 * @method integer             getInitialCount()            Returns the current record's "initial_count" value
 * @method boolean             getIsFinished()              Returns the current record's "is_finished" value
 * @method string              getErrorsInImport()          Returns the current record's "errors_in_import" value
 * @method string              getTemplateVersion()         Returns the current record's "template_version" value
 * @method boolean             getExcludeInvalidEntries()   Returns the current record's "exclude_invalid_entries" value
 * @method string              getTaxonomyName()            Returns the current record's "taxonomy_name" value
 * @method boolean             getIsReferenceTaxonomy()     Returns the current record's "is_reference_taxonomy" value
 * @method string              getSourceTaxonomy()          Returns the current record's "source_taxonomy" value
 * @method string              getCreationDate()            Returns the current record's "creation_date" value
 * @method integer             getCreationDateMask()        Returns the current record's "creation_date_mask" value
 * @method string              getDefinitionTaxonomy()      Returns the current record's "definition_taxonomy" value
 * @method string              getUrlWebsiteTaxonomy()      Returns the current record's "url_website_taxonomy" value
 * @method string              getUrlWebserviceTaxonomy()   Returns the current record's "url_webservice_taxonomy" value
 * @method integer             getSpecimenTaxonomyRef()     Returns the current record's "specimen_taxonomy_ref" value
 * @method boolean             getWorking()                 Returns the current record's "working" value
 * @method string              getMimeType()                Returns the current record's "mime_type" value
 * @method string              getTaxonomyKingdom()         Returns the current record's "taxonomy_kingdom" value
 * @method boolean             getMergeGtu()                Returns the current record's "merge_gtu" value
 * @method Collections         getCollections()             Returns the current record's "Collections" value
 * @method Users               getUsers()                   Returns the current record's "Users" value
 * @method Doctrine_Collection getStaging()                 Returns the current record's "Staging" collection
 * @method Doctrine_Collection getStagingCatalogue()        Returns the current record's "StagingCatalogue" collection
 * @method Imports             setId()                      Sets the current record's "id" value
 * @method Imports             setFilename()                Sets the current record's "filename" value
 * @method Imports             setUserRef()                 Sets the current record's "user_ref" value
 * @method Imports             setFormat()                  Sets the current record's "format" value
 * @method Imports             setCollectionRef()           Sets the current record's "collection_ref" value
 * @method Imports             setState()                   Sets the current record's "state" value
 * @method Imports             setCreatedAt()               Sets the current record's "created_at" value
 * @method Imports             setUpdatedAt()               Sets the current record's "updated_at" value
 * @method Imports             setInitialCount()            Sets the current record's "initial_count" value
 * @method Imports             setIsFinished()              Sets the current record's "is_finished" value
 * @method Imports             setErrorsInImport()          Sets the current record's "errors_in_import" value
 * @method Imports             setTemplateVersion()         Sets the current record's "template_version" value
 * @method Imports             setExcludeInvalidEntries()   Sets the current record's "exclude_invalid_entries" value
 * @method Imports             setTaxonomyName()            Sets the current record's "taxonomy_name" value
 * @method Imports             setIsReferenceTaxonomy()     Sets the current record's "is_reference_taxonomy" value
 * @method Imports             setSourceTaxonomy()          Sets the current record's "source_taxonomy" value
 * @method Imports             setCreationDate()            Sets the current record's "creation_date" value
 * @method Imports             setCreationDateMask()        Sets the current record's "creation_date_mask" value
 * @method Imports             setDefinitionTaxonomy()      Sets the current record's "definition_taxonomy" value
 * @method Imports             setUrlWebsiteTaxonomy()      Sets the current record's "url_website_taxonomy" value
 * @method Imports             setUrlWebserviceTaxonomy()   Sets the current record's "url_webservice_taxonomy" value
 * @method Imports             setSpecimenTaxonomyRef()     Sets the current record's "specimen_taxonomy_ref" value
 * @method Imports             setWorking()                 Sets the current record's "working" value
 * @method Imports             setMimeType()                Sets the current record's "mime_type" value
 * @method Imports             setTaxonomyKingdom()         Sets the current record's "taxonomy_kingdom" value
 * @method Imports             setMergeGtu()                Sets the current record's "merge_gtu" value
 * @method Imports             setCollections()             Sets the current record's "Collections" value
 * @method Imports             setUsers()                   Sets the current record's "Users" value
 * @method Imports             setStaging()                 Sets the current record's "Staging" collection
 * @method Imports             setStagingCatalogue()        Sets the current record's "StagingCatalogue" collection
 * 
 * @package    darwin
 * @subpackage model
 * @author     DB team <darwin-ict@naturalsciences.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseImports extends DarwinModel
{
    public function setTableDefinition()
    {
        $this->setTableName('imports');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('filename', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('user_ref', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('format', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('collection_ref', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('state', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'to_be_loaded',
             ));
        $this->hasColumn('created_at', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('updated_at', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('initial_count', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('is_finished', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('errors_in_import', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('template_version', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('exclude_invalid_entries', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('taxonomy_name', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('is_reference_taxonomy', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));
        $this->hasColumn('source_taxonomy', 'string', null, array(
             'type' => 'string',
             'notnull' => false,
             ));
        $this->hasColumn('creation_date', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('creation_date_mask', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('definition_taxonomy', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('url_website_taxonomy', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('url_webservice_taxonomy', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('specimen_taxonomy_ref', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('working', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('mime_type', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('taxonomy_kingdom', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('merge_gtu', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Collections', array(
             'local' => 'collection_ref',
             'foreign' => 'id'));

        $this->hasOne('Users', array(
             'local' => 'user_ref',
             'foreign' => 'id'));

        $this->hasMany('Staging', array(
             'local' => 'id',
             'foreign' => 'import_ref'));

        $this->hasMany('StagingCatalogue', array(
             'local' => 'id',
             'foreign' => 'import_ref'));
    }
}