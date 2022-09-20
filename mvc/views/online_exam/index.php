<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-slideshare"></i> <?=$this->lang->line('panel_title')?></h3>


        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('panel_title')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">

                <?php
                    if(permissionChecker('online_exam_add')) {
                ?>
                <h5 class="page-header">
                    <a href="<?php echo base_url('online_exam/add') ?>">
                        <i class="fa fa-plus"></i>
                        <?=$this->lang->line('add_title')?>
                    </a>
                </h5>
                <?php } ?>
                <div id="hide-table">
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-sm-2"><?=$this->lang->line('slno')?></th>
                                <th class="col-sm-2"><?=$this->lang->line('online_exam_name')?></th>
                                <?php if(permissionChecker('online_exam_edit') || permissionChecker('online_exam_delete') || permissionChecker('online_exam_view')) { ?>
                                    <th class="col-sm-2"><?=$this->lang->line('action')?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($online_exams)) {$i = 1; foreach($online_exams as $online_exam) { ?>
                                <tr>
                                    <td data-title="<?=$this->lang->line('slno')?>">
                                        <?php echo $i; ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('online_exam_name')?>">
                                        <?php
                                            if(strlen($online_exam->name) > 25)
                                                echo substr(strip_tags($online_exam->name), 0, 25)."...";
                                            else
                                                echo strip_tags($online_exam->name);
                                        ?>
                                    </td>
                                    <?php if(permissionChecker('online_exam_edit') || permissionChecker('online_exam_delete') || permissionChecker('online_exam_view')) { ?>

                                        <td data-title="<?=$this->lang->line('action')?>">
                                            <?php echo btn_extra('online_exam/addquestion/'.$online_exam->onlineExamID, $this->lang->line('addquestion'), 'online_exam_add') ?>
                                            <?php echo btn_edit('online_exam/edit/'.$online_exam->onlineExamID, $this->lang->line('edit')) ?>
                                            <?php echo btn_delete('online_exam/delete/'.$online_exam->onlineExamID, $this->lang->line('delete')) ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php $i++; }} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>