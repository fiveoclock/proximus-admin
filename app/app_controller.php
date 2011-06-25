<?php  
class AppController extends Controller { 
  var $components = array('Acl', 'MyAuth', 'Session', 'Tracker');
  var $priv_roles = array(1, 3); # global- and read-only admins


// http://unknown-host.com/blog/2011/04/06/ldap-authentication-in-cakephp/#more-35

   function beforeRender() {
      $this->set('auth', $this->MyAuth->user());
      //$this->set('godmode', $this->Session->read('Auth.Admin.role_id'));
   }

   function beforeFilter() {
      //Configure AuthComponent
      $this->MyAuth->userModel = 'Admin';
      $this->MyAuth->authorize = 'controller';
      //$this->MyAuth->actionPath = 'controllers/';
      $this->MyAuth->loginAction = array('admin' => true, 'controller' => 'admins', 'action' => 'login');
      //$this->MyAuth->logoutRedirect = array('controller' => 'admins', 'action' => 'login');
      //$this->MyAuth->loginRedirect = array('admin' => true, 'controller' => 'locations', 'action' => 'start');
      $this->MyAuth->loginError = 'Invalid username / password combination. Please try again';
      $this->MyAuth->authError = 'Access denied';
      $this->MyAuth->userScope = array('Admin.active' => 'Y');
/*
      if ($this->MyAuth->user()) {
         $this->Session->write('Auth.locations', $this->checkAllowedLocations());
         if ($this->Session->read('Auth.Admin.role_id')==1) {
            #set godmode to 1 for global admin groups in order to see all entries
            $this->Session->write('Auth.godmode',1);
         }
      }
      else {
         $this->Session->destroy();
      }
 */     
   } 
  
   function getAdminLocations() {
      $Location = ClassRegistry::init('Location'); 
      $loggeduser = $this->MyAuth->user();
      $locations_array = $Location->adminLocations($loggeduser['Admin']['id']);
      return $locations_array;   
   }

   function getAdminLocationIds() {
      $locations_array = $this->getAdminLocations();
      $results = Set::extract('/Location/id', $locations_array);
      return $results;   
   }

   function isAuthorized() {
      $model = $this->MyAuth->getModel();
      $user = $model->findById( $this->MyAuth->user('id') );
      //pr( $user);
      //pr( $user['Role']['name'] );
      
      
      $this->log( $this->MyAuth->user('username') . "; $this->action; " , 'activity');
      if ( $user['Role']['name'] == 'Global Admin') {
         return true;
      }
      elseif ($user['Role']['name'] == 'Location Admin + global view') {
         if ( in_array($this->action, array('admin_index', 'admin_view', 'admin_start')) ) {
            return true;
         }
         //return false;
      }
      return null;
   }


} 
?>
