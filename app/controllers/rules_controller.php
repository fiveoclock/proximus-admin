<?php
class RulesController extends AppController {

	var $name = 'Rules';
	var $helpers = array('Html', 'Form', 'Policy');
   var $uses = array('Rule','ProxySetting','Log','Location','Group');

   function beforeFilter() {
      parent::beforeFilter();
   }

	function getAll() {
		return $this->Rule->find('all');
	}

   function afterFilter() {
      $allowedActions = array('admin_searchlist');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass']);
      }   
   }   

   function admin_search($pattern = null) {
      # code after form submit
		if (!empty($this->data)) {
         $pattern = "'%".$this->data['Rule']['pattern']."%'";
         $WILDCARD = "'*'";
         $search_result = $this->Rule->query('SELECT * 
                                             FROM rules LEFT JOIN groups on rules.group_id = groups.id 
                                                        LEFT JOIN locations as loc1 on rules.location_id = loc1.id 
                                                        LEFT JOIN locations as loc2 on groups.location_id = loc2.id
                                             WHERE (rules.sitename LIKE '.$pattern.' OR rules.sitename = '.$WILDCARD.')
                                             AND (rules.location_id = 1 OR rules.location_id = '.$this->data['Rule']['locations'].')
                                             ORDER BY sitename, priority;',$cachequeries = false);
         #pr($search_result);
         $this->set('results',$search_result);
      }

      if( !in_array($this->Session->read('role.name'), $this->priv_roles) ) {
         $allowed_locations = parent::getAdminLocationIds();
         $find_condition = array('fields' => array('Location.*'),
                              'conditions'=>array("AND" => array(
                                    'Location.id'=>$allowed_locations,
                                    'Location.id NOT' => "1"),),
                              'order'=>'Location.code' );
      }
      else {
         $find_condition = array('fields' => array('Location.*'), 'order'=>'Location.code', 'conditions'=>array("id NOT" => "1"), );
      }

      $locations_list = $this->Location->find('all',$find_condition);
      $locations = Set::combine(
         $locations_list,
         '{n}.Location.id',
         array('%s %s','{n}.Location.code','{n}.Location.name')
      );
      $this->set(compact('locations'));
   }

   // todo ... check this code... + auth
	function admin_createFromLog($log_id = null,$location_id = null) {
      if (!empty($this->data)) {
         $this->Rule->create();
         $this->data['Rule']['group_id'] = 0;
         if (!empty($this->data['Rule']['groups'])) {
            $this->data['Rule']['group_id'] = $this->data['Rule']['groups'];
         }
         if ($this->Rule->save($this->data)) {
            #debug($this->data['Rule']);
            if ($this->data['Rule']['delete_log'] == 1) {
               if ($this->Log->deleteLog($this->data['Rule']['log_id'],$this->data['Rule']['location_code'])) {
                  $this->Session->setFlash(__('The Rule has been saved', true));
               }
               else {
               $this->Session->setFlash(__('The Rule has been saved but logs could not be deleted, check manually', true));
               }
            }
            else {
               $this->Session->setFlash(__('The Rule has been saved', true));
               $this->log( $this->MyAuth->user('username') . "; $this->name; create from log: " . $this->data['Rule']['id'], 'activity');
            } 
            $this->redirect(array('controller'=>'logs','action'=>'searchlist'));
         } else {
            $this->Session->setFlash(__('The Rule could not be saved. Please, try again.', true));
            $this->redirect(array('controller'=>'logs','action'=>'searchlist'));
         }
      }
#OPEN: check if the user is allowed to create this rule, access this log
      
      if (!is_null($location_id) && !is_null($log_id)) {
         $location = $this->Location->findById($location_id);
         $this->Log->useDbConfig = $location['Location']['code'];
         $log = $this->Log->findById($log_id);
         $user = $this->Location->Group->User->findById($log['Log']['user_id']);
         $this->Location->Group->unbindModel(array('hasMany' => array('Rule','User')));
         $groups = $this->Location->Group->find('all',array(
                                                   'conditions'=>array(
                                                      'Group.location_id'=>$location_id),
                                                   'order'=>array(
                                                      'Group.name')));
         $groups_list = Set::combine($groups,'{n}.Group.id',array('%s - %s',"{n}.Location.code","{n}.Group.name"));

         $this->set('groups',$groups_list);
         $this->set('location',$location['Location']['code']);

         $this->data['Rule']['sitename'] = $log['Log']['sitename'];
         $this->data['Rule']['protocol'] = $log['Log']['protocol'];
         $this->data['Rule']['description'] = 'Generated for user '.$user['User']['username'];
         $this->data['Rule']['location_id'] = $location_id;
         $this->data['Rule']['log_id'] = $log_id;
         $this->data['Rule']['location_code'] = $location['Location']['code'];
      }
   }

	function admin_add($location_id = null, $group_id = null) {
      if (array_key_exists('cancel', $this->params['form'])) {  
         $this->Session->setFlash(__('Canceled', true));
         $this->Tracker->back();
      } 
		if (!empty($this->data)) {
         // check permission
         if ( ! parent::checkSecurity( $this->data[ $this->modelClass ][ 'location_id' ] )) $this->Tracker->back();

			$this->Rule->create();
			
         if ($this->Rule->save($this->data)) {
				$this->Session->setFlash(__('The Rule has been saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name; add: " . $this->data['Rule']['id'], 'activity');
            $this->Tracker->back();

			} else {
				$this->Session->setFlash(__('The Rule could not be saved. Please, try again.', true));
            $this->Tracker->back();
			}
		}
		
      if(!is_null($location_id)) {
         // check permission
         if ( ! parent::checkSecurity( $location_id )) $this->Tracker->back();

         $this->data['Rule']['location_id'] = $location_id;
      }
      else {
			$this->Session->setFlash(__('Unknown location_id, please choose valid location!', true));
			$this->Tracker->back();
      }    
      if(!is_null($group_id)) {
         $group = $this->Group->read(null, $group_id);
         $this->data['Rule']['group_id'] = $group_id;
      }
      else {
         $group_id = 0; 
         $this->data['Rule']['group_id'] = $group_id;
      }
	}

	function admin_edit($id = null) {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->Tracker->back();
      }
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Rule', true));
   		$this->Tracker->back();
		}
      
		if (!empty($this->data)) {
			if ($this->Rule->save($this->data)) {
				$this->Session->setFlash(__('The Rule has been saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name; edit: " . $this->data['Rule']['id'], 'activity');
            $this->Tracker->back();
			} else {
				$this->Session->setFlash(__('The Rule could not be saved. Please, try again.', true));
            $this->Tracker->back();
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Rule->read(null, $id);
         # fix the problem with time values for empty start/endtime
         if (is_null($this->data['Rule']['starttime'])) {
            $this->data['Rule']['starttime'] = '0:00';
         }
         if (is_null($this->data['Rule']['endtime'])) {
            $this->data['Rule']['endtime'] = '0:00';
         }
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Rule', true));
			$this->Tracker->back();
		}

		if ($this->Rule->delete($id)) {
			$this->Session->setFlash(__('Rule deleted', true));
         $this->log( $this->MyAuth->user('username') . "; $this->name; delete: " . $this->data['Rule']['id'], 'activity');
			$this->Tracker->back();
		}
	}

   function isAuthorized() {
      $parent = parent::isAuthorized();
      if ( !is_null($parent) ) return $parent;

      if ( in_array($this->action, array('admin_view', 'admin_edit', 'admin_delete') )) {
         $rule = $this->Rule->read(null, $this->passedArgs['0'] );
         $locId = $rule['Location']['id'];

         if ( ! parent::checkSecurity( $locId)) $this->Tracker->back();
         return true;
      }

      if ($this->action == 'admin_search') {
         return true;
      }

      if ($this->action == 'admin_add') {
         // permission check within the function
         return true;
      }

      return false;
   }

}
?>
