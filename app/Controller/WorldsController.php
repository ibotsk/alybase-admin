<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP WorldsController
 * @author Matus
 */
class WorldsController extends AppController {

    public $name = 'worlds';
    public $uses = array('WorldL4');
    public $components = array('RequestHandler');

    public function index($id) {
        
    }

    public function search() {
        if ($this->request->is('ajax')) {
            $term = $this->request->query('term');
            $worlds = $this->WorldL4->getWorlds($term);
            $this->set(compact('worlds'));
        }
    }

}
