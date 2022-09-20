<div class="col-sm-12 do-not-refresh">
    <div class="callout callout-danger">
        <h4><?=$this->lang->line('take_exam_warning')?></h4>
        <p><?=$this->lang->line('take_exam_page_refresh')?></p>
    </div>
</div>

<section class="panel">
    <div class="panel-body bio-graph-info">
        <div id="printablediv" class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <h3>Score : <?=$correctAnswer?>/<?=count($onlineExamQuestions)?></h3>
                    <h3>Mark : <?=$totalCorrectMark?>/<?=$totalQuestionMark?></h3>
                    <h3>Percentage : <?php echo round((($correctAnswer*100)/count($questionStatus)), 2)."%"; ?></h3>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript" >
    $('.sidebar-menu li a').css('pointer-events', 'none');
    function disableF5(e) {
        if ( ( (e.which || e.keyCode) == 116 ) || ( e.keyCode == 82 && e.ctrlKey ) ) {
            e.preventDefault();
        }
    }

    $(document).bind("keydown", disableF5);

    function Disable(event) {
        if (event.button == 2)
        {
            window.oncontextmenu = function () {
                return false;
            }
        }
    }
    document.onmousedown = Disable;
</script>