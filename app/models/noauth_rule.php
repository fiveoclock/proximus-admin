<?php
class NoauthRule extends AppModel {

	var $name = 'NoauthRule';
	var $validate = array(
		'sitename' => array('notempty'),
		'protocol' => array('notempty')
	);

}
?>
