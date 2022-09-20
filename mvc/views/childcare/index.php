
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-wheelchair"></i> <?=$this->lang->line('panel_title')?></h3>


        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_childcare')?></a></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <?php if(permissionChecker('childcare_add')) { ?>
                <div class="col-sm-12">
                    <div class="col-sm-10">
                        <form  action="<?=base_url('childcare/index')?>" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">

                            <?php
                                if(form_error('classesID'))
                                    echo "<div class='form-group has-error' >";
                                else
                                    echo "<div class='form-group' >";
                            ?>
                                <label for="classesID" class="col-sm-2 control-label">
                                    <?=$this->lang->line("classesID")?> <span class="text-red">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <?php
                                        $array = array(0 => $this->lang->line("select_class"));
                                        foreach ($classes as $classa) {
                                            $array[$classa->classesID] = $classa->classes;
                                        }
                                        echo form_dropdown("classesID", $array, set_value("classesID"), "id='classesID' class='form-control select2'");
                                    ?>

                                </div>
                                <span class="col-sm-4 control-label">
                                    <?php echo form_error('classesID'); ?>
                                </span>
                            </div>

                            <?php
                                if(form_error('userID'))
                                    echo "<div class='form-group has-error' >";
                                else
                                    echo "<div class='form-group' >";
                            ?>
                                <label for="userID" class="col-sm-2 control-label">
                                    <?=$this->lang->line("userID")?> <span class="text-red">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <?php
                                        $studentArray = array(0 => $this->lang->line("select_student"));

                                        if(count($students)) {
                                                foreach ($students as $student) {
                                                    $studentArray[$student->studentID] = $student->name;
                                                }
                                            }

                                        echo form_dropdown("userID", $studentArray, set_value("userID"), "id='userID' class='form-control select2'");

                                        ?>

                                </div>
                                <span class="col-sm-4 control-label">
                                    <?php echo form_error('userID'); ?>
                                </span>
                            </div>

                            <?php
                                if(form_error('receiver_name'))
                                    echo "<div class='form-group has-error' >";
                                else
                                    echo "<div class='form-group' >";
                            ?>
                                <label for="receiver_name" class="col-sm-2 control-label">
                                    <?=$this->lang->line("receiver_name")?> <span class="text-red">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="receiver_name" name="receiver_name" value="<?=set_value('receiver_name')?>" >
                                </div>
                                <span class="col-sm-4 control-label">
                                    <?php echo form_error('receiver_name'); ?>
                                </span>
                            </div>

                            <?php
                                if(form_error('phone'))
                                    echo "<div class='form-group has-error' >";
                                else
                                    echo "<div class='form-group' >";
                            ?>
                                <label for="phone" class="col-sm-2 control-label">
                                    <?=$this->lang->line("phone")?> <span class="text-red">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?=set_value('phone')?>" >
                                </div>
                                <span class="col-sm-4 control-label">
                                    <?php echo form_error('phone'); ?>
                                </span>
                            </div>

                            <?php
                                if(form_error('drop_date') || form_error('drop_time'))
                                    echo "<div class='form-group has-error' >";
                                else
                                    echo "<div class='form-group' >";
                            ?>
                                <label for="add_drop_time" class="col-sm-2 control-label">
                                    <?=$this->lang->line("add_drop_time")?> <span class="text-red">*</span>
                                </label>

                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="drop_date" name="drop_date" value="<?=set_value('drop_date')?>" >
                                </div>

                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="drop_time" name="drop_time" value="<?=set_value('drop_time')?>" >
                                </div>

                                <span class="col-sm-4 control-label">
                                    <?php echo form_error('drop_date').'<br>'; ?>
                                    <?php echo form_error('drop_time'); ?>
                                </span>
                            </div>



                            <?php
                                if(form_error('receive_date') || form_error('receive_time'))
                                    echo "<div class='form-group has-error' >";
                                else
                                    echo "<div class='form-group' >";
                            ?>
                                <label for="add_receive_time" class="col-sm-2 control-label">
                                    <?=$this->lang->line("add_receive_time")?> <span class="text-red">*</span>
                                </label>

                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="receive_date" name="receive_date" value="<?=set_value('receive_date')?>" >
                                </div>

                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="receive_time" name="receive_time" value="<?=set_value('receive_time')?>" >
                                </div>

                                <span class="col-sm-4 control-label">
                                    <?php echo form_error('receive_date').'<br>'; ?>
                                    <?php echo form_error('receive_time'); ?>
                                </span>
                            </div>


                            <?php
                                if(form_error('comment'))
                                    echo "<div class='form-group has-error' >";
                                else
                                    echo "<div class='form-group' >";
                            ?>
                                <label for="comment" class="col-sm-2 control-label">
                                    <?=$this->lang->line("comment")?>
                                </label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" id="comment" name="comment"><?=set_value('comment')?></textarea>
                                </div>
                                <span class="col-sm-4 control-label">
                                    <?php echo form_error('comment'); ?>
                                </span>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-1">
                                    <input type="submit" class="btn btn-success" value="<?=$this->lang->line("add_title")?>" >
                                </div>

                                <div class="col-sm-offset-1 col-sm-4">
                                     <input class="btn btn-danger" type="button" value="<?=$this->lang->line("cancel")?>" >
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
            <?php } ?>
            <div class="col-sm-12">
                <div id="hide-table">
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th ><?=$this->lang->line('slno')?></th>
                                <th ><?=$this->lang->line('classesID')?></th>
                                <th ><?=$this->lang->line('userID')?></th>
                                <th><?=$this->lang->line('phone')?></th>
                                <th><?=$this->lang->line('drop_date')?></th>
                                <th><?=$this->lang->line('receive_date')?></th>
                                <th><?=$this->lang->line('comment')?></th>
                                <?php
                                    if(permissionChecker('childcare_delete')) {
                                        echo "<th>".$this->lang->line('action')."</th>";
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(count($drop_receive)) {$i = 1; foreach($drop_receive as $drop) { ?>
                            <tr>
                                <td data-title="<?=$this->lang->line('slno')?>">
                                    <?php echo $i; ?>
                                </td>
                                <td data-title="<?=$this->lang->line('classesID')?>">
                                    <?php echo $drop->classes; ?>
                                </td>
                                <td data-title="<?=$this->lang->line('userID')?>">
                                    <?php echo $drop->name; ?>
                                </td>
                                <td data-title="<?=$this->lang->line('phone')?>">
                                    <?php echo $drop->phone; ?>
                                </td>
                                <td data-title="<?=$this->lang->line('drop_date')?>">
                                    <?php echo $drop->dropped_at; ?>
                                </td>
                                <td data-title="<?=$this->lang->line('receive_date')?>">
                                    <?php echo $drop->received_at; ?>
                                </td>
                                <td data-title="<?=$this->lang->line('comment')?>">
                                    <?php echo $drop->comment; ?>
                                </td>
                                <?php if(permissionChecker('childcare_delete')) { ?>
                                <td data-title="<?=$this->lang->line('action')?>">
                                    <?php echo btn_delete('childcare/delete/'.$drop->childcareID, $this->lang->line('delete')); ?>
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

<script type="text/javascript">
    $( document ).ready(function() {
        $("#drop_date").datepicker();
        $("#receive_date").datepicker();
        $('#drop_time, #receive_time').timepicker({
            defaultTime: 'value',
            minuteStep: 1,
            disableFocus: true,
            template: 'dropdown',
            showMeridian:false
        });
        $('#classesID').change(function() {
            var classes = $(this).val();
            if(classes != 0) {
                $.ajax({
                    type: 'POST',
                    url: "<?=base_url('childcare/all_student')?>",
                    data: "&classes=" + classes,
                    dataType: "html",
                    success: function(data) {
                        $('#userID').html(data);
                    }
                });
            }
        });
    });
</script>