<div class="groups form">
<?php echo $form->create('Group');?>
	<fieldset>
 		<legend><?php __('Edit Group');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		if ($camefrom == 'locations') { echo $form->input('location_id'); }
		echo $form->input('User',array('type'=>'select','multiple'=>'multiple'));
	?>
   <?php echo $form->end('Submit');?>
   <?php echo $this->element('back_btn');?>
	</fieldset>
</div>
