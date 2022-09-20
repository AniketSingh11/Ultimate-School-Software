
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-plug"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("asset_assignment/index")?>"><?=$this->lang->line('panel_title')?></a></li>
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
                            <td><?=$this->lang->line("asset_assignment_usertypeID")?></td>
                            <td>
                            <?php 
                                echo isset($usertype[$asset_assignment->usertypeID]) ? $usertype[$asset_assignment->usertypeID] : '';
                            ?></td>
                        </tr>
                        <tr>
                            <td><?=$this->lang->line("asset_assignment_check_out_to")?></td>
                            <td><?php unset($user[0]); echo isset($user[$asset_assignment->check_out_to])  ? $user[$asset_assignment->check_out_to] : ''; ?></td>
                        </tr>
                        <tr>
                            <td><?=$this->lang->line("asset_assignment_assetID")?></td>
                            <td><?php echo $asset_assignment->description; ?></td>
                        </tr>
                        <tr>
                            <td><?=$this->lang->line("assigned_quantity")?></td>
                            <td><?php echo $asset_assignment->assigned_quantity; ?></td>
                        </tr>
                        <tr>
                            <td><?=$this->lang->line("due_date")?></td>
                            <td><?php echo isset($asset_assignment->due_date) ?  date('d M Y', strtotime($asset_assignment->due_date)) : ''; ?></td>
                        </tr>
                        <tr>
                            <td><?=$this->lang->line("check_out_date")?></td>
                            <td><?php echo isset($asset_assignment->check_out_date) ? date('d M Y', strtotime($asset_assignment->check_out_date)) : ''; ?></td>
                        </tr>
                        <tr>
                            <td><?=$this->lang->line("check_in_date")?></td>
                            <td><?php echo isset($asset_assignment->check_in_date) ? date('d M Y', strtotime($asset_assignment->check_in_date)) : ''; ?></td>
                        </tr>
                        <tr>
                            <td><?=$this->lang->line("status")?></td>
                            <td>
                                <?php
                                    if($asset_assignment->status == 1) {
                                        echo $this->lang->line('asset_status_checked_out');
                                    } elseif($asset_assignment->status == 2) {
                                        echo $this->lang->line('asset_status_checked_in');
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?=$this->lang->line("asset_assignment_note")?></td>
                            <td><?php echo $asset_assignment->note; ?></td>
                        </tr>
                        <tr>
                            <td><?=$this->lang->line("asset_locationID")?></td>
                            <td><?php echo $asset_assignment->location; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

