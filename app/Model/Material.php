<?php
App::uses('AppModel', 'Model');
class Material extends AppModel {

	public $useTable = 'material';

	public $actsAs = array(
			'Containable' 
	);

	/*
	 * public $validate = array(
	 * 'coordinates_lat' => array(
	 * 'allowEmpty' => true,
	 * 'rule' => "/^\d{2}°\d{2}'\d{2}(\.\d+)?''[NS]$/",
	 * 'message' => 'DD°MM\'SS\'\'N - Leading zeros, no spaces, apostrophes instead of double quotes, only seconds can be decimal'
	 * ),
	 * 'coordinates_lon' => array(
	 * 'allowEmpty' => true,
	 * 'rule' => "/^\d{2}°\d{2}'\d{2}(\.\d+)?''[WE]$/",
	 * 'message' => 'DD°MM\'SS\'\'E - Leading zeros, no spaces, apostrophes instead of double quotes, only seconds can be decimal'
	 * )
	 * ,
	 * 'coordinates_georef_lat' => array(
	 * 'allowEmpty' => true,
	 * 'rule' => "/^\d{2}°\d{2}'\d{2}(\.\d+)?''[NS]$/",
	 * 'message' => 'DD°MM\'SS\'\'N - Leading zeros, no spaces, apostrophes instead of double quotes, only seconds can be decimal'
	 * )
	 * ,
	 * 'coordinates_georef_lon' => array(
	 * 'allowEmpty' => true,
	 * 'rule' => "/^\d{2}°\d{2}'\d{2}(\.\d+)?''[WE]$/",
	 * 'message' => 'DD°MM\'SS\'\'E - Leading zeros, no spaces, apostrophes instead of double quotes, only seconds can be decimal'
	 * )
	 * );
	 */
	public $hasOne = array(
			'Reference' => array(
					'className' => 'Reference',
					'foreignKey' => 'id_material' 
			) 
	);

	public $belongsTo = array(
			'Cdata' => array(
					'className' => 'Cdata',
					'foreignKey' => 'id_cdata'
			),
			'WorldL4' => array(
					'className' => 'WorldL4',
					'foreignKey' => 'id_world_4' 
			),
			'PersonsCol' => array(
					'className' => 'Person',
					'foreignKey' => 'collected_by' 
			),
			'PersonsIdf' => array(
					'className' => 'Person',
					'foreignKey' => 'identified_by' 
			),
			'PersonsChk' => array(
					'className' => 'Person',
					'foreignKey' => 'checked_by' 
			),
			'PhytogeoDistrict' => array(
					'className' => 'PhytogeographicalDistrict',
					'foreignKey' => 'phytogeographical_district' 
			) 
	);
}
