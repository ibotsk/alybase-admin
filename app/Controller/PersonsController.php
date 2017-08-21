<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP PersonsController
 * @author Matus
 */
class PersonsController extends AppController {

    public $uses = array('Person');
    public $components = array('RequestHandler');

    public function index($id) {
        
    }

    public function search() {
        if ($this->request->is('ajax')) {
            $term = $this->request->query('term');
            $persons = $this->Person->getPersons($term);
            $this->set(compact('persons'));
        }
    }

    public function insert() {
        if ($this->request->is('ajax')) {
            $data = $this->request->data;
            $this->Person->save($data);
            $data['Person']['id'] = $this->Person->id;
            $this->set(compact('data'));
        }
    }

}
