<?php
new dBug($data);

$ntypes = array(
    'A' => 'Accepted',
    'PA' => 'Provisionally Accepted',
    'S' => 'Synonym',
    'DS' => 'Doubtful Synonym',
    'U' => 'Unresolved',
    'H' => 'Hybrid'
);

//prepare list of all species for select
$loss_list = Hash::combine($loss, '{n}.ListOfSpecies.id', '{n}');
unset($loss);

foreach ($loss_list as $key => $val) {
    $l = $this->Format->los($val['ListOfSpecies']);
    $loss_list[$key] = $l;
}

//prepare list of accepted names for select
$accepted_list = Hash::combine($accepted, '{n}.ListOfSpecies.id', '{n}');
unset($accepted);

foreach ($accepted_list as $key => $val) {
    $l = $this->Format->los($val['ListOfSpecies']);
    $accepted_list[$key] = $l;
}

$action = 'insert';
if (!empty($data)) {
    $action = 'edit';
}

$url = array(
    'controller' => 'data',
    'action' => $action
);
if ($action == 'edit' && Hash::check($data, 'Cdata.id')) {
    $url[] = $data['Cdata']['id'];
}

echo $this->Form->create(false, array(
    'class' => 'formHorizontal',
    'type' => 'post',
    'url' => $url,
    'role' => 'form',
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    )
));

if (Hash::check($data, 'ListOfSpecies.id')) { // data exist -> we are editing
    echo $this->Form->hidden('ListOfSpecies.id', array(
        'value' => Hash::get($data, 'ListOfSpecies.id')
    ));
}
?>
<script type="text/javascript">
    var lossList = <?php echo json_encode($loss_list); ?>;
    initLos(lossList);
</script>
<h3><?php echo __('Name'); ?></h3>
<table class="table table-bordered table-condensed table-responsive">
    <tr class="form-group">
        <td class="col-xs-4"><?php echo __('Genus'); ?></td>
        <td><?php echo $this->Form->input('ListOfSpecies.genus', array('class' => 'form-control', 'value' => Hash::get($data, 'ListOfSpecies.genus'))); ?> </td>
    </tr>
    <tr class="form-group">
        <td class="col-xs-4"><?php echo __('Species'); ?></td>
        <td><?php echo $this->Form->input('ListOfSpecies.species', array('class' => 'form-control', 'value' => Hash::get($data, 'ListOfSpecies.species'))); ?> </td>
    </tr>
    <tr class="form-group">
        <td class="col-xs-4"><?php echo __('Subsp'); ?></td>
        <td><?php echo $this->Form->input('ListOfSpecies.subsp', array('class' => 'form-control', 'value' => Hash::get($data, 'ListOfSpecies.subsp'))); ?> </td>
    </tr>
    <tr class="form-group">
        <td class="col-xs-4"><?php echo __('Var'); ?></td>
        <td><?php echo $this->Form->input('ListOfSpecies.var', array('class' => 'form-control', 'value' => Hash::get($data, 'ListOfSpecies.var'))); ?> </td>
    </tr>
    <tr class="form-group">
        <td class="col-xs-4"><?php echo __('Subvar'); ?></td>
        <td><?php echo $this->Form->input('ListOfSpecies.subvar', array('class' => 'form-control', 'value' => Hash::get($data, 'ListOfSpecies.subvar'))); ?> </td>
    </tr>
    <tr class="form-group">
        <td class="col-xs-4"><?php echo __('Forma'); ?></td>
        <td><?php echo $this->Form->input('ListOfSpecies.forma', array('class' => 'form-control', 'value' => Hash::get($data, 'ListOfSpecies.forma'))); ?> </td>
    </tr>
    <tr class="form-group">
        <td class="col-xs-4"><?php echo __('Authors'); ?></td>
        <td><?php echo $this->Form->input('ListOfSpecies.authors', array('class' => 'form-control', 'value' => Hash::get($data, 'ListOfSpecies.authors'))); ?> </td>
    </tr>
    <tr class="form-group">
        <td class="col-xs-4"><?php echo __('Type'); ?></td>
        <td><?php echo $this->Form->input('ListOfSpecies.ntype', array('class' => 'form-control', 'type' => 'select', 'options' => $ntypes, 'value' => Hash::get($data, 'ListOfSpecies.ntype'))); ?> </td>
    </tr>
</table>

<div id="hybrid-fields" class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title clickable">
                <a data-toggle="collapse" href="#collapse1">
                    Hybrid fields
                    <span class="pull-right">&blacktriangledown;</span>
                </a>
            </h4>
        </div>
        <?php
        $is_hybrid = Hash::get($data, 'ListOfSpecies.hybrid');
        ?>
        <div id="collapse1" class="panel-collapse collapse<?php echo $is_hybrid ? ' in' : ''; ?>"">
            <table class="table table-bordered table-condensed table-responsive">
                <tr>
                    <td class="col-xs-4"><?php echo __('H. Genus'); ?></td>
                    <td><?php echo $this->Form->input('ListOfSpecies.genus_h', array('class' => 'form-control', 'value' => Hash::get($data, 'ListOfSpecies.genus_h'))); ?> </td>
                </tr>
                <tr>
                    <td class="col-xs-4"><?php echo __('H. Species'); ?></td>
                    <td><?php echo $this->Form->input('ListOfSpecies.species_h', array('class' => 'form-control', 'value' => Hash::get($data, 'ListOfSpecies.species_h'))); ?> </td>
                </tr>
                <tr>
                    <td class="col-xs-4"><?php echo __('H. Subsp'); ?></td>
                    <td><?php echo $this->Form->input('ListOfSpecies.subsp_h', array('class' => 'form-control', 'value' => Hash::get($data, 'ListOfSpecies.subsp_h'))); ?> </td>
                </tr>
                <tr>
                    <td class="col-xs-4"><?php echo __('H. Var'); ?></td>
                    <td><?php echo $this->Form->input('ListOfSpecies.var_h', array('class' => 'form-control', 'value' => Hash::get($data, 'ListOfSpecies.var_h'))); ?> </td>
                </tr>
                <tr>
                    <td class="col-xs-4"><?php echo __('H. Subvar'); ?></td>
                    <td><?php echo $this->Form->input('ListOfSpecies.subvar_h', array('class' => 'form-control', 'value' => Hash::get($data, 'ListOfSpecies.subvar_h'))); ?> </td>
                </tr>
                <tr>
                    <td class="col-xs-4"><?php echo __('H. Forma'); ?></td>
                    <td><?php echo $this->Form->input('ListOfSpecies.forma_h', array('class' => 'form-control', 'value' => Hash::get($data, 'ListOfSpecies.forma_h'))); ?> </td>
                </tr>
                <tr>
                    <td class="col-xs-4"><?php echo __('H. Authors'); ?></td>
                    <td><?php echo $this->Form->input('ListOfSpecies.authors_h', array('class' => 'form-control', 'value' => Hash::get($data, 'ListOfSpecies.authors_h'))); ?> </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<table class="table table-bordered table-condensed table-responsive">
    <tr>
        <td class="col-xs-4"><?php echo __('Publication'); ?></td>
        <td><?php echo $this->Form->input('ListOfSpecies.publication', array('class' => 'form-control', 'value' => Hash::get($data, 'ListOfSpecies.publication'))); ?> </td>
    </tr>
    <tr>
        <td class="col-xs-4"><?php echo __('Tribus'); ?></td>
        <td><?php echo $this->Form->input('ListOfSpecies.tribus', array('class' => 'form-control', 'value' => Hash::get($data, 'ListOfSpecies.tribus'))); ?> </td>
    </tr>
    <tr>
        <td class="col-xs-4"></td>
        <td><?php echo $this->Form->input('ListOfSpecies.is_isonym', array('type' => 'checkbox', 'label' => 'Is isonym', 'value' => Hash::get($data, 'ListOfSpecies.is_isonym'))); ?></td>
    </tr>
</table>

<h3><?php echo __('Associations'); ?></h3>
<table class="table table-bordered table-condensed table-responsive">
    <tr>
        <td class="col-xs-4"><?php echo __('Accepted name'); ?></td>
        <td><?php echo $this->Form->input('ListOfSpecies.id_accepted_name', array('class' => 'form-control', 'type' => 'select', 'options' => $accepted_list, 'value' => Hash::get($data, 'ListOfSpecies.id_accepted_name'), 'empty' => true)); ?></td>
    </tr>
    <tr>
        <td class="col-xs-4"><?php echo __('Basionym'); ?></td>
        <td><?php echo $this->Form->input('ListOfSpecies.id_basionym', array('class' => 'form-control', 'type' => 'select', 'options' => $loss_list, 'value' => Hash::get($data, 'ListOfSpecies.id_basionym'), 'empty' => true)); ?></td>
    </tr>
    <tr>
        <td class="col-xs-4"><?php echo __('Replaced name'); ?></td>
        <td><?php echo $this->Form->input('ListOfSpecies.id_replaced', array('class' => 'form-control', 'type' => 'select', 'options' => $loss_list, 'value' => Hash::get($data, 'ListOfSpecies.id_replaced'), 'empty' => true)); ?></td>
    </tr>
    <tr>
        <td class="col-xs-4"><?php echo __('Nomen novum'); ?></td>
        <td><?php echo $this->Form->input('ListOfSpecies.id_nomen_novum', array('class' => 'form-control', 'type' => 'select', 'options' => $loss_list, 'value' => Hash::get($data, 'ListOfSpecies.id_nomen_novum'), 'empty' => true)); ?></td>
    </tr>
</table>

<h3><?php echo __('Nomenclatoric Synonyms'); ?></h3>
<table id="nomenclatoric" class="table table-bordered table-condensed table-responsive">
    <?php
    foreach (Hash::get($data, 'SynonymsNomenclatoric', array()) as $val) :
        ?>
        <tr>
            <td class="col-xs-11"><?php echo $this->Format->los($val); ?></td>
            <td class="col-xs-1"><?php echo $this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array('controller' => 'synonyms', 'action' => 'delete', $val['id']), array('class' => 'btn btn-danger btn-delete', 'escape' => false)); ?></td>
        </tr>
        <?php
    endforeach;
    ?>
</table>

<?php
//format nomenclatoric synonyms for json
//$syns_nomen = array();
//foreach (Hash::get($data, 'SynonymsNomenclatoric', array()) as $val) {
//    $l = $this->Format->los($val);
//    $syns_nomen[$val['id']] = $l;
//}
//
//echo $this->Html->script('additable-list', array('inline' => false));
//$script = '$(document).ready(function() {' . "\n";
//$script .= 'var lossource = ' . json_encode($syns_nomen) . ';' . "\n";
//$script .= '$("#nomenclatoric").additableList({source: lossource, class: "table table-bordered table-condensed table-responsive"});' . "\n";
//$script .= '});';
//echo $this->Html->scriptBlock($script, array('inline' => false));
?>

<h3><?php echo __('Taxonomic Synonyms'); ?></h3>
<table id="taxonomic" class="table table-bordered table-condensed table-responsive">

</table>

<div class="row">
    <div class="col-md-2 col-xs-6">
        <?php
        echo $this->Form->submit('Save', array(
            'class' => 'btn btn-primary',
            'div' => false,
            'formnovalidate' => true
        ));
        ?>
    </div>
    <div class="col-md-2 col-xs-6">
        <?php
        echo $this->Html->link(__('Cancel'), '/checklist/index', array(
            'class' => 'btn btn-default'
        ));
        ?>
    </div>
    <div class="col-md-8 col-xs-12">
        <?php
        $losId = Hash::get($data, 'ListOfSpecies.id');
        $class = 'btn btn-danger pull-right btn-delete' . ($losId ? '' : ' disabled'); // disable if new record

        echo $this->Html->link(__('Delete'), array(
            'controller' => 'data',
            'action' => 'delete',
            $losId
                ), array(
            'class' => $class
        ));
        ?>
    </div>
</div>

<?php
$this->Form->end();
