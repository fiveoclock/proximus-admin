<?
class Rule extends AppModel {
	var $name = 'Rule';
	var $belongsTo = array('Location','Group');
	var $validate = array(
		'sitename' => array('notempty'),
		'protocol' => array('notempty'),
		'priority' => array('notempty')
	);
}
?>