<?php
class Log extends AppModel {

	var $name = 'Log';

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
         if ($this->del($id)) {
            return true;
         }
         else {
            return false;
         }
      }
}

}
?>
