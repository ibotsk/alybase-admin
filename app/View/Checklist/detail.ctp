<?php
//new dBug($result);

$ntypes = array(
    'A' => 'Accepted',
    'PA' => 'Provisionally Accepted',
    'S' => 'Synonym',
    'DS' => 'Doubtful Synonym',
    'U' => 'Unresolved',
    'H' => 'Hybrid'
);

$loss_list = Hash::combine($loss, '{n}.ListOfSpecies.id', '{n}');
unset($loss);

foreach ($loss_list as $key => $val) {
    $l = $this->Format->los($val['ListOfSpecies']);
    $loss_list[$key] = $l;
}

$accepted_list = Hash::combine($accepted, '{n}.ListOfSpecies.id', '{n}');
unset($accepted);

foreach ($accepted_list as $key => $val) {
    $l = $this->Format->los($val['ListOfSpecies']);
    $accepted_list[$key] = $l;
}
?>

<div id="checklist-detail" class="container">

    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $result['ListOfSpecies']['id']), array('class' => 'btn btn-default')); ?>

    <h3><?php echo __('Name'); ?></h3>
    <table class="table table-bordered table-condensed table-responsive">
        <tr>
            <td class="col-xs-4"><?php echo __('Genus'); ?></td>
            <td><?php echo $this->Eip->input('ListOfSpecies.genus', $result); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Species'); ?></td>
            <td><?php echo $this->Eip->input('ListOfSpecies.species', $result); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Subsp'); ?></td>
            <td><?php echo $this->Eip->input('ListOfSpecies.subsp', $result); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Var'); ?></td>
            <td><?php echo $this->Eip->input('ListOfSpecies.var', $result); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Subvar'); ?></td>
            <td><?php echo $this->Eip->input('ListOfSpecies.subvar', $result); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Forma'); ?></td>
            <td><?php echo $this->Eip->input('ListOfSpecies.forma', $result); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Authors'); ?></td>
            <td><?php echo $this->Eip->input('ListOfSpecies.authors', $result); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Type'); ?></td>
            <td><?php echo $this->Eip->input('ListOfSpecies.ntype', $result, array('type' => 'select', 'source' => $ntypes, 'display' => $this->Format->type($result['ListOfSpecies']['ntype']))); ?> </td>
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
            $is_hybrid = Hash::get($result, 'ListOfSpecies.hybrid');
            ?>
            <div id="collapse1" class="panel-collapse collapse<?php echo $is_hybrid ? ' in' : ''; ?>"">
                <table class="table table-bordered table-condensed table-responsive">
                    <tr>
                        <td class="col-xs-4"><?php echo __('H. Genus'); ?></td>
                        <td><?php echo $this->Eip->input('ListOfSpecies.genus_h', $result); ?> </td>
                    </tr>
                    <tr>
                        <td class="col-xs-4"><?php echo __('H. Species'); ?></td>
                        <td><?php echo $this->Eip->input('ListOfSpecies.species_h', $result); ?> </td>
                    </tr>
                    <tr>
                        <td class="col-xs-4"><?php echo __('H. Subsp'); ?></td>
                        <td><?php echo $this->Eip->input('ListOfSpecies.subsp_h', $result); ?> </td>
                    </tr>
                    <tr>
                        <td class="col-xs-4"><?php echo __('H. Var'); ?></td>
                        <td><?php echo $this->Eip->input('ListOfSpecies.var_h', $result); ?> </td>
                    </tr>
                    <tr>
                        <td class="col-xs-4"><?php echo __('H. Subvar'); ?></td>
                        <td><?php echo $this->Eip->input('ListOfSpecies.subvar_h', $result); ?> </td>
                    </tr>
                    <tr>
                        <td class="col-xs-4"><?php echo __('H. Forma'); ?></td>
                        <td><?php echo $this->Eip->input('ListOfSpecies.forma_h', $result); ?> </td>
                    </tr>
                    <tr>
                        <td class="col-xs-4"><?php echo __('H. Authors'); ?></td>
                        <td><?php echo $this->Eip->input('ListOfSpecies.authors_h', $result); ?> </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-condensed table-responsive">
        <tr>
            <td class="col-xs-4"><?php echo __('Publication'); ?></td>
            <td><?php echo $this->Eip->input('ListOfSpecies.publication', $result); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Tribus'); ?></td>
            <td><?php echo $this->Eip->input('ListOfSpecies.tribus', $result); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Is isonym'); ?></td>
            <td><?php echo $this->Eip->inputBool('ListOfSpecies.is_isonym', $result, 'True', 'False'); ?> </td>
        </tr>
    </table>

    <h3><?php echo __('Associations'); ?></h3>
    <table class="table table-bordered table-condensed table-responsive">
        <tr>
            <td class="col-xs-4"><?php echo __('Accepted name'); ?></td>
            <td><?php echo $this->Eip->input('ListOfSpecies.id_accepted_name', $result, array('type' => 'select', 'source' => $accepted_list, 'display' => $this->Format->los(Hash::get($result, 'Accepted')))); ?></td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Basionym'); ?></td>
            <td><?php echo $this->Eip->input('ListOfSpecies.id_basionym', $result, array('type' => 'select', 'source' => $loss_list, 'display' => $this->Format->los(Hash::get($result, 'Basionym')))); ?></td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Replaced name'); ?></td>
            <td><?php echo $this->Eip->input('ListOfSpecies.id_replaced', $result, array('type' => 'select', 'source' => $loss_list, 'display' => $this->Format->los(Hash::get($result, 'Replaced')))); ?></td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Nomen novum'); ?></td>
            <td><?php echo $this->Eip->input('ListOfSpecies.id_nomen_novum', $result, array('type' => 'select', 'source' => $loss_list, 'display' => $this->Format->los(Hash::get($result, 'Nomen novum')))); ?></td>
        </tr>
    </table>

    <h3>
        <?php echo __('Nomenclatoric Synonyms'); ?>
        <small><?php echo __('(Synonyms can be managed only in ') . $this->Html->link('full edit mode', array('action' => 'edit', $result['ListOfSpecies']['id'], '#' => 'nomenclatoric')) . ')'; ?></small>
    </h3>
    <table class="table table-condensed table-responsive table-bordered-outline">
        <?php if (empty($result['SynonymsNomenclatoric'])): //show one empty row ?>
            <tr><td></td></tr>
        <?php endif; ?>
        <?php foreach ($result['SynonymsNomenclatoric'] as $sn) : ?>
            <tr>
                <td class="col-xs-1">&#8801;</td>
                <td>
                    <?php
                    $sn_name = $this->Format->los($sn, array('special' => $sn['is_isonym']));
                    echo $this->Html->link($sn_name, array('action' => 'detail', $sn['id']));
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>
        <?php echo __('Taxonomic Synonyms'); ?>
        <small><?php echo __('(Synonyms can be managed only in ') . $this->Html->link('full edit mode', array('action' => 'edit', $result['ListOfSpecies']['id'], '#' => 'taxonomic')) . ')'; ?></small>
    </h3>
    <p>
        All associated nomenclatoric synonyms are shown here to see which are associated with each other. Those in grey colour will not be shown on the website.
        <?php echo $this->Html->link('(Example)', '/checklist/detail/335'); ?>
    </p>
    <table class="table table-condensed table-responsive table-bordered-outline">
        <?php if (empty($result['SynonymsTaxonomic'])): //show one empty row ?>
            <tr><td></td></tr>
        <?php endif; ?>
        <?php foreach ($result['SynonymsTaxonomic'] as $st) : ?>
            <tr>
                <td class="col-xs-1">=</td>
                <td>
                    <?php
                    $st_name = $this->Format->los($st, array('special' => $st['is_isonym']));
                    echo $this->Html->link($st_name, array('action' => 'detail', $st['id']));
                    ?>
                    <ul class="normal">
                        <?php
                        foreach ($st['SynonymsNomenclatoric'] as $st_n):
                            $st_n_name = $this->Format->los($st_n, array('special' => $st['is_isonym']));
                            $is_shown = Hash::get($st_n, 'Synonym.show_in_tree') ? '' : 'class="grey"';
                            ?>
                            <li <?php echo $is_shown; ?>>
                                <span class="col-xs-1">&#8801;</span>
                                <span class="col-xs-11"><?php echo $this->Html->link($st_n_name, array('action' => 'detail', $st_n['id'])); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>
        <?php echo __('Invalid designations'); ?>
    </h3>
    <table class="table table-condensed table-responsive table-bordered">
        <?php if (empty($result['SynonymsInvalid'])): //show one empty row ?>
            <tr><td></td></tr>
        <?php endif; ?>
        <?php foreach ($result['SynonymsInvalid'] as $ind) : ?>
            <tr>
                <td>
    <?php
    $ind_name = $this->Format->los($ind, array('special' => $ind['is_isonym']));
    echo $this->Html->link($ind_name, array('action' => 'detail', $ind['id']));
    ?>
                </td>
            </tr>
<?php endforeach; ?>
    </table>

    <h3>
<?php echo __('Basionym for'); ?>
        <small><?php echo __('(Only if this name is a basionym)'); ?></small>
    </h3>
    <table class="table table-condensed table-responsive table-bordered">
<?php if (empty($result['BasionymFor'])): //show one empty row ?>
            <tr><td></td></tr>
        <?php endif; ?>
        <?php foreach ($result['BasionymFor'] as $bf) : ?>
            <tr>
                <td>
            <?php
            $bf_name = $this->Format->los($bf, array('special' => $bf['is_isonym']));
            echo $this->Html->link($bf_name, array('action' => 'detail', $bf['id']));
            ?>
                </td>
            </tr>
                <?php endforeach; ?>
    </table>

    <h3>
<?php echo __('Replaced name for'); ?>
        <small><?php echo __('(Only if this name is a replaced name)'); ?></small>
    </h3>
    <table class="table table-condensed table-responsive table-bordered">
<?php if (empty($result['ReplacedFor'])): //show one empty row ?>
            <tr><td></td></tr>
        <?php endif; ?>
        <?php foreach ($result['ReplacedFor'] as $rf) : ?>
            <tr>
                <td>
            <?php
            $rf_name = $this->Format->los($rf, array('special' => $rf['is_isonym']));
            echo $this->Html->link($rf_name, array('action' => 'detail', $rf['id']));
            ?>
                </td>
            </tr>
                <?php endforeach; ?>
    </table>


    <div class="col-xs-6"><?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $result['ListOfSpecies']['id']), array('class' => 'btn btn-default')); ?></div>
    <div class="col-xs-6"><?php echo $this->Html->link(__('Back'), array('action' => 'index'), array('class' => 'btn btn-default')); ?></div>

</div>