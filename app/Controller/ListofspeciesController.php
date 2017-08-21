<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP ListOfSpeciesController
 * @author Matus
 */
class ListofspeciesController extends AppController {

    public $uses = array('ListOfSpecies');
    public $components = array('RequestHandler');
    public $helpers = array('Format');

    public function index($id) {
        
    }

    public function search() {
        if ($this->request->is('ajax')) {
            $term = $this->request->query('term');
            $loss = $this->ListOfSpecies->getListOfSpecies($term);
            $this->set(compact('loss'));
        }
    }

    public function insert() {
        if ($this->request->is('ajax')) {
            $data = $this->request->data;
            $this->ListOfSpecies->save($data);
            $data['ListOfSpecies']['id'] = $this->ListOfSpecies->id;
            if (empty($data['ListOfSpecies']['hybrid'])) {
                $this->_emptyHybrid($data);
            }
            $this->set(compact('data'));
        }
    }

    protected function _emptyHybrid(&$data) {
        $data['ListOfSpecies']['genus_h'] = null;
        $data['ListOfSpecies']['species_h'] = null;
        $data['ListOfSpecies']['subsp_h'] = null;
        $data['ListOfSpecies']['var_h'] = null;
        $data['ListOfSpecies']['subvar_h'] = null;
        $data['ListOfSpecies']['forma_h'] = null;
        $data['ListOfSpecies']['authors_h'] = null;
    }

}
