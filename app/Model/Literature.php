<?php
App::uses('AppModel', 'Model');
class Literature extends AppModel {

	public $useTable = 'literature';

	public $belongsTo = array(
			'DisplayTypes' => array(
					'className' => 'DisplayTypes',
					'foreignKey' => 'display_type' 
			) 
	);

	public $hasMany = array(
			'Reference' => array(
					'className' => 'Reference',
					'foreignKey' => 'id_literature' 
			) 
	);

	public function getLiteratures($term = null) {
		if (!empty($term)) {
			// $this->unbindModel(array('hasMany' => array('Reference')));
			$this->recursive = -1;
			$literatures = $this->find('all', array(
					'conditions' => array(
							'paper_title ILIKE' => '%' . trim($term) . '%' 
					),
					'order' => array(
							'paper_title',
							'paper_author',
							'year',
							'volume',
							'issue' 
					) 
			));
			return $literatures;
		}
		return false;
	}

	public function listLiterature() {
		$this->unbindModel(array('belongsTo' => array('DisplayTypes'), 'hasMany' => array('Reference')));
		return $this->find('all', array(
				'fields' => array(
						'id',
						'paper_author',
						'paper_title',
						'series_source',
						'volume',
						'issue',
						'publisher',
						'editor',
						'year',
						'pages',
						'journal_name',
						'display_type'
				),
				'order' => array(
						'paper_author',
						'paper_title',
						'year',
						'journal_name',
						'volume',
						'issue',
						'id'
				) 
		));
	}
}

