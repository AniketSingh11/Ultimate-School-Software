<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-commenting"></i> <?=$this->lang->line('panel_title')?></h3>


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
                   if(permissionChecker('complain_add')) {
                ?>
                <h5 class="page-header">
                    <a href="<?php echo base_url('complain/add') ?>">
                        <i class="fa fa-plus"></i>
                        <?=$this->lang->line('add_title')?>
                    </a>
                </h5>
              <?php } ?>
                <div id="hide-table">
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class=""><?=$this->lang->line('slno')?></th>
                                <th class=""><?=$this->lang->line('complain_usertypeID')?></th>
                                <th class=""><?=$this->lang->line('complain_title')?></th>
                                <th class=""><?=$this->lang->line('complain_description')?></th>
                              <?php if(permissionChecker('complain_edit') || permissionChecker('complain_delete') || permissionChecker('complain_view')) { ?>
                                    <th class=""><?=$this->lang->line('action')?></th>
                              <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($complains)) {$i = 1; foreach($complains as $complain) { ?>
                                <tr>
                                    <td data-title="<?=$this->lang->line('slno')?>">
                                        <?php echo $i; ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('complain_usertypeID')?>">
                                        <?=$complain->usertype?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('complain_title')?>">
                                        <?php
                                            if(strlen($complain->title) > 25)
                                                echo strip_tags(substr($complain->title, 0, 25)."...");
                                            else
                                                echo strip_tags(substr($complain->title, 0, 25));
                                        ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('complain_description')?>">
                                        <?php
                                            if(strlen($complain->description) > 25)
                                                echo strip_tags(substr($complain->description, 0, 25)."...");
                                            else
                                                echo strip_tags(substr($complain->description, 0, 25));
                                        ?>
                                    </td>
                                  <?php if(permissionChecker('complain_edit') || permissionChecker('complain_delete') || permissionChecker('complain_view')) { ?>

                                        <td data-title="<?=$this->lang->line('action')?>">
                                            <?php echo btn_view('complain/view/'.$complain->complainID, $this->lang->line('view')) ?>
                                            <?php echo btn_edit('complain/edit/'.$complain->complainID, $this->lang->line('edit')) ?>
                                            <?php echo btn_delete('complain/delete/'.$complain->complainID, $this->lang->line('delete')) ?>
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