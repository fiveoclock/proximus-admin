<div class="groups view">
   <h2>
      <?php
        echo $html->link('Locations','/admin/locations/start',null,null,false);
        echo " / ";
        echo $html->link($group['Location']['code'], array('controller'=> 'locations', 'action'=>'view', $group['Location']['id']));
        echo " / ";
        echo $group['Group']['name'];
      ?>
   </h2>
</div>
<div class="groups form">
<?php echo $form->create('Group');?>
	<fieldset>
 		<legend><?php __('Edit Group');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->hidden('location_id', array('type' => 'text') );
		echo $form->input('User',array('type'=>'select','multiple'=>'multiple'));
	?>
   <?php echo $form->end('Submit');?>
   <?php echo $this->element('back_btn');?>
	</fieldset>
</div>
