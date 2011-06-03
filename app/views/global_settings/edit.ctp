<div class="globalsettings form">
<?php echo $form->create('GlobalSetting');?>
	<fieldset>
 		<legend><?php __('Edit global settings');?></legend>
	<?php
		echo $form->input('subsite_sharing');
		echo $form->input('mail_interval');
		echo $form->input('retrain_key');
		echo $form->input('regex_cut');
	?>
   <?php echo $form->end('Submit');?>
   <?php echo $this->element('back_btn');?> 
	</fieldset>
</div>

