<?php

/**
 * Imports form.
 *
 * @package    darwin
 * @subpackage form
 * @author     DB team <darwin-ict@naturalsciences.be>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ImportsForm extends BaseImportsForm
{
  public function configure()
  {    
  //ftheeten july 2017 (fixed january 2018)
    if($this->options['format'] == 'taxon')
    {
     //$this->useFields(array('format', 'exclude_invalid_entries', 'taxonomy_name', 'creation_date', 'is_reference_taxonomy', 'source_taxonomy', 'definition_taxonomy', 'url_website_taxonomy', 'url_webservice_taxonomy')) ;
     $this->useFields(array('format', 'exclude_invalid_entries', 'specimen_taxonomy_ref')) ;
      $category = array('taxon'=>$this->getI18N()->__('Taxonomy')) ;
      $this->widgetSchema['exclude_invalid_entries'] = new sfWidgetFormChoice(
        array(
          'choices'=>array(true=>$this->getI18N()->__('No'),false=>$this->getI18N()->__('Yes')),
          'multiple'=>false,
          'expanded'=>true,
        )
      );
      
      //ftheeten 2018 03 06
       $this->widgetSchema['specimen_taxonomy_ref']=new sfWidgetFormChoice(array(
      'choices' =>  TaxonomyMetadataTable::getAllTaxonomicMetadata('taxonomy_name ASC', false)
    ));
         
    }
    else
    {
      $this->useFields(array('collection_ref', 'format','merge_gtu')) ;
      /* Collection Reference */
      $this->widgetSchema['collection_ref'] = new widgetFormButtonRef(
        array(
          'model' => 'Collections',
          'link_url' => 'collection/choose',
          'method' => 'getName',
          'box_title' => $this->getI18N()->__('Choose'),
          'button_class'=>'',
        ),
        array(
          'class'=>'inline',
        )
      );
      $category = imports::getFormats();
      $this->validatorSchema['collection_ref'] = new sfValidatorInteger(array('required'=>true));
      
      //ftheeeten 2017 08 02
      $this->widgetSchema['specimen_taxonomy_ref'] =new sfWidgetFormChoice(array(
      //'choices' => array_merge( array(''=>'All'), TaxonomyMetadataTable::getAllTaxonomicMetadata())
      'choices' =>  TaxonomyMetadataTable::getAllTaxonomicMetadata('id ASC', true)
        ));
      $this->validatorSchema['specimen_taxonomy_ref'] = new sfValidatorInteger(array('required'=>false));
      
      //2019 12 16
      $this->widget_schema['merge_gtu'] = new sfWidgetFormInputCheckbox();
      $this->validatorSchema['merge_gtu'] = new sfValidatorBoolean (array('required'=>false));
    
    }
    $this->widgetSchema['uploadfield'] = new sfWidgetFormInputFile(array(),array('id'=>'uploadfield'));
    //$allowed_types = array('text/xml','application/xml') ;
    //ftheeten 2017 09 07
    $allowed_types = array('text/xml','application/xml', 'text/plain') ;
    $this->widgetSchema['format'] = new sfWidgetFormChoice(
      array(
        'choices' => $category
      )
    );

    /* Labels */
    $this->widgetSchema->setLabels(array(
      'collection_ref' => 'Collection',
      'uploadfield' => 'File',
      'format' => 'Format',
      'exclude_invalid_entries' => 'Match invalid Units',
    ));

    $this->validatorSchema['format'] = new sfValidatorChoice(
      array('choices'=> array_keys($category)
    ));    
    $this->validatorSchema['uploadfield'] = new xmlFileValidator(
      array(
        'xml_path_file'=>$this->options['format'] == 'taxon'?'/xsd/taxonomy.xsd':'/xsd/ABCD_2.06_EFGDNA.XSD',
        'required' => true,
        'mime_types' => $allowed_types,
        'validated_file_class' => 'myValidatedFile',
    ));
	
	  //ftheeeten 2018 06 06
      $this->widgetSchema['taxonomy_kingdom'] =new sfWidgetFormChoice(array(
      
      'choices' =>  TaxonomyTable::getTaxaByLevel("2", true)
        ));
      $this->validatorSchema['taxonomy_kingdom'] = new sfValidatorInteger(array('required'=>false));
    
    //ftheeten 2017 09 13
     $this->mergePostValidator(new sfValidatorCallback(
			array('callback' => array($this, 'setValidatorSetMimeType'))));

    
  }
  
  //ftheeten 2017 09 13
  public function setValidatorSetMimeType($validator, $values, $arguments)
  {
    $tmpFile=$values["uploadfield"];
    print($tmpFile);
      //ftheeten 2018 02 22
    if(is_object($tmpFile))
    {
     if($tmpFile->getType()) 
     {
         $this->getObject()->setMimeType($tmpFile->getType());
     }
    }
     return $values;
  }
		
}
