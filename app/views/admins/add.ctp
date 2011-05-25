<div class="admins form">
<?php echo $form->create('Admin');?>
	<fieldset>
 		<legend><?php __('Add Admin');?></legend>
	<?php
		echo $form->input('username');
      echo $form->input('password', array('size'=>'20', 'label' => 'Password', 'value' => ''));
      echo $form->input('password_confirm', array('size'=>'20', 'type' => 'password', 'label' => 'Confirm password', 'value' => ''));
		echo $form->input('role_id');
      #echo "For Global Admin's no locations must be selected!";
      echo $form->input('Location',array('type'=>'select','multiple'=>'multiple'));
	?>
   <?php echo $form->end('Submit');?>
   <?php echo $this->element('back_btn');?>
	</fieldset>
</div>
