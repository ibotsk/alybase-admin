<?php

App::uses('Component', 'Controller');

class UtilsComponent extends Component {

    public function losFields($alias = '') {
        $fields = array('id', 'ntype', 'hybrid', 'genus', 'species', 'subsp', 'var', 'subvar', 'forma', 'authors',
            'genus_h', 'species_h', 'subsp_h', 'var_h', 'subvar_h', 'forma_h', 'authors_h', 'id_accepted_name',
            'publication', 'tribus', 'syn_type');
        foreach ($fields as &$value) {
            $value = $alias . '.' . $value;
        }
        return $fields;
    }

    public function litFields($alias = '') {
        $fields = array();
    }

    public function convertToOrder($field) {
        switch ($field) {
            case 'id':
                return array('Cdata.id');
            case 'urcenie':
                return array('LosIdentification.genus', 'LosIdentification.species', 'LosIdentification.subsp',
                    'LosIdentification.var', 'LosIdentification.subvar', 'LosIdentification.forma', 'LosIdentification.authors');
            case 'revizia':
                return array('LosRevision.genus', 'LosRevision.species', 'LosRevision.subsp',
                    'LosRevision.var', 'LosRevision.subvar', 'LosRevision.forma', 'LosRevision.authors');
            case 'autorpubl':
                return array('Literature.paper_author');
            case 'rok':
                return array('Literature.year');
            case 'n':
                return array('Cdata.n');
            case '2n':
                return array('Cdata.dn');
            case 'ploidia':
                return array('Cdata.ploidy_level');
            case 'ploidiarev':
                return array('Cdata.ploidy_level_revised');
            case 'xrev':
                return array('Cdata.x_revised');
            case 'spocital':
                return array('CountedBy.pers_name');
            case 'datumspocitania':
                return array('Cdata.counted_date');
            case 'ulozenev':
                return array('Material.deposited_in');
            case 'krajina':
                return array('Material.country');
            case 'w4':
                return array('W4.description');
            default:
                return array('Cdata.id');
        }
    }

    public function saveFieldInModel($model, $id, $field, $value) {
    	if (!$model || !$id || !$field || !$value) {
    		return;
    	}
    	switch ($model) {
    		case 'Cdata':
    			$this->Cdata->saveFieldOfID($id, $field, $value);
    			break;
    		case 'Material':
    			$this->Material->saveFieldOfID($id, $field, $value);
    			break;
    		default:
    			break;
    	}
    }
    
}
