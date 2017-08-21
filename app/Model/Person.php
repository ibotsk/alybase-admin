<?php
App::uses('AppModel', 'Model');
class Person extends AppModel {

	public $useTable = 'persons';

	public $actsAs = array(
			'Containable' 
	);

	public $hasMany = array(
			'PersonsCtb' => array(
					'className' => 'Cdata',
					'foreignKey' => 'counted_by' 
			),
			'PersonsCol' => array(
					'className' => 'Material',
					'foreignKey' => 'collected_by' 
			),
			'PersonsIdf' => array(
					'className' => 'Material',
					'foreign_key' => 'identified_by' 
			),
			'PersonsChk' => array(
					'className' => 'Material',
					'foreign_key' => 'checked_by' 
			) 
	);

	public function getPersons($term = null) {
		if (!empty($term)) {
			$this->recursive = -1;
			$persons = $this->find('all', array(
					'conditions' => array(
							'pers_name ILIKE' => '%' . trim($term) . '%' 
					),
					'order' => array(
							'pers_name',
							'id'
					) 
			));
			return $persons;
		}
		return false;
	}

	public function listPersons() {
		return $this->find('list', array(
				'fields' => array(
						'id',
						'pers_name' 
				),
				'order' => array(
						'pers_name',
						'id' 
				) 
		));
	}
}