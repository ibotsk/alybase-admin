<?php

App::uses('AppController', 'Controller');

class ChecklistController extends AppController {

    public $name = 'checklist';
    public $uses = array(
        'ListOfSpecies'
    );
    public $helpers = array(
        'Eip.Eip',
        'Paginator'
    );
    public $components = array(
        'Paginator'
    );

    public function index() {
        $this->Paginator->settings = array(
            'ListOfSpecies' => array(
                'contain' => array(
                    'Accepted',
                    'Basionym',
                    'BasionymFor',
                    'Replaced',
                    'ReplacedFor'
                ),
                'limit' => 50,
                'order' => array(
                    'ListOfSpecies.ntype_order',
                    'ListOfSpecies.genus',
                    'ListOfSpecies.species',
                    'ListOfSpecies.subsp',
                    'ListOfSpecies.var',
                    'ListOfSpecies.subvar',
                    'ListOfSpecies.forma',
                    'ListOfSpecies.authors',
                    'ListOfSpecies.id'
                )
            )
        );

        $data = $this->Paginator->paginate('ListOfSpecies', array(), array(
            'ListOfSpecies.id'
        ));
        $this->set(compact('data'));
    }

    public function detail($id) {
        if (!$id) {
            throw new InvalidArgumentException('ChecklistsController::detail - invalid id');
        }

        $result = $this->ListOfSpecies->getDetail($id);
        $accepted = $this->ListOfSpecies->listSpecies(array('ntype' => array('A', 'PA')));
        $loss = $this->ListOfSpecies->listSpecies();
        $this->set(compact('accepted', 'loss', 'result'));
    }

    public function insert() {
        
    }

    public function edit($id) {
        $data = $this->ListOfSpecies->getDetail($id);
        $accepted = $this->ListOfSpecies->listSpecies(array('ntype' => array('A', 'PA')));
        $loss = $this->ListOfSpecies->listSpecies();
        $this->set(compact('accepted', 'data', 'loss'));
    }

}
