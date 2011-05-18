<div class="locations form">
<?php echo $form->create('Location');?>
	<fieldset>
 		<legend><?php __('Add Location');?></legend>
	<?php
		echo $form->input('code');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $this->element('back_btn');?>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Locations', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Groups', true), array('controller'=> 'groups', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Group', true), array('controller'=> 'groups', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Rules', true), array('controller'=> 'rules', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Rule', true), array('controller'=> 'rules', 'action'=>'add')); ?> </li>
	</ul>
</div>
