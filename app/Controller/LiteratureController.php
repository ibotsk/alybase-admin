<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP LiteraturesController
 * @author Matus
 */
class LiteratureController extends AppController {

    public $name = 'literature';
    public $uses = array('Literature');
    public $components = array('RequestHandler');
    
    public $helpers = array(
        'Eip.Eip',
        'Format'
        );

    public function index() {
        $this->Literature->recursive = -1;
        $literatures = $this->Literature->find('all');
        $this->set(compact('literatures'));
    }

    public function detail($id) {
        if (empty($id)) {
            throw new InvalidArgumentException('literatures/view: Id must be specified');
        }
        $this->Literature->recursive = -1;
        $data = $this->Literature->findById($id);
        $this->set(compact('data'));
    }

    
    /**
     * Used in ajax autocomplete
     */
    public function search() {
        if ($this->request->is('ajax')) {
            $term = $this->request->query('term');
            $literatures = $this->Literature->getLiteratures($term);
            $this->set(compact('literatures'));
            //$this->set('_serialize', array('literatures'));
        }
    }

    public function insert() {
        if ($this->request->is('ajax')) {
            $data = $this->request->data;
            $this->Literature->save($data);
            $data['Literature']['id'] = $this->Literature->id;
            //$data['Literature']['id'] = 1;
            $this->set(compact('data'));
        }
    }

}
