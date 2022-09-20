
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-diamond"></i> <?=$this->lang->line('report_certificate')?> <?=$this->lang->line('panel_title')?></h3>



        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_report')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">

            <div class="col-sm-12">

                <div class="form-group col-sm-4" id="schoolyearDiv">
                    <label><?=$this->lang->line("report_academic_year")?></label>
                    <?php
                        $schoolYearArray = array("0" => $this->lang->line("report_select_academic_year"));
                        if(count($schoolyears)) {
                            foreach ($schoolyears as $schoolyear) {
                                $schoolYearArray[$schoolyear->schoolyearID] = $schoolyear->schoolyear;
                            }
                        }

                        echo form_dropdown("schoolyearID", $schoolYearArray, set_value("schoolyearID"), "id='schoolyearID' class='form-control'");
                     ?>
                </div>

                <div class="form-group col-sm-4" id="classDiv">
                    <label><?=$this->lang->line("report_class")?></label>
                    <?php
                        $array = array("0" => $this->lang->line("report_select_class"));
                        if(count($classes)) {
                            foreach ($classes as $classa) {
                                 $array[$classa->classesID] = $classa->classes;
                            }
                        }
                        echo form_dropdown("classesID", $array, set_value("classesID"), "id='classesID' class='form-control'");
                     ?>
                </div>


                <div class="form-group col-sm-4" id="sectionDiv">
                    <label><?=$this->lang->line("report_section")?></label>
                    <select id="sectionID" name="sectionID" class="form-control">
                        <option value=""><?php echo $this->lang->line("report_select_section"); ?></option>
                    </select>
                </div>

                <div class="form-group col-sm-4" id="templateDiv">
                    <label><?=$this->lang->line("report_template")?></label>
                    <?php
                        $templateArray = array("0" => $this->lang->line("report_select_template"));
                        if(count($templates)) {
                            foreach ($templates as $template) {
                                 $templateArray[$template->certificate_templateID] = $template->name;
                            }
                        }
                        echo form_dropdown("templateID", $templateArray, set_value("templateID"), "id='templateID' class='form-control'");
                     ?>
                </div>


                <div class="col-sm-4">
                    <button id="get_student_list" class="btn btn-success" style="margin-top:23px;"> <?=$this->lang->line("report_submit")?></button>
                </div>

            </div>

        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->

<div class="box" id="load_certificatereport"></div>


<script type="text/javascript">
    function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML =
            "<html><head><title></title></head><body>" +
            divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;
    }

    $("#classesID").change(function() {
        var id = $(this).val();
        if(parseInt(id)) {
            if(id === '0') {
                $('#sectionID').val(0);
            } else {
                $.ajax({
                    type: 'POST',
                    url: "<?=base_url('report/getSection')?>",
                    data: {"id" : id},
                    dataType: "html",
                    success: function(data) {
                       $('#sectionID').html(data);
                    }
                });
            }
        }
    });

    $("#get_student_list").click(function() {
        var schoolyearID = $('#schoolyearID').val();
        var classID = $('#classesID').val();
        var sectionID = $('#sectionID').val();
        var templateID = $('#templateID').val();

        if(parseInt(schoolyearID) && parseInt(classID) && parseInt(templateID) && (parseInt(sectionID) || parseInt(sectionID) == 0)) {

            $('#schoolyearDiv').removeClass('has-error');
            $('#classDiv').removeClass('has-error');
            $('#templateDiv').removeClass('has-error');
            $.ajax({
                type: 'POST',
                url: "<?=base_url('report/getStudentList')?>",
                data: {"schoolyearID" : schoolyearID, "classID" : classID, "sectionID": sectionID, "templateID" : templateID},
                dataType: "html",
                success: function(data) {
                   $('#load_certificatereport').html(data).hide().fadeIn('slow');
                }
            });
        } else {
            if(parseInt(schoolyearID) == 0) {
                $('#schoolyearDiv').addClass('has-error');
            } else {
                 $('#schoolyearDiv').removeClass('has-error');
            }

            if(parseInt(classID) == 0) {
                $('#classDiv').addClass('has-error');
            } else {
                 $('#classDiv').removeClass('has-error');
            }

            if(parseInt(templateID) == 0) {
                $('#templateDiv').addClass('has-error');
            } else {
                $('#templateDiv').removeClass('has-error');
            }
        }
    });
</script>
