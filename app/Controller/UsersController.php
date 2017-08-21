<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public $uses = array('User');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login');
    }

    public function login() {
        if ($this->request->is('post')) {
            // Important: Use login() without arguments! See warning below.
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function add() {
        $user['User'] = array();
        //$this->User->save($user);
    }

}
