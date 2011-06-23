<div class="blockednetworks form">
<?php echo $form->create('Blockednetwork');?>
	<fieldset>
 		<legend><?php __('Edit Blocked Network');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('network');
		echo $form->input('description');
		echo $form->input('location_id');
	?>
   <?php echo $form->end('Submit');?>
   <?php echo $this->element('back_btn');?> 
	</fieldset>
</div>

