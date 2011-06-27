<div class="admin view">
<h2><?php  __('Profile of '. $admin['Admin']['username']);?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $admin['Admin']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Username'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $admin['Admin']['username']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Real name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $admin['Admin']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Role'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $admin['Role']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $admin['Admin']['active']; ?>
			&nbsp;
		</dd>
		<dt>Assigned locations</dt>
   </dl>

<ul>
<?php
$i = 0;
foreach ($admin['Location'] as $location):
   echo "<li>" . $location['code'] . " - " . $location['name'] . "</li>";
endforeach;

?>
</ul>
</div>

<br>
<h2>Actions</h2>
<div class="actions">
   <ul>
      <li><?php echo $html->link('Change password',array('action'=>'changePassword',$this->data['Admin']['id'])); ?></li>
   </ul>
</div>

