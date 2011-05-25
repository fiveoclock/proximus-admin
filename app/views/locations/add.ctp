<div class="locations form">
<?php echo $form->create('Location');?>
	<fieldset>
 		<legend><?php __('Add Location');?></legend>
	<?php
		echo $form->input('code');
		echo $form->input('name');
	?>
   <?php echo $form->end('Submit');?>
   <?php echo $this->element('back_btn');?>

	</fieldset>
</div>
