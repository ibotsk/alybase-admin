<?php
// echo $this->element('sql_dump');
//new dBug($data);
$literatures_list = Hash::combine($literatures, '{n}.Literature.id', '{n}');
unset($literatures);

foreach ($literatures_list as $key => $val) {
    $l = $this->Format->literature($val['Literature']);
    $literatures_list[$key] = $l;
}

$loss_list = Hash::combine($loss, '{n}.ListOfSpecies.id', '{n}');
unset($loss);

foreach ($loss_list as $key => $val) {
    $l = $this->Format->los($val['ListOfSpecies']);
    $loss_list[$key] = $l;
}
?>

<div id="chrom-data-detail" class="container">

    <?php echo $this->Html->link(__('Edit'), array('controller' => 'data', 'action' => 'edit', $data['Cdata']['id']), array('class' => 'btn btn-default')); ?>

    <h3><?php echo __('Name'); ?></h3>
    <table class="table table-bordered table-condensed table-responsive">
        <tr>
            <td class="col-xs-4"><?php echo __('Name after last revision:'); ?></td>
            <td><?php echo $this->Html->link($this->Format->los(Hash::get($data, 'LatestRevision.ListOfSpecies'), array('italic' => true)), array('controller' => 'checklist', 'action' => 'detail', $data['LatestRevision']['ListOfSpecies']['id']), array('escape' => false)); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Name as originally published (standardised version from checklist):'); ?></td>
            <td>
                <div class="col-xs-11">
                    <?php
                    $std_name = $this->Format->los(Hash::get($data, 'Material.Reference.OriginalIdentification'), array(
                        'italic' => true
                    ));

                    echo $this->Eip->input('Material.Reference.id_standardised_name', $data, array(
                        'type' => 'select',
                        'source' => $loss_list,
                        'display' => $std_name
                    ));
                    ?>
                </div>
                <div class="col-xs-1">
                    <?php
                    if (!empty($std_name)) {
                        echo $this->Html->link('View', array(
                            'controller' => 'checklist',
                            'action' => 'detail',
                            $data['Material']['Reference']['OriginalIdentification']['id']
                                ), array(
                            'target' => '_blank',
                            'escape' => false
                        ));
                    }
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <td><?php echo __('Accepted name (of original identification):'); ?></td>
            <td>
                <?php
                $name = Hash::get($data, 'Material.Reference.OriginalIdentification.Accepted');
                if (empty($name)) {
                    $name = Hash::get($data, 'Material.Reference.OriginalIdentification');
                }
                echo $this->Format->los($name);
                ?>
            </td>
        </tr>
        <tr>
            <td><?php echo __('Name exactly as originally published:'); ?></td>
            <td><?php echo $this->Eip->input('Material.Reference.name_as_published', $data); //echo $data['Material']['Reference']['name_as_published'];  ?></td>
        </tr>
    </table>

    <h3>
        <?php echo __('Identification revisions'); ?><br />
        <small><?php echo __('(Revisions can be managed only in ') . $this->Html->link('full edit mode', array('controller' => 'data', 'action' => 'edit', $data['Cdata']['id'])) . ')'; ?></small>
    </h3>

    <?php
    $i = 1;
    $revisions = Hash::get($data, 'History');
    $r_count = count($revisions);
    $first = '<span class="label label-primary">Newest</span>';
    $last = '<span class="label label-primary">Oldest</span>';
    ?>

    <table id="revision-table" class="table table-bordered table-condensed">
        <?php
        foreach ($revisions as $r) :
            ?>
            <tr>
                <td class="col-xs-1"><?php echo $i == 1 ? $first : ($i == count($revisions) ? $last : ''); ?></td>
                <td class="col-xs-3"><?php echo Hash::get($r, 'revised_name'); ?></td>
                <td><?php echo $this->Format->los(Hash::get($r, 'ListOfSpecies')); ?></td>
            </tr>
            <?php
            $i++;
        endforeach
        ;
        ?>
    </table>

    <h3><?php echo __('Literature'); ?></h3>
    <table class="table table-bordered table-condensed table-responsive">
        <tr>
            <td colspan="2">
                <?php
                $lit = $this->Format->literature(Hash::get($data, 'Material.Reference.Literature'));
                echo $this->Eip->input('Material.Reference.id_literature', $data, array(
                    'type' => 'select',
                    'source' => $literatures_list,
                    'display' => $lit
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Exact page(s) on which the record is published:'); ?></td>
            <td><?php echo $this->Eip->input('Material.Reference.page', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Notes:'); ?></td>
            <td><?php echo $this->Eip->input('Material.Reference.Literature.note', $data, array('type' => 'textarea')); ?></td>
        </tr>
    </table>

    <h3><?php echo __('Chromosome data'); ?></h3>
    <table class="table table-bordered table-condensed table-responsive">
        <tr>
            <td class="col-xs-4"><?php echo __('Chromosome count n:'); ?></td>
            <td><?php echo $this->Eip->input('Cdata.n', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Chromosome count 2n:'); ?></td>
            <td><?php echo $this->Eip->input('Cdata.dn', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Ploidy as published in original source:'); ?></td>
            <td><?php echo $this->Eip->input('Cdata.ploidy_level', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Ploidy revised:'); ?></td>
            <td><?php echo $this->Eip->input('Cdata.ploidy_level_revised', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Base chromosome number (x) as published:'); ?></td>
            <td><?php echo $this->Eip->input('Cdata.x', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Base chromosome number (x) after last revision:'); ?></td>
            <td><?php echo $this->Eip->input('Cdata.x_revised', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Counted by:'); ?></td>
            <td><?php echo $this->Eip->input('Cdata.counted_by', $data, array('type' => 'select', 'source' => $persons, 'display' => Hash::get($data, 'CountedBy.pers_name'))); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Counted date:'); ?></td>
            <td><?php echo $this->Eip->input('Cdata.counted_date', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Number of analysed plants:'); ?></td>
            <td><?php echo $this->Eip->input('Cdata.number_of_analysed_plants', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Slide number:'); ?></td>
            <td><?php echo $this->Eip->input('Cdata.slide_no', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Deposited in:'); ?></td>
            <td><?php echo $this->Eip->input('Cdata.deposited_in', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Karyotype:'); ?></td>
            <td><?php echo $this->Eip->input('Cdata.karyotype', $data); ?></td>
        </tr>
        <tr>
            <td colspan="2">
                <?php
                $true = __('True');
                $false = __('False');
                ?>
                <div class="col-xs-4">
                    <div class="col-md-3"><?php echo __('Photo:'); ?></div>
                    <div class="col-md-9"><?php echo $this->Eip->inputBool('Cdata.photo', $data, $true, $false); ?></div>
                </div>
                <div class="col-xs-4">
                    <div class="col-md-3"><?php echo __('Idiogram:'); ?></div>
                    <div class="col-md-9"><?php echo $this->Eip->inputBool('Cdata.idiogram', $data, $true, $false); ?></div>
                </div>
                <div class="col-xs-4">
                    <div class="col-md-3"><?php echo __('Drawing:'); ?></div>
                    <div class="col-md-9"><?php echo $this->Eip->inputBool('Cdata.drawing', $data, $true, $false); ?></div>
                </div>
            </td>
        </tr>
        <tr>
            <td><?php echo __('Private note:'); ?></td>
            <td><?php
                echo $this->Eip->input('Cdata.note', $data, array(
                    'type' => 'textarea'
                ));
                ?></td>
        </tr>
        <tr>
            <td><?php echo __('Public note:'); ?></td>
            <td><?php
                echo $this->Eip->input('Cdata.public_note', $data, array(
                    'type' => 'textarea'
                ));
                ?></td>
        </tr>
    </table>

    <h3><?php echo __('Estimated ploidy level and/or DNA content'); ?></h3>
    <table class="table table-bordered table-condensed table-responsive">
        <tr>
            <td class="col-xs-4"><?php echo __('Method:'); ?></td>
            <td><?php echo $this->Eip->input('Dna.method', $data); ?></td>
        </tr>
        <tr>
            <td ><?php echo __('DNA ploidy level as published in the original source:'); ?></td>
            <td><?php echo $this->Eip->input('Dna.ploidy', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('DNA ploidy level after last revision:'); ?></td>
            <td><?php echo $this->Eip->input('Dna.ploidy_revised', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Chromosome count:'); ?></td>
            <td><?php echo $this->Eip->input('Dna.ch_count', $data); ?></td>
        </tr>
        <tr>
            <td colspan="2"><?php echo __('Genome size:'); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Size c:'); ?></td>
            <td><?php echo $this->Eip->input('Dna.size_c', $data); ?>
        </tr>
        <tr>
            <td><?php echo __('Size from:'); ?></td>
            <td><?php echo $this->Eip->input('Dna.size_from', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Size to:'); ?></td>
            <td><?php echo $this->Eip->input('Dna.size_to', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Size units:'); ?></td>
            <td><?php echo $this->Eip->input('Dna.size_units', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Number of analysed plants:'); ?></td>
            <td><?php echo $this->Eip->input('Dna.plants_analysed', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Number of analyses:'); ?></td>
            <td><?php echo $this->Eip->input('Dna.number_analyses', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Note:'); ?></td>
            <td><?php echo $this->Eip->input('Dna.note', $data); ?></td>
        </tr>
    </table>

    <h3><?php echo __('Locality'); ?></h3>
    <div class="panel panel-default">
        <div class="panel-heading">
            World Geographical Scheme for Recording Plant Distributions (<a href="http://www.nhm.ac.uk/hosted_sites/tdwg/TDWG_geo2.pdf">Brummitt 2001</a>)
        </div>
        <table class="table table-bordered table-condensed table-responsive panel-body">
            <tr>
                <td class="col-xs-4"><?php echo __('Level 4:'); ?></td>
                <td><?php echo $this->Eip->input('Material.id_world_4', $data, array('type' => 'select', 'source' => $worlds4, 'display' => Hash::get($data, 'Material.WorldL4.description'))); ?></td>
            </tr>
        </table>
    </div>

    <table class="table table-bordered table-condensed table-responsive">
        <tr>
            <td class="col-xs-4"><?php echo __('Country'); ?></td>
            <td><?php echo $this->Eip->input('Material.country', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Closest city/town/village/settlement:'); ?></td>
            <td><?php echo $this->Eip->input('Material.closest_village_town', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Description of the locality:'); ?></td>
            <td><?php echo $this->Eip->input('Material.description', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Exposition:'); ?></td>
            <td><?php echo $this->Eip->input('Material.exposition', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Altitude:'); ?></td>
            <td><?php echo $this->Eip->input('Material.altitude', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Published geographical coordinates:'); ?></td>
            <td><div class="col-md-4">
                    <?php echo $this->Eip->input('Material.coordinates_n', $data, array('display' => $this->Format->coordinates($data['Material']['coordinates_n']))); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $this->Eip->input('Material.coordinates_e', $data, array('display' => $this->Format->coordinates($data['Material']['coordinates_e']))); ?>
                </div></td>
        </tr>
        <tr>
            <td><?php echo __('Estimated geographical coordinates:'); ?></td>
            <td>
                <div class="col-md-4">
                    <?php echo $this->Eip->input('Material.coordinates_georef_lat', $data, array('display' => $this->Format->coordinates($data['Material']['coordinates_georef_lat']))); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $this->Eip->input('Material.coordinates_georef_lon', $data, array('display' => $this->Format->coordinates($data['Material']['coordinates_georef_lon']))); ?>
                </div>
            </td>
        </tr>
        <tr>
            <td><?php echo __('Central european mapping unit:'); ?></td>
            <td><?php echo $this->Eip->input('Material.central_european_mapping_unit', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Geographical district:'); ?></td>
            <td><?php echo $this->Eip->input('Material.geographical_district', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Phytogeographical district:'); ?></td>
            <td><?php echo $this->Eip->input('Material.phytogeographical_district', $data, array('type' => 'select', 'source' => $phytodistricts, 'display' => Hash::get($data, 'Material.PhytogeoDistrict.district_name'))); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Administrative unit:'); ?></td>
            <td><?php echo $this->Eip->input('Material.administrative_unit', $data); ?></td>
        </tr>
    </table>

    <h3><?php echo __('Material'); ?></h3>
    <table class="table table-bordered table-condensed table-responsive">
        <tr>
            <td class="col-xs-4"><?php echo __('Collected by:'); ?></td>
            <td><?php echo $this->Eip->input('Material.collected_by', $data, array('type' => 'select', 'source' => $persons, 'display' => Hash::get($data, 'Material.PersonsCol.pers_name'))); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Collected date:'); ?></td>
            <td><?php echo $this->Eip->input('Material.collected_date', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Identified by:'); ?></td>
            <td><?php echo $this->Eip->input('Material.identified_by', $data, array('type' => 'select', 'source' => $persons, 'display' => Hash::get($data, 'Material.PersonsIdf.pers_name'))); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Voucher:'); ?></td>
            <td><?php echo $this->Eip->input('Material.voucher_specimen_no', $data); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Voucher deposited in:'); ?></td>
            <td><?php echo $this->Eip->input('Material.deposited_in', $data); ?></td>
        </tr>
    </table>

    <?php echo $this->Html->link(__('Edit'), array('controller' => 'data', 'action' => 'edit', $data['Cdata']['id']), array('class' => 'btn btn-default')); ?>

</div>
<?php echo $this->fetch('script'); ?>
