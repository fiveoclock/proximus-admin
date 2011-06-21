<?php
class Log extends AppModel {

	var $name = 'Log';

   var $belongsTo = array(
      'Location' => array(
         'className' => 'Location',
         'foreignKey' => 'location_id',
         'conditions' => '',
         'fields' => '',
         'order' => ''
      ),
      'User' => array(
         'className' => 'User',
         'foreignKey' => 'user_id',
         'conditions' => '',
         'fields' => '',
         'order' => ''
      ),
      'Parent' => array(
         'className' => 'Log',
         'foreignKey' => 'parent_id',
         'conditions' => '',
         'fields' => '',
         'order' => ''
      ),

   );
/*
   var $hasMany = array(
      'Child' => array(
         'className' => 'Log',
         'foreignKey' => 'parent_id'
      ),
   );
*/

   var $hasAndBelongsToMany = array(
      'Child' => array(
         'className' => 'Log',
         'joinTable' => 'logs',
         'foreignKey' => 'parent_id',
         'associationForeignKey' => 'id',
         'unique' => '',
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

function deleteLog($id = null,$loc_code = null) {
      
      if (!$id || !$loc_code) {
         return false;
      }
      else {
         # connect Log model the correct DB
         $this->useDbConfig = $loc_code;

         $children = $this->findByParentId($id);
         if (!empty($children)) {
            $condition = array('parent_id'=>$id);
            $this->deleteAll($condition);
         }
         if ($this->delete($id)) {
            return true;
         }
         else {
            return false;
         }
      }
}

}
?>
