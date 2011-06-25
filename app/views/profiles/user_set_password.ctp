<div class="profiles form">
<?php //echo $form->create('Profile', array('action' => 'setPassword'));?>	
<?php echo $form->create('User', array('url'=>$this->Html->url(array('user' => true, 'controller'=>'profiles', 'action'=>'setPassword'), true))); ?>
   <fieldset>
 		<legend><?php __('Change password');?></legend>
	<?php
		echo $form->input('id');
      echo $form->input('password', array('size'=>'20', 'label' => 'Type old password', 'value' => ''));
      echo $form->input('password', array('size'=>'20', 'label' => 'Type new password', 'value' => ''));
      echo $form->input('password_confirm', array('size'=>'20', 'type' => 'password', 'label' => 'Confirm new password', 'value' => ''));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
