<?php
class LogsController extends AppController {
   var $name = 'Logs';
   var $pageTitle = 'Logs';
   var $helpers = array('Html', 'Form', 'Policy');
   var $uses = array('Log','Location','User','ProxySetting', 'Rule');
   var $paginate = array('limit' => 100);

   function beforeFilter() {
      parent::beforeFilter();
   }

   function afterFilter() {
      $allowedActions = array('admin_searchlist');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass']);
      }
   }

   function admin_searchlist() {
      /* # don't really know.......
      if ($this->Session->read('Auth.godmode') != 1) {
         $this->Session->setFlash(__('You are not allowed to access this search method', true));
         $this->Tracker->back();
      }
      */
      $user = parent::getUser();

      # get proxys / locations
      if( $user['Role']['name'] == "admin_global" ) {
         $find_conditions = array("Location.id NOT" => "1");
      }
      else {
         $allowed_locations = parent::getAdminLocationIds();
         $find_conditions = array('Location.id'=>$allowed_locations,
                                 'Location.id NOT' => "1");
      }

      $proxy_list = $this->ProxySetting->find('all',
            array(
               'fields'=>array(
                  'Location.id','Location.code','Location.name','ProxySetting.fqdn_proxy_hostname', 'ProxySetting.id'
                  ),
               'conditions'=>$find_conditions,
               'order'=>array('Location.code')
            )
         );

      $proxyIds = Set::combine(
         $proxy_list,
         '{n}.ProxySetting.id',
         array('%s - %s','{n}.Location.code','{n}.ProxySetting.fqdn_proxy_hostname')
      );
      $this->set(compact('proxyIds'));


      ##################
      # If form was submitted
      if (!empty($this->data) && isset($this->data['Log']['proxyId'])) {
         $proxy = $this->ProxySetting->findById($this->data['Log']['proxyId']);

         // check permissions
         if ( ! parent::checkSecurity( $proxy['ProxySetting']['location_id'] ) ) $this->Tracker->back();

         // use correct datasource
         $this->CommonTasks->setDataSource($proxy);

         # build up conditions for query
         $conditions = array();
         if( !empty($this->data['Log']['site'])) {
            $conditions['Log.sitename LIKE'] = '%'.$this->data['Log']['site'].'%';
         }
         if ( !empty($this->data['Log']['onlyThisLoc'])) {
            $conditions['Log.location_id'] = $proxy['ProxySetting']['location_id'];
         }
         if ( !empty($this->data['Log']['status'])) {
            $conditions['Log.source'] = $this->data['Log']['status'];
         }
         if ( !empty($this->data['Log']['type'])) {
            if ( $this->data['Log']['type'] == "NOT null" ) array_push($conditions, array("not" => array ( "Log.parent_id" => null) ) );
            if ( $this->data['Log']['type'] == "null" ) $conditions['Log.parent_id'] = null;
         }
         if ( !empty($this->data['Log']['users'])) {
            # first get the ids of the matching users
            $user_ids = $this->User->find('all',array('fields'=>'id','conditions'=>array(
                                          'or'=>array(
                                             'User.realname LIKE'=>'%'.$this->data['Log']['users'].'%',
                                             'User.username LIKE'=>'%'.$this->data['Log']['users'].'%'))));
            $user_ids = Set::extract('/User/id', $user_ids);

            $conditions['Log.user_id'] = $user_ids;
         }
         // set parrent id to avoid double entries...
         if( empty($this->data['Log']['users']) && empty($this->data['Log']['site']) && empty($this->data['Log']['type']) ) {
            $conditions['Log.parent_id'] = null;
         }

         // delete if requested...
         if ( isset($this->params['form']['deleteMatching']) ) {
            $this->Log->deleteAll($conditions);
         }

         // do a search 
         $tree = $this->Log->find('all',array('conditions'=>$conditions ));
         $this->set('logs',$tree);

         $this->log( $this->MyAuth->user('username') . "; $this->name; search logs", "activity");
         #pr($conditions);    # debug
      }
   }

	function admin_index() {
		$this->Log->recursive = 0;
		$this->set('logs', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Log.', true));
			$this->Tracker->back();
		}
		$this->set('log', $this->Log->read(null, $id));
	}

	function admin_delete($id = null, $proxy_id = null) {
		if (!$id || !$proxy_id) {
			$this->Session->setFlash(__('Invalid id for Log', true));
			$this->Tracker->back();
      }
      $proxy = $this->ProxySetting->findById($proxy_id);
      //pr($proxy);
      $this->CommonTasks->setDataSource($proxy);

		if ($this->Log->delete($id)) {
         $this->log( $this->MyAuth->user('username') . "; $this->name; delete: " . $this->data['Log']['id'], 'activity');
			$this->Session->setFlash(__('Log deleted', true));
		   $this->Tracker->back();
		}
	}

	function admin_createRule($id = null, $proxy_id = null) {
      // if the form was submitted
      if (!empty($this->data)) {
         $this->Rule->create();

         // check security
         if ( ! parent::checkSecurity( $this->data['Rule']['location_id'] )) $this->Tracker->back();

         // set the time to null if start and end is the same
         if ( $this->data['Rule']['starttime']  == $this->data['Rule']['endtime'] ) {
            $this->data['Rule']['starttime'] = null;
            $this->data['Rule']['endtime'] = null;
         }

         // if group a group was selected set it, else use 0
         if (!empty($this->data['Rule']['groups'])) {
            $this->data['Rule']['group_id'] = $this->data['Rule']['groups'];
         }
         else {
            $this->data['Rule']['group_id'] = 0;
         }

         // save the rule
         //debug($this->data['Rule']); return;
         if ($this->Rule->save($this->data)) {
            if ($this->data['Rule']['delete_log'] == 1) {
               // set the right datasource
               $proxy = $this->ProxySetting->findById( $this->data['Rule']['proxy_id'] );
               $this->CommonTasks->setDataSource($proxy);

               // and delete the log
               if ($this->Log->delete( $this->data['Rule']['log_id'] )) {
                  $this->Session->setFlash(__('The Rule has been saved', true));
               }
               else {
                  $this->Session->setFlash(__('The Rule has been saved but logs could not be deleted, check manually', true));
               }
            }
            else {
               $this->Session->setFlash(__('The Rule has been saved', true));
            }
            $this->redirect(array('controller'=>'logs','action'=>'searchlist'));
         }
         else {
            $this->Session->setFlash(__('The Rule could not be saved. Please, try again.', true));
            $this->redirect(array('controller'=>'logs','action'=>'searchlist'));
         }
      }

      // show form
      if (!is_null($proxy_id) && !is_null($id)) {
         $proxy = $this->ProxySetting->findById($proxy_id);
         $this->CommonTasks->setDataSource($proxy);

         // get the log entrie and the user information
         $log = $this->Log->findById($id);
         $user = $this->Log->User->findById($log['Log']['user_id']);

         // check security
         if ( ! parent::checkSecurity( $user['Location']['id'] )) $this->Tracker->back();

         // get the groups
         $this->Location->Group->unbindModel(array('hasMany' => array('Rule','User')));
         $groups = $this->Location->Group->find('all',array(
                                                   'conditions'=>array(
                                                      'Group.location_id'=>$user['Location']['id']),
                                                   'order'=>array('Group.name') ));
         $groups_list = Set::combine($groups,'{n}.Group.id',array('%s - %s',"{n}.Location.code","{n}.Group.name"));

         // set variables for the view
         $this->set('groups',$groups_list);
         $this->set('location',$user['Location']['code']);

         $this->data['Rule']['sitename'] = $log['Log']['sitename'];
         $this->data['Rule']['protocol'] = $log['Log']['protocol'];
         $this->data['Rule']['description'] = 'Generated for user '.$user['User']['username'];
         $this->data['Rule']['location_id'] = $user['Location']['id'];
         $this->data['Rule']['log_id'] = $id;
         $this->data['Rule']['proxy_id'] = $proxy_id;
      }
	}



   function isAuthorized() {
      $parent = parent::isAuthorized();
      if ( !is_null($parent) ) return $parent;

      $locs = parent::getAdminLocationIds();

      if ( in_array($this->action, array('admin_delete', 'admin_view' ) )) {
         $log = $this->Log->read(null, $this->passedArgs['0'] );
         $locId = $log['Location']['id'];

         if ( ! parent::checkSecurity( $locId)) $this->Tracker->back();
         return true;
      }

      if ( in_array($this->action, array('admin_searchlist' ) )) {
         if ( isset($this->data) ) {
            $proxy = $this->ProxySetting->read(null, $this->data['Log']['proxyId'] );
            $locId = $proxy['Location']['id'];

            if ( ! parent::checkSecurity( $locId)) $this->Tracker->back();
         }
         return true;
      }

      if ( in_array($this->action, array('admin_createRule' ) )) {
         // security check in action
         return true;
      }

      return false;
   }

}
?>
