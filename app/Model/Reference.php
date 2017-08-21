<?php
App::uses('AppModel', 'Model');
class Reference extends AppModel {

	public $useTable = 'reference';

	public $actsAs = array(
			'Containable' 
	);

	public $hasOne = array(
	);

	public $belongsTo = array(
			'Material' => array(
					'className' => 'Material',
					'foreignKey' => 'id_material',
					'dependent' => true 
			),
			'Literature' => array(
					'className' => 'Literature',
					'foreignKey' => 'id_literature' 
			),
			'OriginalIdentification' => array(
					'className' => 'ListOfSpecies',
					'foreignKey' => 'id_standardised_name' 
			) 
	);
}
