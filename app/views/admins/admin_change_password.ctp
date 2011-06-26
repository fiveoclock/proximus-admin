<div class="admins form">
<?php echo $form->create('Admin', array('action' => 'changePassword'));?>	
   <fieldset>
 		<legend><?php __('Change password');?></legend>
	<?php
		echo $form->input('id');
      echo $form->input('password_old',     array('size'=>'20', 'type' => 'password', 'label' => 'Enter your current password', 'value' => ''));
      echo $form->input('password', array('size'=>'20', 'label' => 'New password', 'value' => ''));
      echo $form->input('password_confirm', array('size'=>'20', 'type' => 'password', 'label' => 'Confirm new password', 'value' => ''));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
