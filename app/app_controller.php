<?php  
class AppController extends Controller {
   var $components = array('Acl', 'MyAuth', 'Session', 'Tracker');
   var $priv_roles = array(1, 3); # global- and read-only admins

   function beforeRender() {
      $this->set('auth', $this->MyAuth->user());
   }

   function beforeFilter() {
      //Configure AuthComponent
      $this->MyAuth->userModel = 'Admin';
      $this->MyAuth->authorize = 'controller';
      $this->MyAuth->loginAction = array('admin' => true, 'controller' => 'admins', 'action' => 'login');
      $this->MyAuth->loginRedirect = array('admin' => true, 'controller' => 'locations', 'action' => 'start');
      $this->MyAuth->logoutRedirect = array('admin' => false, 'controller' => 'pages', 'action' => 'start');
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
      $user = $this->getUser();
      //pr( $user);
      //pr( $user['Role']['name'] );

      // maybe move this to auth??
      $this->Session->write('role', $user['Role'] );
      
      $this->log( $user['Admin']['username'] . "; $this->action; " , 'activity');
      if ( $user['Role']['name'] == 'admin_global') {
         return true;
      }
      elseif ($user['Role']['name'] == 'admin_location_global_ro') {
         if ( in_array($this->action, array('admin_index', 'admin_view', 'admin_start')) ) {
            return true;
         }
         //return false;
      }
      return null;
   }

   function checkSecurity($location_id) {
      $global = $this->isAuthorized();
      if ( !is_null($global) ) return $global;
      
      if ( !in_array($location_id, $this->getAdminLocationIds()) ) {
         $this->Session->setFlash(__('Sorry, you have no permissions for this location.', true));
         return false;
      }
      return true;
   }

   function checkLocationSecurity($location_id) {
      if ( !in_array($location_id, $this->getAdminLocationIds()) ) {
         $this->Session->setFlash(__('Sorry, you have no permissions for this location.', true));
         return false;
      }
      return true;
   }

   function getUser() {
      $model = $this->MyAuth->getModel();
      return $model->findById( $this->MyAuth->user('id') );
   }

} 
?>
