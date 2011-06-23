<div class="roles form">
<?php echo $form->create('Role');?>
	<fieldset>
 		<legend><?php __('Edit Role');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Role.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Role.id'))); ?></li>
		<li><?php echo $html->link(__('List Roles', true), array('action'=>'index'));?></li>
	</ul>
</div>
