<div class="admins form">
<?php echo $form->create('Admin');?>
	<fieldset>
 		<legend><?php __('Edit Admin');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('username');
		echo $form->input('role_id');
      echo $form->input('Location',array('type'=>'select','multiple'=>'multiple'));
#      debug($this->data['Admin']['id']);
      echo $html->link('Change Password',array('action'=>'changePassword',$this->data['Admin']['id']));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
