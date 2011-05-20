<div class="admins form">


<?php echo $form->create('Admin');?>
	<fieldset>
 		<legend><?php __('Edit Admin');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('username', array('disabled'=>'disabled' ));
		echo $form->input('role_id');
		echo $form->input('active', array('options' => array('Y'=>'Yes','N'=>'No')));
      echo $form->input('Location',array('type'=>'select','multiple'=>'multiple'));
#      debug($this->data['Admin']['id']);
	?>

   <div class="actions">
      <ul>
         <li><?php echo $html->link('Change Password',array('action'=>'changePassword',$this->data['Admin']['id'])); ?></li>
      </ul>
   </div>

	</fieldset>
   <?php echo $this->element('back_btn');?>
   <?php echo $form->end('Submit');?>
</div>



