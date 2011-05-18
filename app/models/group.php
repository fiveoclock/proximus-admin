<?php
class Group extends AppModel {

	var $name = 'Group';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array('Location');

	var $hasMany = array('Rule','User');
#	var $hasAndBelongsToMany = array('User');
	var $validate = array(
		'name' => array('notempty')
	);
}
?>