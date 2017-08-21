<?php

$litOut = array();
foreach ($literatures as $l) {
    $label = $this->Format->literature($l['Literature']);
    $litOut[] = array('value' => $l['Literature']['id'], 'label' => $label);
}

echo json_encode($litOut);
