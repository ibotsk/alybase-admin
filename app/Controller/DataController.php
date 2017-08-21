<?php

App::uses('AppController', 'Controller');

class DataController extends AppController {

    public $helpers = array(
        'AutoComplete',
        'Eip.Eip',
        'Html',
        'Format',
        'Paginator'
    );
    public $components = array(
        'Paginator',
        'Session',
        'RequestHandler',
        'Utils'
    );
    public $uses = array(
        'Cdata',
        'History',
        'ListOfSpecies',
        'Literature',
        'Material',
        'Person',
        'PhytogeographicalDistrict',
        'Reference',
        'WorldL4'
    );

    public function beforeFilter() {
        if ($this->request->is('ajax') || $this->RequestHandler->isXml()) {
            Configure::write('debug', 0);
        }
        parent::beforeFilter();
    }

    public function index($sort = null, $direction = null) {
        $this->Cdata->unbindModel(array(
            'belongsTo' => array(
                'Dna'
            ),
            'hasMany' => array(
                'Dcomment',
                'History'
            )
        ));

        $this->Paginator->settings = array(
            'Cdata' => array(
                'contain' => array(
                    'Material' => array(
                        'Reference' => array(
                            'Literature',
                            'OriginalIdentification' => 'Accepted'
                        ),
                        'WorldL4'
                    ),
                    'CountedBy',
                    'LatestRevision' => array(
                        'ListOfSpecies'
                    )
                ),
                'limit' => 50,
                'order' => 'Cdata.id'
            )
        );

        $data = $this->Paginator->paginate('Cdata', array(), array(
            'Cdata.id',
            'Literature.year'
        ));

        $this->set(compact('data'));
    }

    public function insert() {
        if ($this->request->is('post')) {
            $data = $this->request->data;
            unset($data['Material']['Reference']['Literature']);

            $this->Cdata->saveAll($data, array(
                'deep' => true,
                'atomic' => true
            ));
        }
        $loss = $this->ListOfSpecies->listSpecies();
        $phytodistricts = $this->PhytogeographicalDistrict->listPhytogeoDistricts();
        $worlds4 = $this->WorldL4->listWorlds();
        $this->set(compact('loss', 'phytodistricts', 'worlds4'));
    }

    public function detail($id) {
        $data = $this->Cdata->getDetails($id);
        $persons = $this->Person->listPersons();
        $phytodistricts = $this->PhytogeographicalDistrict->listPhytogeoDistricts();
        $literatures = $this->Literature->listLiterature();
        $loss = $this->ListOfSpecies->listSpecies();
        $worlds4 = $this->WorldL4->listWorlds();
        $this->set(compact('data', 'persons', 'phytodistricts', 'literatures', 'loss', 'worlds4'));
    }

    public function edit($id) {
        if ($this->request->is('post')) { // save edited data
            $data = $this->request->data;
            unset($data['Material']['Reference']['Literature']);
            unset($data['Material']['Reference']['OriginalIdentification']);

            if (!empty($data['History'])) { // new revisions were added
                // revisions are in reversed order, we must reverse them
                $reversed = array_reverse($data['History'], true);
                $data['History'] = $reversed;
            }

            $this->Cdata->saveAll($data, array(
                'atomic' => true,
                'deep' => true
            ));
        }
        $data = $this->Cdata->getDetails($id);
        $phytodistricts = $this->PhytogeographicalDistrict->listPhytogeoDistricts();
        $worlds4 = $this->WorldL4->listWorlds();
        $loss = $this->ListOfSpecies->listSpecies();
        $this->set(compact('data', 'loss', 'phytodistricts', 'worlds4'));
    }

    public function delete($id) {
        $this->autorender = false;
        if ($id) { // if id is not given, nothing to delete, ok
            $dataSource = $this->Cdata->getDataSource();
            $dataSource->begin();
            if ($this->Cdata->delete($id)) {
                $this->Flash->success(_('Record was deleted'));
                $dataSource->commit();
            } else {
                $dataSource->rollback();
                $this->Flash->set(__('Record not deleted'));
            }
        }
        $this->redirect($this->referer()); // show all records
    }

}
