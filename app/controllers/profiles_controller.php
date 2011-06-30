<?php
class ProfilesController extends AppController {

	var $name = 'Profiles';
	var $helpers = array('Html', 'Form');
   var $paginate = array('limit' => 100);
   var $uses = array('User', 'GlobalSetting', 'Log', 'ProxySetting');

   function beforeFilter() {
      //parent::beforeFilter();
      $this->MyAuth->userModel = 'User';
      //$this->MyAuth->authorize = 'controller';
      $this->MyAuth->loginAction = array('user' => true, 'controller' => 'profiles', 'action' => 'login');
      $this->MyAuth->loginRedirect = array('user' => true, 'controller' => 'profiles', 'action' => 'start');
      $this->MyAuth->logoutRedirect = array('user' => false, 'controller' => 'pages', 'action' => 'start');
      $this->MyAuth->loginError = 'Invalid username / password combination. Please try again';
      $this->MyAuth->authError = 'Access denied';
      $this->MyAuth->userScope = array('User.active' => 'Y');
   }

   function afterFilter() {
      $allowedActions = array('user_start', 'user_view', 'user_logs');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass']);
      }   
   }   

   function user_login() {
   }

   function user_logout() {
      $this->Session->setFlash('Good-Bye');
      $this->log( $this->MyAuth->user('username') . "; $this->name; logout: " . $this->data['User']['username'], 'activity');
      $this->redirect($this->MyAuth->logout());
   }

   function user_start() {
   }

   function user_view($id = null) {
      if (!$id) {
         $this->Session->setFlash(__('Invalid user.', true));
         $this->redirect(array('controller'=>'profiles','action'=>'index'));
      }
      $user= $this->User->read(null, $id);
      $this->set('user', $user);
   }

   function user_logs() {
      $user = parent::getUser();
      $this->set('location', $user['Location']['id'] );
      $this->set('user', $user );

      ##################
      # If form was submitted
      if (!empty($this->data) ) {
         $model = $this->modelClass;
         $proxy = $this->ProxySetting->find('first', array( 'conditions' => array('Location.id' => $user['Location']['id'] ), ) );

         $this->set('proxy', $proxy);

         // use correct datasource
         $this->CommonTasks->setDataSource($proxy);

         # build up conditions for query
         $conditions = array();
         $conditions['Log.user_id'] =  $user['User']['id'];

         if( !empty($this->data[$model]['site'])) {
            $conditions['Log.sitename LIKE'] = '%'.$this->data[$model]['site'].'%';
         }
         if ( !empty($this->data[$model]['status'])) {
            $conditions['Log.source'] = $this->data[$model]['status'];
         }
         if ( !empty($this->data[$model]['type'])) {
            if ( $this->data[$model]['type'] == "NOT null" ) array_push($conditions, array("not" => array ( "Log.parent_id" => null) ) );
            if ( $this->data[$model]['type'] == "null" ) $conditions['Log.parent_id'] = null;
         }
         // set parrent id to avoid double entries...
         if( empty($this->data[$model]['users']) && empty($this->data[$model]['site']) && empty($this->data[$model]['type']) ) {
            $conditions['Log.parent_id'] = null;
         }

         // delete if requested...
         if ( isset($this->params['form']['deleteMatching']) ) {
            $this->Log->deleteAll($conditions);
         }

         // do a search 
         $tree = $this->Log->find('all',array('conditions'=>$conditions ));
         $this->set('logs',$tree);
      }
   }

   function user_confirmlog($id = null, $proxy_id = null) {
      if (!$id || !$proxy_id) {
         $this->Session->setFlash(__('Invalid id for Log', true));
         $this->Tracker->back();
      }
      $proxy = $this->ProxySetting->findById($proxy_id);
      //pr($proxy);
      $this->CommonTasks->setDataSource($proxy);

      $this->Log->id = $id;
      $this->Log->set('source', 'USER');

      if ($this->Log->save()) {
         $this->Session->setFlash(__('Log confirmed', true));
         $this->Tracker->back();
      }
   }

   function user_deletelog($id = null, $proxy_id = null) {
      if (!$id || !$proxy_id) {
         $this->Session->setFlash(__('Invalid id for Log', true));
         $this->Tracker->back();
      }
      $proxy = $this->ProxySetting->findById($proxy_id);
      //pr($proxy);
      $this->CommonTasks->setDataSource($proxy);

      if ($this->Log->delete($id)) {
         $this->Session->setFlash(__('Log deleted', true));
         $this->Tracker->back();
      }
   }

   function user_setPassword($id = null) {
      $this->User->recursive = -1;
      $this->User->id = $this->MyAuth->user('id');
      $user = $this->User->read();
      $this->set('user', $user );

      if (!empty($this->data)) {
         $password1 = $this->data['User']['password'];
         $password2 = $this->data['User']['password_confirm'];

         // check if old password is correct
         if ( $user['User']['password'] != $this->MyAuth->password($this->data['User']['password_old']) ) {
            $this->Session->setFlash(__('Your current password is incorrect.', true));
            return;
         }

         // check if the new password was typed in correctly
         if ( $password1 != $password2 ) {
            $this->Session->setFlash(__('New password mismatch. Please, retype the password again.', true));
            return;
         }

         // set password in array and do validation
         $user['User']['password'] = $this->MyAuth->password( $password1 );
         $user['User']['password_confirm'] = $password2;
         $this->User->set($user) && $this->User->validates();

         // save the password
         $user['User']['password'] = $this->MyAuth->password( $password1 );
         if ($this->User->save($user)) {
            $this->Session->setFlash(__('New password was set', true));
            $this->Tracker->back();
         }
         else {
            $this->Session->setFlash(__('Password could not be saved. Please, try again.', true));
         }
      }
   }



}

?>
