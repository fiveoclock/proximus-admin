<?php
class NoauthRulesController extends AppController {

	var $name = 'NoauthRules';
	var $helpers = array('Html', 'Form');
   var $paginate = array('limit' => 100);

   function beforeFilter() {
      parent::beforeFilter();
   }

   function afterFilter() {
      $allowedActions = array('admin_index');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass']);
      }   
   }   

	function admin_index() {
      $this->NoauthRules->recursive = 0;
      if (!empty($this->data) && isset($this->data['NoauthRule']['searchstring'])) {
		   $this->set('noauth_rules', $this->paginate('NoauthRule',array('NoauthRule.sitename LIKE'=>'%'.$this->data['NoauthRule']['searchstring'].'%')));
      } 
      else {
         $this->set('noauth_rules', $this->paginate('NoauthRule',array('1=1 ORDER BY valid_until DESC') ));
      }
	}

	function admin_add() {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->Tracker->back();
      }
      $this->CommonTasks->setLocationsList(true);

		if (!empty($this->data)) {
         // check permission
         if ( ! parent::checkSecurity( $this->data[ $this->modelClass ][ 'location_id' ] )) return;

			$this->NoauthRule->create();
			if ($this->NoauthRule->save($this->data)) {
				$this->Session->setFlash(__('The Noauth rule has been saved', true));
            $this->Tracker->back();
			}
         else {
				$this->Session->setFlash(__('The Noauth rule could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->Tracker->back();
      }
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Noauth rule', true));
         $this->Tracker->back();
		}
		if (!empty($this->data)) {
			if ($this->NoauthRule->save($this->data)) {
				$this->Session->setFlash(__('The Noauth rule has been saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name ; edit: " . $id, 'activity');
            $this->Tracker->back();
			} else {
				$this->Session->setFlash(__('The Noauth rule could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->NoauthRule->read(null, $id);
		}
      $this->CommonTasks->setLocationsList(true);
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Noauth rule', true));
         $this->Tracker->back();
		}
		if ($this->NoauthRule->delete($id)) {
			$this->Session->setFlash(__('Noauth rule deleted', true));
         $this->log( $this->MyAuth->user('username') . "; $this->name ; delete: " . $id, 'activity');
         $this->Tracker->back();
		}
	}

   function isAuthorized() {
      $parent = parent::isAuthorized();
      if ( !is_null($parent) ) return $parent;

      // get global settings
      $settings = $this->CommonTasks->getGlobalSettings();
      // deny if according to global setting
      if ( $settings['locadmin_manage_noauth'] != "true" ) return false;

      if ( in_array($this->action, array('admin_view', 'admin_edit', 'admin_delete') )) {
         $rule = $this->NoauthRule->read(null, $this->passedArgs['0'] );
         $locId = $rule['Location']['id'];

         if ( ! parent::checkSecurity( $locId)) $this->Tracker->back();
         return true;
      }

      if ( in_array($this->action, array('admin_index', 'admin_add' ) )) {
         // rest of security check in function
         return true;
      }

      return false;
   }

}
?>
