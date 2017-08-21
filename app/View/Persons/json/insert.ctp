<?php

$person = array('value' => $data['Person']['id'], 'label' => $data['Person']['pers_name'], 'ref' => $data['Person']['ref']);

echo json_encode($person);