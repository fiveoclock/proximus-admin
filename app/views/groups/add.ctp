<div class="groups form">
<?php echo $form->create('Group');?>
	<fieldset>
 		<legend><?php __('Add Group');?></legend>
	<?php
		echo $form->input('name');
      echo $form->hidden('location_id');
	?>
	</fieldset>
<?php echo $this->element('back_btn');?>
<?php echo $form->end('Submit');?>
</div>
