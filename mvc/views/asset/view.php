


<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-fax"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("asset/index")?>"><?=$this->lang->line('menu_asset')?></a></li>
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
                            <th class="col-sm-5"><?=$this->lang->line("asset_serial")?></th>
                            <td class="col-sm-7"><?php echo $asset->serial; ?></td>
                        </tr>
                        <tr>
                            <th class="col-sm-5"><?=$this->lang->line("asset_description")?></th>
                            <td class="col-sm-7"><?php echo $asset->adescription; ?></td>
                        </tr>
                        <tr>
                            <th class="col-sm-5"><?=$this->lang->line("asset_status")?></th>
                            <td class="col-sm-7">
                                <?php
                                    if($asset->status == 1) {
                                        echo $this->lang->line('asset_status_checked_out');
                                    } elseif($asset->status == 2) {
                                        echo $this->lang->line('asset_status_checked_in');
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="col-sm-5"><?=$this->lang->line("asset_categoryID")?></th>
                            <td class="col-sm-5"><?php echo $asset->category; ?></td>
                        </tr>
                        <tr>
                            <th class="col-sm-5"><?=$this->lang->line("asset_locationID")?></th>
                            <td class="col-sm-7"><?php echo $asset->location; ?></td>
                        </tr>
                        <tr>
                            <th class="col-sm-5"><?=$this->lang->line("asset_condition")?></th>
                            <td class="col-sm-7">
                                <?php 
                                    $arrayCondition = array(
                                        0 => $this->lang->line('asset_select_condition'), 
                                        1 => $this->lang->line('asset_condition_new'), 
                                        2 => $this->lang->line('asset_condition_used')
                                    );

                                    echo isset($arrayCondition[$asset->asset_condition]) ? $arrayCondition[$asset->asset_condition] : '';
                                ?>
                                </td>
                        </tr>
                        <tr>
                            <th class="col-sm-5"><?=$this->lang->line("asset_create_date")?></th>
                            <td class="col-sm-7"><?php echo date("d M Y", strtotime($asset->acreate_date)); ?></td>
                        </tr>

                        <tr>
                            <th class="col-sm-5"><?=$this->lang->line("asset_attachment")?></th>
                            <td class="col-sm-7">
                                <?php
                                    if($asset->attachment!=null) {
                                        echo btn_download_link('asset/download/'.$asset->assetID, $asset->originalfile);
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