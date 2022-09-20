<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-user-secret"></i> <?=$this->lang->line('panel_title')?></h3>


        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('panel_title')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div id="hide-table">
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                        <tr>
                            <th class="col-sm-1"><?=$this->lang->line('slno')?></th>
                            <th class="col-sm-6"><?=$this->lang->line('take_exam_name')?></th>
                            <th class="col-sm-2"><?=$this->lang->line('take_exam_duration')?></th>
                            <!--                                --><?php //if(permissionChecker('take_exam_edit') || permissionChecker('take_exam_delete') || permissionChecker('take_exam_view')) { ?>
                            <th class="col-sm-2"><?=$this->lang->line('action')?></th>
                            <!--                                --><?php //} ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(count($onlineExams)) {$i = 1; foreach($onlineExams as $onlineExam) { ?>
                            <tr>
                                <td data-title="<?=$this->lang->line('slno')?>">
                                    <?php echo $i; ?>
                                </td>
                                <td data-title="<?=$this->lang->line('take_exam_name')?>">
                                    <?php
                                    if(strlen($onlineExam->name) > 50)
                                        echo strip_tags(substr($onlineExam->name, 0, 50)."...");
                                    else
                                        echo strip_tags(substr($onlineExam->name, 0, 50));
                                    ?>
                                </td>
                                <td data-title="<?=$this->lang->line('take_exam_duration')?>">
                                    <?php echo $onlineExam->duration; ?>
                                </td>
                                <?php //if(permissionChecker('take_exam_edit') || permissionChecker('take_exam_delete') || permissionChecker('take_exam_view')) { ?>

                                <td data-title="<?=$this->lang->line('action')?>">
                                    <button class="btn btn-primary btn-sm" onclick="newPopup('<?=base_url('take_exam/instruction/'.$onlineExam->onlineExamID)?>')"><?=$this->lang->line('panel_title')?></button>
                                </td>
                                <?php //} ?>
                            </tr>
                            <?php $i++; }} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">

    function newPopup(url) {
        window.open(url,'_blank',"width=1000,height=650,toolbar=0,location=0,scrollbars=yes");
        runner();
    }

    function runner()
    {
        url = localStorage.getItem('redirect_url');
        if(url) {
            localStorage.clear();
            window.location = url;
        }
        setTimeout(function() {
            runner();
        }, 500);

    }
 </script>