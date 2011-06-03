<div class="globalsettings index">
<h2><?php __('Global settings');?></h2>
<div class="actions">
	<ul>
      <li><?php echo $html->link(__('Edit the global settings', true), array('action'=>'edit', 1)); ?></li>
	</ul>
</div>
<br>
<p>
<?php

?>
</p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th>Setting name</th>
	<th>Value</th>
</tr>

<?php
$settings = $global_settings[0];
?>

	<tr>
		<td>
			subsite_sharing
		</td>
		<td>
			<?php echo $settings['GlobalSetting']['subsite_sharing']; ?>
		</td>
   </tr>
   <tr>
		<td>
			mail_interval
		</td>
		<td>
			<?php echo $settings['GlobalSetting']['mail_interval']; ?>
		</td>
   </tr>
   <tr>
		<td>
			retrain_key
		</td>
		<td>
			<?php echo $settings['GlobalSetting']['retrain_key']; ?>
		</td>
	</tr>
   <tr>
		<td>
			regex_cut
		</td>
		<td>
			<?php echo $settings['GlobalSetting']['regex_cut']; ?>
		</td>
	</tr>

</table>
</div>

<h3><?php __('Description');?></h3>
	<ul>
      <li>subsite_sharing - defines the bahaviour of the subsite sharing feature when dynamic rules are allowed; values:<br>"own_parents": access is granted to subsites the user discovered himself. <br>"all_parents": access is granted to all known subsites, even if they are from another user.</li>
      <li>mail_interval - if the rule DENY_MAIL is used, this value defines the interval in hours in which the deny mail is sent to the user</li>
      <li>retrain_key - prefix for the URL; if this key is used when accessing a website, ProXimus will learn new subsites</li>
      <li>regex_cut - is used to cut away a prefix from the username (eg. DOMAIN\user => user)</li>
	</ul>
<br>
<p>


