<?php
class PagesController extends AppController {
	var $name = 'Pages';
	var $helpers = array('Html');
	var $uses = array();

   function afterFilter() {
      $allowedActions = array('view', 'index', 'display');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass']);
      }
   }

   function beforeFilter() {
      parent::beforeFilter();
      $this->MyAuth->allowedActions = array('display');
   }

	function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title = Inflector::humanize($path[$count - 1]);
		}

      # get global settings
      $settings = $this->CommonTasks->getGlobalSettings();

      $this->set('settings', $settings);
      $this->set('priv_roles', $this->priv_roles);
		$this->set(compact('page', 'subpage', 'title'));

		$this->render(join('/', $path));
	}
}

?>
