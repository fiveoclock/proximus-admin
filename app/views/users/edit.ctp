<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Edit User');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('username', array('disabled'=>'disabled' ));
		echo $form->input('realname');
		echo $form->input('emailaddress');
		echo $form->input('location_id');
	?>
	</fieldset>
   <?php echo $this->element('back_btn');?>
   <?php echo $form->end('Submit');?>
</div>

