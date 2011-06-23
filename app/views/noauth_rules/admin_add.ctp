<div class="noauth_rules form">
<?php echo $form->create('NoauthRule');?>
	<fieldset>
 		<legend><?php __('Add Noauth Rule');?></legend>
	<?php
		echo $form->input('type', array('options' => array('DN'=>'Host- or domain name','IP'=>'IP-Address')));
      echo $form->input('sitename', array('label'=> 'Host/domain name or IP address (eg. .example.com / 10.1.1.1 )'));
      echo $form->input('location_id');
      echo $form->input('valid_until', array('type'=>'text', 'label'=> 'Valid until (use yyyy-mm-dd hh:mm), leave empty for no limitation'));
		echo $form->input('description');
	?>
   <?php echo $form->end('Submit');?>
   <?php echo $this->element('back_btn');?>
	</fieldset>
</div>
