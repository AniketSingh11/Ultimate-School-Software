<div id="printablediv">
    <div class="box-header bg-gray">
        <h3 class="box-title text-navy"><i class="fa fa-clipboard"></i> <?=$this->lang->line('report_class')?> <?=$class?> ( <?=$section?> ) </h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <?php if(count($students)) { ?>
                <div id="hide-table">
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-sm-1">#</th>
                                <th class="col-sm-1"><?=$this->lang->line('report_photo')?></th>
                                <th class="col-sm-2"><?=$this->lang->line('report_name')?></th>
                                <th class="col-sm-2"><?=$this->lang->line('report_class')?></th>
                                <th class="col-sm-1"><?=$this->lang->line('report_section')?></th>
                                <th class="col-sm-1"><?=$this->lang->line('report_roll')?></th>
                                <th class="col-sm-1"><?=$this->lang->line('report_action')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    $i = 1;
                                    // $flag = 0;
                                    foreach($students as $student) {
                            ?>
                                <tr>
                                    <td data-title="#">
                                        <?php echo $i; ?>
                                    </td>

                                    <td data-title="<?=$this->lang->line('report_photo')?>">
                                        <?php $array = array(
                                                "src" => base_url('uploads/images/'.$student->photo),
                                                'width' => '35px',
                                                'height' => '35px',
                                                'class' => 'img-rounded'

                                            );
                                            echo img($array);
                                        ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('report_name')?>">
                                        <?php echo $student->srname; ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('report_class')?>"><?php echo $classes[$student->srclassesID]; ?></td>
                                    <td data-title="<?=$this->lang->line('report_section')?>"><?php echo $sections[$student->srsectionID]; ?></td>
                                   
                                    <td data-title="<?=$this->lang->line('report_roll')?>">
                                        <?php echo $student->srroll; ?>
                                    </td>

                                    <td data-title="<?=$this->lang->line('report_action')?>">
                                        <a class="btn btn-success" target="_blank" href="<?=base_url('report/generate_certificate/'.$student->studentID .'/'.$student->usertypeID.'/'.$templateID.'/'.$student->srschoolyearID.'/'.$student->srclassesID)?>"><?=$this->lang->line('report_generate_certificate')?></a>
                                    </td>
                               </tr>
                            <?php $i++; } } else { ?>
                                <div class="callout callout-danger">
                                    <p><b class="text-info"><?=$this->lang->line('report_student_not_found')?></b></p>
                                </div>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- row -->
    </div><!-- Body -->
</div>
