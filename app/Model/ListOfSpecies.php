<?php
App::uses('AppModel', 'Model');
class ListOfSpecies extends AppModel {

	public $actsAs = array(
			'Containable' 
	);

	public $useTable = 'list_of_species';

	public $hasMany = array(
			'History' => array(
					'className' => 'History',
					'foreignKey' => 'id_standardised_name' 
			),
			'LatestRevision' => array(
					'className' => 'LatestRevision',
					'foreignKey' => 'id_standardised_name' 
			),
			'Reference' => array(
					'className' => 'Reference',
					'foreignKey' => 'id_standardised_name' 
			),
			/*
			 'Synonyms' => array(
			 'className' => 'ListOfSpecies',
			 'foreignKey' => 'id_accepted_name',
			 'conditions' => array(
			 //'OR' => array(
			 'Synonyms.syn_type' => 2,
			 //array('Synonyms.syn_type' => 3, 'Synonyms.id_basionym' => null)),
			 'Synonyms.is_basionym' => false,
			 'Synonyms.id_superior_name' => null,
			 //'Synonyms.ntype !=' => 0
			 //array('OR' => array(
			 //array(
			 //    array('OR' => array('Synonyms.subsp != Synonyms.species', 'Synonyms.subsp' => null)),
			 //    array('OR' => array('Synonyms.var != Synonyms.species', 'Synonyms.var' => null)),
			 //    array('OR' => array('Synonyms.forma != Synonyms.species', 'Synonyms.forma' => null))
			 //),
			 //        'Synonyms.id_superior_name' => null
			 //)
			 ),
			 'order' => array('Synonyms.genus', 'Synonyms.species',
			 'Synonyms.subsp', 'Synonyms.var', 'Synonyms.subvar',
			 'Synonyms.forma', 'Synonyms.authors')
			 ),
			 */
			'SynonymsInvalid' => array(
					'className' => 'ListOfSpecies',
					'foreignKey' => 'id_accepted_name',
					'conditions' => array(
							'SynonymsInvalid.syn_type' => 1 
					),
					'order' => array(
							'SynonymsInvalid.genus',
							'SynonymsInvalid.species',
							'SynonymsInvalid.subsp',
							'SynonymsInvalid.var',
							'SynonymsInvalid.subvar',
							'SynonymsInvalid.forma',
							'SynonymsInvalid.authors' 
					) 
			),
			
			'BasionymFor' => array(
					'className' => 'ListOfSpecies',
					'foreignKey' => 'id_basionym'  // this species is a basionym, so we want to see to which it is basionym for
				/*
			 * Option of having separated table for basionym and its associated names was investigated and declined
			 * as it would make things unnecessarily complicated
			 */
				// 'conditions' => array('BasionymFor.ntype !=' => '')
			),
			'NomenNovumFor' => array(
					'className' => 'ListOfSpecies',
					'foreignKey' => 'id_nomen_novum' 
			),
			'ReplacedFor' => array(
					'className' => 'ListOfSpecies',
					'foreignKey' => 'id_replaced' 
			),
			'LosComment' => array(
					'className' => 'LosComment',
					'foreignKey' => 'id_list_of_species',
					'dependent' => true,
					'order' => 'LosComment.date_posted' 
			) 
	);

	/*
	 *
	 * public $hasOne = array(
	 * 'Parent' => array(
	 * 'className' => 'Synonym',
	 * 'foreignKey' => 'id_synonym'
	 * )
	 * );
	 */
	public $belongsTo = array(
			/* 'Family' => array(
			 'className' => 'Family',
			 'foreignKey' => 'id_family'
			 ), */
			'Accepted' => array(
					'className' => 'ListOfSpecies',
					'foreignKey' => 'id_accepted_name' 
			),
			'Basionym' => array(
					'className' => 'ListOfSpecies',
					'foreignKey' => 'id_basionym' 
			),
			'Replaced' => array(
					'className' => 'ListOfSpecies',
					'foreignKey' => 'id_replaced' 
			),
			'NomenNovum' => array(
					'className' => 'ListOfSpecies',
					'foreignKey' => 'id_nomen_novum'
			)
	);

	public $hasAndBelongsToMany = array(
			/*
			 * All synonyms are explicitly stored in 'synonyms' table
			 */
			'SynonymsTaxonomic' => array(
					'className' => 'ListOfSpecies',
					'joinTable' => 'synonyms',
					'foreignKey' => 'id_parent',
					'associationForeignKey' => 'id_synonym',
					'with' => 'Synonym',
					'conditions' => array(
							'Synonym.syntype' => 2 
					),
					'order' => 'Synonym.rorder' 
			),
			'SynonymsNomenclatoric' => array(
					'className' => 'ListOfSpecies',
					'joinTable' => 'synonyms',
					'foreignKey' => 'id_parent',
					'associationForeignKey' => 'id_synonym',
					'with' => 'Synonym',
					'conditions' => array(
							'Synonym.syntype' => 3 
					),
					'order' => 'Synonym.rorder' 
			) 
	);

	public function getListOfSpecies($term = null) {
		if (!empty($term)) {
			$termok = '%' . trim($term) . '%';
			$this->recursive = -1;
			$loss = $this->find('all', array(
					'conditions' => array(
							'OR' => array(
									'genus ILIKE' => $termok,
									'species ILIKE' => $termok,
									'subsp ILIKE' => $termok,
									'var ILIKE' => $termok,
									'authors ILIKE' => $termok 
							) 
					) 
			));
			return $loss;
		}
		return false;
	}

	public function listSpecies($conditions = array()) {
		$this->recursive = -1;
    	return $this->find('all', array(
    			'conditions' => $conditions,
    			'order' => array(
    					'genus',
    					'species',
    					'subsp',
    					'var',
    					'subvar',
    					'forma',
    					'authors',
    					'id'
    			)
    	));
	}
	
	public function getDetail($id) {
		if (!$id) {
			throw new InvalidArgumentException('ListOfSpecies::getDetail - invalid id');
		}
		return $this->find('first', array(
				'conditions' => array(
						'ListOfSpecies.id' => $id
				),
				'contain' => array(
						'Accepted',
						'Basionym',
						'BasionymFor',
						'Replaced',
						'ReplacedFor',
						'NomenNovum',
						'NomenNovumFor',
						'SynonymsInvalid',
						'SynonymsTaxonomic' => array(
								'SynonymsNomenclatoric' => array(
										/*'conditions' => array(  //in admin, we want to see all nomenclatoric synonyms
												'show_in_tree' => true
										),*/
										'order' => 'rorder'
								)
						),
						'SynonymsNomenclatoric'
				)
		));
	}
}
