
<div id="functions" class="container">
    <div class="col-xs-12">
        <?php
        $glyph = '<span class="glyphicon glyphicon-plus"></span> ';
        echo $this->Html->link($glyph . __('Add new'), array('action' => 'insert'), array('class' => 'btn btn-success', 'escape' => false));
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
                <th>ID</th>
                <th><?php echo __('Action'); ?></th>
                <th><?php echo __('Type'); ?></th>
                <th><?php echo __('Name'); ?></th>
                <th><?php echo __('Publication'); ?></th>
                <th><?php echo __('Accepted name'); ?></th>
                <th><?php echo __('Basionym'); ?></th>
                <th><?php echo __('Is basionym for'); ?></th>
                <th><?php echo __('Replaced name'); ?></th>
                <th><?php echo __('Is replaced name for'); ?></th>
            </tr>

            <?php
            foreach ($data as $d) :
                $is_isonym = Hash::get($d, 'is_isonym');
                $basionym_for = array();
                foreach ($d['BasionymFor'] as $b) {
                    $basionym_for[$b['id']] = $this->Format->los($b, array('publication' => false));
                }

                $replaced_for = array();
                foreach ($d['ReplacedFor'] as $r) {
                    $replaced_for[$r['id']] = $this->Format->los($r, array('publication' => false));
                }
                ?>
                <tr>
                    <td><?php echo $this->Html->link($d['ListOfSpecies']['id'], array('action' => 'detail', $d['ListOfSpecies']['id']), array('title' => __('View'))); ?></td>
                    <td><?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $d['ListOfSpecies']['id']), array('title' => __('Edit'))); ?></td>
                    <td><?php echo Hash::get($d, 'ListOfSpecies.ntype', '-'); ?></td>
                    <td><?php
                        $name = $this->Format->los(Hash::get($d, 'ListOfSpecies'), array('publication' => false, 'special' => $is_isonym));
                        echo $this->Html->link($name, array('action' => 'detail', $d['ListOfSpecies']['id']), array('title' => __('View')));
                        ?></td>
                    <td><?php echo Hash::get($d, 'ListOfSpecies.publication'); ?></td>
                    <td><?php
                        $a_name = $this->Format->los(Hash::get($d, 'Accepted'), array('publication' => false, 'special' => $is_isonym));
                        echo $a_name ? $this->Html->link($a_name, array('action' => 'detail', Hash::get($d, 'Accepted.id'))) : '';
                        ?></td>
                    <td><?php
                        $b_name = $this->Format->los(Hash::get($d, 'Basionym'), array('publication' => false, 'special' => $is_isonym));
                        echo $b_name ? $this->Html->link($b_name, array('action' => 'detail', Hash::get($d, 'Basionym.id'))) : '';
                        ?></td>
                    <td><?php
                        if (!empty($basionym_for)) {
                            echo $this->Form->select('basionyms', $basionym_for, array('class' => 'form-control', 'empty' => false));
                        }
                        ?></td>
                    <td><?php
                        $r_name = $this->Format->los(Hash::get($d, 'Replaced'), array('publication' => false, 'special' => $is_isonym));
                        echo $r_name ? $this->Html->link($r_name, array('action' => 'detail', Hash::get($d, 'Replaced.id'))) : '';
                        ?></td>
                    <td><?php
                        if (!empty($replaced_for)) {
                            echo $this->Form->select('replaceds', $replaced_for, array('class' => 'form-control', 'empty' => false));
                        }
                        ?></td>
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