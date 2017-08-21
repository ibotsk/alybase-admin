
<?php
//new dBug($data);
//echo $this->element('sql_dump');
?>
<div id="functions" class="container">
    <div class="col-xs-12">
        <?php
        $glyph = '<span class="glyphicon glyphicon-plus"></span> ';
        echo $this->Html->link($glyph . __('Add new'), '/data/insert', array('class' => 'btn btn-success', 'escape' => false));
        ?>
    </div>
</div>

<div class="container-fluid">
    <div class="row text-center text-primary">
        <?php
        echo $this->Paginator->counter(
                'Page {:page} of {:pages}, showing {:current} records out of
     			{:count} total'
        );
        ?>
    </div>
    <div class="row text-center">
        <ul class="pagination">
            <?php echo $this->Paginator->prev('< Prev', array('tag' => 'li', 'class' => false), null, array('disabledTag' => 'a', 'class' => 'disabled')); ?>
            <?php echo $this->Paginator->numbers(array('first' => 1, 'last' => 1, 'modulus' => 6, 'tag' => 'li', 'separator' => false, 'ellipsis' => '<li class="readonly"><a>...</a></li>', 'currentTag' => 'a', 'currentClass' => 'active')); ?>
            <?php echo $this->Paginator->next('Next >', array('tag' => 'li', 'class' => false), null, array('disabledTag' => 'a', 'class' => 'disabled')); ?>
        </ul>
    </div>
    <div id="table-container">
        <table class="table table-striped table-bordered table-condensed table-responsive">
            <tr>
                <th colspan="3"></th>
                <th colspan="2"><?php echo __('Name'); ?></th>
                <th colspan="2"><?php echo __('Reference'); ?></th>
                <th colspan="12"><?php echo __('Chromosome data'); ?></th>
                <th colspan="6"><?php echo __('Locality'); ?></th>
            </tr>
            <tr>
                <th><?php echo $this->Paginator->sort('Cdata.id', 'ID'); //$this->Html->link('ID', array('controller' => 'data', 'action' => 'all', 'id', 'asc'));  ?></th>
                <th colspan="2"><?php echo __('Action'); ?></th>
                <th><?php echo $this->Html->link(__('Orig. identification'), array('controller' => 'data', 'action' => 'all', 'urcenie', 'asc')); ?></th>
                <th><?php echo $this->Html->link(__('Last revision'), array('controller' => 'data', 'action' => 'all', 'revizia', 'asc')); ?></th>
                <th><?php echo $this->Html->link(__('Publ. author'), array('controller' => 'data', 'action' => 'all', 'autorpubl', 'asc')); ?></th>
                <th><?php echo $this->Html->link(__('Year'), array('controller' => 'data', 'action' => 'all', 'rok', 'asc')); ?></th>
                <th><?php echo $this->Html->link(__('n'), array('controller' => 'data', 'action' => 'all', 'n', 'asc')); ?></th>
                <th><?php echo $this->Html->link(__('2n'), array('controller' => 'data', 'action' => 'all', '2n', 'asc')); ?></th>
                <th><?php echo $this->Html->link(__('Ploidy'), array('controller' => 'data', 'action' => 'all', 'ploidia', 'asc')); ?></th>
                <th><?php echo $this->Html->link(__('Ploidy revised'), array('controller' => 'data', 'action' => 'all', 'ploidiarev', 'asc')); ?></th>
                <th><?php echo $this->Html->link(__('x revised'), array('controller' => 'data', 'action' => 'all', 'xrev', 'asc')); ?></th>
                <th><?php echo $this->Html->link(__('Counted by'), array('controller' => 'data', 'action' => 'all', 'spocital', 'asc')); ?></th>
                <th><?php echo $this->Html->link(__('Date of counting'), array('controller' => 'data', 'action' => 'all', 'datumspocitania', 'asc')); ?></th>
                <th><?php echo __('Number of plants'); ?></th>
                <th><?php echo __('Notes'); ?></th>
                <th>E/D/A</th>
                <th><?php echo __('Duplicate'); ?></th>
                <th><?php echo $this->Html->link(__('Stored in'), array('controller' => 'data', 'action' => 'all', 'ulozenev', 'asc')); ?></th>
                <th><?php echo $this->Html->link(__('W4'), array('controller' => 'data', 'action' => 'all', 'w4', 'asc')); ?></th>
                <th><?php echo $this->Html->link(__('Country'), array('controller' => 'data', 'action' => 'all', 'krajina', 'asc')); ?></th>
                <th><?php echo __('Latitude'); ?></th>
                <th><?php echo __('Longitude'); ?></th>
                <th><?php echo __('Lokality descr.'); ?></th>
            </tr>
            <?php
            foreach ($data as $d) :
                $origIdentification = Hash::check($d, 'Material.Reference.OriginalIdentification.Accepted.id') ? $d['Material']['Reference']['OriginalIdentification']['Accepted'] : $d['Material']['Reference']['OriginalIdentification'];
                ?>
                <tr>
                    <td>
    <?php echo $this->Html->link($d['Cdata']['id'], array('controller' => 'data', 'action' => 'detail', $d['Cdata']['id']), array('title' => __('View'))); ?>
                    </td>
                    <td>
    <?php echo $this->Html->link(__('Edit'), array('controller' => 'data', 'action' => 'edit', $d['Cdata']['id']), array('title' => __('Edit'))); ?>
                    </td>
                    <td><?php echo$this->Html->link(__('Delete'), array('controller' => 'data', 'action' => 'delete', $d['Cdata']['id']), array('title' => __('Delete'), 'class' => 'text-danger btn-delete-strong')); ?></td>
                    <td><?php echo $this->Format->los($origIdentification); ?></td>
                    <td><?php echo $this->Format->los(Hash::get($d, 'LatestRevision.ListOfSpecies')); ?></td>
                    <td><?php echo Hash::get($d, 'Material.Reference.Literature.paper_author'); ?></td>
                    <td><?php echo Hash::get($d, 'Material.Reference.Literature.year'); ?></td>
                    <td><?php echo Hash::get($d, 'Cdata.n'); ?></td>
                    <td><?php echo Hash::get($d, 'Cdata.dn'); ?></td>
                    <td><?php echo Hash::get($d, 'Cdata.ploidy_level'); ?></td>
                    <td><?php echo Hash::get($d, 'Cdata.ploidy_level_revised'); ?></td>
                    <td><?php echo Hash::get($d, 'Cdata.x_revised'); ?></td>
                    <td><?php echo Hash::get($d, 'CountedBy.pers_name'); ?></td>
                    <td><?php echo Hash::get($d, 'Cdata.counted_date'); ?></td>
                    <td><?php echo Hash::get($d, 'Cdata.number_of_analysed_plants'); ?></td>
                    <td><?php echo Hash::get($d, 'Cdata.note'); ?></td>
                    <td><?php echo $this->Format->eda($d['Cdata']); ?></td>
                    <!--<td><?php //echo $d['Cdata']['erroneous_marked_by'];    ?></td>-->
                    <td><?php echo Hash::get($d, 'Cdataduplicate_data'); ?></td>
                    <td><?php echo Hash::get($d, 'Material.deposited_in'); ?></td>
                    <td><?php echo Hash::get($d, 'Material.WorldL4.description'); ?></td>
                    <td><?php echo Hash::get($d, 'Material.country'); ?></td>
                    <td><?php
                        if (Hash::check($d, 'Material.coordinates_georef_lat')) {
                            echo $this->Format->coordinates($d['Material']['coordinates_georef_lat'], true);
                        } else {
                            echo $this->Format->coordinates($d['Material']['coordinates_n']);
                        }
                        ?></td>
                    <td><?php
                        if (Hash::check($d, 'Material.coordinates_georef_lon')) {
                            echo $this->Format->coordinates($d['Material']['coordinates_georef_lon'], true);
                        } else {
                            echo $this->Format->coordinates($d['Material']['coordinates_e']);
                        }
                        ?></td>
                    <td><?php echo Hash::get($d, 'Material.description'); ?></td>
                </tr>
                <?php
            endforeach;
            ?>
        </table>
    </div>

    <div class="row text-center">
        <ul class="pagination">
            <?php echo $this->Paginator->prev('< Prev', array('tag' => 'li', 'class' => false), null, array('disabledTag' => 'a', 'class' => 'disabled')); ?>
            <?php echo $this->Paginator->numbers(array('first' => 1, 'last' => 1, 'modulus' => 6, 'tag' => 'li', 'separator' => false, 'ellipsis' => '<li class="readonly"><a>...</a></li>', 'currentTag' => 'a', 'currentClass' => 'active')); ?>
<?php echo $this->Paginator->next('Next >', array('tag' => 'li', 'class' => false), null, array('disabledTag' => 'a', 'class' => 'disabled')); ?>
        </ul>
    </div>
</div>