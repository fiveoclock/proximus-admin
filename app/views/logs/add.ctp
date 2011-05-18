<div class="logs form">
<?php echo $form->create('Log');?>
	<fieldset>
 		<legend><?php __('Add Log');?></legend>
	<?php
		echo $form->input('sitename');
		echo $form->input('ipaddress');
		echo $form->input('protocol');
		echo $form->input('user_id');
		echo $form->input('location_id');
		echo $form->input('parent_id');
		echo $form->input('source');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Logs', true), array('action'=>'index'));?></li>
	</ul>
</div>
