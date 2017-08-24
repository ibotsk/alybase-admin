<?php
new dBug($data);

$dtypes = array(
    1 => 'Journal',
    2 => 'Book',
    3 => 'Manuscript',
    4 => 'Chapter',
    5 => 'Report'
);
?>

<div id="literature-detail" class="container">

    <table class="table table-bordered table-condensed table-responsive">
        <tr>
            <td class="col-xs-4"><?php echo __('Type'); ?></td>
            <td><?php 
            $dt = $data['Literature']['display_type'];
            echo $this->Eip->input('Literature.display_type', $data, array('type' => 'select', 'source' => $dtypes, 'display' => $dtypes[$dt])); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Paper authors'); ?></td>
            <td><?php echo $this->Eip->input('Literature.paper_author', $data); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Paper title'); ?></td>
            <td><?php echo $this->Eip->input('Literature.paper_title', $data); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Series source'); ?></td>
            <td><?php echo $this->Eip->input('Literature.series_source', $data); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Volume'); ?></td>
            <td><?php echo $this->Eip->input('Literature.volume', $data); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Issue'); ?></td>
            <td><?php echo $this->Eip->input('Literature.issue', $data); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Publisher'); ?></td>
            <td><?php echo $this->Eip->input('Literature.publisher', $data); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Editors'); ?></td>
            <td><?php echo $this->Eip->input('Literature.editor', $data); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Year'); ?></td>
            <td><?php echo $this->Eip->input('Literature.year', $data); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Pages'); ?></td>
            <td><?php echo $this->Eip->input('Literature.pages', $data); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Journal'); ?></td>
            <td><?php echo $this->Eip->input('Literature.journal_name', $data); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Note'); ?></td>
            <td><?php echo $this->Eip->input('Literature.note', $data, array('type' => 'textarea')); ?> </td>
        </tr>
        <tr>
            <td class="col-xs-4"><?php echo __('Corrected in DB by'); ?></td>
            <td><?php echo $this->Eip->input('Literature.corrected_in_db_by', $data); ?> </td>
        </tr>
    </table>
    
    <div class="col-xs-6"><?php echo $this->Html->link(__('Back'), array('action' => 'index'), array('class' => 'btn btn-default')); ?></div>

</div>