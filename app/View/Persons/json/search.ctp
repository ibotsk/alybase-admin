<?php

$persOut = array();
foreach ($persons as $p) {
    $persOut[] = array('value' => $p['Person']['id'], 'label' => $p['Person']['pers_name']);
}

echo json_encode($persOut);