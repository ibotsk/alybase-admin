<div id="modal-person" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add new person</h4>
            </div>
            <div class="modal-body">
                <?php
                echo $this->Form->create('Person', array('url' => array('controller' => 'persons', 'action' => 'insert'),
                    'id' => 'PersonInsertForm', 'role' => 'form', 'inputDefaults' => array('label' => false, 'div' => false)));
                ?>
                <div class="form-group">
                    <?php echo $this->Form->input('pers_name', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Name')); ?>
                </div>
                <?php echo $this->Form->input('ref', array('type' => 'hidden', 'id' => 'modal-person-ref-btn')); ?>
                <?php echo $this->Form->end(); ?>
            </div>
            <div class="modal-footer">
                <button id="submit-person" type="button" class="btn btn-info">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

