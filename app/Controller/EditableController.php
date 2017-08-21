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
class EditableController extends AppController {

    public $components = array(
        'Eip.Eip'
    );

    public function eip() {
        $this->autoRender = false;
        $path = $this->request->data['name'];
        $items = $this->Eip->pathToArray($path);

        $fullModels = implode('.', array_slice($items, 0, -1));

        //$modelToSave = $items[$i_size - 2];
        //$fieldToSave = $items[$i_size - 1];

        if (!empty($path)) {
            $data = $this->Eip->setupData($fullModels);
            $saved = $this->Eip->save($data);
            $this->Eip->respondLazy($saved, $fullModels);
        }
    }

}
