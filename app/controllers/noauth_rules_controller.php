<?php
class NoauthRulesController extends AppController {

	var $name = 'NoauthRules';
	var $helpers = array('Html', 'Form');
   var $paginate = array('limit' => 100);

   function beforeFilter() {
      parent::beforeFilter();
      #$this->MyAuth->allowedActions = array('*');
   }

   function afterFilter() {
      $allowedActions = array('index');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass']);
      }   
   }   

	function admin_index() {

      # If form submit has been done
      if (!empty($this->data) && isset($this->data['NoauthRule']['searchstring'])) {

		   $this->NoauthRules->recursive = 0;
		   $this->set('noauth_rules', $this->paginate('NoauthRule',array('NoauthRule.sitename LIKE'=>'%'.$this->data['NoauthRule']['searchstring'].'%')));
      } 
      else {
         #$this->set('noauth_rules', $this->paginate());
         $this->set('noauth_rules', $this->paginate('NoauthRule',array('1=1 ORDER BY valid_until DESC') ));
      }
	}

	function admin_add() {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
		if (!empty($this->data)) {
			$this->NoauthRule->create();
			if ($this->NoauthRule->save($this->data)) {
				$this->Session->setFlash(__('The Noauth rule has been saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name ; edit: " . $id, 'activity');
				$this->redirect($this->Tracker->loadLastPos());
			} else {
				$this->Session->setFlash(__('The Noauth rule could not be saved. Please, try again.', true));
			}
		}

      # show location code + name 
      $locations_all = $this->NoauthRule->Location->find('all',array(
         'fields'=>array('Location.id','Location.code','Location.name'),
         'recursive'=>-1,
         'conditions'=>array("Location.id NOT" => "1"),
         'order'=>array(
            'Location.code',
      )));
      # convert array
      $locations = Set::combine(
         $locations_all,
         '{n}.Location.id',
         array('%s %s','{n}.Location.code','{n}.Location.name')
      );
      $this->set(compact('locations'));
	}

	function admin_edit($id = null) {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Noauth rule', true));
			$this->redirect($this->Tracker->loadLastPos());
		}
		if (!empty($this->data)) {
			if ($this->NoauthRule->save($this->data)) {
				$this->Session->setFlash(__('The Noauth rule has been saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name ; edit: " . $id, 'activity');
				$this->redirect($this->Tracker->loadLastPos());
			} else {
				$this->Session->setFlash(__('The Noauth rule could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->NoauthRule->read(null, $id);
		}

      # show location code + name 
      $locations_all = $this->NoauthRule->Location->find('all',array(
         'fields'=>array('Location.id','Location.code','Location.name'),
         'recursive'=>-1,
         'conditions'=>array("Location.id NOT" => "1"),
         'order'=>array(
            'Location.code',
      )));
      # convert array
      $locations = Set::combine(
         $locations_all,
         '{n}.Location.id',
         array('%s %s','{n}.Location.code','{n}.Location.name')
      );
      $this->set(compact('locations'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Noauth rule', true));
			$this->redirect($this->Tracker->loadLastPos());
		}
		if ($this->NoauthRule->delete($id)) {
			$this->Session->setFlash(__('Noauth rule deleted', true));
         $this->log( $this->MyAuth->user('username') . "; $this->name ; delete: " . $id, 'activity');
			$this->redirect($this->Tracker->loadLastPos());
		}
	}

   function isAuthorized() {
      $parent = parent::isAuthorized();
      if ( !is_null($parent) ) return $parent;

      $locs = parent::getAdminLocationIds();
      $rule = $this->NoauthRule->read(null, $this->passedArgs['0'] );
      $locId = $rule['Location']['id'];
      //pr ( $rule) ;
      //pr ( $locId) ;
      //pr ( $locs) ;

      if ($this->action == 'admin_index') {
         return true;
      }

      if ( in_array($this->action, array('admin_view', 'admin_add', 'admin_edit', 'admin_delete') )) {
         if (!in_array($locId, $locs )) {
            $this->Session->setFlash(__('You are not allowed to access this rule', true));
            return false;
         }
         return true;
      }

      return false;
   }

}
?>
