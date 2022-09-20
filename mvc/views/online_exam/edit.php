<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-slideshare "></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("online_exam/index")?>"><?=$this->lang->line('panel_title')?></a></li>
            <li class="active"><?=$this->lang->line('menu_edit')?> <?=$this->lang->line('panel_title')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <form class="form-horizontal" role="form" method="post">
                    <?php
                    if(form_error('name'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                        <label for="name" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_name")?>
                            <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="name" name="name" value="<?=set_value('name', $online_exam->name)?>" placeholder="<?=$this->lang->line("online_exam_name")?>">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('name'); ?>
                        </span>
                    </div>


                    <?php
                    if(form_error('description'))
                        echo "<div class='form-group has-error'>";
                    else
                        echo "<div class='form-group'>";
                    ?>
                        <label for="description" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_description")?>
                        </label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="description" name="description" ><?=set_value('description', $online_exam->description)?></textarea>
                        </div>
                        <span class="col-sm-3 control-label">
                            <?php echo form_error('description'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('usertype'))
                        echo "<div class='form-group has-error' style='display:none;'>";
                    else
                        echo "<div class='form-group' style='display:none;'>";
                    ?>
                        <label for="usertype" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_usertype")?>
                        </label>
                        <div class="col-sm-6">
                            <?php
                            $array = array(0 => $this->lang->line("online_exam_select"));
                            foreach ($usertypes as $usertype) {
                                $array[$usertype->usertypeID] = $usertype->usertype;
                            }
                            echo form_dropdown("usertype", $array, set_value("usertype", $userTypeID), "id='usertype' class='form-control select2'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('usertype'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('classes'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                        <label for="classes" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_class")?>
                        </label>
                        <div class="col-sm-6">
                            <?php
                            $array = array(0 => $this->lang->line("online_exam_select"));
                            foreach ($classes as $class) {
                                $array[$class->classesID] = $class->classes;
                            }
                            echo form_dropdown("classes", $array, set_value("classes", $online_exam->classID), "id='classes' class='form-control select2'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('classes'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('section'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                        <label for="section" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_section")?>
                        </label>
                        <div class="col-sm-6">
                            <?php
                            $array = array(0 => $this->lang->line("online_exam_select"));
                            foreach ($sections as $section) {
                                $array[$section->sectionID] = $section->section;
                            }
                            echo form_dropdown("section", $array, set_value("section", $online_exam->sectionID), "id='section' class='form-control select2'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('section'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('studentGroup'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                        <label for="studentGroup" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_studentGroup")?>
                        </label>
                        <div class="col-sm-6">
                            <?php
                            $array = array(0 => $this->lang->line("online_exam_select"));
                            foreach ($groups as $group) {
                                $array[$group->studentgroupID] = $group->group;
                            }
                            echo form_dropdown("studentGroup", $array, set_value("studentGroup", $online_exam->studentGroupID), "id='studentGroup' class='form-control select2'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('studentGroup'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('subject'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                        <label for="subject" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_subject")?>
                        </label>
                        <div class="col-sm-6">
                            <?php
                            $array = array(0 => $this->lang->line("online_exam_select"));
                            foreach ($subjects as $subject) {
                                $array[$subject->subjectID] = $subject->subject;
                            }
                            echo form_dropdown("subject", $array, set_value("subject", $online_exam->subjectID), "id='subject' class='form-control select2'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('subject'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('instruction'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                        <label for="instruction" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_instruction")?>
                        </label>
                        <div class="col-sm-6">
                            <?php
                            $array = array(0 => $this->lang->line("online_exam_select"));
                            foreach ($instructions as $instruction) {
                                $array[$instruction->instructionID] = $instruction->title;
                            }
                            echo form_dropdown("instruction", $array, set_value("instruction", $online_exam->instructionID), "id='instruction' class='form-control select2'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('instruction'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('type'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                        <label for="type" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_type")?>
                        </label>
                        <div class="col-sm-6">
                            <?php
                            $array = [];
                            //                            $array = array(0 => $this->lang->line("online_exam_select"));
                            foreach ($types as $type) {
                                $array[$type->examTypeNumber] = $type->title;
                            }
                            echo form_dropdown("type", $array, set_value("type", $online_exam->examTypeNumber), "id='type' class='form-control select2'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('type'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('duration'))
                        echo "<div class='form-group has-error' id='durationDiv'>";
                    else
                        echo "<div class='form-group' id='durationDiv'>";
                    ?>
                        <label for="duration" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_duration")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="duration" name="duration" value="<?=set_value('duration', $online_exam->duration)?>" placeholder="<?=$this->lang->line("online_exam_duration")?>">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('duration'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('startdate'))
                        echo "<div class='form-group has-error' id='startdateDiv'>";
                    else
                        echo "<div class='form-group' id='startdateDiv'>";
                    ?>
                        <label for="startdate" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_startdatetime")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="startdate" name="startdate" value="<?=set_value('startdate', !is_null($online_exam->startDateTime) ? date('d-m-Y', strtotime($online_exam->startDateTime) ) : '' )?>" placeholder="<?=$this->lang->line("online_exam_startdatetime")?>">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('startdate'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('enddate'))
                        echo "<div class='form-group has-error' id='enddateDiv'>";
                    else
                        echo "<div class='form-group' id='enddateDiv'>";
                    ?>
                        <label for="enddate" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_enddatetime")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="enddate" name="enddate" value="<?=set_value('enddate', !is_null($online_exam->endDateTime) ? date('d-m-Y', strtotime($online_exam->endDateTime) ) : '')?>" placeholder="<?=$this->lang->line("online_exam_enddatetime")?>">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('enddate'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('startdatetime'))
                        echo "<div class='form-group has-error' id='startdatetimeDiv'>";
                    else
                        echo "<div class='form-group' id='startdatetimeDiv'>";
                    ?>
                        <label for="startdatetime" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_startdatetime")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="startdatetime" name="startdatetime" value="<?=set_value('startdatetime', !is_null($online_exam->startDateTime) ? date('d-m-Y h:i a', strtotime($online_exam->startDateTime)) : '' )?>" placeholder="<?=$this->lang->line("online_exam_startdatetime")?>">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('startdatetime'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('enddatetime'))
                        echo "<div class='form-group has-error' id='enddatetimeDiv'>";
                    else
                        echo "<div class='form-group' id='enddatetimeDiv'>";
                    ?>
                        <label for="enddatetime" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_enddatetime")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="enddatetime" name="enddatetime" value="<?=set_value('enddatetime', !is_null($online_exam->endDateTime) ? date('d-m-Y h:i a', strtotime($online_exam->endDateTime)) : '' )?>" placeholder="<?=$this->lang->line("online_exam_enddatetime")?>">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('enddatetime'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('negativeMark'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                        <label for="negativeMark" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_negativeMark")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="negativeMark" name="negativeMark" value="<?=set_value('negativeMark', $online_exam->negativeMark)?>" placeholder="<?=$this->lang->line("online_exam_negativeMark")?>">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('negativeMark'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('random'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                        <label for="random" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_random")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="random" name="random" value="<?=set_value('random', $online_exam->random)?>" placeholder="<?=$this->lang->line("online_exam_random_placeholder")?>">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('random'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('percentage'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                        <label for="percentage" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_percentage")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="percentage" name="percentage" value="<?=set_value('percentage', $online_exam->percentage)?>" placeholder="<?=$this->lang->line("online_exam_percentage")?>">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('percentage'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('ispaid'))
                        echo "<div class='form-group has-error' style='display: none;'>";
                    else
                        echo "<div class='form-group' style='display: none;'>";
                    ?>
                        <label for="ispaid" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_ispaid")?>
                        </label>
                        <div class="col-sm-6">
                            <?php
                            $array = [
                                0 => $this->lang->line("online_exam_free"),
                                1 => $this->lang->line("online_exam_paid")
                            ];
                            echo form_dropdown("ispaid", $array, set_value("ispaid", $online_exam->ispaid), "id='ispaid' class='form-control select2'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('ispaid'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('validDays'))
                        echo "<div class='form-group has-error' id='validDaysDiv'>";
                    else
                        echo "<div class='form-group' id='validDaysDiv'>";
                    ?>
                        <label for="validDays" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_validDays")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="validDays" name="validDays" value="<?=set_value('validDays', $online_exam->validDays)?>" placeholder="<?=$this->lang->line("online_exam_validDays")?>">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('validDays'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('cost'))
                        echo "<div class='form-group has-error' id='costDiv'>";
                    else
                        echo "<div class='form-group' id='costDiv'>";
                    ?>
                        <label for="cost" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_cost")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="cost" name="cost" value="<?=set_value('cost', $online_exam->cost)?>" placeholder="<?=$this->lang->line("online_exam_cost")?>">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('cost'); ?>
                        </span>
                    </div>

                    <?php
                    if(form_error('judge'))
                        echo "<div class='form-group has-error' style='display: none;'>";
                    else
                        echo "<div class='form-group' style='display: none;'>";
                    ?>
                        <label for="judge" class="col-sm-2 control-label">
                            <?=$this->lang->line("online_exam_judge")?>
                        </label>
                        <div class="col-sm-6">
                            <?php
                            $array = [
                                0 => $this->lang->line("online_exam_auto"),
                                1 => $this->lang->line("online_exam_manually")
                            ];
                            echo form_dropdown("judge", $array, set_value("judge", $online_exam->judge), "id='judge' class='form-control select2'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('judge'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("update_class")?>" >
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#description').jqte();
    $('#type').change(function() {
        var type = $(this).val();
//        alert(type);
//        $('#durationDiv').show();
//        $('#startdatetimeDiv').show();
//        $('#enddatetimeDiv').show();
        if(type == 2) {
            $('#startdateDiv').hide();
            $('#enddateDiv').hide();
            $('#startdatetimeDiv').hide();
            $('#enddatetimeDiv').hide();
        } else if(type == 4) {
            $('#startdateDiv').show();
            $('#enddateDiv').show();

            $('#startdatetimeDiv').hide();
            $('#enddatetimeDiv').hide();

            $('#startdate').datetimepicker({
                viewMode: 'years',
                format: 'DD-MM-YYYY'
            });
            $('#enddate').datetimepicker({
//                useCurrent: false,
                viewMode: 'years',
                format: 'DD-MM-YYYY'
            });
        } else if(type == 5) {
            $('#startdatetimeDiv').show();
            $('#enddatetimeDiv').show();

            $('#startdateDiv').hide();
            $('#enddateDiv').hide();

            $('#startdatetime').datetimepicker({
//                useCurrent: false,
                viewMode: 'years',
                format: 'DD-MM-YYYY hh:mm a'
            });
            $('#enddatetime').datetimepicker({
//                useCurrent: false,
                viewMode: 'years',
                format: 'DD-MM-YYYY hh:mm a'
            });
        }
    });
    $(function () {
        $('#startdatetimeDiv').hide();
        $('#startdatetimeDiv').show();
//        $('#durationDiv').hide();
        var type = '<?=$online_exam->examTypeNumber?>';
//        console.log(type);
        if(type == 2 ) {
            $('#startdateDiv').hide();
            $('#enddateDiv').hide();
            $('#startdatetimeDiv').hide();
            $('#enddatetimeDiv').hide();
        } else if (type == 4) {
            $('#startdatetimeDiv').hide();
            $('#enddatetimeDiv').hide();
            $('#startdate').datetimepicker({
                viewMode: 'years',
                format: 'DD-MM-YYYY'
            });
            $('#enddate').datetimepicker({
                viewMode: 'years',
                format: 'DD-MM-YYYY'
            });
        } else if (type == 5) {
            $('#startdatetime').datetimepicker({
                viewMode: 'years',
                format: 'DD-MM-YYYY hh:mm a'
            });
            $('#enddatetime').datetimepicker({
                viewMode: 'years',
                format: 'DD-MM-YYYY hh:mm a'
            });
        }

        $('#validDaysDiv').hide();
        $('#costDiv').hide();
    });

    $("#classes").change(function() {
        var id = $(this).val();
        if(parseInt(id)) {
            if(id === '0') {
                $('#sectionID').val(0);
            } else {
                $.ajax({
                    type: 'POST',
                    url: "<?=base_url('online_exam/getSection')?>",
                    data: {"id" : id},
                    dataType: "html",
                    success: function(data) {
                        $('#section').html(data);
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: "<?=base_url('online_exam/getSubject')?>",
                    data: {"classID" : id},
                    dataType: "html",
                    success: function(data) {
                        $('#subject').html(data);
                    }
                });
            }
        }
    });

</script>