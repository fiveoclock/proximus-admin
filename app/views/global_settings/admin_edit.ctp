<div class="globalsettings form">
<?php echo $form->create('GlobalSetting');?>
	<fieldset>
 		<legend><?php __('Edit global settings');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name', array('disabled'=>'disabled' ));
		echo $form->input('name', array('type'=>'hidden' ));
		echo $form->input('value', array('type'=>'text'));
	?>
   <?php echo $form->end('Submit');?>
   <?php echo $this->element('back_btn');?> 
	</fieldset>
</div>

