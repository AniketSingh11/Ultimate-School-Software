

<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-asterisk"></i> <?=$this->lang->line('panel_title')?></h3>


        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_frontend_setting')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    <?php
                        if(form_error('facebook'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="facebook" class="col-sm-2 control-label ">
                            <?=$this->lang->line("frontend_setting_facebook")?>
                        </label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="facebook" name="facebook" value="<?=set_value('facebook', $frontend_setting->facebook)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('facebook'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('twitter'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="twitter" class="col-sm-2 control-label">
                            <?=$this->lang->line("frontend_setting_twitter")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="twitter" name="twitter" value="<?=set_value('twitter', $frontend_setting->twitter)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('twitter'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('linkedin'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="linkedin" class="col-sm-2 control-label">
                            <?=$this->lang->line("frontend_setting_linkedin")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="linkedin" name="linkedin" value="<?=set_value('linkedin', $frontend_setting->linkedin)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('linkedin'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('youtube'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="youtube" class="col-sm-2 control-label">
                            <?=$this->lang->line("frontend_setting_youtube")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="youtube" name="youtube" value="<?=set_value('youtube', $frontend_setting->youtube)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('youtube'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('google'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="google" class="col-sm-2 control-label">
                            <?=$this->lang->line("frontend_setting_google")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="google" name="google" value="<?=set_value('google', $frontend_setting->google)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('google'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("update_frontend_setting")?>" >
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>