<div class="proxy_settings form">
<?php echo $form->create('ProxySetting');?>
	<fieldset>
 		<legend><?php __('Edit Proxy Settings');?></legend>
	<?php
		echo $form->input('id');
      echo $form->input('location_id', array( 'label'=> 'Location where the proxy resides') );
      echo $form->input('fqdn_proxy_hostname', array( 'label'=> 'Fully quallified hostname of the proxy server') );
      echo $form->input('redirection_host', array( 'label'=> 'Redirection host for user messages') );
      echo $form->input('redirection_path', array( 'label'=> 'Redirection path for user messages (result eg: http://$host$path/proximus.php? )') );
      echo $form->input('smtpserver');
      echo $form->input('admin_email');
      echo $form->input('admincc', array('options' => array('0'=>'No','1'=>'Yes'), 'label'=> 'Send CC mails to admin?' ));
      echo $timezone->select('timezone', 'Timezone');
	?>
   <?php echo $form->end('Submit');?>
   <?php echo $this->element('back_btn');?>
	</fieldset>
</div>
