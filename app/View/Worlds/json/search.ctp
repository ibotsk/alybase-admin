<?php

$worldsOut = array();
foreach ($worlds as $w) {
    $worldsOut[] = array('value' => $w['WorldL4']['id'], 'label' => $w['WorldL4']['description'],
        'desc' => $w['WorldL3']['description']);
}

echo json_encode($worldsOut);
