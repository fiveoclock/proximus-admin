<?php
class Group extends AppModel {

	var $name = 'Group';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array('Location');

	var $hasMany = array(
      'Rule' => array(
         'className' => 'Rule',
         'foreignKey' => 'group_id',
         'dependent' => true,
         'conditions' => '',
         'fields' => '',
         'order' => '',
         'limit' => '',
         'offset' => '',
         'exclusive' => '',
         'finderQuery' => '',
         'counterQuery' => ''
      ),
      'User' => array(
         'className' => 'User',
         'foreignKey' => 'group_id',
         'dependent' => false,
         'conditions' => '',
         'fields' => '',
         'order' => '',
         'limit' => '',
         'offset' => '',
         'exclusive' => '',
         'finderQuery' => '',
         'counterQuery' => ''
      ),
   );

#	var $hasAndBelongsToMany = array('User');
	var $validate = array(
		'name' => array('notempty')
	);
}
?>
