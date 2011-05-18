<div class="noauth_rules form">
<?php echo $form->create('NoauthRule');?>
	<fieldset>
 		<legend><?php __('Add Noauth Rule');?></legend>
	<?php
		echo $form->input('type', array('options' => array('DN'=>'DN','IP'=>'IP')));
		echo $form->input('sitename');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $this->element('back_btn');?>
<?php echo $form->end('Submit');?>
</div>
