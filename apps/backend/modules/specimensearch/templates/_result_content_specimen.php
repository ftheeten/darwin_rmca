    <?php $action = $sf_user->isAtLeast(Users::ENCODER)?'edit':'view' ; ?>
    <td class="col_category">
      <?php if($specimen->getStoragePartFieldHTML("category") == 'physical' || $specimen->getStoragePartFieldHTML("category") == 'mixed' ):?>
        <?php echo image_tag('sp_in.png', array('alt' => __('Physical'), 'title'=> __('Physical')));?>
      <?php endif;?>
      <?php if($specimen->getStoragePartFieldHTML("category") == 'mixed' ):?>
        <?php echo __('+');?>
      <?php endif;?>
      <?php if($specimen->getStoragePartFieldHTML("category") == 'observation'  || $specimen->getStoragePartFieldHTML("category") == 'mixed' ):?>
        <?php echo image_tag('blue_eyel.png', array('alt' => __('Other'), 'title'=> __('Other')));?>
      <?php endif;?>
    </td>
    <td  class="col_collection">
      <?php if($specimen->getCollectionRef() > 0) : ?>
        <?php echo image_tag('info.png',"title=info class=info id=collection_".$specimen->getId()."_info");?>
        <?php if($sf_user->isAtLeast(Users::ADMIN) || ($sf_user->isAtLeast(Users::MANAGER) && $specimen->getHasEncodingRights())) : ?>           
          <a href="<?php echo url_for('collection/edit?id='.$specimen->getCollectionRef());?>"><?php echo $specimen->getCollectionName();?></a>
        <?php else : ?>
          <?php echo $specimen->getCollectionName();?>
        <?php endif ; ?>
        <div id="collection_<?php echo $specimen->getId();?>_tree" class="tree"></div>
		
				<!--JMHerpers 2018 02 27 add collection ref hidden-->
		<input id="Collid" class="Collid" style="display: none;" value="<?php echo $specimen->getCollectionRef();?>">
		
        <script type="text/javascript">
            $('#collection_<?php echo $specimen->getId();?>_info').click(function() 
            {
              item_row=$(this).closest('tr');
              if(item_row.find('#collection_<?php echo $specimen->getId();?>_tree').is(":hidden"))
              {
                $.get('<?php echo url_for("catalogue/tree?table=collections&id=".$specimen->getCollectionRef()) ;?>',function (html){
                  item_row.find('#collection_<?php echo $specimen->getId();?>_tree').html(html).slideDown();
                  });
              }
              $('#collection_<?php echo $specimen->getId();?>_tree').slideUp();
            });
        </script>
      <?php endif ; ?>
    </td>
    <td class="col_taxon">
      <?php if($specimen->getTaxonRef() > 0) : ?>
        <?php echo image_tag('info.png',"title=info class=info id=taxon_".$specimen->getId()."_info");?>
        <a href="<?php echo url_for('taxonomy/'.$action.'?id='.$specimen->getTaxonRef());?>" target="_blank"><?php echo $specimen->getTaxonName();?></a>
        <!--ftheeten 2016 10 12 (synonymy)-->
        <?php if($specimen->getSynonymyCountAllInGroup() > 0) : ?>
        
            <?php if($specimen->getCountBySynonymyStatus() ==$specimen->getSynonymyCountAllInGroup() ) : ?>
                    <div id="taxon_synonymy<?php echo $specimen->getId();?>" ><i>Is synonym or has synonyms (no unique valid name set in the synonymy)</i></div>
            <?php else : ?>
                <?php if($specimen->getSynonymyStatus() =="invalid") : ?>
                    <div id="taxon_synonymy<?php echo $specimen->getId();?>" ><i>Synonym</i></div>
                <?php elseif($specimen->getSynonymyStatus() =="valid" && $specimen->getCountBySynonymyStatus()>1) : ?>
                    <div id="taxon_synonymy<?php echo $specimen->getId();?>" ><i>Is synonym or has synonyms (no unique valid name set in the synonymy)</i></div>
                <?php elseif($specimen->getSynonymyStatus() =="valid" && $specimen->getCountBySynonymyStatus()==1) : ?>
                    <div id="taxon_synonymy<?php echo $specimen->getId();?>" ><i>Has synonyms</i></div>
                <?php endif ; ?>
            <?php endif ; ?>
         <?php endif ; ?>
		<?php if($specimen->getCites() == TRUE ) : ?>
			&nbsp;<B><font size="4" color="red">(CITES!!)</font></B>
		 <?php endif ; ?>
        <div id="taxon_<?php echo $specimen->getId();?>_tree" class="tree"></div>
        <script type="text/javascript">
            $('#taxon_<?php echo $specimen->getId();?>_info').click(function() 
            {
              item_row=$(this).closest('tr');
              if(item_row.find('#taxon_<?php echo $specimen->getId();?>_tree').is(":hidden"))
              {
                $.get('<?php echo url_for("catalogue/tree?table=taxonomy&id=".$specimen->getTaxonRef()) ;?>',function (html){
                  item_row.find('#taxon_<?php echo $specimen->getId();?>_tree').html(html).slideDown();
                  });
              }
              $('#taxon_<?php echo $specimen->getId();?>_tree').slideUp();
            });
        </script>
      <?php endif ; ?>&nbsp;
    </td>
    <td class="col_gtu">
      <?php if($specimen->getGtuRef() > 0) : ?>
        <?php if($specimen->getHasEncodingRights() || $specimen->getStationVisible() || $sf_user->isAtLeast(Users::ADMIN) ):?>
			<!--JMHerpers 2018 02 22-->
          <!--<?php echo image_tag('info.png',"title=info class=info id=gtu_ctr_".$specimen->getId()."_info");?>-->
          <script type="text/javascript">
            $(document).ready(function()
            {
              $('#gtu_ctr_<?php echo $specimen->getId(); ?>_info').click(function() 
              {
                item_row = $(this).closest('tr');
                elem = item_row.find('#gtu_<?php echo $specimen->getId();?>_details');
                if(elem.is(":hidden"))
                { 
                  $.get('<?php echo url_for("gtu/completeTag?id=".$specimen->getId()."&view=true") ;?>',function (html){
                    item_row.find('.general_gtu').slideUp();
                    elem.html(html).slideDown();
                  });
                }
                else
                {
                  elem.slideUp();
                  item_row.find('.general_gtu').slideDown();
                }
              });
            });
          </script>
          <?php if ($action == 'edit') : ?>
            <a target='_blank' href="<?php echo url_for('gtu/'.$action.'?id='.$specimen->getGtuRef()) ;?>"><?php echo $specimen->getGtuCode();?></a>
          <?php else : ?>
            <?php echo $specimen->getGtuCode(ESC_RAW);?>
          <?php endif ; ?>
        <?php else:?>
          <?php echo image_tag('info-bw.png',"title=info class=info id=gtu_ctr_".$specimen->getId()."_info");?>
        <?php endif;?>

          <div class="general_gtu">
			<?php if($specimen->getOtherGtuTags() != ""): ?>
				<!--JMHerpers 2018 02 22-->
				<!--<strong><?php echo __('Locality (summary)');?> :</strong>-->
				<?php echo $specimen->getOtherGtuTags(ESC_RAW);?>
			<?php endif ; ?>
          </div>
          <div id="gtu_<?php echo $specimen->getId();?>_details" style="display:none;"></div>

      <?php endif ; ?>
    </td> 
		    <!--JMHerpers 2018 02 22-->
    <td class="col_gtu_location">
		<?php if($specimen->getGtuLocation() !== null) : ?>
			<?php $pos = strpos($specimen->getGtuLocation(), ",");echo "● <b>Long: </b>".substr($specimen->getGtuLocation(),1,$pos -1)."<br>● <b>Lat: </b>".substr($specimen->getGtuLocation(),$pos+1,strlen($specimen->getGtuLocation())-$pos-2);?>
			<br>
			<?php if(null !== $specimen->getGtuElevation()):;?>
				<b>● Elevation: </b><?php echo $specimen->getGtuElevation();?>
			<?php endif ; ?>
		<?php endif ; ?>
    </td>
    <!--ftheeten 2016 09 13-->
    <td class="col_collecting_dates">
			<!--jmherpers 2018 01 29-->
			<?php if(null !==$specimen->getGtuFromDateMasked() && $specimen->getGtuFromDateMask()):?>
				<?php if($specimen->getGtuFromDateMask() == 56):?>
					<b>From: </b><?php echo substr($specimen->getGtuFromDateMasked(ESC_RAW),0,14);?>
					<?php elseif($specimen->getGtuFromDateMask() == 48):?>
						<b>From: </b><?php echo substr($specimen->getGtuFromDateMasked(ESC_RAW),12,10);?>
						<?php elseif($specimen->getGtuFromDateMask() == 32):?>
							<b>From: </b><?php echo substr($specimen->getGtuFromDateMasked(ESC_RAW),15,8);?>
				<?php endif ; ?>
            <?php endif ; ?>
            <?php if(null !==$specimen->getGtuToDateMasked() && $specimen->getGtuToDateMask()):?>
				<br/>
				<?php if($specimen->getGtuToDateMask() == 56):?>
					<b>To: </b><?php echo substr($specimen->getGtuToDateMasked(ESC_RAW),0,14);?>
					<?php elseif($specimen->getGtuToDateMask() == 48):?>
						<b>To: </b><?php echo substr($specimen->getGtuToDateMasked(ESC_RAW),12,10);?>
						<?php elseif($specimen->getGtuToDateMask() == 32):?>
							<b>To: </b><?php echo substr($specimen->getGtuToDateMasked(ESC_RAW),15,8);?>
				<?php endif ; ?>
            <?php endif ; ?>
			<!--end jmherpers 2018 01 29-->
    </td>
     <!--ftheeten 2016 09 13-->
    <td class="col_ecology">
            <?php if(Doctrine::getTable('Comments')->findForTableByNotion('specimens',$specimen->getId(), "ecology")):?>
            <?php echo(Doctrine::getTable('Comments')->findForTableByNotion('specimens',$specimen->getId(), "ecology")[0]->getComment()); ?>
            <?php endif ; ?>
    </td>

    <td class="col_codes">
      <?php if(isset($codes[$specimen->getId()])):?>
		
        <ul>
        <?php $cpt = 0 ; foreach($codes[$specimen->getId()] as $key=>$code):?>            
            <?php if($code->getCodeCategory() == 'main') : ?>
              <?php $cpt++ ; ?>
              <li <?php if($cpt > 3) echo("class='hidden code_supp'"); ?>>
			  <!--rmca 2017 12 13-->
			   <strong>
					<?php echo link_to( $code->getFullCode(), 'specimen/view?id='.$specimen->getId(), array('target' => '_blank'));?>
                </strong>
              </li> 			  
          <?php elseif ($sf_user->isAtLeast(Users::ENCODER)) : ?>
                      
            <li class="hidden code_supp" >
                <?php if ($code->getCodeCategory() == 'main') echo "<strong>" ; ?>            
                <?php echo $code->getFullCode(); ?>
                <?php if ($code->getCodeCategory() == 'main') echo "</strong>" ; ?>
            </li>         
          <?php endif ; ?>
        <?php endforeach; ?>
        </ul>
      <?php endif;?>
    </td>
	<?php if ($sf_user->isAtLeast(Users::ENCODER)) : ?>
    <td  class="col_loans">
        <?php if($specimen->getLoanItems()!==NULL):?>
            <?php foreach($specimen->getLoanDescription() as $key=>$item):?>
                <?php echo($item['name']);?>&nbsp;&nbsp;&nbsp;<?php echo($item['last_status']);?>
                <br/>
             <?php endforeach;?>
        <?php endif;?>
    </td>
     <?php endif;?>
     <td  class="col_valid_label">
         <?php if($specimen->getValidLabel()===TRUE):?>
			<!--jmherpers 2018 01 29-->
            <!--<?php echo __("Valid label: yes");?>-->
			<?php echo __("Valid");?>
        <?php elseif($specimen->getValidLabel()===FALSE):?>
			<!--jmherpers 2018 01 29-->
            <!--<?php echo __("Valid label: no");?>-->
			<?php echo __("Not valid");?>
        <?php endif;?>
    </td>
	<td class="col_nagoya"><?php echo $specimen->getNagoyastatus();?></td> 
	<td class="col_col_peoples">
		<?php $cpt = 0 ; foreach(Doctrine::getTable('CataloguePeople')->getPeopleRelated("specimens", array('collector'),$specimen->getId() ) as $key=>$people):?>
			<li>
			<?php echo Doctrine::getTable('People')->findOneById($people->getPeopleRef())->getFormatedName() ; ?>
			</li>
		<?php endforeach; ?>		
	</td>
	<td class="col_ident_peoples">
		 <?php foreach(Doctrine::getTable('Identifications')->getIdentificationsRelated("specimens", $specimen->getId() ) as $keyIdent=>$ident):?>
			<?php $cpt = 0 ; foreach(Doctrine::getTable('CataloguePeople')->getPeopleRelated("identifications", array('identifier'), $ident->getId()) as $key=>$people):?>
				<li>
					<?php echo Doctrine::getTable('People')->findOneById($people->getPeopleRef())->getFormatedName() ; ?>
				</li>
			 <?php endforeach?>
		 <?php endforeach?>
	</td>
	<td class="col_don_peoples">
		<?php $cpt = 0 ; foreach(Doctrine::getTable('CataloguePeople')->getPeopleRelated("specimens", array('donator'),$specimen->getId() ) as $key=>$people):?>
			<li>
			<?php echo Doctrine::getTable('People')->findOneById($people->getPeopleRef())->getFormatedName() ; ?>
			</li>
		<?php endforeach; ?>		
	</td>
    <td  class="col_chrono">
      <?php if($specimen->getChronoRef() > 0) : ?>
        <?php echo image_tag('info.png',"title=info class=info id=chrono_".$specimen->getId()."_info");?>
        <a href="<?php echo url_for('chronostratigraphy/'.$action.'?id='.$specimen->getChronoRef());?>"><?php echo $specimen->getChronoName();?></a>
        <div id="chrono_<?php echo $specimen->getId();?>_tree" class="tree"></div>
        <script type="text/javascript">
    
            $('#chrono_<?php echo $specimen->getId();?>_info').click(function() 
            {
              item_row=$(this).closest('tr');
              if(item_row.find('#chrono_<?php echo $specimen->getId();?>_tree').is(":hidden"))
              {
                $.get('<?php echo url_for("catalogue/tree?table=chronostratigraphy&id=".$specimen->getChronoRef()) ;?>',function (html){
                  item_row.find('#chrono_<?php echo $specimen->getId();?>_tree').html(html).slideDown();
                  });
              }
              $('#chrono_<?php echo $specimen->getId();?>_tree').slideUp();
            });
        </script>
      <?php endif ; ?>
    </td>    
    <td  class="col_ig">
      <?php if($specimen->getIgRef() > 0) : ?>       
          <a href="<?php echo url_for('igs/'.$action.'?id='.$specimen->getIgRef());?>"><?php echo $specimen->getIgNum();?></a>
      <?php endif ;?>
    </td>    
    <td  class="col_litho">
      <?php if($specimen->getLithoRef() > 0) : ?>
        <?php echo image_tag('info.png',"title=info class=info id=litho_".$specimen->getId()."_info");?>
        <a href="<?php echo url_for('lithostratigraphy/'.$action.'?id='.$specimen->getLithoRef());?>"><?php echo $specimen->getLithoName();?></a>
        <div id="litho_<?php echo $specimen->getId();?>_tree" class="tree"></div>
        <script type="text/javascript">
            $('#litho_<?php echo $specimen->getId();?>_info').click(function() 
            {
              item_row=$(this).closest('tr');
              if(item_row.find('#litho_<?php echo $specimen->getId();?>_tree').is(":hidden"))
              {
                $.get('<?php echo url_for("catalogue/tree?table=lithostratigraphy&id=".$specimen->getLithoRef()) ;?>',function (html){
                  item_row.find('#litho_<?php echo $specimen->getId();?>_tree').html(html).slideDown();
                  });
              }
              $('#litho_<?php echo $specimen->getId();?>_tree').slideUp();
            });
        </script> 
      <?php endif ; ?>
    </td> 
    <td class="col_lithologic">
      <?php if($specimen->getLithologyRef() > 0) : ?>
        <?php echo image_tag('info.png',"title=info class=info id=lithologic_".$specimen->getId()."_info");?>
        <a href="<?php echo url_for('lithology/'.$action.'?id='.$specimen->getLithologyRef());?>"><?php echo $specimen->getLithologyName();?></a>
        <div id="lithologic_<?php echo $specimen->getId();?>_tree" class="tree"></div>
        <script type="text/javascript">
            $('#lithologic_<?php echo $specimen->getId();?>_info').click(function() 
            {
              item_row=$(this).closest('tr');
              if(item_row.find('#lithologic_<?php echo $specimen->getId();?>_tree').is(":hidden"))
              {
                $.get('<?php echo url_for("catalogue/tree?table=lithology&id=".$specimen->getLithologyRef()) ;?>',function (html){
                  item_row.find('#lithologic_<?php echo $specimen->getId();?>_tree').html(html).slideDown();
                  });
              }
              $('#lithologic_<?php echo $specimen->getId();?>_tree').slideUp();
            });
        </script> 
      <?php endif ; ?>
    </td>
    <td class="col_mineral">
      <?php if($specimen->getMineralRef() > 0) : ?>
        <?php echo image_tag('info.png',"title=info class=info id=mineral_".$specimen->getId()."_info");?>                
        <a href="<?php echo url_for('mineralogy/'.$action.'?id='.$specimen->getMineralRef());?>"><?php echo $specimen->getMineralName();?></a>
        <div id="mineral_<?php echo $specimen->getId();?>_tree" class="tree"></div>
        <script type="text/javascript">
            $('#mineral_<?php echo $specimen->getId();?>_info').click(function() 
            {
              item_row=$(this).closest('tr');
              if(item_row.find('#mineral_<?php echo $specimen->getId();?>_tree').is(":hidden"))
              {
                $.get('<?php echo url_for("catalogue/tree?table=mineralogy&id=".$specimen->getMineralRef()) ;?>',function (html){
                  item_row.find('#mineral_<?php echo $specimen->getId();?>_tree').html(html).slideDown();
                  });
              }
              $('#mineral_<?php echo $specimen->getId();?>_tree').slideUp();
            });
        </script> 
      <?php endif ; ?>
    </td>
    <td class="col_expedition">
      <?php if($specimen->getExpeditionRef() > 0) : ?>
        <a href="<?php echo url_for('expedition/'.$action.'?id='.$specimen->getExpeditionRef());?>"><?php echo $specimen->getExpeditionName();?></a>
      <?php endif ; ?>
    </td>
    <td class="col_acquisition_category">
        <?php echo $specimen->getAcquisitionCategory();?>
    </td>    
