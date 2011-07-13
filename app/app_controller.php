<?php  
class AppController extends Controller {
   var $components = array('MyAuth', 'Session', 'Tracker', 'CommonTasks' );
   var $priv_roles = array('admin_global', 'admin_location_global_ro'); # global- and read-only admins
   var $helpers = array('Html', 'Form', 'Session', 'Menu');

   function beforeRender() {
      // get usermodel from auth
      $userModel = $this->MyAuth->getModel();
      // set the user_id and read the user
      $user = $userModel->read( null, $this->MyAuth->user('id') );
      // and set auth variable for the view
      $this->set('auth', $user);

      // set last pos
      $this->set('lastPos', $this->Tracker->lastPos());
      $this->Tracker->lastPos();

      # get global settings
      $settings = $this->CommonTasks->getGlobalSettings();
      $this->set('settings', $settings);
      $priv_roles = $this->priv_roles;
      $this->set('priv_roles', $priv_roles);
   }

   function beforeFilter() {
      //Configure AuthComponent
      $this->MyAuth->userModel = 'Admin';
      $this->MyAuth->authorize = 'controller';
      $this->MyAuth->autoRedirect = false;
      $this->MyAuth->loginAction = array('admin' => true, 'controller' => 'admins', 'action' => 'login');
      $this->MyAuth->logoutRedirect = array('admin' => false, 'controller' => 'pages', 'action' => 'start');
      $this->MyAuth->loginError = 'Invalid username / password combination. Please try again';
      $this->MyAuth->authError = 'Access denied';
      $this->MyAuth->userScope = array('Admin.active' => 'Y');
   } 
  
   function getAdminLocations() {
      $Location = ClassRegistry::init('Location'); 
      $loggeduser = $this->MyAuth->user();
      $locations_array = $Location->adminLocations($loggeduser['Admin']['id']);
      return $locations_array;   
   }

   function getAdminLocationIds() {
      $locations_array = self::getAdminLocations();
      $results = Set::extract('/Location/id', $locations_array);
      return $results;   
   }

   function isAuthorized() {
      $user = self::getUser();
     
      $this->log( $user['Admin']['username'] . "; $this->action; " , 'activity');
      if ( $user['Role']['name'] == 'admin_global') {
         return true;
      }
      elseif ($user['Role']['name'] == 'admin_location_global_ro') {
         if ( in_array($this->action, array('admin_index', 'admin_view')) ) {
            return true;
         }
         //return false;
      }
      return null;
   }

   // cheks if a admin has permissions for a certain location
   function checkSecurity($location_id, $location_ids=null) {
      $global = self::isAuthorized();
      if ( !is_null($global) ) return $global;

      if ( is_null($location_ids) ) {
         $location_ids = self::getAdminLocationIds();
      }
      
      if ( !in_array($location_id, $location_ids) ) {
         $this->Session->setFlash(__('Sorry, you have no permissions for this location.', true));
         return false;
      }
      return true;
   }

   function getUser() {
      return $this->Session->read('User');
      /*
      $model = $this->MyAuth->getModel();
      return $model->findById( $this->MyAuth->user('id') ); */
   }

} 
?>
