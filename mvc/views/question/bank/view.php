<div class="well">
    <div class="row">
        <div class="col-sm-6">
            <button class="btn-cs btn-sm-cs" onclick="javascript:printDiv('printablediv')"><span class="fa fa-print"></span> <?=$this->lang->line('print')?> </button>
            <?php
           if(permissionChecker('question_bank_edit')) {
                echo btn_sm_edit('question_bank/edit/'.$question->questionBankID, $this->lang->line('edit'));
           }
            ?>
        </div>


        <div class="col-sm-6">
            <ol class="breadcrumb">
                <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
                <li><a href="<?=base_url("question_bank/index")?>"><?=$this->lang->line('panel_title')?></a></li>
                <li class="active"><?=$this->lang->line('menu_view')?></li>
            </ol>
        </div>

    </div>

</div>


<section class="panel">
    <div class="panel-body bio-graph-info">
        <div id="printablediv" class="box-body">
            <div class="row">
                <div class="col-sm-12">

                    <?php
                            $questionOptions = isset($options[$question->questionBankID]) ? $options[$question->questionBankID] : [];
                            $questionAnswers = isset($answers[$question->questionBankID]) ? $answers[$question->questionBankID] : [];
                            if($question->typeNumber == 1 || $question->typeNumber == 2) {
                                $questionAnswers = pluck($questionAnswers, 'optionID');
                            }

                            if($question != '') {
                                ?>
                                <div class="clearfix">
                                    <div class="question-body">
                                        <!--    <label class="lb-title">sbi clear : questin 1 of 10</label>-->
                                        <label class="lb-content question-color"><a href="<?=base_url('question_bank/edit/'.$question->questionBankID)?>" target="_blank"><?=$question->question?></a></label>
                                        <label class="lb-mark"> <?= $question->mark != "" ? $question->mark.' '.$this->lang->line('question_bank_mark') : ''?> </label>
                                    </div>

                                    <div class="question-answer">
                                        <table class="table">
                                            <tr>
                                                <?php
                                                $tdCount = 0;
                                                foreach ($questionOptions as $option) {
                                                    $checked = '';
                                                    if(in_array($option->optionID, $questionAnswers)) {
                                                        $checked = 'checked';
                                                    }
                                                    ?>
                                                    <td>
                                                        <input id="option<?=$option->optionID?>" value="1" name="option" type="<?=$question->typeNumber == 1 ? 'radio' : 'checkbox'?>" <?=$checked?> disabled>
                                                        <label for="option<?=$option->optionID?>">
                                                            <span class="fa-stack <?=$question->typeNumber == 1 ? 'radio-button' : 'checkbox-button'?>">
                                                                <i class="active fa fa-check">
                                                                </i>
                                                            </span>
                                                            <span ><?=$option->name?></span>
                                                            <?php
                                                                if(!is_null($option->img) && $option->img != "") {
                                                                    ?>
                                                                    <img src="<?=base_url('uploads/images/'.$option->img)?>" width="40%"/>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </label>
                                                    </td>
                                                    <?php
                                                        $tdCount++;
                                                        if($tdCount == 2) {
                                                            $tdCount = 0;
                                                            echo "</tr><tr>";
                                                        }
                                                    }

                                                    if($question->typeNumber == 3) {
                                                        foreach ($questionAnswers as $answerKey => $answer) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <input type="button" value="<?=$answerKey+1?>"> <input class="fillInTheBlank" id="answer<?=$answer->answerID?>" name="option" value="<?=$answer->text?>" type="text" disabled>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <br/>
                                <?php
                            }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

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
</script>

