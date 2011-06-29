<div class="proxy_settings index">
<h2><?php __('Proxy Settings');?></h2>

<div class="actions">
   <ul>
      <li><?php echo $html->link(__('Create a new Proxy', true), array('action'=>'add')); ?></li>
   </ul>
   <br>
</div>


<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('Location','Location.code');?></th>
	<th><?php echo $paginator->sort('Hostname (fqdn)');?></th>
	<th><?php echo $paginator->sort('Admin E-Mail');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($proxy_settings as $proxy_setting):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $proxy_setting['Location']['code']; ?>
		</td>
		<td>
			<?php echo $proxy_setting['ProxySetting']['fqdn_proxy_hostname']; ?>
		</td>
		<td>
			<?php echo $proxy_setting['ProxySetting']['admin_email']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $proxy_setting['ProxySetting']['id'])); ?>
			<?php echo $html->link(__('DB settings', true), array('action'=>'editdb', $proxy_setting['ProxySetting']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $proxy_setting['ProxySetting']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $proxy_setting['ProxySetting']['id'])); ?>
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

