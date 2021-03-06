<?php

require_once(APPLICATION_PATH . '/modules/auth/models/DbTable/Users.php');
require_once(APPLICATION_PATH . '/modules/auth/models/DbTable/Roles.php');

class Auth_UsersController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->manage = true;
        
        $users = new Auth_Model_DbTable_Users();
        $result = $users->fetchAllR();
        $this->view->result = $result;
        
        $roles = new Auth_Model_DbTable_Roles();
        $rolenames = $roles->getAllRolename();
        $this->view->rolenames = $rolenames;
    }

    public function updateAction()
    {
    	$request = $this->getRequest();
    	$d = $request->getParam('d');
    	$users = new Auth_Model_DbTable_Users();
    	foreach ($d as $dline) {
    		$data = array('status' => $dline['status'], 'id_role' => $dline['id_role']);
    		$where = $users->getAdapter()->quoteInto('username = ?', $dline['username']);
    		$users->update($data, $where);
    	}
    	echo '{"success": "OK"}';
    	// stop layout and render
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
    }

}