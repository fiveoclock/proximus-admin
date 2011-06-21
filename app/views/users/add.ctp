<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Add User');?></legend>
	<?php
		echo $form->input('username');
		echo $form->input('realname');
		echo $form->input('emailaddress');
		echo $form->input('location_id');
      if ( $settings['auth_method_User'] == "internal" ) {
         echo $form->input('password', array('size'=>'20', 'label' => 'Password', 'value' => ''));
         echo $form->input('password_confirm', array('size'=>'20', 'type' => 'password', 'label' => 'Confirm password', 'value' => ''));
      }
	?>
   <?php echo $form->end('Submit');?>
   <?php echo $this->element('back_btn');?>
	</fieldset>
</div>

