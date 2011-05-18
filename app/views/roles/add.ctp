<div class="roles form">
<?php echo $form->create('Role');?>
	<fieldset>
 		<legend><?php __('Add Role');?></legend>
	<?php
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Roles', true), array('action'=>'index'));?></li>
	</ul>
</div>
