<div class="locations form">
<?php echo $form->create('Location');?>
	<fieldset>
 		<legend><?php __('Edit Location');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('code');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $this->element('back_btn');?>
<?php echo $form->end('Submit');?>
