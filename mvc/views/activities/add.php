<div class="row">
    <div class="col-lg-4">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><i class="fa icon-student"></i> <?=$this->lang->line('students')?></h3>


                <ol class="breadcrumb">
                    <a href="<?= base_url('student') ?>"><li class="active"><?=$this->lang->line('menu_student')?></li></a>
                </ol>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="users-list clearfix">
                            <?php foreach($students as $student) { ?>
                            <li class="act-image">
                                <img id="<?=$student->studentID?>" src="<?=base_url('uploads/images/'.$student->photo)?>" alt="User Image" class="tooltip-custom" >
                                <a class="users-list-name" href="#"><?=$student->name?></a>
                            </li>
                            <?php } ?>
                        </ul>
                        <div class="tooltip_content">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8" style="padding-left: 0;">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-fighter-jet"></i> <?=$this->lang->line('panel_title')?></h3>

                <ol class="breadcrumb">
                    <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
                    <li><a href="<?= base_url('activities') ?>"><?=$this->lang->line('menu_activities')?></a></li>
                    <li class="active"><?=$this->lang->line('add_activities')?></li>
                </ol>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">

                            <?php
                                if(form_error('description') || form_error('students'))
                                    echo "<div class='form-group has-error' >";
                                else
                                    echo "<div class='form-group' >";
                            ?>
                                <label for="description" class="col-sm-2 control-label">
                                    <?=$this->lang->line("activities_description")?>
                                    <span class="text-red">*</span>
                                </label>
                                <div class="col-sm-6">
                                    
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
                                </div>
                                <span class="col-sm-4 control-label">
                                    <?php echo form_error('description'); ?>
                                    <?php echo form_error('students[]'); ?>
                                </span>
                            </div>

                            <?php
                                if(form_error('time_from')||form_error('time_to'))
                                    echo "<div class='form-group has-error' >";
                                else
                                    echo "<div class='form-group' >";
                            ?>
                                <label for="time_from" class="col-sm-2 control-label">
                                    <?=$this->lang->line("activities_time_frame")?>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="time_from" name="time_from" value="<?=set_value('time_from')?>" >
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="time_to" name="time_to" value="<?=set_value('time_to')?>" >
                                </div>
                                <span class="col-sm-4 control-label">
                                    <?php echo form_error('time_from'); ?>
                                    <?php echo form_error('time_to'); ?>
                                </span>
                            </div>

                            <?php
                                if(form_error('time_at'))
                                    echo "<div class='form-group has-error' >";
                                else
                                    echo "<div class='form-group' >";
                            ?>
                                <label for="time_at" class="col-sm-2 control-label">
                                    <?=$this->lang->line("activities_time_at")?>
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="time_at" name="time_at" value="<?=set_value('time_at')?>" >
                                </div>
                                <span class="col-sm-4 control-label">
                                    <?php echo form_error('time_at'); ?>
                                </span>
                            </div>

                            <?php
                                if(form_error('attachment'))
                                    echo "<div class='form-group has-error' >";
                                else
                                    echo "<div class='form-group' >";
                            ?>
                                <label for="attachment" class="col-sm-2 control-label">
                                    <?=$this->lang->line("attachment")?>
                                </label>
                                <div class="col-sm-6">
                                    <input id="fileupload" multiple="multiple" type="file" name="attachment[]"/>

                                </div>

                                <span class="col-sm-4">
                                    <?php echo form_error('attachment'); ?>
                                </span>
                            </div>

                            <input name="students[]" id="students" value="" type="hidden" />

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-8">
                                    <input type="submit" class="btn btn-success" value="<?=$this->lang->line("add_activities")?>" >
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box-footer clearfix">
                <div id="dvPreview"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.tooltip-custom').tooltipster({
            content: $('#tooltip_content'),
            delay: 2000,
            contentAsHTML: true,
            contentCloning: true,
            // 'instance' is basically the tooltip. More details in the "Object-oriented Tooltipster" section.
            functionBefore: function(instance, helper) {

                var $origin = $(helper.origin);
                var id = $origin.attr("id");

                // we set a variable so the data is only loaded once via Ajax, not every time the tooltip opens
                if ($origin.data('loaded') !== true) {
                    $.post("<?=base_url("activities/single_student_info/")?>",
                    {
                        id: id
                    },
                    function(data){
                        instance.content(data);
                        // to remember that the data has been loaded
                        $origin.data('loaded', true);
                    });
                }
            }
        });
    });

    $(function () {
        $("#fileupload").change(function () {
            if (typeof (FileReader) != "undefined") {
                var dvPreview = $("#dvPreview");
                dvPreview.html("");
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
                $($(this)[0].files).each(function () {
                    var file = $(this);
                    if (regex.test(file[0].name.toLowerCase())) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var img = $("<img />");
                            var span = $("<span></span>");

                            img.attr("style", "");
                            img.attr("class", "act-attach");
                            img.attr("src", e.target.result);

                            span.attr("class", "thumbnail-attach");

                            span.append(img);
                            dvPreview.append(span);
                        }
                        reader.readAsDataURL(file[0]);
                    } else {
                        alert(file[0].name + " is not a valid image file.");
                        dvPreview.html("");
                        return false;
                    }
                });
            } else {
                alert("This browser does not support HTML5 FileReader.");
            }
        });
    });

    $('.act-image img').click(function(){
        var id = $(this).attr('id');
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            $('input[type=hidden]').each(function() {
                if ($(this).val() === id) {
                    $(this).remove();
                }
            });
        } else {
            $(this).addClass('selected'); // adds the class to the clicked image
            $("#students").after(
                "<input id='students' type='hidden' name='students[]' value="+id+" />"
            );
        }
    });
    $('#time_from, #time_to, #time_at').timepicker({
        defaultTime: 'value',
        minuteStep: 1,
        disableFocus: true,
        template: 'dropdown',
        showMeridian:false
    });
</script>