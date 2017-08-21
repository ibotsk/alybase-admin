<div id="modal-literature" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add new paper</h4>
            </div>
            <div class="modal-body">
                <?php
                echo $this->Form->create('Literature', array('url' => array('controller' => 'literatures', 'action' => 'insert'),
                    'id' => 'LiteratureInsertForm', 'role' => 'form', 'inputDefaults' => array('label' => false, 'div' => false)));
                ?>
                <div class="form-group">
                    <?php echo $this->Form->input('display_type', array('options' => array('1' => 'časopis', '2' => 'kniha', '3' => 'rukopis', '4' => 'kapitola', '5' => 'report'), 'class' => 'form-control input-sm', 'placeholder' => 'Paper type')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('paper_author', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Paper author')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('paper_title', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Paper title')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('year', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Year')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('series_source', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Series source')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('volume', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Volume')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('issue', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Issue')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('publisher', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Publisher')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('editor', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Editor')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('pages', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Pages')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('journal_name', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Journal')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('note', array('type' => 'textarea', 'class' => 'form-control input-sm', 'placeholder' => 'Note')); ?>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
            <div class="modal-footer">
                <button id="submit-literature" type="button" class="btn btn-info">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>