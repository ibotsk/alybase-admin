<div class="container" style="margin-bottom: 20px;">
    <?php
    echo $this->Flash->render();
    echo $this->element('form-insert-edit', array('data' => array()));
    ?>
</div>
<?php 
/*
if (!empty($data)) {
    new dBug($data);
}
*/