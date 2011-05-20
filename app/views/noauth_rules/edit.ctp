<div class="noauth_rules form">
<?php echo $form->create('NoauthRule');?>
	<fieldset>
 		<legend><?php __('Edit Rule');?></legend>
	<?php
      echo $form->input('type', array('options' => array('DN'=>'DN','IP'=>'IP')));
      echo $form->input('sitename');
      echo $form->input('location_id');
      echo $form->input('valid_until', array('type'=>'text', 'label'=> 'Valid until (use yyyy-mm-dd hh-mm), leave empty for no limitation'));
      echo $form->input('description');
	?>
	</fieldset>
<?php echo $this->element('back_btn');?> 
<?php echo $form->end('Submit');?>
</div>
