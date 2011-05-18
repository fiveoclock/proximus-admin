<?php  
class AppController extends Controller { 
  var $components = array('Acl', 'Auth', 'Tracker');

   function beforeRender() {
      $this->set('auth', $this->Auth->user());
      $this->set('godmode', $this->Session->read('Auth.Admin.role_id'));
   }

   function beforeFilter() {
      #Security::setHash('md5');
      //Configure AuthComponent
      $this->Auth->userModel = 'Admin';
      $this->Auth->authorize = 'actions';
      $this->Auth->actionPath = 'controllers/';
      $this->Auth->loginAction = array('controller' => 'admins', 'action' => 'login');
      $this->Auth->logoutRedirect = array('controller' => 'admins', 'action' => 'login');
      $this->Auth->loginRedirect = array('controller' => 'locations', 'action' => 'start');
      $this->Auth->loginError = 'Invalid username / password combination. Please try again';
      $this->Auth->authError = 'Your session has expired or you are not authorized to access that location!  Please log in again.';
      $this->Auth->userScope = array('Admin.active' => 'Y');
      if ($this->Auth->user()) {
         $this->Session->write('Auth.locations', $this->checkAllowedLocations());
         if ($this->Session->read('Auth.Admin.role_id')==1) {
            #set godmode to 1 for global admin groups in order to see all entries
            $this->Session->write('Auth.godmode',1);
         }
      }
      else {
         $this->Session->destroy();
      }
      
   } 
   
   function checkAllowedLocations() {
      $Location = ClassRegistry::init('Location'); 
      $loggeduser = $this->Auth->user();
      $locations_array = $Location->adminLocations($loggeduser['Admin']['id']);
      $results = Set::extract('/Location/id', $locations_array);
      #$locations = implode(',',$results);
      #$locations = "'".implode("','", $results)."'";

      return $results;   
   }
} 
?>
