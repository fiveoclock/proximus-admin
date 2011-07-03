<div class="blockednetworks index">
<h2><?php __('Blocked Networks');?></h2>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Add a blocked network', true), array('action'=>'add')); ?></li>
	</ul>
</div>
<br>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table>
<tr>
	<th><?php echo $paginator->sort('network');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th><?php echo $paginator->sort('Location','Location.code');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($blockednetworks as $blockednetwork):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $blockednetwork['Blockednetwork']['network']; ?>
		</td>
		<td>
			<?php echo $blockednetwork['Blockednetwork']['description']; ?>
		</td>
		<td>
			<?php echo $blockednetwork['Location']['code']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $blockednetwork['Blockednetwork']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $blockednetwork['Blockednetwork']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $blockednetwork['Blockednetwork']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
