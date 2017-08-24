<?php
//new dBug($data);
// prepare list of species
$loss_list = Hash::combine($loss, '{n}.ListOfSpecies.id', '{n}');
unset($loss);

foreach ($loss_list as $key => $val) {
    $l = $this->Format->los($val['ListOfSpecies']);
    $loss_list[$key] = $l;
}

//
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

echo $this->element('form-identification');
echo $this->element('form-publication');
echo $this->element('form-person');

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

if (Hash::check($data, 'Cdata.id')) { // data exist -> we are editing
    echo $this->Form->hidden('Cdata.id', array(
        'value' => Hash::get($data, 'Cdata.id')
    ));
    echo $this->Form->hidden('Material.id', array(
        'value' => Hash::get($data, 'Material.id')
    ));
    echo $this->Form->hidden('Material.Reference.id', array(
        'value' => Hash::get($data, 'Material.Reference.id')
    ));
    echo $this->Form->hidden('Dna.id', array(
        'value' => Hash::get($data, 'Dna.id')
    ));
}
?>
<div id="data-id">
    <h3>
        <?php
        if ($action == 'insert') {
            echo 'New record';
        } else {
            echo 'ID ' . $data['Cdata']['id'];
        }
        ?>
    </h3>
</div>
<div id="identification">
    <h3><?php echo __('Name'); ?></h3>
    <table class="table table-bordered table-condensed">
        <tr class="form-group">
            <td><?php echo __('Name after last revision:'); ?></td>
            <td>
                <?php
                $latest_rev_name = Hash::get($data, 'LatestRevision.ListOfSpecies');
                if ($latest_rev_name) {
                    echo $this->Html->link($this->Format->los(Hash::get($data, 'LatestRevision.ListOfSpecies'), array(
                                'italic' => true
                            )), array(
                        'controller' => 'checklist',
                        'action' => 'detail',
                        $data['LatestRevision']['ListOfSpecies']['id']
                            ), array(
                        'escape' => false
                    ));
                }
                ?>
            </td>
        </tr>
        <tr class="form-group">
            <td class="col-md-4"><?php echo __('Name as originally published (standardised version from checklist):'); ?></td>
            <td>
                <?php
                $name = Hash::get($data, 'Material.Reference.OriginalIdentification.Accepted'); //accepted name of original identification as default
                if (empty($name)) {
                    $name = Hash::get($data, 'Material.Reference.OriginalIdentification');
                }
                $orig_los = $this->Format->los($name);

                echo $this->AutoComplete->input('Material.Reference.id_standardised_name', $this->Html->url('/listofspecies/search.json'), array(
                    'idText' => 'identification-name',
                    'idHidden' => 'identification-name-id',
                    'select' => array('$("#revision-first-std-name").val(ui.item.value);'),
                    'textvalue' => $orig_los,
                    'hiddenvalue' => Hash::get($data, 'Material.Reference.id_standardised_name'),
                    'btnLabel' => __('Add new name'),
                    'tooltip' => __('Add new name to the database and immediately use it in this field'),
                    'placeholder' => 'Start by typing a name (it must be in the database first)',
                    'modalId' => 'modal-identification'
                ));
                ?>
            </td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Name exactly as originally published <small>(with spelling errors)</small>'); ?></td>
            <td>
                <div class="input-group">
<?php echo $this->Form->input('Material.Reference.name_as_published', array('type' => 'text', 'id' => 'identification-name-as-published', 'class' => 'form-control', 'value' => Hash::get($data, 'Material.Reference.name_as_published'))); ?>
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default"
                                id="name-as-published-copy" data-toggle="tooltip"
                                title="Copy value from checklist">
                            <span class="glyphicon glyphicon-import"></span>
                        </button>
                    </div>
                </div>
            </td>
        </tr>
    </table>

</div>

<div id="revisions">
    <h3><?php echo __('Identification revisions'); ?></h3>
    <script type="text/javascript">
        var lossList = <?php echo json_encode($loss_list); ?>;
        initLos(lossList);
    </script>	

<?php
$i = 1;
$revisions = Hash::get($data, 'History', array());
$r_count = count($revisions);
$first = '<span class="label label-primary">Newest</span>';
$last = '<span class="label label-primary">Oldest</span>';
?>
    <button id="revision-add" type="button" class="btn btn-success"
            data-toggle="tooltip" title="<?php echo __('Add newest revision'); ?>">
        <span class="glyphicon glyphicon-plus"></span>
    </button>

    <table id="revision-table" class="table table-bordered table-condensed">
<?php if ($r_count == 0) : //no present revision means we are creating a new record. At least one revision must be added => original name  ?>
            <tr>
                <td class="col-xs-1"><span class="label label-warning">First</span></td>
                <td class="col-xs-3"><?php echo $this->Form->input('History.0.revised_name', array('class' => 'form-control', 'placeholder' => __('Revised name'))); ?></td>
                <td class="col-xs-7"><?php echo $this->Form->input('History.0.id_standardised_name', array('class' => 'form-control', 'id' => 'revision-first-std-name', 'type' => 'select', 'options' => $loss_list, 'empty' => true)); ?></td>
                <td class="col-xs-1"><?php //no delete button for this one  ?></td>
            </tr>
<?php
endif;

// class btn-delete-rev-strong is for revisions already in db, it deletes them permanently from the db
// class btn-delete-rev-weak is for new revisions not yet in db, it only removes the row from this table
foreach ($revisions as $r) :
    ?>
            <tr>
                <td class="col-xs-1"><?php echo $i == 1 ? $first : ($i == count($revisions) ? $last : ''); ?></td>
                <td class="col-xs-3"><?php echo Hash::get($r, 'revised_name'); ?></td>
                <td class="col-xs-7"><?php echo $this->Format->los(Hash::get($r, 'ListOfSpecies')); ?></td>
                <td class="col-xs-1"><?php
        if ($r_count > 1) { // we do not want to delete the only revision
            echo $this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array(
                'controller' => 'revisions',
                'action' => 'delete',
                $r['id']
                    ), array(
                'class' => 'btn btn-danger btn-delete-strong',
                'escape' => false,
                'data-toggle' => 'tooltip',
                'title' => __('Permanently remove this revision')
            ));
        }
    ?></td>
            </tr>
            <?php
            $i++;
        endforeach
        ;
        ?>
    </table>
</div>


<div id="literature">
    <h3><?php echo __('Literature'); ?></h3>
    <table class="table table-bordered table-condensed">
        <tr class="form-group">
            <td class="col-md-4"><?php echo __('Paper:'); ?></td>
            <td>
                <?php
                echo $this->AutoComplete->input('Material.Reference.id_literature', $this->Html->url('/literature/search.json'), array(
                    'idText' => 'literature-paper',
                    'idHidden' => 'literature-id',
                    'textvalue' => $this->Format->literature(Hash::get($data, 'Material.Reference.Literature')),
                    'hiddenvalue' => Hash::get($data, 'Material.Reference.id_literature'),
                    'btnLabel' => __('Add new paper'),
                    'tooltip' => __('Add new paper to database and immediately use it in this field'),
                    'placeholder' => 'Start by typing a paper title (it must be in the database first)',
                    'modalId' => 'modal-literature'
                ));
                ?>
            </td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Exact page(s) on which the record is published:'); ?></td>
            <td><?php echo $this->Form->input('Material.Reference.page', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Material.Reference.page'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Notes:'); ?></td>
            <td><?php echo $this->Form->input('Material.Reference.note', array('type' => 'textarea', 'class' => 'form-control', 'value' => Hash::get($data, 'Material.Reference.note'))); ?></td>
        </tr>
    </table>
</div>

<div id="chrom">
    <h3><?php echo __('Chromosome data'); ?></h3>
    <table class="table table-bordered table-condensed">
        <tr class="form-group">
            <td class="col-md-4"><?php echo __('Chromosome count n:'); ?></td>
            <td><?php echo $this->Form->input('Cdata.n', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Cdata.n'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Chromosome count 2n:'); ?></td>
            <td><?php echo $this->Form->input('Cdata.dn', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Cdata.dn'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Ploidy as published in original source:'); ?></td>
            <td><?php echo $this->Form->input('Cdata.ploidy_level', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Cdata.ploidy_level'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Ploidy revised:'); ?></td>
            <td><?php echo $this->Form->input('Cdata.ploidy_level_revised', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Cdata.ploidy_level_revised'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Base chromosome number (x) as published:'); ?></td>
            <td><?php echo $this->Form->input('Cdata.x', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Cdata.x'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Base chromosome number (x) after last revision:'); ?></td>
            <td><?php echo $this->Form->input('Cdata.x_revised', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Cdata.x_revised'))); ?></td>
        </tr>

        <tr class="form-group">
            <td><?php echo __('Counted by:'); ?></td>
            <td>
                <?php
                echo $this->AutoComplete->input('Cdata.counted_by', $this->Html->url('/persons/search.json'), array(
                    'idText' => 'counted-by-name',
                    'idHidden' => 'counted-by-id',
                    'textvalue' => Hash::get($data, 'CountedBy.pers_name'),
                    'hiddenvalue' => Hash::get($data, 'Cdata.counted_by'),
                    'btnLabel' => __('Add new person'),
                    'btnClass' => 'btn btn-info person-btn',
                    'tooltip' => __('Add new person(s) to the database and immediately use it in this field'),
                    'placeholder' => 'Start by typing a surname (it must be in the database first)',
                    'modalId' => 'modal-person'
                ));
                ?>
            </td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Counted date:'); ?></td>
            <td> <?php echo $this->Form->input('Cdata.counted_date', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Cdata.counted_date'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Number of analysed plants:'); ?></td>
            <td><?php echo $this->Form->input('Cdata.number_of_analysed_plants', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Cdata.number_of_analysed_plants'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Slide number:'); ?></td>
            <td><?php echo $this->Form->input('Cdata.slide_no', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Cdata.slide_no'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Deposited in:'); ?></td>
            <td><?php echo $this->Form->input('Cdata.deposited_in', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Cdata.deposited_in'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Karyotype:'); ?></td>
            <td><?php echo $this->Form->input('Cdata.karyotype', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Cdata.karyotype'))); ?></td>
        </tr>
        <tr class="form-group">
            <td colspan="2">
                <div class="col-xs-4">
                    <?php echo $this->Form->input('Cdata.drawing', array('type' => 'checkbox', 'label' => 'Drawing', 'value' => Hash::get($data, 'Cdata.drawing'))); ?>
                </div>
                <div class="col-xs-4">
                    <?php echo $this->Form->input('Cdata.photo', array('type' => 'checkbox', 'label' => 'Photo', 'value' => Hash::get($data, 'Cdata.photo'))); ?>
                </div>
                <div class="col-xs-4">
                    <?php echo $this->Form->input('Cdata.idiogram', array('type' => 'checkbox', 'label' => 'Idiogram', 'value' => Hash::get($data, 'Cdata.idiogram'))); ?>
                </div>
            </td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Private note:'); ?></td>
            <td><?php echo $this->Form->input('Cdata.note', array('type' => 'textarea', 'class' => 'form-control', 'value' => Hash::get($data, 'Cdata.note'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Public note:'); ?></td>
            <td><?php echo $this->Form->input('Cdata.public_note', array('type' => 'textarea', 'class' => 'form-control', 'value' => Hash::get($data, 'Cdata.public_note'))); ?></td>
        </tr>
    </table>
</div>

<div id="dna">
    <h3><?php echo __('Estimated ploidy level and/or DNA content'); ?></h3>
    <table class="table table-bordered table-condensed">
        <tr class="form-group">
            <td class="col-md-4"><?php echo __('Method:'); ?></td>
            <td><?php echo $this->Form->input('Dna.method', array('class' => 'form-control', 'value' => Hash::get($data, 'Dna.method'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('DNA ploidy level as published in the original source:'); ?></td>
            <td><?php echo $this->Form->input('Dna.ploidy', array('class' => 'form-control', 'value' => Hash::get($data, 'Dna.ploidy'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('DNA ploidy level after last revision:'); ?></td>
            <td><?php echo $this->Form->input('Dna.ploidy_revised', array('class' => 'form-control', 'value' => Hash::get($data, 'Dna.ploidy_revised'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Chromosome count:'); ?></td>
            <td><?php echo $this->Form->input('Dna.ch_count', array('class' => 'form-control', 'value' => Hash::get($data, 'Dna.ch_count'))); ?></td>
        </tr>
        <tr class="form-group">
            <td colspan="2"><?php echo __('Genome size:'); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Size c:'); ?></td>
            <td><?php echo $this->Form->input('Dna.size_c', array('class' => 'form-control', 'value' => Hash::get($data, 'Dna.size_c'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Size from:'); ?></td>
            <td><?php echo $this->Form->input('Dna.size_from', array('class' => 'form-control', 'value' => Hash::get($data, 'Dna.size_from'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Size to:'); ?></td>
            <td><?php echo $this->Form->input('Dna.size_to', array('class' => 'form-control', 'value' => Hash::get($data, 'Dna.size_to'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Size units:'); ?></td>
            <td><?php echo $this->Form->input('Dna.size_units', array('class' => 'form-control', 'value' => Hash::get($data, 'Dna.size_units'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Number of analysed plants:'); ?></td>
            <td><?php echo $this->Form->input('Dna.plants_analysed', array('class' => 'form-control', 'value' => Hash::get($data, 'Dna.plants_analysed'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Number of analyses:'); ?></td>
            <td><?php echo $this->Form->input('Dna.number_analyses', array('class' => 'form-control', 'value' => Hash::get($data, 'Dna.number_analyses'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Note:'); ?></td>
            <td><?php echo $this->Form->input('Dna.note', array('type' => 'textarea', 'class' => 'form-control', 'value' => Hash::get($data, 'Dna.note'))); ?></td>
        </tr>
    </table>
</div>

<div id="material">
    <h3><?php echo __('Locality'); ?></h3>
    <div class="panel panel-default">
        <div class="panel-heading">
            World Geographical Scheme for Recording Plant Distributions (<a
                href="http://www.nhm.ac.uk/hosted_sites/tdwg/TDWG_geo2.pdf">Brummitt
                2001</a>)
        </div>
        <table class="table table-bordered table-condensed panel-body">
            <tr class="form-group">
                <td class="col-xs-4"><?php echo __('World 4:'); ?></td>
                <td><?php
                    echo $this->Form->input('Material.id_world_4', array(
                        'type' => 'select',
                        'options' => $worlds4,
                        'id' => 'world4-name',
                        'class' => 'form-control',
                        'value' => Hash::get($data, 'Material.WorldL4.id')
                    ));
                    ?></td>
            </tr>
        </table>
    </div>

    <table class="table table-bordered table-condensed">
        <tr class="form-group">
            <td class="col-md-4"><?php echo __('Country:'); ?></td>
            <td><?php echo $this->Form->input('Material.country', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Material.country'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Closest city/town/village/settlement:'); ?></td>
            <td><?php echo $this->Form->input('Material.closest_village_town', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Material.closest_village_town'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Description of the locality:'); ?></td>
            <td><?php echo $this->Form->input('Material.description', array('type' => 'textarea', 'class' => 'form-control', 'value' => Hash::get($data, 'Material.description'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Exposition:'); ?></td>
            <td><?php echo $this->Form->input('Material.exposition', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Material.exposition'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Altitude:'); ?></td>
            <td><?php echo $this->Form->input('Material.altitude', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Material.altitude'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Published latitude:'); ?></td>
            <td><?php echo $this->Form->input('Material.coordinates_n', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Material.coordinates_n'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Published longitude:'); ?></td>
            <td><?php echo $this->Form->input('Material.coordinates_e', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Material.coordinates_e'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Estimated latitude:'); ?></td>
            <td><?php echo $this->Form->input('Material.coordinates_georef_lat', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Material.coordinates_georef_lat'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Estimated longitude:'); ?></td>
            <td><?php echo $this->Form->input('Material.coordinates_georef_lon', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Material.coordinates_georef_lon'))); ?></td>
        </tr>

        <tr class="form-group">
            <td><?php echo __('Central european mapping unit:'); ?></td>
            <td><?php echo $this->Form->input('Material.central_european_mapping_unit', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Material.central_european_mapping_unit'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Geographical District:'); ?></td>
            <td><?php echo $this->Form->input('Material.geographical_district', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Material.geographical_district'))); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Phytogeographical district:'); ?></td>
            <td><?php echo $this->Form->input('Material.phytogeographical_district', array('type' => 'select', 'options' => $phytodistricts, 'class' => 'form-control', 'empty' => true, 'selected' => Hash::get($data, 'Material.phytogeographical_district'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Administrative unit:'); ?></td>
            <td><?php echo $this->Form->input('Material.administrative_unit', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Material.administrative_unit'))); ?></td>
        </tr>
    </table>

    <h3><?php echo __('Material'); ?></h3>
    <table class="table table-bordered table-condensed">
        <tr class="form-group">
            <td class="col-xs-4"><?php echo __('Collected by:'); ?></td>
            <td>
                <?php
                echo $this->AutoComplete->input('Material.collected_by', $this->Html->url('/persons/search.json'), array(
                    'idText' => 'collected-by-name',
                    'idHidden' => 'collected-by-id',
                    'textvalue' => Hash::get($data, 'Material.PersonsCol.pers_name'),
                    'hiddenvalue' => Hash::get($data, 'Material.collected_by'),
                    'btnLabel' => __('Add new person'),
                    'btnClass' => 'btn btn-info person-btn',
                    'tooltip' => __('Add new person(s) to the database and immediately use it in this field'),
                    'placeholder' => 'Start by typing a surname (it must be in the database first)',
                    'modalId' => 'modal-person'
                ));
                ?>
            </td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Colected date:'); ?></td>
            <td><?php echo $this->Form->input('Material.collected_date', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Material.collected_date'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Identified by:'); ?></td>
            <td>
                <?php
                echo $this->AutoComplete->input('Material.identified_by', $this->Html->url('/persons/search.json'), array(
                    'idText' => 'identified-by-name',
                    'idHidden' => 'identified-by-id',
                    'textvalue' => Hash::get($data, 'Material.PersonsIdf.pers_name'),
                    'hiddenvalue' => Hash::get($data, 'Material.identified_by'),
                    'btnLabel' => __('Add new person'),
                    'btnClass' => 'btn btn-info person-btn',
                    'tooltip' => __('Add new person(s) to the database and immediately use it in this field'),
                    'placeholder' => 'Start by typing a surname (it must be in the database first)',
                    'modalId' => 'modal-person'
                ));
                ?>
            </td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Voucher:'); ?></td>
            <td><?php echo $this->Form->input('Material.voucher_specimen_no', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Cdata.deposited_in'))); ?></td>
        </tr>
        <tr class="form-group">
            <td><?php echo __('Voucher deposited in:'); ?></td>
            <td><?php echo $this->Form->input('Material.deposited_in', array('type' => 'text', 'class' => 'form-control', 'value' => Hash::get($data, 'Material.deposited_in'))); ?></td>
        </tr>

    </table>

</div>

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
echo $this->Html->link(__('Cancel'), '/data/index', array(
    'class' => 'btn btn-default'
));
?>
    </div>
    <div class="col-md-8 col-xs-12">
        <?php
        $cdataId = Hash::get($data, 'Cdata.id');
        $class = 'btn btn-danger pull-right btn-delete' . ($cdataId ? '' : ' disabled'); // disable if new record

        echo $this->Html->link(__('Delete'), array(
            'controller' => 'data',
            'action' => 'delete',
            $cdataId
                ), array(
            'class' => $class
        ));
        ?>
    </div>
</div>

<?php
$this->Form->end();
