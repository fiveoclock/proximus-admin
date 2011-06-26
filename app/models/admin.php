<?php
class Admin extends AppModel {

	var $name = 'Admin';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasAndBelongsToMany = array(
		'Location' => array(
			'className' => 'Location',
			'joinTable' => 'admins_locations',
			'foreignKey' => 'admin_id',
			'associationForeignKey' => 'location_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

  var $validate = array(

    'username' => array(
      'notEmpty' => array(
        'rule' => 'notEmpty',
        'message' => 'The username cannot be empty'
      ),
      'isUnique' => array(
        'rule' => 'isUnique',
        'message' => 'The username is already taken.'
      )
    ),
    'password_confirm' => array(
                        'notEmpty',
                        'alphanumeric' => array(
                                'rule' => array('custom', '/^[a-z0-9 ]*$/i'),
                                'message' => 'Only alphabets and numbers allowed'
                        ),
                        'between' => array(
                                'rule' => array('between', 4, 20),
                                'message' => 'Password must be between 4 and 20 characters long.'
                        ),
      )
   );
  
}
?>
