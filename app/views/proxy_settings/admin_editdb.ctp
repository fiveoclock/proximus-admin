<div class="proxy_settings form">
<?php echo $form->create('ProxySetting');?>
	<fieldset>
 		<legend><?php __('Edit Proxy Settings');?></legend>
	<?php
		echo $form->input('id');
      echo $form->input('db_default', array('options' => array('0'=>'No','1'=>'Yes'),'label'=> 'Use default database (if this proxy uses a replication DB, set this to Yes and configure the database below)' ));
      echo $form->input('db_host', array('label'=> 'Host') );
      echo $form->input('db_name', array('label'=> 'Database name'));
      echo $form->input('db_user', array('label'=> 'Username'));
      echo $form->input('db_pass', array('label'=> 'Password', 'type' => 'password' ));
	?>
   <?php echo $form->end('Submit');?>
   <?php echo $this->element('back_btn');?>
	</fieldset>
</div>
