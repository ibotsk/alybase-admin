<div id="modal-identification" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add new name to checklist</h4>
            </div>
            <div class="modal-body">
                <?php
                echo $this->Form->create('ListOfSpecies', array('url' => array('controller' => 'listofspecies', 'action' => 'insert'),
                    'id' => 'ListOfSpeciesInsertForm', 'role' => 'form', 'inputDefaults' => array('label' => false, 'div' => false)));
                ?>
                <div class="form-group">
                    <?php echo $this->Form->input('ntype', array('options' => array('A' => 'Accepted name', 'S' => 'Synonym'), 'class' => 'form-control input-sm', 'placeholder' => 'Type')); ?>
                </div>
                <div class="form-group">
                    <label>
                        <?php echo $this->Form->input('hybrid', array('type' => 'checkbox', 'id' => 'identification-is-hybrid')); ?> Hybrid
                    </label>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('genus', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Genus')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('species', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Species')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('subsp', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Subspecies')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('var', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Varieta')); ?>
                </div><div class="form-group">
                    <?php echo $this->Form->input('subvar', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Subvarieta')); ?>
                </div><div class="form-group">
                    <?php echo $this->Form->input('forma', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Forma')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('authors', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Authors')); ?>
                </div>
                <div id="identification-hybrid" class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <?php echo $this->Form->input('genus_h', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Hybrid Genus')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $this->Form->input('species_h', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Hybrid Species')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $this->Form->input('subsp_h', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Hybrid Subspecies')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $this->Form->input('var_h', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Hybrid Varieta')); ?>
                        </div><div class="form-group">
                            <?php echo $this->Form->input('subvar_h', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Hybrid Subvarieta')); ?>
                        </div><div class="form-group">
                            <?php echo $this->Form->input('forma_h', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Hybrid Forma')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $this->Form->input('authors_h', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Hybrid Authors')); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('publication', array('type' => 'text', 'class' => 'form-control input-sm', 'placeholder' => 'Publication')); ?>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
            <div class="modal-footer">
                <button id="submit-identification" type="button" class="btn btn-info">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
