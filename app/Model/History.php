<?php

App::uses('AppModel', 'Model');

class History extends AppModel {

    public $useTable = 'history';
    public $actsAs = array('Containable');
    
    public $belongsTo = array(
        'Cdata' => array(
            'className' => 'Cdata',
            'foreignKey' => 'id_data'
        ),
        'ListOfSpecies' => array(
            'className' => 'ListOfSpecies',
            'foreignKey' => 'id_standardised_name'
        )
    );
    
    public function getByData($id_data) {
    	if (empty($id_data)) {
    		return array();
    	}
    	$this->unbindModel(array('belongsTo' => 'Cdata'));
    	return $this->findAllByIdData($id_data, array(), array('History.id' => 'desc'));
    }
    
}
