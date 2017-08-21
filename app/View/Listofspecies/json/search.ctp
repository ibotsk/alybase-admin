<?php

$lossOut = array();
foreach ($loss as $l) {
    $label = $this->Format->los($l['ListOfSpecies']);
    $lossOut[] = array('value' => $l['ListOfSpecies']['id'], 'label' => $label);
}

echo json_encode($lossOut);
