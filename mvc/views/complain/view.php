
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-commenting"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("complain/index")?>"><?=$this->lang->line('menu_complain')?></a></li>
            <li class="active"><?=$this->lang->line('menu_view')?></li>
        </ol>

    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <table class="table table-responsive table-bordered">
                    <tbody>
                        <tr>
                            <th class="col-sm-5"><?=$this->lang->line("complain_usertypeID")?></th>
                            <td class="col-sm-7"><?php if(isset($usertype->usertype)) echo $usertype->usertype; else ''; ?></td>
                        </tr>
                        <tr>
                            <th class="col-sm-5"><?=$this->lang->line("complain_userID")?></th>
                            <td class="col-sm-7"><?php if(isset($user->name)) { echo $user->name;} else { echo ''; } ?></td>
                        </tr>
                        <tr>
                            <th class="col-sm-5"><?=$this->lang->line("complain_title")?></th>
                            <td class="col-sm-7"><?php echo $complain->title; ?></td>
                        </tr>
                        <tr>
                            <th class="col-sm-5"><?=$this->lang->line("complain_description")?></th>
                            <td class="col-sm-7"><?php echo $complain->description; ?></td>
                        </tr>

                        <tr>
                            <th class="col-sm-5"><?=$this->lang->line("complain_attachment")?></th>
                            <td class="col-sm-7">
                                <?php
                                    if($complain->attachment!=null) {
                                        echo btn_download_link('complain/download/'.$complain->complainID, $complain->originalfile);
                                    }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

