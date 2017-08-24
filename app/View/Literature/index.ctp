<?php
//new dBug($literatures);
?>

<div class="container-fluid">
    <table class="table table-bordered table-condensed table-responsive table-striped">
        <?php foreach ($literatures as $lit): ?>
            <tr>
                <td><?php echo $this->Html->link(__('View/Edit'), array('action' => 'detail', $lit['Literature']['id'])); ?></td>
                <td><?php echo $this->Format->literature($lit['Literature']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
