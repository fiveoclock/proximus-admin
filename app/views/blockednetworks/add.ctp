<div class="blockednetworks form">
<?php echo $form->create('Blockednetwork');?>
	<fieldset>
 		<legend><?php __('Add Blocked Network');?></legend>
	<?php
		echo $form->input('network');
		echo $form->input('description');
		echo $form->input('location_id');
	?>
	</fieldset>
<?php echo $this->element('back_btn');?> <?php echo $form->end('Submit');?>
</div>
