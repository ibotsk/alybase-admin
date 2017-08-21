<?php
App::uses('AppModel', 'Model');
class WorldL4 extends AppModel {

	public $useTable = 'world_l4';

	public $actsAs = array(
			'Containable' 
	);

	public $hasMany = array(
			'Material' => array(
					'className' => 'Material',
					'foreignKey' => 'id_world_1',
					'dependent' => false 
			) 
	);

	public $belongsTo = array(
			'WorldL3' => array(
					'className' => 'WorldL3',
					'foreignKey' => 'id_parent' 
			) 
	);

	public function getWorlds($term = null) {
		if (!empty($term)) {
			$this->unbindModel(array(
					'hasMany' => array(
							'Material' 
					) 
			));
			$worlds = $this->find('all', array(
					'conditions' => array(
							'WorldL4.description ILIKE' => trim($term) . '%' 
					),
					'order' => array(
							'WorldL4.description' 
					) 
			));
			return $worlds;
		}
		return false;
	}

	public function listWorlds() {
		return $this->find('list', array(
				'fields' => array(
						'id',
						'description' 
				),
				'order' => array(
						'description',
						'id' 
				) 
		));
	}
}
