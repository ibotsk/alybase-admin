<?php

$data['ListOfSpecies']['publication'] = '';
$data['ListOfSpecies']['syn_type'] = '';
$data['ListOfSpecies']['tribus'] = '';
$label = $this->Format->los($data['ListOfSpecies']);
$los = array('value' => $data['ListOfSpecies']['id'], 'label' => $label);

echo json_encode($los);
