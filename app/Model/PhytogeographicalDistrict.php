<?php
App::uses('AppModel', 'Model');
class PhytogeographicalDistrict extends AppModel {

	public $useTable = 'phytogeographical_district';

	public $hasMany = array(
			'Material' => array(
					'className' => 'Material',
					'foreignKey' => 'phytogeographical_district' 
			) 
	);

	public function listPhytogeoDistricts() {
		return $this->find('list', array(
				'fields' => array(
						'id',
						'district_name' 
				),
				'order' => array(
						'district_name',
						'id' 
				) 
		));
	}
}
