<?php
class ProfilesController extends AppController {

	var $name = 'Profiles';
	var $helpers = array('Html', 'Form');
   var $paginate = array('limit' => 100);
   var $uses = array('User', 'GlobalSetting');

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
      $allowedActions = array('view', 'index');
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

   function user_view($id = null) {
      if (!$id) {
         $this->Session->setFlash(__('Invalid user.', true));
         $this->redirect(array('controller'=>'profiles','action'=>'index'));
      }
      $user= $this->User->read(null, $id);
      $this->set('user', $user);
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
