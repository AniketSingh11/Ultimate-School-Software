
<div class="row">
    <?php if(permissionChecker('activities_add')) { ?>
        <div class="col-lg-4">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-fighter-jet"></i> <?=$this->lang->line('panel_title')?></h3>


                    <ol class="breadcrumb">
                        <a href="<?= base_url('activities_category') ?>"><li class="active"><?=$this->lang->line('menu_activities_category')?></li></a>
                    </ol>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php $colors = array("maroon", "green", "aqua", "blue", "olive", "navy", "purple", "black");?>
                            <?php foreach($activitiescategories as $category) { ?>
                                <?php $randIndex = array_rand($colors); ?>
                                <a href="<?=base_url('activities/add/'.$category->activitiescategoryID)?>" class="col-sm-1 btn btn-app bg-<?=$colors[$randIndex];?>">
                                    <i class="fa <?=$category->fa_icon?>"></i> <?=$category->title?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if(count($activities) > 0) { $i = 0; foreach ($activities as $activity) { ?>
    <div class="col-md-8 <?php if(permissionChecker('activities_add')) { echo ' activity-padd-left '; } ?> <?php if($i > 0) { if(permissionChecker('activities_add')) { echo " col-lg-offset-4"; }} ?>" >
        <!-- Box Comment -->
        <div class="box box-widget">
            <div class="box-header with-border social-media">
                <div class="user-block">
                    <img class="img-circle" src="<?=base_url("uploads/images/".$activity->user_image); ?>" alt="User Image">
                    <span class="username"><a href="#"><?=$activity->publisher?></a></span>
                    <span class="description"><?=$this->lang->line('activities_shared_publicly')?> - <?php echo date("l jS \of F Y h:i:s A", strtotime($activity->create_date));?></span>
                </div>
                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <?php if (permissionChecker('activities_delete') && ($usertypeID == 1 || ($usertypeID == $activity->usertypeID && $userID == $activity->userID))): ?>
                        <a onclick="return confirm('you are about to delete a record. This cannot be undone. are you sure?')" class="btn btn-box-tool" href="<?=base_url('activities/delete/'.$activity->activitiesID)?>"><i class="fa fa-times"></i></a>
                    <?php endif ?>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="container-fluid no-padding">
                    <div class="row">
                    <?php if(count($activity->attachments) > 0) { foreach ($activity->attachments as $attachment) { ?>
                        <?php if(count($activity->attachments) > 1) { ?>
                            <div class="col-md-4 no-padding">
                                <img style="width: 100%;" class="img-responsive pad" src="<?=base_url("uploads/activities/$attachment->attachment"); ?>" alt="Photo">
                            </div>
                        <?php } else { ?>
                            <div class="col-md-12 no-padding">
                                <img style="width: 100%; max-height: 400px;" class="img-responsive pad" src="<?=base_url("uploads/activities/$attachment->attachment"); ?>" alt="Photo">
                            </div>
                    <?php }}} ?>
                    </div>
                </div>
                <p><?=$activity->description?></p>
                <?php if($activity->time_from) { ?>
                    <button type="button" class="btn btn-info btn-xs"><i class="fa fa-clock-o"></i> <?php echo date("h:i:s A", strtotime($activity->time_from));?></button>
                <?php } ?>
                <?php if($activity->time_to) { ?>
                    <button type="button" class="btn btn-info btn-xs"><i class="fa fa-clock-o"></i> <?php echo date("h:i:s A", strtotime($activity->time_to));?></button>
                <?php } ?>
                <?php if($activity->time_at) { ?>
                    <button type="button" class="btn btn-info btn-xs"><i class="fa fa-clock-o"></i> <?php echo date("h:i:s A", strtotime($activity->time_at));?></button>
                <?php } ?>
                <span class="pull-right text-muted">
                    <?php if(count($activity->comments) > 0) { ?>
                        <?=count($activity->comments)?> comments
                    <?php } ?>
                </span>
            </div>
            <!-- /.box-body -->
            <?php if(count($activity->comments) > 0) { $i = 0; ?>
            <div class="box-footer box-comments">
                <?php foreach ($activity->comments as $comment) { ?>
                <div class="box-comment">
                    <!-- User image -->
                    <img class="img-circle img-sm" src="<?=base_url("uploads/images/".$comment->photo); ?>" alt="User Image">

                    <div class="comment-text">
                      <span class="username">
                          <?=$comment->sender?>
                          <?php if (permissionChecker('activities_delete') && ($usertypeID == 1 || ($usertypeID == $activity->usertypeID && $userID == $activity->userID))): ?>
                            <a href="<?=base_url('activities/delete_comment/'.$comment->activitiescommentID)?>" onclick="return confirm('you are about to delete a record. This cannot be undone. are you sure?')" style="margin-left: 5px; margin-top: -4px; font-size: 15px;" class="text-muted pull-right text-danger"><i class="fa fa-trash"></i></a> &nbsp;&nbsp;&nbsp;
                          <?php endif ?>
                          <span class="text-muted pull-right">
                              <?php echo date("l jS \of F Y h:i:s A", strtotime($comment->create_date));?>
                          </span> &nbsp;&nbsp;&nbsp;
                      </span><!-- /.username -->
                        <?=$comment->comment?>
                    </div>
                    <!-- /.comment-text -->
                </div>
                <!-- /.box-comment -->
                <?php } ?>
            </div>
            <?php } ?>
            <!-- /.box-footer -->
            <div class="box-footer">
                <form action="<?=base_url('activities/index/'.$activity->activitiesID)?>" method="post">
                    <img class="img-responsive img-circle img-sm" src="<?=base_url("uploads/images/".$this->session->userdata('photo')); ?>" alt="Alt Text">
                    <!-- .img-push is used to add margin to elements next to floating images -->
                    <div class="img-push">
                        <input type="text" name="comment" class="form-control input-sm" placeholder="Press enter to post comment">
                    </div>
                </form>
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
    <?php $i++; } } ?>
</div>

