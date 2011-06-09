<div class="globalsettings index">
<h2><?php __('Global settings');?></h2>
<table cellpadding="0" cellspacing="0">
<br>
<tr>
	<th>Setting name</th>
	<th>Value</th>
   <th class="actions"><?php __('Actions');?></th>
</tr>

<?php
$i = 0;
foreach ($global_settings as $setting):
   $class = null;
   if ($i++ % 2 == 0) {
      $class = ' class="altrow"';
   }
?>
   <tr<?php echo $class;?>>
      <td>
         <?php echo $setting['GlobalSetting']['name']; ?>
      </td>
      <td>
         <?php echo $setting['GlobalSetting']['value']; ?>
      </td>
      <td>
         <?php echo $html->link(__('Edit', true), array('action'=>'edit', $setting['GlobalSetting']['id'])); ?>
      </td>
   </tr>
<?php endforeach; ?>
</table>
</div>

<h3><?php __('Description');?></h3>
	<ul>
      <li>subsite_sharing - defines the bahaviour of the subsite sharing feature when dynamic rules are used; values:<br>empty: subsites are not shared among users <br>"own_parents": subsites are shared among users if the users share the parent site. <br>"all_parents": access to all known subsites is allowed, no matter what user they belog to.<br><br></li>
      <li>mail_interval - if the rule DENY_MAIL is used, this value defines the interval in hours in which the deny mail is sent to the user (0 for no interval)</li>
      <li>retrain_key - prefix for the URL; if this key is used when accessing a website, ProXimus will learn new subsites</li>
      <li>regex_cut - is used to cut away a prefix from the username (eg. DOMAIN\user => user)</li>
	</ul>
<br>
<p>


