<div class="proxy_settings form">
<?php echo $form->create('ProxySetting');?>
	<fieldset>
 		<legend><?php __('Edit Proxy Settings');?></legend>
	<?php
		echo $form->input('id');
      echo $form->input('location_id');
      echo $form->input('fqdn_proxy_hostname');
      echo $form->input('redirection_host');
      echo $form->input('smtpserver');
      echo $form->input('admin_email');
      echo $form->input('admin_cc', array('options' => array('Off'=>0,'On'=>1)));
	?>
	</fieldset>
<?php echo $this->element('back_btn');?>
<?php echo $form->end('Submit');?>
</div>
