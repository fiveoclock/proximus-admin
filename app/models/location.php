<?php
class Location extends AppModel {

	var $name = 'Location';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Blockednetwork' => array(
			'className' => 'Blockednetwork',
			'foreignKey' => 'location_id',
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
      'NoauthRule' => array(
         'className' => 'NoauthRule',
         'foreignKey' => 'location_id',
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
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'location_id',
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
		'Log' => array(
			'className' => 'Log',
			'foreignKey' => 'location_id',
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
		'ProxySetting' => array(
			'className' => 'ProxySetting',
			'foreignKey' => 'location_id',
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
		'Rule' => array(
			'className' => 'Rule',
			'foreignKey' => 'location_id',
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
			'foreignKey' => 'location_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	var $hasAndBelongsToMany = array(
		'Admin' => array(
			'className' => 'Admin',
			'joinTable' => 'admins_locations',
			'foreignKey' => 'location_id',
			'associationForeignKey' => 'admin_id',
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

   public function userLocations($admin_id = null,$role_id = null,$location_id = null) {
      $this->recursive = 0;
      if($role_id > 1) {
         $this->bindModel(array('hasOne' => array('AdminsLocation')));
         if(is_null($location_id)) {
            $find_condition = array('fields' => array('Location.*'),
                               'conditions'=>array('AdminsLocation.admin_id'=>$admin_id),
                               'order'=>'Location.code'
                               );
         }
         else {
            $find_condition = array('fields' => array('Location.*'),
                               'conditions'=>array('AdminsLocation.admin_id'=>$admin_id,'Location.id'=>$location_id),
                               'order'=>'Location.code'
                               );
         }
      }
      elseif($role_id == 1) {
         if(is_null($location_id)) {
            $find_condition = array('order'=>'Location.code');
         }
         else {
            $find_condition = array('conditions'=>array('Location.id'=>$location_id),'order'=>'Location.code');
         }
      }
         $location_array = $this->find('all',$find_condition);
         return $location_array;
   }
   
   public function adminLocations($admin_id = null) {
      $this->recursive = 0;
      $this->bindModel(array('hasOne' => array('AdminsLocation')));
      $find_condition = array('fields' => array('Location.id'),
                               'conditions'=>array('AdminsLocation.admin_id'=>$admin_id),
                               'order'=>'Location.id'
                               );
      $location_array = $this->find('all',$find_condition);
      return $location_array;
   }

   var $validate = array(
      'code' => array(
         'rule' => array('isUnique'),
         'message' => 'Location code already used.'
      )
   );

}
?>
