<?php

$label = $this->Format->literature($data['Literature']);
$litOut = array('value' => $data['Literature']['id'], 'label' => $label);

echo json_encode($litOut);
