<?php
App::uses('AppModel', 'Model');
class Cdata extends AppModel {

	public $useTable = 'cdata';

	public $actsAs = array(
			'Containable' 
	);

	public $belongsTo = array(
			
			'CountedBy' => array(
					'className' => 'Person',
					'foreignKey' => 'counted_by' 
			) 
	);

	public $hasMany = array(
			'Dcomment' => array(
					'className' => 'Dcomment',
					'foreignKey' => 'id_cdata',
					'dependent' => true,
					'order' => 'Dcomment.date_posted' 
			),
			'History' => array(
					'className' => 'History',
					'foreignKey' => 'id_data',
					'dependent' => true,
					'order' => array(
							'History.h_date DESC',
							'History.id DESC' 
					) 
			) 
	);

	public $hasOne = array(
			'Dna' => array(
					'className' => 'Dna',
					'foreignKey' => 'id_cdata'
			),
			'Material' => array(
					'className' => 'Material',
					'foreignKey' => 'id_cdata' 
			),
			'LatestRevision' => array(
					'className' => 'LatestRevision',
					'foreignKey' => 'id_data' 
			) 
	);

	public function getDetails($id) {
		$this->unbindModel(array(
				'hasMany' => array(
						'Dcomment' 
				) 
		));
		$data = $this->find('first', array(
				'contain' => array(
						'Dna',
						'CountedBy',
						'Material' => array(
								'Reference' => array(
										'OriginalIdentification' => 'Accepted',
										'Literature' 
								),
								'WorldL4' => array(
										'WorldL3' => array(
												'WorldL2' => array(
														'WorldL1' 
												) 
										) 
								),
								'PersonsCol',
								'PersonsIdf',
								'PersonsChk',
								'PhytogeoDistrict' 
						),
						'LatestRevision' => 'ListOfSpecies',
						'History' => 'ListOfSpecies' 
				),
				'conditions' => array(
						'Cdata.id' => $id 
				) 
		));
		return $data;
	}
}

