<?php

/**
 * SpecimensFlat filter form.
 *
 * @package    darwin
 * @subpackage filter
 * @author     DB team <darwin-ict@naturalsciences.be>
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
 
 class SpecimensFormFilter extends BaseSpecimensFormFilter
{
  public function configure()
  {
    $this->with_group = false;
    $this->useFields(array('gtu_code','gtu_from_date','gtu_to_date', 'taxon_level_ref', 'litho_name', 'litho_level_ref', 'litho_level_name', 'chrono_name', 'chrono_level_ref',
        'chrono_level_name', 'lithology_name', 'lithology_level_ref', 'lithology_level_name', 'mineral_name', 'mineral_level_ref',
        'mineral_level_name','ig_num','acquisition_category','acquisition_date',
        //ftheeten 2018 04 10
        'ig_ref',
		//JMherpers 2019 04 25
		'nagoya',
        'import_ref'
        ));

    $this->addPagerItems();

    $this->widgetSchema['gtu_code'] = new sfWidgetFormInputText();
    //$this->widgetSchema['expedition_name'] = new sfWidgetFormInputText(array(), array('class'=>'medium_size'));
	//ftheeten 2015 10 22
	    //expedition widget
    $this->widgetSchema['expedition_ref'] = new widgetFormButtonRef(array(
	  'label'=> $this->getI18N()->__('Choose Expedition'),
      'model' => 'Expeditions',
      'link_url' => 'expedition/choose',
      'method' => 'getName',
      'box_title' => $this->getI18N()->__('Choose Expedition'),
      'nullable' => true,
      'button_class'=>'',
       ),
      array('class'=>'inline',)
    );
	
	
    $this->widgetSchema['taxon_name'] = new sfWidgetFormInputText(array(), array('class'=>'medium_size'));
    $this->widgetSchema['taxon_level_ref'] = new sfWidgetFormDarwinDoctrineChoice(array(
        'model' => 'CatalogueLevels',
        'table_method' => array('method'=>'getLevelsByTypes','parameters'=>array(array('table'=>'taxonomy'))),
        'add_empty' => $this->getI18N()->__('All')
      )
      ,
      //ftheeten 2017 06 26
      array('class'=>'taxon_level_ref')
      );
    $rel = array('child'=>'Is a Child Of','direct_child'=>'Is a Direct Child','synonym'=> 'Is a Synonym Of', 'equal' => 'Is strictly equal to');

    //$this->widgetSchema['taxon_relation'] = new sfWidgetFormChoice(array('choices'=> $rel,'expanded'=> true));
//ftheeten 2016 03 24
$this->widgetSchema['taxon_relation'] = new sfWidgetFormChoice(array('choices'=> $rel,'expanded'=> true, 'multiple'=>true));

    $this->widgetSchema['taxon_relation']->setDefault('child');
    $this->widgetSchema['taxon_item_ref'] = new widgetFormCompleteButtonRef(array(
      'model' => 'Taxonomy',
      'method' => 'getName',
      'link_url' => 'taxonomy/choose',
      'box_title' => $this->getI18N()->__('Choose Taxon'),
      'button_is_hidden' => true,
      'complete_url' => 'catalogue/completeName?table=taxonomy&level=1',
      'nullable' => true
    ));

        //$this->validatorSchema['taxon_item_ref'] = new sfValidatorInteger(array('required'=>false));
    //ftheeten 2018 10 01 for double taxonomies
    $this->validatorSchema['taxon_item_ref'] = new sfValidatorString(array('required'=>false));
    
    //$this->validatorSchema['taxon_relation'] = new sfValidatorChoice(array('required'=>false, 'choices'=> array_keys($rel)));
//ftheeten 2016 03 24
$this->validatorSchema['taxon_relation'] = new sfValidatorChoice(array('required'=>false, 'choices'=> array_keys($rel), 'multiple'=>true));

    $this->widgetSchema['lithology_relation'] = new sfWidgetFormChoice(array('choices'=> $rel,'expanded'=> true));
    $this->widgetSchema['lithology_item_ref'] = new widgetFormCompleteButtonRef(array(
      'model' => 'Lithology',
      'link_url' => 'lithology/choose',
      'method' => 'getName',
      'box_title' => $this->getI18N()->__('Choose Lithologic unit'),
      'button_is_hidden' => true,
      'complete_url' => 'catalogue/completeName?table=lithology',
      'nullable' => true,
      ));

    $this->validatorSchema['lithology_item_ref'] = new sfValidatorInteger(array('required'=>false));
    $this->validatorSchema['lithology_relation'] = new sfValidatorChoice(array('required'=>false, 'choices'=> array_keys($rel)));
    $this->widgetSchema['lithology_relation']->setDefault('child');


    $this->widgetSchema['lithology_name'] = new sfWidgetFormInputText(array(), array('class'=>'medium_size'));
    $this->widgetSchema['lithology_level_ref'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'CatalogueLevels',
      'table_method' => array('method'=>'getLevelsByTypes','parameters'=>array(array('table'=>'lithology'))),
      'add_empty' => $this->getI18N()->__('All')
    ));

    $this->widgetSchema['litho_name'] = new sfWidgetFormInputText(array(), array('class'=>'medium_size'));
    $this->widgetSchema['litho_level_ref'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'CatalogueLevels',
      'table_method' => array('method'=>'getLevelsByTypes','parameters'=>array(array('table'=>'lithostratigraphy'))),
      'add_empty' => $this->getI18N()->__('All')
    ));

    $this->widgetSchema['litho_relation'] = new sfWidgetFormChoice(array('choices'=> $rel,'expanded'=> true));
    $this->widgetSchema['litho_relation']->setDefault('child');
    $this->widgetSchema['litho_item_ref'] = new widgetFormCompleteButtonRef(array(
      'model' => 'Lithostratigraphy',
      'link_url' => 'lithostratigraphy/choose',
      'method' => 'getName',
      'box_title' => $this->getI18N()->__('Choose Lithostratigraphic unit'),
      'button_is_hidden' => true,
      'complete_url' => 'catalogue/completeName?table=lithostratigraphy',
      'nullable' => true,
      ));

    $this->validatorSchema['litho_item_ref'] = new sfValidatorInteger(array('required'=>false));
    $this->validatorSchema['litho_relation'] = new sfValidatorChoice(array('required'=>false, 'choices'=> array_keys($rel)));

    $this->widgetSchema['chrono_name'] = new sfWidgetFormInputText(array(), array('class'=>'medium_size'));
    $this->widgetSchema['chrono_level_ref'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'CatalogueLevels',
      'table_method' => array('method'=>'getLevelsByTypes','parameters'=>array(array('table'=>'chronostratigraphy'))),
      'add_empty' => $this->getI18N()->__('All')
    ));

    $this->widgetSchema['chrono_relation'] = new sfWidgetFormChoice(array('choices'=> $rel,'expanded'=> true));
    $this->widgetSchema['chrono_relation']->setDefault('child');

    $this->widgetSchema['chrono_item_ref'] = new widgetFormCompleteButtonRef(array(
      'model' => 'Chronostratigraphy',
      'link_url' => 'chronostratigraphy/choose',
      'method' => 'getName',
      'box_title' => $this->getI18N()->__('Choose Chronostratigraphic unit'),
      'nullable' => true,
      'button_is_hidden' => true,
      'complete_url' => 'catalogue/completeName?table=chronostratigraphy',
      'button_class'=>'',
     ));

    $this->validatorSchema['chrono_item_ref'] = new sfValidatorInteger(array('required'=>false));
    $this->validatorSchema['chrono_relation'] = new sfValidatorChoice(array('required'=>false, 'choices'=> array_keys($rel)));


    $this->widgetSchema['mineral_name'] = new sfWidgetFormInputText(array(), array('class'=>'medium_size'));
    $this->widgetSchema['mineral_level_ref'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'CatalogueLevels',
      'table_method' => array('method'=>'getLevelsByTypes','parameters'=>array(array('table'=>'mineralogy'))),
      'add_empty' => $this->getI18N()->__('All')
    ));

    $this->widgetSchema['mineral_item_ref'] = new widgetFormCompleteButtonRef(array(
      'model' => 'Mineralogy',
      'link_url' => 'mineralogy/choose',
      'method' => 'getName',
      'box_title' => $this->getI18N()->__('Choose Mineralogic unit'),
      'nullable' => true,
      'button_is_hidden' => true,
      'complete_url' => 'catalogue/completeName?table=mineralogy',
      'button_class'=>'',
      ));

    $this->widgetSchema['mineral_relation'] = new sfWidgetFormChoice(array('choices'=> $rel,'expanded'=> true));
    $this->widgetSchema['mineral_relation']->setDefault('child');

    $this->validatorSchema['mineral_item_ref'] = new sfValidatorInteger(array('required'=>false));
    $this->validatorSchema['mineral_relation'] = new sfValidatorChoice(array('required'=>false, 'choices'=> array_keys($rel)));


    $minDate = new FuzzyDateTime(strval(min(range(intval(sfConfig::get('dw_yearRangeMin')), intval(sfConfig::get('dw_yearRangeMax')))).'/01/01'));
    $maxDate = new FuzzyDateTime(strval(max(range(intval(sfConfig::get('dw_yearRangeMin')), intval(sfConfig::get('dw_yearRangeMax')))).'/12/31'));
    $maxDate->setStart(false);
    $dateLowerBound = new FuzzyDateTime(sfConfig::get('dw_dateLowerBound'));
    $dateUpperBound = new FuzzyDateTime(sfConfig::get('dw_dateUpperBound'));
    $this->widgetSchema['ig_num'] = new sfWidgetFormInputText();
    $this->widgetSchema['ig_from_date'] = new widgetFormJQueryFuzzyDate(
      $this->getDateItemOptions(),
      array('class' => 'from_date')
    );

    $this->widgetSchema['ig_to_date'] = new widgetFormJQueryFuzzyDate(
      $this->getDateItemOptions(),
      array('class' => 'to_date')
    );

    $this->widgetSchema['ig_num']->setAttributes(array('class'=>'small_size'));
    $this->validatorSchema['ig_num'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['ig_from_date'] = new fuzzyDateValidator(array(
      'required' => false,
      'from_date' => true,
      'min' => $minDate,
      'max' => $maxDate,
      'empty_value' => $dateLowerBound,
      ),
      array('invalid' => 'Date provided is not valid',)
    );

    $this->validatorSchema['ig_to_date'] = new fuzzyDateValidator(array(
      'required' => false,
      'from_date' => false,
      'min' => $minDate,
      'max' => $maxDate,
      'empty_value' => $dateUpperBound,
      ),
      array('invalid' => 'Date provided is not valid',)
    );

    $this->validatorSchema->setPostValidator(new sfValidatorSchemaCompare(
      'ig_from_date',
      '<=',
      'ig_to_date',
      array('throw_global_error' => true),
      array('invalid'=>'The "begin" date cannot be above the "end" date.')
    ));


    $this->widgetSchema['col_fields'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['collection_ref'] = new sfWidgetCollectionList(array('choices' => array()));
    $this->widgetSchema['collection_ref']->addOption('public_only',false);
    $this->validatorSchema['collection_ref'] = new sfValidatorPass(); //Avoid duplicate the query
    $this->widgetSchema['spec_ids'] = new sfWidgetFormTextarea(array('label'=>"#ID list separated by ',' "));

    $this->validatorSchema['spec_ids'] = new sfValidatorString( array(
      'required' => false,
      'trim' => true
    ));

    $this->validatorSchema['col_fields'] = new sfValidatorString(array(
      'required' => false,
      'trim' => true
    ));

    $this->validatorSchema['gtu_code'] = new sfValidatorString(array(
      'required' => false,
      'trim' => true
    ));

    $this->validatorSchema['expedition_ref'] = new sfValidatorInteger(array(
      'required' => false,
    ));
	
    $this->validatorSchema['taxon_name'] = new sfValidatorString(array(
      'required' => false,
      'trim' => true
    ));

    $this->validatorSchema['taxon_level_ref'] = new sfValidatorInteger(array(
      'required' => false,
    ));

    $this->validatorSchema['chrono_name'] = new sfValidatorString(array(
      'required' => false,
      'trim' => true
    ));

    $this->validatorSchema['chrono_level_ref'] = new sfValidatorInteger(array(
      'required' => false,
    ));

    $this->validatorSchema['litho_name'] = new sfValidatorString(array(
      'required' => false,
      'trim' => true
    ));

    $this->validatorSchema['litho_level_ref'] = new sfValidatorInteger(array(
      'required' => false,
    ));

    $this->validatorSchema['lithology_name'] = new sfValidatorString(array(
      'required' => false,
      'trim' => true
    ));

    $this->validatorSchema['lithology_level_ref'] = new sfValidatorInteger(array(
      'required' => false,
    ));

    $this->validatorSchema['mineral_name'] = new sfValidatorString(array(
      'required' => false,
      'trim' => true
    ));

    $this->validatorSchema['mineral_level_ref'] = new sfValidatorInteger(array(
      'required' => false,
    ));

    $minDate = new FuzzyDateTime(strval(min(range(intval(sfConfig::get('dw_yearRangeMin')), intval(sfConfig::get('dw_yearRangeMax')))).'/01/01'));
    $maxDate = new FuzzyDateTime(strval(max(range(intval(sfConfig::get('dw_yearRangeMin')), intval(sfConfig::get('dw_yearRangeMax')))).'/12/31'));
    $maxDate->setStart(false);
    $dateLowerBound = new FuzzyDateTime(sfConfig::get('dw_dateLowerBound'));
    $dateUpperBound = new FuzzyDateTime(sfConfig::get('dw_dateUpperBound'));
    $this->widgetSchema['tags'] = new sfWidgetFormInputText();
    $this->widgetSchema['gtu_from_date'] = new widgetFormJQueryFuzzyDate(
      $this->getDateItemOptions(),
      array('class' => 'from_date')
    );

    $this->widgetSchema['gtu_to_date'] = new widgetFormJQueryFuzzyDate(
      $this->getDateItemOptions(),
      array('class' => 'to_date')
    );

    $this->validatorSchema['tags'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['gtu_from_date'] = new fuzzyDateValidator(array(
      'required' => false,
      'from_date' => true,
      'min' => $minDate,
      'max' => $maxDate,
      'empty_value' => $dateLowerBound,
      ),
      array('invalid' => 'Date provided is not valid',)
    );

    $this->validatorSchema['gtu_to_date'] = new fuzzyDateValidator(array(
      'required' => false,
      'from_date' => false,
      'min' => $minDate,
      'max' => $maxDate,
      'empty_value' => $dateUpperBound,
      ),
      array('invalid' => 'Date provided is not valid',)
    );
    
     $this->widgetSchema['gtu_from_precise'] = new sfWidgetFormInputCheckbox();//array('default' => FALSE));
	$this->widgetSchema['gtu_from_precise']->setAttributes(Array("class"=>"precise_gtu_date"));
    $this->validatorSchema['gtu_from_precise'] = new sfValidatorPass();
    
    //2019 02 25
    $this->widgetSchema['creation_from_date'] = new widgetFormJQueryFuzzyDate(
      $this->getDateItemOptions(),
      array('class' => 'from_date')
    );

    $this->widgetSchema['creation_to_date'] = new widgetFormJQueryFuzzyDate(
      $this->getDateItemOptions(),
      array('class' => 'to_date')
    );
    
     $this->validatorSchema['creation_from_date'] = new fuzzyDateValidator(array(
      'required' => false,
      'from_date' => true,
      'min' => $minDate,
      'max' => $maxDate,
      'empty_value' => $dateLowerBound,
      ),
      array('invalid' => 'Date provided is not valid',)
    );
    
    $this->validatorSchema['creation_to_date'] = new fuzzyDateValidator(array(
      'required' => false,
      'from_date' => false,
      'min' => $minDate,
      'max' => $maxDate,
      'empty_value' => $dateUpperBound,
      ),
      array('invalid' => 'Date provided is not valid',)
    );

    $subForm = new sfForm();
    $this->embedForm('Tags',$subForm);

    $this->widgetSchema['tools'] = new widgetFormSelectDoubleListFilterable(array(
      'choices' => new sfCallable(array(Doctrine::getTable('CollectingTools'),'fetchTools')),
      'label_associated'=>$this->getI18N()->__('Selected'),
      'label_unassociated'=>$this->getI18N()->__('Available')
    ));

    $this->widgetSchema['methods'] = new widgetFormSelectDoubleListFilterable(array(
      'choices' => new sfCallable(array(Doctrine::getTable('CollectingMethods'),'fetchMethods')),
      'label_associated'=>$this->getI18N()->__('Selected'),
      'label_unassociated'=>$this->getI18N()->__('Available')
    ));

    $this->validatorSchema['methods'] = new sfValidatorPass();
    $this->validatorSchema['tools'] = new sfValidatorPass();

    $this->widgetSchema['with_multimedia'] = new sfWidgetFormInputCheckbox();

    $this->validatorSchema['with_multimedia'] = new sfValidatorPass();
	
		//jmherpers 13/9/2019
    $this->widgetSchema['category']= new sfWidgetFormChoice(array(
        'choices' => array(NULL=>'','all'=>'all','document'=>'document','ext' => 'External', 'vc' => 'Virtual Collection',	'image_link'=>'image link', 
	'html_3d_snippet'=>'html 3d snippet' , 'thumbnail'=>'thumbnail', 'nagoya' => 'Nagoya' , 'cites'=>'CITES', 'acquisition'=>'Acquisition documents', 'ltp' => 'LTP' ),
    ));
	$this->validatorSchema['category'] = new sfValidatorString(array('trim'=>true, 'required'=>false));
	$this->widgetSchema['category']->setDefault(NULL);
	


    /* Acquisition categories */
    $this->widgetSchema['acquisition_category'] = new sfWidgetFormChoice(array(
      'choices' =>  array_merge(array('' => ''), SpecimensTable::getDistinctCategories()),
    ));

    $this->widgetSchema['acquisition_from_date'] = new widgetFormJQueryFuzzyDate(
      $this->getDateItemOptions(),
      array('class' => 'from_date')
    );

    $this->widgetSchema['acquisition_to_date'] = new widgetFormJQueryFuzzyDate(
      $this->getDateItemOptions(),
      array('class' => 'to_date')
    );

    $this->validatorSchema['acquisition_from_date'] = new fuzzyDateValidator(array(
      'required' => false,
      'from_date' => true,
      'min' => $minDate,
      'max' => $maxDate,
      'empty_value' => $dateLowerBound,
      ),
      array('invalid' => 'Date provided is not valid',)
    );

    $this->validatorSchema['acquisition_to_date'] = new fuzzyDateValidator(array(
      'required' => false,
      'min' => $minDate,
      'from_date' => false,
      'max' => $maxDate,
      'empty_value' => $dateUpperBound,
      ),
      array('invalid' => 'Date provided is not valid',)
    );
  /**
  * Individuals Fields
  */


    //ftheeten 2017 09 21
	$this->widgetSchema['type'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'Specimens',
      'table_method' => 'getDistinctTypesNoCombinations',
      'multiple' => true,
      'expanded' => true,
      'add_empty' => false,)
        //ftheeten 2018 09 27
      ,  array('class' => 'search_type_class'));
    $this->validatorSchema['type'] = new sfValidatorPass();

    $this->widgetSchema['sex'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'Specimens',
      'table_method' => 'getDistinctSexes',
      'multiple' => true,
      'expanded' => true,
      'add_empty' => false,
    ));
    $this->validatorSchema['sex'] = new sfValidatorPass();


    $this->widgetSchema['stage'] = new widgetFormSelectDoubleListFilterable(array(
      'choices' => new sfCallable(array(Doctrine::getTable('Specimens'),'getDistinctStages')),
      'label_associated'=>$this->getI18N()->__('Selected'),
      'label_unassociated'=>$this->getI18N()->__('Available')
    ));

    $this->validatorSchema['stage'] = new sfValidatorPass();

    $this->widgetSchema['status'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'Specimens',
      'table_method' => 'getDistinctStates',
      'multiple' => true,
      'expanded' => true,
      'add_empty' => false,
    ));
    $this->validatorSchema['status'] = new sfValidatorPass();

    $this->widgetSchema['social'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'Specimens',
      'table_method' => 'getDistinctSocialStatuses',
      'multiple' => true,
      'expanded' => true,
      'add_empty' => false,
    ));
    $this->validatorSchema['social'] = new sfValidatorPass();

    $this->widgetSchema['rockform'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'Specimens',
      'table_method' => 'getDistinctRockForms',
      'multiple' => true,
      'expanded' => true,
      'add_empty' => false,
    ));
    $this->validatorSchema['rockform'] = new sfValidatorPass();

    $this->widgetSchema['container'] = new sfWidgetFormInput();
    $this->validatorSchema['container'] = new sfValidatorString(array('required' => false));

    $this->widgetSchema['sub_container'] = new sfWidgetFormInput();
    $this->validatorSchema['sub_container'] = new sfValidatorString(array('required' => false));


/*pvignaux20160606*/
    $this->validatorSchema['container_storage'] = new sfValidatorString(array('required' => false));
       $this->widgetSchema['container_storage'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'StorageParts',
'add_empty'=> true,
        'table_method' => Array('method'=> 'createFlatDistinct', 'parameters'=>Array('storage_parts','container_storage', 'id'))
    ));

/*pvignaux20160606*/
    $this->validatorSchema['sub_container_storage'] = new sfValidatorString(array('required' => false));
       $this->widgetSchema['sub_container_storage'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'StorageParts',
'add_empty'=> true,
        'table_method' => Array('method'=> 'createFlatDistinct', 'parameters'=>Array('storage_parts','sub_container_storage', 'id'))
    ));

/*pvignaux20160606*/
    $this->validatorSchema['container_type'] = new sfValidatorString(array('required' => false));
       $this->widgetSchema['container_type'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'StorageParts',
'add_empty'=> true,
        'table_method' => Array('method'=> 'createFlatDistinct', 'parameters'=>Array('storage_parts','container_type', 'id'))
    ));

/*pvignaux20160606*/
    $this->validatorSchema['sub_container_type'] = new sfValidatorString(array('required' => false));
       $this->widgetSchema['sub_container_type'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'StorageParts',
'add_empty'=> true,
        'table_method' => Array('method'=> 'createFlatDistinct', 'parameters'=>Array('storage_parts','sub_container_type', 'id'))
    ));

/*ftheeten 2016 06 22*/
 $this->widgetSchema['specimen_count_min'] = new sfWidgetForminput();
 $this->widgetSchema['specimen_count_min']->setAttributes(array('class'=>'vvsmall_size'));
 $this->widgetSchema['specimen_count_min']->setLabel('Count (min)');
 $this->validatorSchema['specimen_count_min'] = new sfValidatorNumber(array('required'=>false,'min' => '0'));
 
  $this->widgetSchema['specimen_count_males_min'] = new sfWidgetForminput();
   $this->widgetSchema['specimen_count_males_min']->setAttributes(array('class'=>'vvsmall_size'));
 $this->widgetSchema['specimen_count_males_min']->setLabel('Count males (min)');
 $this->validatorSchema['specimen_count_males_min'] = new sfValidatorNumber(array('required'=>false,'min' => '0'));
 
   $this->widgetSchema['specimen_count_females_min'] = new sfWidgetForminput();
      $this->widgetSchema['specimen_count_females_min']->setAttributes(array('class'=>'vvsmall_size'));
 $this->widgetSchema['specimen_count_females_min']->setLabel('Count females (min)');
 $this->validatorSchema['specimen_count_females_min'] = new sfValidatorNumber(array('required'=>false,'min' => '0'));

   $this->widgetSchema['specimen_count_juveniles_min'] = new sfWidgetForminput();
      $this->widgetSchema['specimen_count_juveniles_min']->setAttributes(array('class'=>'vvsmall_size'));
 $this->widgetSchema['specimen_count_juveniles_min']->setLabel('Count juveniles (min)');
 $this->validatorSchema['specimen_count_juveniles_min'] = new sfValidatorNumber(array('required'=>false,'min' => '0'));
 
  $this->widgetSchema['specimen_count_max'] = new sfWidgetForminput();
 $this->widgetSchema['specimen_count_max']->setAttributes(array('class'=>'vvsmall_size'));
 $this->widgetSchema['specimen_count_max']->setLabel('Count (max)');
 $this->validatorSchema['specimen_count_max'] = new sfValidatorNumber(array('required'=>false,'min' => '0'));
 
  $this->widgetSchema['specimen_count_males_max'] = new sfWidgetForminput();
   $this->widgetSchema['specimen_count_males_max']->setAttributes(array('class'=>'vvsmall_size'));
 $this->widgetSchema['specimen_count_males_max']->setLabel('Count males (max)');
 $this->validatorSchema['specimen_count_males_max'] = new sfValidatorNumber(array('required'=>false,'min' => '0'));
 
   $this->widgetSchema['specimen_count_females_max'] = new sfWidgetForminput();
      $this->widgetSchema['specimen_count_females_max']->setAttributes(array('class'=>'vvsmall_size'));
 $this->widgetSchema['specimen_count_females_max']->setLabel('Count females (max)');
 $this->validatorSchema['specimen_count_females_max'] = new sfValidatorNumber(array('required'=>false,'min' => '0'));
 
    $this->widgetSchema['specimen_count_juveniles_max'] = new sfWidgetForminput();
      $this->widgetSchema['specimen_count_juveniles_max']->setAttributes(array('class'=>'vvsmall_size'));
 $this->widgetSchema['specimen_count_juveniles_max']->setLabel('Count juveniles (max)');
 $this->validatorSchema['specimen_count_juveniles_max'] = new sfValidatorNumber(array('required'=>false,'min' => '0'));
 //end group count

 /*ftheeten 2016 07 05*/
     $this->widgetSchema['ecology'] = new sfWidgetFormTextarea();
    $this->validatorSchema['ecology'] = new sfValidatorString(array('required' => false));
    
    /*$this->widgetSchema['specimen_part'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'StorageParts',
      'table_method' => 'getDistinctParts',
      'add_empty' => true,
    ));*/
    
      $this->widgetSchema['specimen_part'] = new sfWidgetFormInput(array(),array('style'=> 'width:97%;'));
	//ftheeten 2017 01 12
    $this->widgetSchema['specimen_part']->setAttributes(array('class'=>' autocomplete_for_parts'));
 
    $this->validatorSchema['specimen_part'] = new sfValidatorString(array('required' => false));



    $this->widgetSchema['object_name'] = new sfWidgetFormInput();
    $this->validatorSchema['object_name'] = new sfValidatorString(array('required' => false));

    $this->validatorSchema['floor'] = new sfValidatorString(array('required' => false));

    $this->widgetSchema['institution_ref'] = new widgetFormButtonRef(array(
      'model' => 'Institutions',
      'link_url' => 'institution/choose?with_js=1',
      'method' => 'getFamilyName',
      'box_title' => $this->getI18N()->__('Choose Institution'),
      'nullable' => true,
     ));
    $this->widgetSchema['institution_ref']->setLabel('Institution');

    $this->validatorSchema['institution_ref'] = new sfValidatorInteger(array('required' => false));

    //ftheeten 2016 09 28
     /*$this->widgetSchema['specimen_status'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'StorageParts',
      'table_method' => 'getDistinctSpecimenStatuses',
      'add_empty' => true,
    ));*/
     $this->widgetSchema['specimen_status'] = new sfWidgetFormInput(array(),array('style'=> 'width:97%;'));
	//ftheeten 2017 01 12
    $this->widgetSchema['specimen_status']->setAttributes(array('class'=>'class_rmca_input_mask autocomplete_for_status'));
    
     $this->validatorSchema['specimen_status'] = new sfValidatorString(array('required' => false));
    
    /*$this->widgetSchema['building'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'StorageParts',
      'table_method' => 'getDistinctBuildings',
      'add_empty' => true,
    ));*/
    
     $this->widgetSchema['building'] = new sfWidgetFormInput(array(),array('style'=> 'width:97%;'));
	//ftheeten 2017 01 12
    $this->widgetSchema['building']->setAttributes(array('class'=>'class_rmca_input_mask autocomplete_for_building'));
    
    //$this->widgetSchema['building'] =new sfWidgetFormInput();

    $this->validatorSchema['building'] = new sfValidatorString(array('required' => false));

    /*$this->widgetSchema['floor'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'Specimens',
      'table_method' => 'getDistinctFloors',
      'add_empty' => true,
    ));*/
        $this->widgetSchema['floor'] = new sfWidgetFormInput(array(),array('style'=> 'width:97%;'));
	//ftheeten 2017 01 12
    $this->widgetSchema['floor']->setAttributes(array('class'=>'class_rmca_input_mask autocomplete_for_floor'));
    $this->validatorSchema['floor'] = new sfValidatorString(array('required' => false));

    /*$this->widgetSchema['row'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'StorageParts',
      'table_method' => 'getDistinctRows',
      'add_empty' => true,
    ));*/
      $this->widgetSchema['row'] = new sfWidgetFormInput(array(),array('style'=> 'width:97%;'));
	//ftheeten 2017 01 12
    $this->widgetSchema['row']->setAttributes(array('class'=>'class_rmca_input_mask autocomplete_for_building'));
    $this->validatorSchema['row'] = new sfValidatorString(array('required' => false));

   /* $this->widgetSchema['col'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'StorageParts',
      'table_method' => 'getDistinctCols',
      'add_empty' => true,
    ));*/
    
    $this->widgetSchema['col'] = new sfWidgetFormInput(array(),array('style'=> 'width:97%;'));
   //ftheeten 2017 01 12
    $this->widgetSchema['col']->setAttributes(array('class'=>'class_rmca_input_mask autocomplete_for_col'));
    $this->validatorSchema['col'] = new sfValidatorString(array('required' => false));

    /*$this->widgetSchema['room'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'StorageParts',
      'table_method' => 'getDistinctRooms',
      'add_empty' => true,
    ));*/
     $this->widgetSchema['room'] = new sfWidgetFormInput(array(),array('style'=> 'width:97%;'));
   //ftheeten 2017 01 12
    $this->widgetSchema['room']->setAttributes(array('class'=>'class_rmca_input_mask autocomplete_for_room'));
    $this->validatorSchema['room'] = new sfValidatorString(array('required' => false));

    /*$this->widgetSchema['shelf'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'StorageParts',
      'table_method' => 'getDistinctShelfs',
      'add_empty' => true,
    ));*/
    
      $this->widgetSchema['shelf'] = new sfWidgetFormInput(array(),array('style'=> 'width:97%;'));
   //ftheeten 2017 01 12
    $this->widgetSchema['shelf']->setAttributes(array('class'=>'class_rmca_input_mask autocomplete_for_shelf'));
    $this->validatorSchema['shelf'] = new sfValidatorString(array('required' => false));

    $this->widgetSchema['property_type'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'Properties',
      'table_method' => array('method'=>'getDistinctType', 'parameters'=> array('specimens') ),
      'add_empty' => $this->getI18N()->__('All')
    ));
    $this->validatorSchema['property_type'] = new sfValidatorString(array('required' => false));


    $this->widgetSchema['property_applies_to'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'Properties',
      'table_method' => array('method'=>'getDistinctApplies', 'parameters'=> array() ),
      'add_empty' => $this->getI18N()->__('All')
    ));
    $this->validatorSchema['property_applies_to'] = new sfValidatorString(array('required' => false));

    $this->widgetSchema['property_value_from'] = new sfWidgetFormInput();
    $this->validatorSchema['property_value_from'] = new sfValidatorString(array('required' => false));

    $this->widgetSchema['property_value_to'] = new sfWidgetFormInput();
    $this->validatorSchema['property_value_to'] = new sfValidatorString(array('required' => false));

    //2019 03 29
	$this->widgetSchema['property_fuzzy'] = new sfWidgetFormInputCheckbox();//array('default' => FALSE));
  	////ftheeten 2015 09 09
	$this->validatorSchema['property_fuzzy'] = new sfValidatorPass();

    $this->widgetSchema['property_units'] = new sfWidgetFormDarwinDoctrineChoice(array(
      'model' => 'Properties',
      'table_method' => array('method' => 'getDistinctUnit', 'parameters' => array(/*$this->options['ref_relation']*/)),
      'add_empty' => true,
    ));
    $this->validatorSchema['property_units'] = new sfValidatorString(array('required' => false));


    $this->widgetSchema['comment'] = new sfWidgetFormInput();
    $this->validatorSchema['comment'] = new sfValidatorString(array('required' => false));

    $comment_choices = array(''=>'');
    $comment_choices = $comment_choices + CommentsTable::getNotionsFor('specimens');
    $this->widgetSchema['comment_notion_concerned'] = new sfWidgetFormChoice(array('choices'=> $comment_choices));
    $this->validatorSchema['comment_notion_concerned'] = new sfValidatorChoice(array('required'=>false, 'choices'=> array_keys($comment_choices)));
	
	 $this->validatorSchema['related_ref'] = new sfValidatorInteger(array('required'=>false));
	 $this->validatorSchema['related_ref'] = new sfValidatorNumber(array('required'=>false,'min' => '0'));


    $subForm = new sfForm();
    $this->embedForm('Codes',$subForm);

     // LAT LON
    $this->widgetSchema['lat_from'] = new sfWidgetForminput();
    $this->widgetSchema['lat_from']->setLabel('Latitude');
    $this->widgetSchema['lat_from']->setAttributes(array('class'=>'medium_small_size'));
    $this->widgetSchema['lat_to'] = new sfWidgetForminput();
    $this->widgetSchema['lat_to']->setAttributes(array('class'=>'medium_small_size'));
    $this->widgetSchema['lon_from'] = new sfWidgetForminput();
    $this->widgetSchema['lon_from']->setLabel('Longitude');
    $this->widgetSchema['lon_from']->setAttributes(array('class'=>'medium_small_size'));
    $this->widgetSchema['lon_to'] = new sfWidgetForminput();
    $this->widgetSchema['lon_to']->setAttributes(array('class'=>'medium_small_size'));
    


    $this->validatorSchema['lat_from'] = new sfValidatorNumber(array('required'=>false,'min' => '-180', 'max'=>'180'));
    $this->validatorSchema['lon_from'] = new sfValidatorNumber(array('required'=>false,'min' => '-360', 'max'=>'360'));
    $this->validatorSchema['lat_to'] = new sfValidatorNumber(array('required'=>false,'min' => '-180', 'max'=>'180'));
    $this->validatorSchema['lon_to'] = new sfValidatorNumber(array('required'=>false,'min' => '-360', 'max'=>'360'));
    
        //2019 03 29
	$this->widgetSchema['include_text_place'] = new sfWidgetFormInputCheckbox();//array('default' => FALSE));
  	////ftheeten 2015 09 09
	$this->validatorSchema['include_text_place'] = new sfValidatorPass();

     //ftheeten 2018 10 05
    $this->widgetSchema['wkt_search'] = new sfWidgetFormInputText();
    $this->widgetSchema['wkt_search']->setAttributes(array('class'=>'wkt_search'));
    $this->validatorSchema['wkt_search'] = new sfValidatorString(array('required' => false, 'trim' => true));
    
    sfWidgetFormSchema::setDefaultFormFormatterName('list');
    $this->widgetSchema->setNameFormat('specimen_search_filters[%s]');
    /* Labels */
    $this->widgetSchema->setLabels(array(
      'rockform' => 'Rock form',
      'gtu_code' => 'Sampling Location code',
      'taxon_name' => 'Taxon text search',
      'litho_name' => 'Litho text search',
      'lithology_name' => 'Lithology text search',
      'chrono_name' => 'Chrono text search',
      'mineral_name' => 'Mineralo text search',
      'taxon_level_ref' => 'Level',
      'code_ref_relation' => 'Code of',
      'people_ref' => 'Whom are you looking for',
      'role_ref' => 'Which role',
      'with_multimedia' => 'Search Only objects with multimedia files',
	  	  //jmherpers 13/9/2019
	  'category' => 'Search specimens with documents of type',
      'gtu_from_date' => 'Between',
      'gtu_to_date' => 'and',
      'acquisition_from_date' => 'Between',
      'acquisition_to_date' => 'and',
      'ig_from_date' => 'Between',
      'ig_to_date' => 'and',
      'ig_num' => 'I.G. unit',
      'property_type' => 'Type',
      'property_applies_to' => 'Applies to',
      'property_value_from' => 'From',
      'property_value_to' => 'To',
      'property_units' => 'Unit',
      'comment_notion_concerned' => 'Notion concerned',
    ));
		//ftheeten 2016 02 12 and JMHerpers 2018/02/02 for inversion OR/AND
	$this->widgetSchema['gtu_boolean'] = new sfWidgetFormChoice(array('choices' => array('OR' =>'OR', 'AND' => 'AND', )));
  	////ftheeten 2015 01 08
	$this->validatorSchema['gtu_boolean'] = new sfValidatorPass();
	
	//ftheeten 2015 01 08
	$this->widgetSchema['code_boolean'] = new sfWidgetFormChoice(array('choices' => array('OR' => 'OR', 'AND' => 'AND')));
  	////ftheeten 2015 01 08
	$this->validatorSchema['code_boolean'] = new sfValidatorPass();
	
	//ftheeten 2015 09 09
	$this->widgetSchema['code_exact_match'] = new sfWidgetFormInputCheckbox();//array('default' => FALSE));
  	////ftheeten 2015 09 09
	$this->validatorSchema['code_exact_match'] = new sfValidatorPass();
	
	//ftheeten 2016 01 08
	//$this->widgetSchema['gtu_exact_match'] = new sfWidgetFormInputCheckbox(array('default' => FALSE));
  	////ftheeten 2016 01 08
	//$this->validatorSchema['gtu_exact_match'] = new sfValidatorPass();
	

    // For compat only with old saved search
    // FIXME: might be removed with a migration
    $this->validatorSchema['what_searched'] = new sfValidatorPass();
	
    //ftheeten 2017 02 10
    $this->widgetSchema['valid_label'] = new sfWidgetFormChoice(array(
        'expanded' => true,
        'choices'  => array(True => 'true', False => 'false', NULL=>'both'),
       
        ), array( 'style' => "display: inline-block;text-align:center"));
    $this->validatorSchema['valid_label'] = new sfValidatorString(array('required' => false));
    
	
	//ftheeten 2015 10 23
	$this->widgetSchema['people_boolean'] = new sfWidgetFormChoice(array('choices' => array('OR' => 'OR', 'AND' => 'AND')));
  	////ftheeten 2015 10 23
	$this->validatorSchema['people_boolean'] = new sfValidatorPass();
	$subForm = new sfForm();
    $this->embedForm('Peoples',$subForm);
    
    //ftheeten 2017 04 27
    $this->widgetSchema['in_loan'] = new sfWidgetFormInputCheckbox();//array('default' => FALSE));
    //ftheeten 2017 04 27
	$this->validatorSchema['in_loan'] = new sfValidatorPass();
    //ftheeten 2017 04 27
    $this->widgetSchema['loan_is_closed'] = new sfWidgetFormChoice(array(
        'expanded' => true,
        'choices'  => array(True => 'true', False => 'false', NULL=>'both'),
       
        ), array( 'style' => "display: inline-block;text-align:center"));
    //ftheeten 2017 04 27
	$this->validatorSchema['loan_is_closed'] = new sfValidatorPass();
	
	//jmherpers 2019 04 26
	$this->widgetSchema['taxonomy_cites'] = new sfWidgetFormChoice(
		array(
			'expanded' => true,
			'choices'  => array(True => 'yes', False => 'no', NULL=>'yes or no')
		),
		array( 'style' => "display: inline-block;text-align:center")
	);
    $this->validatorSchema['taxonomy_cites'] = new sfValidatorString(array('required' => false));
	
	   //jmherpers 2019 04 26
    $this->widgetSchema['nagoya'] = new sfWidgetFormChoice(array(
        'expanded' => true,
        'choices'  => array('yes' => 'yes', 'no' => 'no', 'not defined'=>'not defined',NULL=>'yes or no or not defined'),
        ), array( 'style' => "display: inline-block;text-align:center"));
    $this->validatorSchema['nagoya'] = new sfValidatorString(array('required' => false));
    
    //ftheeten 2018 11 22
	$this->widgetSchema['codes_list'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['codes_list']->setAttributes(Array("class"=>"select2_code_values"));
    $this->validatorSchema['codes_list'] = new sfValidatorString(array('required' => false));
    $this->widgetSchema['exact_codes_list']=new sfWidgetFormInputCheckbox();   
    $this->widgetSchema['exact_codes_list']->setLabel("Fuzzy matching");
    $this->validatorSchema['exact_codes_list'] = new sfValidatorPass();
    $this->is_fuzzy_codes_list=false;
    $this->codeListCalled=false;
    
    //ftheeten 2018 11 26
	$this->widgetSchema['taxa_list'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['taxa_list']->setAttributes(Array("class"=>"select2_taxa_values"));
    $this->validatorSchema['taxa_list'] = new sfValidatorString(array('required' => false));
    $this->widgetSchema['taxa_list_placeholder'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['taxa_list_placeholder']->setAttributes(Array("class"=>"select2_taxa_list_placeholder"));
    $this->validatorSchema['taxa_list_placeholder'] = new sfValidatorString(array('required' => false));
    
    //ftheeten 2019 06 02
	 $this->widgetSchema['import_ref'] = new sfWidgetFormInputText(array(), array('class'=>'medium_size'));
	 $this->validatorSchema['import_ref'] = new sfValidatorString(array('required' => false));
    
  }

  public function addGtuTagValue($num)
  {
      $form = new TagLineForm(null,array('num'=>$num));
      $this->embeddedForms['Tags']->embedForm($num, $form);
      $this->embedForm('Tags', $this->embeddedForms['Tags']);
  }

  
    public function addPeopleValue($num)
  {
	 
      $form = new PeopleLineForm(null,array('num'=>$num));
      $this->embeddedForms['Peoples']->embedForm($num, $form);
      $this->embedForm('Peoples', $this->embeddedForms['Peoples']);
  }


  public function addCodeValue($num)
  {
      $form = new CodeLineForm();
      $this->embeddedForms['Codes']->embedForm($num, $form);
      $this->embedForm('Codes', $this->embeddedForms['Codes']);
  }
  public function addCommentsQuery($query, $notion, $comment)
  {
    if($notion != '' || $comment != '') {
      $query->innerJoin('s.SubComments c');
      // $query->andWhere("c.referenced_relation = ? ",'specimens');

      //$query->groupBy("s.id");

      if($notion != '')
        $query->andWhere('notion_concerned = ?', $notion ) ;
      if($comment != '')
        $query->andWhere('comment_indexed like concat(\'%\', fulltoindex(?), \'%\' )', $comment);
      $this->with_group = true;
    }
    return $query ;
  }
  
  
    //ftheeten 2018 11 22
  public function addCodesListColumnQuery($query, $fields, $val)
  {
        
                   
            if(strlen(trim($val))>0)
            {
                $sql_params=Array();
                $sql_parts=Array();
                $tmpCodes= preg_split( "/(;|\|)/", $val );
              
                foreach($tmpCodes as $to_search)
                {
                    if($this->is_fuzzy_codes_list)
                    {
                        $to_search="%".BaseSpecimensFormFilter::fulltoindex_sql($to_search)."%";
                        $sql_parts[]= "EXISTS(select 1 from codes where referenced_relation='specimens' and code_category='main' and record_id = s.id AND full_code_indexed LIKE ? ) ";
                    }
                    else
                    {
                        $sql_parts[]= "EXISTS(select 1 from codes where referenced_relation='specimens' and code_category='main' and record_id = s.id AND full_code_indexed like (SELECT  fulltoindex(?) )) ";
                    }
                    $sql_params[] =trim($to_search);
                }
                $sql=implode(" OR ", $sql_parts);
                $query->andWhere("(" .$sql.")", $sql_params);
            }
        
        return $query ;
  }
  


  public function addLatLonColumnQuery($query, $values)
  {
        //ftheeten 2018 03 02 !==
    if( isset($values['lat_from']) && isset($values['lon_from']) && isset($values['lon_to'])  && isset($values['lat_to']))
    {

        //ftheeten 2017 05 30
        
        $horizontal_box = "((-180, ".(float)$values['lat_from']."),(180, ".(float)$values['lat_to']."))";
      $vert_box = "((".(float)$values['lon_from'].",".(float)$values['lat_from']."),(".(float)$values['lon_to'].",".(float)$values['lat_to']."))";
      // Look for a wrapped box (ie. between RUSSIA and USA)
      if( (float)$values['lon_to'] < (float) $values['lon_from']) {

        $tmp="
         
          (  box('$horizontal_box') @> gtu_location AND NOT box('$vert_box') @> gtu_location
          )";
        

      } else {
        $tmp="
          
          (  box('$horizontal_box') @> gtu_location AND box('$vert_box') @> gtu_location
          )
        ";       
      }
        if(isset($values['include_text_place'])) 
        {
            if($values['include_text_place']==TRUE)
            {
               $tmp2=$this->addTagsColumn_text(   $values['Tags']);
               if(strlen($tmp2)>0)
             {
                $tmp= "((".$tmp.") OR (".$tmp2."))";
             }
            }
        }
      $query->andWhere($tmp);
      $query->whereParenWrap();
      $query->andWhere('gtu_location is not null');
    }
    
    //2018 10 05
    if( isset($values['wkt_search']))
    {
        if(strlen(trim($values['wkt_search'])))
        {
            $tmp="ST_INTERSECTS(ST_SETSRID(ST_Point(gtu_location[0], gtu_location[1]),4326), ST_GEOMFROMTEXT('".$values['wkt_search']."',4326))";
            if(isset($values['include_text_place'])) 
            {
                if($values['include_text_place']==TRUE)
                {
                    $tmp2=$this->addTagsColumn_text(  $values['Tags']);
                    if(strlen($tmp2)>0)
                    {
                    $tmp= "((".$tmp.") OR (".$tmp2."))";
                    }
                }
            }
            $query->andWhere($tmp);
        }
    }
    return $query;
  }

  public function addToolsColumnQuery($query, $field, $val)
  {
    if($val != '' && is_array($val) && !empty($val)) {
      $query->andWhere('s.id in (select fct_search_tools (?))',implode(',', $val));
    }
    return $query ;
  }

  public function addMethodsColumnQuery($query, $field, $val)
  {
    if($val != '' && is_array($val) && !empty($val)) {
      $query->andWhere('s.id in (select fct_search_methods (?))',implode(',', $val));
    }
    return $query ;
  }

  
   //ftheeten 2018 04 10
   public function addIgRefColumnQuery($query, $field, $values)
  {
    if ($values != "") {
      $conn_MGR = Doctrine_Manager::connection();
      $query->andWhere("s.ig_ref= ?" , $values);
    }
    return $query;
  }

  public function addIgNumColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if ($values != "") {
      $conn_MGR = Doctrine_Manager::connection();
      $query->andWhere("ig_num_indexed like fullToIndex(".$conn_MGR->quote($values, 'string').") ");
    }
    return $query;
  }

  public function checksToQuotedValues($val) {
    if($val == '') return ;
    if(! is_array($val))
      $val = array($val);
    $conn_MGR = Doctrine_Manager::connection();
    foreach($val as $k => $v)
      $val[$k] = $conn_MGR->quote($v, 'string');
    return $val;
  }

  public function addSexColumnQuery($query, $field, $val)
  {
    $val = $this->checksToQuotedValues($val);
    $query->andWhere('s.sex in ('.implode(',',$val).')');
    return $query ;
  }

//ftheeten 2017 09 21
  public function addTypeColumnQuery($query, $field, $val)
  {
    $criterias=Array();
     /*print_r($val);*/
     foreach($val as $tmpType)
     {
        
        $criterias[]=" s.type = '".$tmpType."' ";
     }
     $query->andWhere(implode(" OR ", $criterias));
    return $query ;
  }
  
  public function addStageColumnQuery($query, $field, $val)
  {
    $val = $this->checksToQuotedValues($val);
    $query->andWhere('s.stage in ('.implode(',',$val).')');
    return $query ;
  }

  public function addStatusColumnQuery($query, $field, $val)
  {
    $val = $this->checksToQuotedValues($val);
    $query->andWhere('s.state in ('.implode(',',$val).')');
    return $query ;
  }

  public function addSocialColumnQuery($query, $field, $val)
  {
    $val = $this->checksToQuotedValues($val);
    $query->andWhere('s.social_status in ('.implode(',',$val).')');
    return $query ;
  }

  public function addRockformColumnQuery($query, $field, $val)
  {
    $val = $this->checksToQuotedValues($val);
    $query->andWhere('s.rock_form in ('.implode(',',$val).')');
    return $query ;
  }

  /*public function addInstitutionRefColumnQuery($query, $field, $val)
  {
    if($val == '' &&  ! ctype_digit($val)) return ;
    $query->andWhere('p.institution_ref =  ?', $val);
    return $query ;
  }*/

  public function addContainerColumnQuery($query, $field, $val)
  {
    if(trim($val) != '') {
      $values = explode(' ',$val);
      $query_value = array();
      foreach($values as $value) {
        if(trim($value) != '')
          $query_value[] = '%'.$value.'%';
      }

      $query_array = array_fill(0,count($query_value),'container ilike ?');
      $query->andWhere( implode(' or ',$query_array) ,$query_value);
    }
    return $query ;
  }

  public function addSubContainerColumnQuery($query, $field, $val)
  {
    if(trim($val) != '') {
      $values = explode(' ',$val);
      $query_value = array();
      foreach($values as $value) {
        if(trim($value) != '')
          $query_value[] = '%'.strtolower($value).'%';
      }

      $query_array = array_fill(0,count($query_value),'p.sub_container ilike ?');
      $query->andWhere( implode(' or ',$query_array) ,$query_value);
    }
    return $query ;
  }


/*pvignaux20160606*/
 public function addContainerStorageColumnQuery($query, $field, $val)
  {
    if( $val != '' ) {
      $conn_MGR = Doctrine_Manager::connection();
      $val = $conn_MGR->quote($val, 'string');
      $query->andWhere('container_storage  = '.$val);
    }
    return $query ;
  }

/*pvignaux20160606*/
 public function addSubContainerStorageColumnQuery($query, $field, $val)
  {
    if( $val != '' ) {
      $conn_MGR = Doctrine_Manager::connection();
      $val = $conn_MGR->quote($val, 'string');
      $query->andWhere('sub_container_storage  = '.$val);
    }
    return $query ;
  }

/*pvignaux20160606*/
 public function addContainerTypeColumnQuery($query, $field, $val)
  {
    if( $val != '' ) {
      $conn_MGR = Doctrine_Manager::connection();
      $val = $conn_MGR->quote($val, 'string');
      $query->andWhere('container_type  = '.$val);
    }
    return $query ;
  }

/*pvignaux20160606*/
 /*public function addSubContainerTypeColumnQuery($query, $field, $val)
  {
    if( $val != '' ) {
      $conn_MGR = Doctrine_Manager::connection();
      $val = $conn_MGR->quote($val, 'string');
      $query->andWhere('p.sub_container_type  = '.$val);
    }
    return $query ;
  }
  */
 //ftheeten 2016 06 22
 public function addSpecimenCountMinColumnQuery($query, $field, $val)
 {
    if( $val != '' ) {
      $conn_MGR = Doctrine_Manager::connection();
      $query->andWhere('s.specimen_count_min  >= '.$val);
    }
    return $query ;
  }
  
   //ftheeten 2016 06 22
 public function addSpecimenCountMaxColumnQuery($query, $field, $val)
 {
    if( $val != '' ) {
      $conn_MGR = Doctrine_Manager::connection();
      $query->andWhere('s.specimen_count_min  <= '.$val);
    }
    return $query ;
  }
  
  //ftheeten 2016 06 22
 public function addSpecimenCountMalesMinColumnQuery($query, $field, $val)
 {
    if( $val != '' ) {
      $conn_MGR = Doctrine_Manager::connection();
      $query->andWhere('s.specimen_count_males_min  >= '.$val);
    }
    return $query ;
  }
  
   //ftheeten 2016 06 22
 public function addSpecimenCountMalesMaxColumnQuery($query, $field, $val)
 {
    if( $val != '' ) {
      $conn_MGR = Doctrine_Manager::connection();
      $query->andWhere('s.specimen_count_males_max  <= '.$val);
    }
    return $query ;
  }
  
    //ftheeten 2016 06 22
 public function addSpecimenCountFemalesMinColumnQuery($query, $field, $val)
 {
    if( $val != '' ) {
      $conn_MGR = Doctrine_Manager::connection();
      $query->andWhere('s.specimen_count_females_min  >= '.$val);
    }
    return $query ;
  }
  
   //ftheeten 2016 06 22
 public function addSpecimenCountFemalesMaxColumnQuery($query, $field, $val)
 {
    if( $val != '' ) {
      $conn_MGR = Doctrine_Manager::connection();
      $query->andWhere('s.specimen_count_females_max  <= '.$val);
    }
    return $query ;
  }
  
      //ftheeten 2016 06 22
 public function addSpecimenCountJuvenilesMinColumnQuery($query, $field, $val)
 {
    if( $val != '' ) {
      $conn_MGR = Doctrine_Manager::connection();
      $query->andWhere('s.specimen_count_juveniles_min  >= '.$val);
    }
    return $query ;
  }
  
   //ftheeten 2016 06 22
 public function addSpecimenCountJuvenilesMaxColumnQuery($query, $field, $val)
 {
    if( $val != '' ) {
      $conn_MGR = Doctrine_Manager::connection();
      $query->andWhere('s.specimen_count_juveniles_max  <= '.$val);
    }
    return $query ;
  }

  //ftheeten 2016 09 06  
  public function addEcologyQuery($query, $val)
  {
    if($val != '') {
      $query->innerJoin('s.SubComments c');
      $query->andWhere("c.referenced_relation = ? ",'specimens');

      //$query->groupBy("s.id");
  
        $query->andWhere('notion_concerned = ?', "ecology" ) ;
     
        $query->andWhere('comment_indexed like concat(\'%\', fulltoindex(?), \'%\' )', $val);
      $this->with_group = true;
    }
    return $query ;
  }
  
    //ftheeten 2017 07 24
  public function addInLoansQuery($query, $val)
  {
    if($val != '') {
      $query->innerJoin('s.LoanItems l');
      //$query->addWhere('in_loan=TRUE');
    }
    return $query ;
  }
  
      //ftheeten 2017 07 24
  public function addInClosedLoansQuery($query, $val)
  {
    if($val != '') {
      $query->innerJoin('s.LoanItems l1');
      //$query->andWhere('l.loan_ref NOT IN (SELECT l2.loan_ref FROM LoanStatus l2 WHERE l2.status =\'returned\')') ;
        if($val==1)
        {
            //true
            $query->andWhere('l1.loan_ref IN (SELECT l2.loan_ref FROM LoanStatus l2 WHERE l2.status =\'closed\')') ;
        }
        else
        {
           //false
            $query->andWhere('l1.loan_ref NOT IN (SELECT l2.loan_ref FROM LoanStatus l2 WHERE l2.status =\'closed\')') ;
        }
    
    }
    return $query ;
  }
  
  
  //ftheeten 2017 02 13
   public function addValidLabelQuery($query, $val)
 {
    if( $val != '' ) {
        if($val==1)
        {
            $val="TRUE";
            $conn_MGR = Doctrine_Manager::connection();
            $query->andWhere('s.valid_label  = '.$val);
        }
        else
        {
            $val="FALSE";
            $conn_MGR = Doctrine_Manager::connection();
            $query->andWhere('s.valid_label  = '.$val);
        }
          
        }
    return $query ;
  }
  


  public function addTagsColumn($query, $field, $val)
  {
    $conn_MGR = Doctrine_Manager::connection();
    $tagList = '';
    $whereArray=array();
    $goWhere=false;
     $tmpStr=Array();
    foreach($val as $line)
    {
      $line_val = $line['tag'];
      if( $line_val != '')
      {
        //$tagList = $conn_MGR->quote($line_val, 'string');
        $tagList=trim($line_val);
        $tagList=trim($tagList, ";");
       
        foreach(explode(";", $tagList  ) as $tagvalue)
        {
            if(strlen($tagvalue)>0)
            {
                $tagvalue = $conn_MGR->quote($tagvalue, 'string');
                $tmpStr[]="(
                        
                        EXISTS(SELECT s.id FROM Tags t where t.tag_indexed ~fulltoindex($tagvalue, true) and t.gtu_ref=s.gtu_ref) 
                      )";
         
            }
            $goWhere=true;
        } 
          
      }
    }
    if(count($tmpStr)>0)
    {
        $query->andWhere("(".implode(" ".$this->gtu_boolean." ",$tmpStr).") AND (s.station_visible = true 
												   OR (s.station_visible = false AND s.collection_ref in (".implode(',',$this->consultation_collection).")))");      
    }
    
    return $query ;
  }
  
    public function addTagsColumn_text( $val)
  {
    $returned="";
    $conn_MGR = Doctrine_Manager::connection();
    $tagList = '';
    $whereArray=array();
    $goWhere=false;
     $tmpStr=Array();
    foreach($val as $line)
    {
      $line_val = $line['tag'];
      if( $line_val != '')
      {
       
        $tagList=trim($line_val);
        $tagList=trim($tagList, ";");
       
        foreach(explode(";", $tagList  ) as $tagvalue)
        {
            if(strlen($tagvalue)>0)
            {
                $tagvalue = $conn_MGR->quote($tagvalue, 'string');
                $tmpStr[]="(
                        
                        EXISTS(SELECT s.id FROM Tags t where t.tag_indexed ~fulltoindex($tagvalue, true) and t.gtu_ref=s.gtu_ref) 
                      )";
         
            }
            $goWhere=true;
        } 
          
      }
    }
    if(count($tmpStr)>0)
    {
        $returned="(".implode(" ".$this->gtu_boolean." ",$tmpStr).") AND (s.station_visible = true 
												   OR (s.station_visible = false AND s.collection_ref in (".implode(',',$this->consultation_collection).")))";      
    }
    
    return $returned ;
  }

  //ftheeten 2015 10 22
    public function addPeoplesColumnQuery($query, $field, $val)
  {

    
	$queriesPeople=Array();
	$array_peoples=array();
    foreach($val as $i=>$people)
    {
		$query_people="";
	  if(empty($people)) continue;
	   if ($people['people_ref'] != '')
		{

			
			$query_people=$this->addPeopleSearchColumnQuerySQL( $people['people_ref'], $people['role_ref'], $i);
			$queriesPeople[]=$query_people;
			
		}
		if ($people['people_fuzzy'] != '') 
		{

			$iParams=0;
			$query_people=$this->addPeopleSearchColumnQueryFuzzySQL( $people['people_fuzzy'], $people['role_ref'], $i, $iParams);
			$queriesPeople[]=$query_people;
			for($iP=0; $iP<$iParams;$iP++)
			{
				$array_peoples[]=$people['people_fuzzy'];
			}
		}
		
		
    }
	if(count($queriesPeople)>0)
	{
		$query->andWhere("(".implode(" ".$this->people_boolean. " ", $queriesPeople).")",$array_peoples);
    }
    return $query ;
  }
  


 public function addCodesColumnQuery($query, $field, $val)
 {
	$sqlElems = Array();
    $sqlParams = Array() ;
	 foreach($val as $i => $code)
    {   
        $sql="";
        if(array_key_exists('code_from', $code)&&array_key_exists('code_to', $code))
        {
            if(ctype_digit($code['code_from']) && ctype_digit($code['code_to'])) 
            {
              $sql = "EXISTS(select 1 from codes where  referenced_relation='specimens' and record_id = s.id AND  code_num BETWEEN ? AND ?";
              $sqlParams[]=$code['code_from'];
              $sqlParams[]=$code['code_to'];
              if($code['category']  != '' && strtolower($code['category'])  != 'all') 
                {
                    
                        $sql .= " AND code_category = ?";
                         $sqlParams[]=$code['category'];
                }
                
                if($code['code_prefix']  != '')
                {
                     $sql .= " AND full_code_indexed LIKE (SELECT fulltoindex(?)||'%')";
                     $sqlParams[]=$code['code_prefix'];
                }
                 $sql .= ")";
                 
             
            }
		}
        if(array_key_exists('code_part', $code))
        {           
            if($code['code_part']  != '')
            {
                $sql ="EXISTS(select 1 from codes where  referenced_relation='specimens' and record_id = s.id AND full_code_indexed like (SELECT fulltoindex(?))";
                $sqlParams[]=$code['code_part'];
                if($code['category']  != '' && strtolower($code['category'])  != 'all') 
                {
                    
                        $sql .= " AND code_category = ?";
                        $sqlParams[]=$code['category'];
                }
                 $sql .= ")";
            }
            if(strlen($sql)>0)
            {
             $sqlElems[]= $sql ;
            }
        }
    }
	if(count($sqlElems)>0)
	{
		if($this->code_boolean=='OR')
		{
			$query->andWhere("(".implode(" OR ", $sqlElems).")",$sqlParams);
		}
		else
		{			
			$query->andWhere("(".implode(" AND ", $sqlElems).")",$sqlParams);
		}
		
	}
	return $query;
	 
 }

  public function addGtuCodeColumnQuery($query, $field, $val)
  {
    if($val != '')
    {
      $query->andWhere("
        (station_visible = true AND  LOWER(gtu_code) like LOWER(?) )
        OR
        (station_visible = false AND s.collection_ref in (".implode(',',$this->consultation_collection).")
          AND LOWER(gtu_code) like LOWER(?) )", array('%'.$val.'%','%'.$val.'%'));
      $query->whereParenWrap();
    }
    return $query ;
  }
  
  

  public function addSpecIdsColumnQuery($query, $field, $val)
  {
    $ids = explode(',', $val);
    $clean_ids =array();
    foreach($ids as $id)
    {
      $id=trim($id);
      if(ctype_digit($id))
        $clean_ids[] = $id;
      elseif(ctype_digit(substr($id,1, strlen($id))))
        $clean_ids[] = substr($id,1, strlen($id));
    }

    if(! empty($clean_ids)) {
      $query->andWhereIn("s.id", $clean_ids);
    }
    return $query ;
  }

  /*public function addPeopleSearchColumnQuery(Doctrine_Query $query, $people_id, $field_to_use, $alias_id=NULL, $boolean="AND")
  {
	$alias1="cp";

	if($alias_id)
	{
		$alias1=$alias1.$alias_id;

	}
    $build_query = '';
    if(! is_array($field_to_use) || count($field_to_use) < 1)
      $field_to_use = array('ident_ids','spec_coll_ids','spec_don_sel_ids') ;

	$nb2=0;  
    foreach($field_to_use as $field)
    {
       $alias1=$alias1.$nb2;

	  if($field == 'ident_ids')
      {
		$build_query .= "s.spec_ident_ids @> ARRAY[$people_id]::int[] OR " ;
      }
      elseif($field == 'spec_coll_ids')
      {
         $build_query .= "(s.spec_coll_ids @> ARRAY[$people_id]::int[] OR (s.expedition_ref IN (SELECT $alias1.record_id FROM CataloguePeople $alias1 WHERE $alias1.referenced_relation= 'expeditions' AND $alias1.people_ref= $people_id) )) OR " ;

      }
      else
      {
        $build_query .= "s.spec_don_sel_ids @> ARRAY[$people_id]::int[] OR " ;
      }
	  $nb2++;
    }
    // I remove the last 'OR ' at the end of the string
    $build_query = substr($build_query,0,strlen($build_query) -3) ;
	if($boolean=="AND")
	{
		$query->andWhere($build_query) ;
	}
	elseif($boolean=="OR")
	{
		if($alias_id>1)
		{
		 $query->orWhere($build_query) ;
		}
		else
		{
		 $query->andWhere($build_query) ;
		}
	}
	

    return $query ;
  }
  */
  
    public function addPeopleSearchColumnQuerySQL($people_id, $field_to_use, $alias_id=NULL)
  {
	$alias1="cp";


	if($alias_id)
	{
		$alias1=$alias1.$alias_id;

	}
    $build_query = '';
    if(! is_array($field_to_use) || count($field_to_use) < 1)
      $field_to_use = array('ident_ids','spec_coll_ids','spec_don_sel_ids') ;

	$nb2=0;  
    foreach($field_to_use as $field)
    {
       $alias1=$alias1.$nb2;

	  if($field == 'ident_ids')
      {
		$build_query .= "s.spec_ident_ids @> ARRAY[$people_id]::int[] OR " ;
      }
      elseif($field == 'spec_coll_ids')
      {
         $build_query .= "(s.spec_coll_ids @> ARRAY[$people_id]::int[] OR (s.expedition_ref IN (SELECT $alias1.record_id FROM CataloguePeople $alias1 WHERE $alias1.referenced_relation= 'expeditions' AND $alias1.people_ref= $people_id) )) OR " ;

      }
      else
      {
        $build_query .= "s.spec_don_sel_ids @> ARRAY[$people_id]::int[] OR " ;
      }
  
	  $nb2++;
    }
    // I remove the last 'OR ' at the end of the string
    $build_query = substr($build_query,0,strlen($build_query) -3) ;
	return $build_query;
  }

  
   /*public function addPeopleSearchColumnQueryFuzzy(Doctrine_Query $query, $people_name, $field_to_use, $alias_id=NULL, $boolean="AND")
  {
    $alias1="ppa";
	$alias2="ppb";
	$alias3="cp";
	$alias4="ppc";
	$alias5="ppd";
	$idxAlias1=1;
	if($alias_id)
	{
			$idxAlias1=	$idxAlias1+$alias_id;
		
	}
	$alias1=$alias1.$idxAlias1;
	$idxAlias1++;
	$alias2=$alias2.$idxAlias1;
	$idxAlias1++;
	$alias3=$alias3.$idxAlias1;
	$idxAlias1++;
	$alias4=$alias4.$idxAlias1;
	$idxAlias1++;
	$alias5=$alias5.$idxAlias1;
    $build_query = '';
    if(! is_array($field_to_use) || count($field_to_use) < 1)
      $field_to_use = array('ident_ids','spec_coll_ids','spec_don_sel_ids') ;
	 $sql_params = array();
    foreach($field_to_use as $field)
    {
      if($field == 'ident_ids')
      {
        $build_query .= "s.spec_ident_ids && (SELECT array_agg($alias1.id) FROM people $alias1 WHERE fulltoindex(formated_name_indexed) LIKE  '%'||fulltoindex(?)||'%' ) OR " ;
		$sql_params[]=$people_name;
      }
      elseif($field == 'spec_coll_ids')
      {
        $build_query .= "(s.spec_coll_ids && (SELECT array_agg($alias2.id) FROM people $alias2 WHERE fulltoindex(formated_name_indexed)LIKE '%'||fulltoindex(?)||'%' ) OR s.expedition_ref IN (SELECT $alias3.record_id FROM CataloguePeople $alias3 WHERE $alias3.referenced_relation= 'expeditions' AND $alias3.people_ref IN (SELECT $alias4.id FROM people $alias4 WHERE fulltoindex(formated_name_indexed) LIKE '%'||fulltoindex(?)||'%')) ) OR " ;
		$sql_params[]=$people_name;
		$sql_params[]=$people_name;
      }
      else
      {
        $build_query .= "s.spec_don_sel_ids && (SELECT array_agg($alias5.id) FROM people $alias5 WHERE fulltoindex(formated_name_indexed) LIKE '%'||fulltoindex(?)||'%' ) OR " ;
		$sql_params[]=$people_name;
      }
    }
    // I remove the last 'OR ' at the end of the string
    $build_query = substr($build_query,0,strlen($build_query) -3) ;
    if($boolean=="AND")
	{
		$query->andWhere($build_query, $sql_params) ;
	}
	elseif($boolean=="OR")
	{
		if($alias_id>1)
		{
		 $query->orWhere($build_query, $sql_params) ;
		}
		else
		{
		 $query->andWhere($build_query, $sql_params) ;
		}
	}
    return $query ;
  }*/
  
  
  public function addPeopleSearchColumnQueryFuzzySQL( $people_name, $field_to_use, $alias_id=NULL, &$count_names)
  {
    $alias1="ppa";
	$alias2="ppb";
	$alias3="cp";
	$alias4="ppc";
	$alias5="ppd";
	$idxAlias1=1;
	$count_names=0;
	if($alias_id)
	{
			$idxAlias1=	$idxAlias1+$alias_id;
		
	}
	$alias1=$alias1.$idxAlias1;
	$idxAlias1++;
	$alias2=$alias2.$idxAlias1;
	$idxAlias1++;
	$alias3=$alias3.$idxAlias1;
	$idxAlias1++;
	$alias4=$alias4.$idxAlias1;
	$idxAlias1++;
	$alias5=$alias5.$idxAlias1;
    $build_query = '';
    if(! is_array($field_to_use) || count($field_to_use) < 1)
      $field_to_use = array('ident_ids','spec_coll_ids','spec_don_sel_ids') ;
	 //$sql_params = array();
    foreach($field_to_use as $field)
    {
      if($field == 'ident_ids')
      {
        $build_query .= "s.spec_ident_ids && (SELECT array_agg($alias1.id) FROM people $alias1 WHERE fulltoindex(formated_name_indexed) LIKE  '%'||fulltoindex(?)||'%' ) OR " ;
		$count_names++;
      }
      elseif($field == 'spec_coll_ids')
      {
        $build_query .= "(s.spec_coll_ids && (SELECT array_agg($alias2.id) FROM people $alias2 WHERE fulltoindex(formated_name_indexed)LIKE '%'||fulltoindex(?)||'%' ) OR s.expedition_ref IN (SELECT $alias3.record_id FROM CataloguePeople $alias3 WHERE $alias3.referenced_relation= 'expeditions' AND $alias3.people_ref IN (SELECT $alias4.id FROM people $alias4 WHERE fulltoindex(formated_name_indexed) LIKE '%'||fulltoindex(?)||'%')) ) OR " ;

		$count_names++;
		$count_names++;
      }
      else
      {
        $build_query .= "s.spec_don_sel_ids && (SELECT array_agg($alias5.id) FROM people $alias5 WHERE fulltoindex(formated_name_indexed) LIKE '%'||fulltoindex(?)||'%' ) OR " ;
		$count_names++;
      }
    }
    // I remove the last 'OR ' at the end of the string
    $build_query = substr($build_query,0,strlen($build_query) -3) ;
    
    return $build_query ;
  }
  
  public function addObjectNameColumnQuery($query, $field, $val) {
    $val = $this->checksToQuotedValues($val);
    $query_array = array_fill(0,count($val)," s.object_name_indexed like '%' || fulltoindex(?) || '%'");
    $query->andWhere( implode(' AND ',$query_array) ,$val);
    return $query ;
  }

  public function addCollectionRefColumnQuery($query, $field, $val)
  {
    //Do Nothing here, the job is done in the doBuildQuery with check collection rights
    return $query;
  }

      //JMHerpers 2019 04 29
	public function addCites($query, $val) {
		if(is_numeric($val)) {
			if($val == 0){
				$query->andWhere("cites = FALSE") ;
			}
			if($val == 1){
				$query->andWhere("cites = TRUE") ;
			}
		}
		return $query ;
	}
  
    public function addNagoyaStatus($query, $val="") {
		if(strlen($val)>0) {
			$query->andwhere("COALESCE(db_user_type, 1) < 4 OR (COALESCE(db_user_type, 1) >= 4 AND LOWER(nagoya) = LOWER(?))", $val);
		}
		return $query ;
	}

   public function addImportRefColumnQuery($query, $field, $val) {
    if(is_numeric($val)) 
    {
        $query->andWhere("import_ref = ? ", $val) ;
    }
    return $query ;
  }
  

  public function addPropertiesQuery($query, $type , $applies_to, $value_from, $value_to, $unit, $taintedValues=Array()) 
  {
  
    $property_fuzzy=FALSE;
    $str_like = " ILIKE ? ";
    if(isset($taintedValues['property_fuzzy'])) 
	{
		if($taintedValues['property_fuzzy']==TRUE)
		{
			$this->property_fuzzy=TRUE;
            $str_like = "  ILIKE '%'||?||'%' ";
		}
	}
    
    $sql_part = array();
    $sql_params = array();
    if(trim($type) != '') {
      $sql_part[] = ' property_type = ? ';
      $sql_params[] = $type;
    }
    if(trim($applies_to) != '') {
      $sql_part[] = ' applies_to = ? ';
      $sql_params[] = $applies_to;
    }
    $value_from = trim($value_from);
    $value_to = trim($value_to);
    $unit = trim($unit);
    if($value_from == '' && $value_to != '') {
      $value_from = $value_to;
      $value_to = '';
    }

    // We have only 1 Value
    if($value_from != '' && $value_to == '') {
      if($unit == '') {
        $sql_part[] = '  ( p.lower_value '.$str_like.' OR  p.upper_value '.$str_like.') ';
        $sql_params[] = $value_from;
        $sql_params[] = $value_from;
      //We don't know the filed unit
      } elseif(Properties::searchRecognizedUnitsGroups($unit) === false) {
        $sql_part[] = '  ( p.lower_value '.$str_like.' OR  p.upper_value  '.$str_like.') AND property_unit = ? ';
        $sql_params[] = $value_from;
        $sql_params[] = $value_from;
        $sql_params[] = $unit;

      } else { // Recognized unit
        $sql_params[] = $value_from;
        $sql_params[] = $unit;
        $sql_params[] = $unit;

        $unitGroupStr =  implode(',',array_fill(0,count($unitGroup),'?'));
        $sql_part[] = ' ( convert_to_unified ( ?,  ? ) BETWEEN p.lower_value_unified AND  p.upper_value_unified) AND is_property_unit_in_group(property_unit, ?)  ';
      }
    }
    // We have 2 Values
    elseif($value_from != '' && $value_to != '') {
      if($unit == '') {
        $sql_part[] = ' ( ( p.lower_value '.$str_like.' OR  p.upper_value '.$str_like.') OR ( p.lower_value '.$str_like.' OR  p.upper_value ILIKE '.$str_like.') )';
        $sql_params[] = $value_from;
        $sql_params[] = $value_from;
        $sql_params[] = $value_to;
        $sql_params[] = $value_to;
      //We don't know the filed unit
      } elseif(Properties::searchRecognizedUnitsGroups($unit) === false) {
        $sql_part[] = ' ( ( p.lower_value '.$str_like.' OR  p.upper_value = ?) OR ( p.lower_value '.$str_like.' OR  p.upper_value '.$str_like.') )  AND property_unit = ? ';
        $sql_params[] = $value_from;
        $sql_params[] = $value_from;
        $sql_params[] = $value_to;
        $sql_params[] = $value_to;
        $sql_params[] = $unit;

      } else { // Recognized unit
        $conn_MGR = Doctrine_Manager::connection();
        $lv = $conn_MGR->quote($value_from, 'string');
        $uv = $conn_MGR->quote($value_to, 'string');
        $unit = $conn_MGR->quote($unit, 'string');
        $sql_part[] = "
            (
              ( p.lower_value_unified BETWEEN convert_to_unified($lv,$unit) AND convert_to_unified($uv,$unit))
              OR
              ( p.upper_value_unified BETWEEN convert_to_unified($lv,$unit) AND convert_to_unified($uv,$unit))
            )
            OR
            (
              p.lower_value_unified BETWEEN 0 AND convert_to_unified($lv,$unit)
              AND
              p.upper_value_unified BETWEEN convert_to_unified($uv,$unit) AND 'Infinity'
        )";
        $query->andWhere("is_property_unit_in_group(property_unit,$unit)") ;
        //OR ( convert_to_unified ( ?::text,  ?::text ) < p.lower_value_unified AND convert_to_unified ( ?::text,  ?::text ) > p.upper_value_unified)
      }

    }
    elseif($unit != '') {
      $sql_part[] = ' property_unit = ? ';
      $sql_params[] = $unit;
    }

    if(!empty($sql_part) ) {
      

      $query->andWhere("EXISTS (SELECT p.id FROM Properties p WHERE p.referenced_relation='specimens' AND p.record_id=s.id AND ".implode(' AND ', $sql_part).")", $sql_params ) ;
      $this->with_group = true;
    }
    return $query;
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {  
    // the line below is used to avoid with_multimedia checkbox to remains checked when we click to back to criteria
    if(!isset($taintedValues['with_multimedia'])) $taintedValues['with_multimedia'] = false ;

    if(isset($taintedValues['Codes'])&& is_array($taintedValues['Codes'])) {
      foreach($taintedValues['Codes'] as $key=>$newVal) {
        if (!isset($this['Codes'][$key])) {
          $this->addCodeValue($key);
        }
      }
    } else {
      $this->offsetUnset('Codes') ;
      $subForm = new sfForm();
      $this->embedForm('Codes',$subForm);
      $taintedValues['Codes'] = array();
    }
		//ftheeten 2015 01 08
	$this->code_boolean='AND';
	 if(isset($taintedValues['Codes'])&& is_array($taintedValues['Codes']) && isset($taintedValues['code_boolean'])) 
	 {
		if($taintedValues['code_boolean']=='OR')
		{
			$this->code_boolean='OR';
		}
	}
	
	
	//ftheeten 2015 01 08
	$this->gtu_boolean='AND';
	 if( isset($taintedValues['gtu_boolean'])) 
	 {
		if($taintedValues['gtu_boolean']=='OR')
		{
			$this->gtu_boolean='OR';
		}
	}
		
	
     //ftheeten 2015 09 09
	$this->code_exact_match=FALSE;
	if(isset($taintedValues['Codes'])&& is_array($taintedValues['Codes']) && isset($taintedValues['code_exact_match'])) 
	{
		if($taintedValues['code_exact_match']==TRUE)
		{
			$this->code_exact_match=TRUE;
		}
	}
    
     //ftheeten 2018 11 22
    if(isset($taintedValues['exact_codes_list']))
    {
        if($taintedValues['exact_codes_list'])
        {
            $this->is_fuzzy_codes_list=true;
        }
    }
	

    if(isset($taintedValues['Tags'])&& is_array($taintedValues['Tags'])) {
      foreach($taintedValues['Tags'] as $key=>$newVal) {
        if (!isset($this['Tags'][$key])) {
          $this->addGtuTagValue($key);
        }
      }
    } else {
      $this->offsetUnset('Tags') ;
      $subForm = new sfForm();
      $this->embedForm('Tags',$subForm);
      $taintedValues['Tags'] = array();
    }
	
	//ftheeten 2015 10 22
	$this->people_boolean='AND';
	 if(isset($taintedValues['Peoples'])&& is_array($taintedValues['Peoples']) && isset($taintedValues['people_boolean'])) 
	 {
		if($taintedValues['people_boolean']=='OR')
		{
			$this->people_boolean='OR';
		}
	}
	

	
	if(isset($taintedValues['Peoples'])&& is_array($taintedValues['Peoples']))
	{

		 foreach($taintedValues['Peoples'] as $key=>$newVal) 
		 {

			if (!isset($this['Peoples'][$key]))
			{

				$this->addPeopleValue($key);
			}
		 }
	}
	else 
	{
      $this->offsetUnset('Peoples') ;
      $subForm = new sfForm();
      $this->embedForm('Peoples',$subForm);
      $taintedValues['Peoples'] = array();
    }

	//ftheeten 2015 10 22 handle several peoples in filter
	$this->people_boolean='AND';
	 if(isset($taintedValues['Peoples'])&& is_array($taintedValues['Peoples']) && isset($taintedValues['people_boolean'])) 
	 {
		if($taintedValues['people_boolean']=='OR')
		{
			$this->people_boolean='OR';
		}
	}
	
	if(isset($taintedValues['Peoples'])&& is_array($taintedValues['Peoples']))
	{

		 foreach($taintedValues['Peoples'] as $key=>$newVal) 
		 {

			if (!isset($this['Peoples'][$key]))
			{

				$this->addPeopleValue($key);
			}
		 }
	}
	else 
	{
      $this->offsetUnset('Peoples') ;
      $subForm = new sfForm();
      $this->embedForm('Peoples',$subForm);
      $taintedValues['Peoples'] = array();
    }
    //see sfValidatorSchemafilter in vendor
	/*foreach($taintedValues as $key=>$val)
    {
        if(!is_array($val))
        {
            unset($taintedValues[$key]);
        }
    }*/
    parent::bind($taintedValues, $taintedFiles);
  }

  public function doBuildQuery(array $values)
  {
    $this->consultation_collection = $this->getCollectionWithRights( sfContext::getInstance()->getUser());
    $this->encoding_collection = $this->getCollectionWithRights( sfContext::getInstance()->getUser(), true); 	
	//$this->encoding_collection = $this->getCollectionWithRights( sfContext::getInstance()->getUser()); 
	$user=$this->options['user'];
     $query = DQ::create()
      ->select("s.*, 
	  (CASE WHEN s.collection_ref NOT IN (".implode(',',$this->encoding_collection).") THEN
		'NAGOYA_UNKOWN'
		ELSE
		nagoya
		END) as nagoyastatus,
		gtu_location[0]::varchar as latitude,
		gtu_location[1]::varchar as longitude,
        (s.collection_ref in (".implode(',',$this->consultation_collection).')) as has_encoding_rights'
      )
      //->from('Specimens s');
      ->from('SpecimensStoragePartsView s');
	 //JMHerpers 17/09/2019
	 // ->leftJoin("s.CollectionsRights cr ON s.collection_ref = cr.collection_ref");
     
        $go_tag=TRUE;
        
        if(isset($values['include_text_place'])) 
        {
      
            if($values['include_text_place']==TRUE)
            {
                 $go_tag=false;
                
            }
        }
        if($go_tag)
        {
	       $this->addTagsColumn($query, $values['Tags'], $values["Tags"]);
        }
	   //$query->andWhere("(cr.user_ref= ? OR ? =8) ", Array($user->getId(),  $user->getDbUserType()));
      //ftheeten 2018 07 13 (force exectuion of GTU search in first position, as complex query makes precedence order bewtenen OR/AND unsure)

    if($values['with_multimedia'])
          $query->andWhere("EXISTS (select m.id from multimedia m where m.referenced_relation = 'specimens' AND m.record_id = s.id)") ;
  
  	//JMHerpers 13/09/2019
    if($values['category'] != NULL){
		if($values['category'] == 'all'){
			$query->andWhere("EXISTS (select e.id from ExtLinks e where e.referenced_relation = 'specimens' AND e.record_id = s.id )") ;
		}else{
			$query->andWhere("EXISTS (select e.id from ExtLinks e where e.referenced_relation = 'specimens' AND e.record_id = s.id AND e.category LIKE ?)", $values['category']);
		}
	}
	
    $this->options['query'] = $query;
    $query = parent::doBuildQuery($values);
    $this->cols = $this->getCollectionWithRights( sfContext::getInstance()->getUser()) ;//$this->options['user']);
    if(!empty($values['collection_ref'])) {
      $this->cols = array_intersect($values['collection_ref'], $this->cols);
    }
    //ftheeten 2017 05 30 (issue with subquery for pager)
    //$query->andwhereIn('collection_ref ', $this->cols);
	//keep these criterias in first position
	
    $query->andWhere('s.collection_ref IN ('.implode(',',$this->cols).')');
    
    //ftheeten 2016 06 08 t disable warning when saving saved search in the DB
    if(isset($values['count_operator']))
    {
        if ($values['count_operator'] != '' && $values['count'] != '')
        {
          if($values['count_operator'] == 'e') $query->andwhere('specimen_count_max = ?',$values['count']) ;
          if($values['count_operator'] == 'l') $query->andwhere('specimen_count_max <= ?',$values['count']) ;
          if($values['count_operator'] == 'g') $query->andwhere('specimen_count_min >= ?',$values['count']) ;
        }
    }
    //if ($values['people_ref'] != '') $this->addPeopleSearchColumnQuery($query, $values['people_ref'], $values['role_ref']);
	//if ($values['people_fuzzy'] != '') $this->addPeopleSearchColumnQueryFuzzy($query, $values['people_fuzzy'], $values['role_ref']);
    if ($values['acquisition_category'] != '' ) $query->andWhere('acquisition_category = ?',$values['acquisition_category']);
    if ($values['taxon_level_ref'] != '') $query->andWhere('taxon_level_ref = ?', intval($values['taxon_level_ref']));
    if ($values['chrono_level_ref'] != '') $query->andWhere('chrono_level_ref = ?', intval($values['chrono_level_ref']));
    if ($values['litho_level_ref'] != '') $query->andWhere('litho_level_ref = ?', intval($values['litho_level_ref']));
    if ($values['lithology_level_ref'] != '') $query->andWhere('lithology_level_ref = ?', intval($values['lithology_level_ref']));
    if ($values['mineral_level_ref'] != '') $query->andWhere('mineral_level_ref = ?', intval($values['mineral_level_ref']));
    $this->addLatLonColumnQuery($query, $values);
	if ($values['expedition_ref'] != '') $query->andWhere('expedition_ref = ?', intval($values['expedition_ref']));


    $this->addNamingColumnQuery($query, 'taxonomy', 'taxon_name_indexed', $values['taxon_name'],'s','taxon_name_indexed');
    $this->addNamingColumnQuery($query, 'chronostratigraphy', 'chrono_name_indexed', $values['chrono_name'],'s','chrono_name_indexed');
    $this->addNamingColumnQuery($query, 'lithostratigraphy', 'litho_name_indexed', $values['litho_name'],'s','litho_name_indexed');
    $this->addNamingColumnQuery($query, 'lithology', 'lithology_name_indexed', $values['lithology_name'],'s','lithology_name_indexed');
    $this->addNamingColumnQuery($query, 'mineralogy', 'mineral_name_indexed', $values['mineral_name'],'s','mineral_name_indexed');

	//JMHerpers 2019 04 29
    $this->addCites($query, $values["taxonomy_cites"]);
	$this->addImportRefColumnQuery($query, $values["import_ref"], $values["import_ref"]);
        
    $this->addPropertiesQuery($query, $values['property_type'] , $values['property_applies_to'], $values['property_value_from'], $values['property_value_to'], $values['property_units'], $values);

    $this->addCommentsQuery($query, $values['comment_notion_concerned'] , $values['comment']);
    //ftheeten 2016 07 06
    $this->addEcologyQuery($query, $values['ecology']);
    //ftheeten 2017 04 27
    $this->addInLoansQuery($query, $values['in_loan']);
    //ftheeten 2017 04 27
    $this->addInClosedLoansQuery($query, $values['loan_is_closed']);

    $fields = array('gtu_from_date', 'gtu_to_date');
    $this->addDateFromToColumnQuery($query, $fields, $values['gtu_from_date'], $values['gtu_to_date']);
    
   
    
    $this->addDateFromToColumnQuery($query, array('ig_date'), $values['ig_from_date'], $values['ig_to_date']);
    $this->addDateFromToColumnQuery($query, array('acquisition_date'), $values['acquisition_from_date'], $values['acquisition_to_date']);
    //2019 02 25
    $this->addCreationDateFromToColumnQuery($query, array('modification_date_time'), $values['creation_from_date'], $values['creation_to_date']);
    
    
    //$this->addCatalogueRelationColumnQuery($query, $values['taxon_item_ref'], $values['taxon_relation'],'taxonomy','taxon');
    //ftheeten 2016 03 24
    //$this->addCatalogueRelationColumnQueryArrayRelations($query, $values['taxon_item_ref'], $values['taxon_relation'],'taxonomy','taxon');
    $this->addCatalogueRelationColumnQueryArrayRelations($query, $values['taxa_list'], $values['taxon_relation'],'taxonomy','taxon');

    $this->addCatalogueRelationColumnQuery($query, $values['chrono_item_ref'], $values['chrono_relation'],'chronostratigraphy','chrono');
    $this->addCatalogueRelationColumnQuery($query, $values['litho_item_ref'], $values['litho_relation'],'lithostratigraphy','litho');
    $this->addCatalogueRelationColumnQuery($query, $values['lithology_item_ref'], $values['lithology_relation'],'lithology','lithology');
    $this->addCatalogueRelationColumnQuery($query, $values['mineral_item_ref'], $values['mineral_relation'],'mineralogy','mineral');
    
    
    //THIS group of storage fields ftheeten 2016 09 27
    if(!empty($values['specimen_status'])) $query->andwhere('specimen_status = ?',$values['specimen_status']) ; 
    if(!empty($values['specimen_part'])) $query->andwhere('specimen_part = ?',$values['specimen_part']) ;
    if(!empty($values['object_name'])) $query->andwhere("object_name_indexed like '%' || fulltoindex(?) || '%'",$values['object_name']) ;
	
	if (!empty($values['related_ref']))
	{

		$array_linked=Doctrine::getTable('SpecimensRelationships')->getAllRelated($values['related_ref']);
		
		$array_linked_str=Array();
		foreach($array_linked as $key=>$row)
		{
			$array_linked_str[]=$row[0];			
		}
		
		$array_linked_str="{".implode(",",$array_linked_str)."}";
		$query->andWhere(" s.id = ANY ('".$array_linked_str."'::integer[])");
    }
    //ftheeten 2017 02 13
    $this->addValidLabelQuery($query, $values['valid_label']);
    
    
    
    if(!empty($values['institution_ref']))
    {
        $valTmp=$values['institution_ref'];
        if($valTmp == '' &&  ! ctype_digit($valTmp)) return ;
            $query->andWhere('institution_ref =  ?', $valTmp);
    }
    $this->template_storage($query, 'building', 'building', $values);
    $this->template_storage($query, 'floor', 'floor', $values);
    $this->template_storage($query, 'room', 'room', $values);
    $this->template_storage($query, 'row', 'row', $values);    
    $this->template_storage($query, 'col', 'col', $values);        
    $this->template_storage($query, 'shelf', 'shelf', $values);
	
	//JMherpers 18/09/2019
	$this->addNagoyaStatus($query,$values['nagoya'] );
	
	
    //ftheeten 2016 06 222
    $query->limit($this->getCatalogueRecLimits());

    return $query;
  }

   //ftheeten 2016 09 27
   public function template_storage($query, $fieldSQL, $fieldPHP, $values)
   {
        if(!empty($values[$fieldPHP]))
        {
            $valTmp = $this->checksToQuotedValues($values[$fieldPHP]);
            $query->andWhere("$fieldSQL in (".implode(',',$valTmp).")");
        }
        return $query;
   }
   
   //ftheeten 2019 02 25
   public function addCreationDateFromToColumnQuery(Doctrine_Query $query, array $dateFields, $val_from, $val_to)
  {
    if (count($dateFields) > 0 && ($val_from->getMask() > 0 || $val_to->getMask() > 0 ))
    {
      $query->innerJoin('s.UsersTrackingSpecimens ut');
      $query->andWhere("ut.referenced_relation = ? ",'specimens');
       $query->andWhere("ut.action = ? ",'insert');
      if($val_from->getMask() > 0 && $val_to->getMask() > 0)
      {
        if (count($dateFields) == 1)
        {
          $query->andWhere($dateFields[0] . " Between ? and ? ",
                           array($val_from->format('d/m/Y'),
                                 $val_to->format('d/m/Y')
                                )
                          );
        }
        else
        {
          $query->andWhere(" " . $dateFields[0] . " >= ? ", $val_from->format('d/m/Y'))
                ->andWhere(" " . $dateFields[1] . " <= ? ", $val_to->format('d/m/Y'));
        }
      }
      elseif ($val_from->getMask() > 0)
      {
        $sql = " (" . $dateFields[0] . " >= ? ) ";
        for ($i = 1; $i <= count($dateFields); $i++)
        {
          $vals[] = $val_from->format('d/m/Y');
        }
        if (count($dateFields) > 1) $sql .= " OR (" . $dateFields[1] . " >= ?) ";
        $query->andWhere($sql,
                         $vals
                        );
      }
      elseif ($val_to->getMask() > 0)
      {
        $sql = " (" . $dateFields[0] . " <= ? AND " . $dateFields[0] . ") ";
        for ($i = 1; $i <= count($dateFields); $i++)
        {
          $vals[] = $val_to->format('d/m/Y');
        }
        if (count($dateFields) > 1) $sql .= " OR (" . $dateFields[1] . " <= ? AND " . $dateFields[1] . ") ";
        $query->andWhere($sql,
                         $vals
                        );
      }
    }
    return $query;
  }
  
  public function getJavaScripts()
  {
    $javascripts=parent::getJavascripts();
    $javascripts[]='/leaflet/leaflet.js';
    $javascripts[]='/js/map.js';
    $javascripts[]='/leaflet/leaflet.markercluster-src.js';
	$javascripts[]= "/Leaflet.draw-master/dist/leaflet.draw.js";
    //ftheeten 2018 11 22
    $javascripts[]= "/select2-4.0.5/dist/js/select2.full.min.js";
    return $javascripts;
  }

  public function getStylesheets() {
    $items=parent::getStylesheets();
    $items['/leaflet/leaflet.css']='all';
    $items['/leaflet/MarkerCluster.css']='all';
	$items["/Leaflet.draw-master/dist/leaflet.draw.css"]=  'all';
     //ftheeten 2018 11 22
    $items["/select2-4.0.5/dist/css/select2.min.css"]=  'all';
    return $items;
  }
}
