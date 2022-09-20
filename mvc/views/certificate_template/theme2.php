<div class="well">
    <div class="row">
        <div class="col-sm-6">
            <button class="btn-cs btn-sm-cs" onclick="javascript:printDiv('printablediv')"><span class="fa fa-print"></span> <?=$this->lang->line('print')?> </button>
            
            <?php if(permissionChecker('certificate_template_edit')) { echo btn_sm_edit('certificate_template/edit/'.$certificate_template->certificate_templateID, $this->lang->line('edit')); }
            ?>
        </div>


        <div class="col-sm-6">
            <ol class="breadcrumb">
                <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
                <li><a href="<?=base_url("certificate_template/index")?>"><?=$this->lang->line('panel_title')?></a></li>
                <li class="active"><?=$this->lang->line('menu_view')?></li>
            </ol>
        </div>

    </div>

</div>


<section class="panel">
    <div class="panel-body bio-graph-info">
        <div id="printablediv" class="box-body">


            <link href="https://fonts.googleapis.com/css?family=Great+Vibes" rel="stylesheet"> 
            <link href="https://fonts.googleapis.com/css?family=Allerta+Stencil" rel="stylesheet"> 
            <link href="https://fonts.googleapis.com/css?family=Fira+Sans+Extra+Condensed" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Limelight" rel="stylesheet">  
            <link href="https://fonts.googleapis.com/css?family=Michroma" rel="stylesheet"> 
            <link href="https://fonts.googleapis.com/css?family=Prosto+One" rel="stylesheet"> 

            <style type="text/css">

                .mainTestimonial {
                    position: relative;
                }

                .testimonialHead {
                    left: 50%;
                    position: absolute;
                    top: 50%;
                    transform: translate(-50%, 80%);
                    font-size: 18px;
                    padding: 3px 5px;
                }

                .topHeadingMiddleImg {
                    width: 50px;
                    height: 50px;
                }

                .topHeadingLeft {
                    font-family: 'Prosto One', cursive;
                    left: 11%;
                    position: absolute;
                    top: 50%;
                    transform: translate(-50%, 50%);
                    font-size: 14px;
                    padding: 3px 5px;
                }

                .topHeadingMiddle {
                    font-family: 'Prosto One', cursive;
                    left: 50%;
                    position: absolute;
                    top: 50%;
                    transform: translate(-50%, 50%);
                    font-size: 14px;
                    padding: 3px 5px;
                }

                .topHeadingRight {
                    font-family: 'Prosto One', cursive;
                    left: 84%;
                    position: absolute;
                    top: 50%;
                    transform: translate(-50%, 50%);
                    font-size: 14px;
                    padding: 3px 5px;
                }

                .mainMiddleTextCenter {
                    text-align: center;
                }

                .mainMiddleText {
                    font-family: 'Limelight', cursive;
                    font-size: 20px;
                    padding: 3px 5px;
                    width: 100%;
                    text-align: center;
                 }

                 .top_heading_title {
                    text-align: center;
                    font-family: 'Allerta Stencil', sans-serif;
                    text-transform: uppercase;
                 }

                .testimonial {
                    min-height: 550px;
                    margin-left: auto;
                    margin-right: auto;
                    padding: 100px;
                    background: url("<?=base_url('uploads/images/'.$certificate_template->background_image)?>") no-repeat ;
                    background-size: 100% 100%;
                }

                .slno span {
                    font-size: 16px;
                    font-weight: 600;
                }

                .testimonialInfo {
                    margin-top: 30px; 

                }

                .testimonialContent {
                    font-family: 'Great Vibes', cursive;
                    font-size: 24px;
                    letter-spacing: 1px;
                    line-height: 25px;
                    letter-spacing: 4px;
                }

               .testimonialContent .dots {
                    display: inline-block;
                    height: 20px;
                    line-height: 10px;
                    position: relative;
                    font-weight: 600;
                }

              .testimonialContent .dots::after {
                    border-bottom: 2px dotted #999;
                    bottom: 0;
                    content: "";
                    height: 0;
                    left: 0;
                    position: absolute;
                    width: 100%;
                }

                .testimonialContent .dots::before {
                    content: attr(data-hover);
                    font-style: italic;
                    height: 5px;
                    left: 0;
                    position: absolute;
                    text-align: center;
                    top: 10px;
                    width: 100%;
                }

                .testimonialContent .dots.widthcss{
                    width: 20%;
                }

                .headSection {
                    margin-top: 80px;
                }

                .footerSection {
                    margin-top: 30px;
                }

                .footer_left_text {
                    font-family: 'Prosto One', cursive;
                    font-size: 14px;

                }

                .footer_middle_text {
                    font-family: 'Prosto One', cursive;
                    font-size: 14px;
                    text-align: center;
                }

                .footer_right_text {
                    font-family: 'Prosto One', cursive;
                    font-size: 14px;
                    text-align: center;
                }
            </style>

            <div class="row">
                <div class="col-sm-12">

                    <div class="testimonial">
                        <div class="mainTestimonial">
                            <h2 class="top_heading_title"><?=$certificate_template->top_heading_title?></h2>

                           <div class="row">
                                <span class="topHeadingLeft"><?=$certificate_template->top_heading_left?></span> 

                                <span class="topHeadingMiddle"><img class="topHeadingMiddleImg" src="<?=base_url('uploads/images/'.$siteinfos->photo)?>"></span> 

                                <span class="topHeadingRight"><?=$certificate_template->top_heading_right?></span> 
                           </div>
                        </div>


                        <div class="headSection">
                            <div class="row" >
                                <div class="col-sm-12 mainMiddleTextCenter"><span class="mainMiddleText"><?=$certificate_template->main_middle_text?></span></div>
                            </div>
                        </div>

                        <div class="testimonialInfo">
                            <p class="testimonialContent">
                                <?=$template_convert?>
                            </p>
                        </div>

                        <div class="footerSection">
                            <div class="row" >
                                <div class="col-sm-4 footer_left_text"><?=$certificate_template->footer_left_text?></div>
                                <div class="col-sm-4 footer_middle_text"></div>
                                <div class="col-sm-4 footer_right_text"><?=$certificate_template->footer_right_text?></div>
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
</section>

<!-- email modal starts here -->
<form class="form-horizontal" role="form" action="<?=base_url('certificate_template/send_mail');?>" method="post">
    <div class="modal fade" id="mail">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><?=$this->lang->line('mail')?></h4>
            </div>
            <div class="modal-body">

                <?php
                    if(form_error('to'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                ?>
                    <label for="to" class="col-sm-2 control-label">
                        <?=$this->lang->line("to")?>
                    </label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" id="to" name="to" value="<?=set_value('to')?>" >
                    </div>
                    <span class="col-sm-4 control-label" id="to_error">
                    </span>
                </div>

                <?php
                    if(form_error('subject'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                ?>
                    <label for="subject" class="col-sm-2 control-label">
                        <?=$this->lang->line("subject")?>
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="subject" name="subject" value="<?=set_value('subject')?>" >
                    </div>
                    <span class="col-sm-4 control-label" id="subject_error">
                    </span>

                </div>

                <?php
                    if(form_error('message'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                ?>
                    <label for="message" class="col-sm-2 control-label">
                        <?=$this->lang->line("message")?>
                    </label>
                    <div class="col-sm-6">
                        <textarea class="form-control" id="message" style="resize: vertical;" name="message" value="<?=set_value('message')?>" ></textarea>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="margin-bottom:0px;" data-dismiss="modal"><?=$this->lang->line('close')?></button>
                <input type="button" id="send_pdf" class="btn btn-success" value="<?=$this->lang->line("send")?>" />
            </div>
        </div>
      </div>
    </div>
</form>
<!-- email end here -->
<script language="javascript" type="text/javascript">
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
    function closeWindow() {
        location.reload();
    }

    function check_email(email) {
        var status = false;
        var emailRegEx = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
        if (email.search(emailRegEx) == -1) {
            $("#to_error").html('');
            $("#to_error").html("<?=$this->lang->line('mail_valid')?>").css("text-align", "left").css("color", 'red');
        } else {
            status = true;
        }
        return status;
    }


    $("#send_pdf").click(function(){
        var to = $('#to').val();
        var subject = $('#subject').val();
        var message = $('#message').val();
        var id = "<?=$certificate_template->certificate_templateID;?>";
        var error = 0;

        if(to == "" || to == null) {
            error++;
            $("#to_error").html("");
            $("#to_error").html("<?=$this->lang->line('mail_to')?>").css("text-align", "left").css("color", 'red');
        } else {
            if(check_email(to) == false) {
                error++
            }
        }

        if(subject == "" || subject == null) {
            error++;
            $("#subject_error").html("");
            $("#subject_error").html("<?=$this->lang->line('mail_subject')?>").css("text-align", "left").css("color", 'red');
        } else {
            $("#subject_error").html("");
        }

        if(error == 0) {
            $.ajax({
                type: 'POST',
                url: "<?=base_url('certificate_template/send_mail')?>",
                data: 'to='+ to + '&subject=' + subject + "&id=" + id+ "&message=" + message,
                dataType: "html",
                success: function(data) {
                    location.reload();
                }
            });
        }
    });
</script>

