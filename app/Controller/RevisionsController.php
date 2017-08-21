<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('AppController', 'Controller');

/**
 * CakePHP LiteraturesController
 * 
 * @author Matus
 */
class RevisionsController extends AppController {

    public $uses = array(
        'History'
    );

    public function insert() {
        
    }

    public function delete($id) {
        $this->autoRender = false;
        if ($id) {
            $dataSource = $this->History->getDataSource();
            $dataSource->begin();

            if ($this->History->delete($id)) {
                $dataSource->commit();
            } else {
                $dataSource->rollback();
            }
        }
        $this->redirect($this->referer());
    }

}
