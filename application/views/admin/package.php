<div class="content-wrapper">

  <!-- Main content -->
  <section class="content">

    <?php if (isset($page_title) && $page_title != "Edit"): ?>
      <div class="list_area container">
   
          <?php if (isset($page_title) && $page_title == "Edit"): ?>
            <h3 class="box-title"><?php echo trans('edit-package') ?> <a href="<?php echo base_url('admin/package') ?>" class="pull-right btn btn-primary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a></h3>
          <?php else: ?>
          <?php endif; ?>

          <div class="col-md-12 col-sm-12 col-xs-12 scroll table-responsive mt-20 p-0">
            <div class="col-md-12 col-sm-12 col-xs-12 scroll">
                <table class="table table-bordered table-hover table-stripe">
                    <tbody>
                        <tr>
                            <td width="30%"><h2><?php echo trans('manage-packages') ?></h2></td>
                            <?php $i=1; foreach ($packages as $package): ?>
                              <td class="text-center">
                                <h2 class="mt-10"><?php echo html_escape($package->name); ?> </h2>
                                <h3 class="mb-15"><?php echo currency_to_symbol(settings()->currency); ?><?php echo round($package->price); ?>  <span class="fs-14">per year</span> | <?php echo currency_to_symbol(settings()->currency); ?><?php echo round($package->monthly_price); ?>  <span class="fs-14"> <?php echo trans('per-month') ?></h3>

                                <a href="#packageModal_<?php echo html_escape($package->id);?>" data-toggle="modal" class="btn btn-default" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> <?php echo trans('edit-package') ?></a>
                              </td>
                            <?php $i++; endforeach; ?>
                            <td></td>
                        </tr>
                        
                        <?php foreach ($features as $feature): ?>
                          <tr>
                              <td width="30%"><?php echo html_escape($feature->name); ?> <br><?php if(!empty($feature->text)){echo html_escape('('.$feature->text.')');} ?></td>
                              <td class="text-center">
                                <?php if ($feature->basic == 0): ?>
                                  <p class="mb-0 feature-item"><i class="fa fa-times text-danger"></i></p>
                                <?php elseif($feature->basic == 1): ?>
                                  <p class="mb-0 feature-item"><i class="fa fa-check text-success"></i></p>
                                <?php elseif($feature->basic == 2): ?>
                                  <p class="mb-0 feature-item"><?php echo trans('unlimited') ?></p>
                                <?php else: ?>
                                  <?php echo html_escape($feature->basic); ?>
                                <?php endif ?>
                              </td>
                              <td class="text-center">
                                <?php if ($feature->standared == 0): ?>
                                  <p class="mb-0 feature-item"><i class="fa fa-times text-danger"></i></p>
                                <?php elseif($feature->standared == 1): ?>
                                  <p class="mb-0 feature-item"><i class="fa fa-check text-success"></i></p>
                                <?php elseif($feature->standared == 2): ?>
                                  <p class="mb-0 feature-item"><?php echo trans('unlimited') ?></p>
                                <?php else: ?>
                                  <?php echo html_escape($feature->standared); ?>
                                <?php endif ?>
                              </td>
                              <td class="text-center">
                                <?php if ($feature->premium == 0): ?>
                                  <p class="mb-0 feature-item"><i class="fa fa-times text-danger"></i></p>
                                <?php elseif($feature->premium == 1): ?>
                                  <p class="mb-0 feature-item"><i class="fa fa-check text-success"></i></p>
                                <?php elseif($feature->premium == 2): ?>
                                  <p class="mb-0 feature-item"><?php echo trans('unlimited') ?></p>
                                <?php else: ?>
                                  <?php echo html_escape($feature->premium); ?>
                                <?php endif ?>
                              </td>
                              <td width="5%"><a href="#featureModal_<?php echo html_escape($feature->id);?>" data-toggle="modal" class="btn btn-default" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> <?php echo trans('edit-features') ?></a></td>
                          </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
          </div>

      </div>
    <?php endif; ?>
  </section>
</div>



<?php foreach ($features as $feature): ?>
<div id="featureModal_<?php echo html_escape($feature->id) ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-zoom modal-md">
        <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/package/update_features/'.$feature->id)?>" role="form" novalidate>
            <div class="modal-content modal-md">
                <div class="modal-header">
                    <h4 class="modal-title" id="vcenter"><?php echo trans('update-package-features-for') ?> - <?php echo html_escape($feature->name) ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">



                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs admin pkg">
                      <li><a class="active monthly_btn"><?php echo trans('monthly') ?></a></li>
                      <li><a class="yearly_btn"><?php echo trans('yearly') ?></a></li>
                    </ul>

                    <hr>

                    <div class="form-group row">
                        <label class="col-sm-4 text-right control-label col-form-label"><?php echo trans('name') ?></label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="name" value="<?php echo html_escape($feature->name) ?>">
                        </div>
                    </div>

                    <div class="mt-20"><hr>
                      <!-- mohthly -->
                      <div class="monthly_area">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 text-right control-label col-form-label"><?php echo trans('basic-limit') ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="basic">
                                    <option value="">----</option>
                                    <option <?php if($feature->basic == 0){echo "selected";} ?> value="0"><?php echo trans('no') ?></option>
                                    <option <?php if($feature->basic == 1){echo "selected";} ?> value="1"><?php echo trans('yes') ?></option>
                                    <option <?php if($feature->basic == 2){echo "selected";} ?> value="2"><?php echo trans('unlimited') ?></option>
                                    <option <?php if($feature->basic == 3){echo "selected";} ?> value="3">3</option>
                                    <option <?php if($feature->basic == 4){echo "selected";} ?> value="4">4</option>
                                    <?php for ($i=1; $i < 100; $i++) { ?>
                                      <option <?php if($feature->basic == $i*5){echo "selected";} ?> value="<?php echo $i*5; ?>"><?php echo $i*5; ?></option>
                                    <?php } ?>
                                </select>  
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 text-right control-label col-form-label"><?php echo trans('standared-limit') ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="standared">
                                    <option value="">----</option>
                                    <option <?php if($feature->standared == 0){echo "selected";} ?> value="0"><?php echo trans('no') ?></option>
                                    <option <?php if($feature->standared == 1){echo "selected";} ?> value="1"><?php echo trans('yes') ?></option>
                                    <option <?php if($feature->standared == 2){echo "selected";} ?> value="2"><?php echo trans('unlimited') ?></option>
                                    <option <?php if($feature->standared == 3){echo "selected";} ?> value="3">3</option>
                                    <option <?php if($feature->standared == 4){echo "selected";} ?> value="4">4</option>
                                    <?php for ($i=1; $i < 100; $i++) { ?>
                                      <option <?php if($feature->standared == $i*5){echo "selected";} ?> value="<?php echo $i*5; ?>"><?php echo $i*5; ?></option>
                                    <?php } ?>
                                </select>  
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 text-right control-label col-form-label"><?php echo trans('premium-limit') ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="premium">
                                    <option value="">----</option>
                                    <option <?php if($feature->premium == 0){echo "selected";} ?> value="0"><?php echo trans('no') ?></option>
                                    <option <?php if($feature->premium == 1){echo "selected";} ?> value="1"><?php echo trans('yes') ?></option>
                                    <option <?php if($feature->premium == 2){echo "selected";} ?> value="2"><?php echo trans('unlimited') ?></option>
                                    <option <?php if($feature->premium == 3){echo "selected";} ?> value="3">3</option>
                                    <option <?php if($feature->premium == 4){echo "selected";} ?> value="4">4</option>
                                    <?php for ($i=1; $i < 100; $i++) { ?>
                                      <option <?php if($feature->premium == $i*5){echo "selected";} ?> value="<?php echo $i*5; ?>"><?php echo $i*5; ?></option>
                                    <?php } ?>
                                </select>  
                            </div>
                        </div>
                      </div>

                      <!-- yearly -->
                      <div class="yearly_area" style="display: none;">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 text-right control-label col-form-label"><?php echo trans('basic-limit') ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="year_basic">
                                    <option value="">----</option>
                                    <option <?php if($feature->year_basic == 0){echo "selected";} ?> value="0"><?php echo trans('no') ?></option>
                                    <option <?php if($feature->year_basic == 1){echo "selected";} ?> value="1"><?php echo trans('yes') ?></option>
                                    <option <?php if($feature->year_basic == 2){echo "selected";} ?> value="2"><?php echo trans('unlimited') ?></option>
                                    <option <?php if($feature->year_basic == 3){echo "selected";} ?> value="3">3</option>
                                    <option <?php if($feature->year_basic == 4){echo "selected";} ?> value="4">4</option>
                                    <?php for ($i=1; $i < 100; $i++) { ?>
                                      <option <?php if($feature->year_basic == $i*5){echo "selected";} ?> value="<?php echo $i*5; ?>"><?php echo $i*5; ?></option>
                                    <?php } ?>
                                </select>  
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 text-right control-label col-form-label"><?php echo trans('standared-limit') ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="year_standared">
                                    <option value="">----</option>
                                    <option <?php if($feature->year_standared == 0){echo "selected";} ?> value="0"><?php echo trans('no') ?></option>
                                    <option <?php if($feature->year_standared == 1){echo "selected";} ?> value="1"><?php echo trans('yes') ?></option>
                                    <option <?php if($feature->year_standared == 2){echo "selected";} ?> value="2"><?php echo trans('unlimited') ?></option>
                                    <option <?php if($feature->year_standared == 3){echo "selected";} ?> value="3">3</option>
                                    <option <?php if($feature->year_standared == 4){echo "selected";} ?> value="4">4</option>
                                    <?php for ($i=1; $i < 100; $i++) { ?>
                                      <option <?php if($feature->year_standared == $i*5){echo "selected";} ?> value="<?php echo $i*5; ?>"><?php echo $i*5; ?></option>
                                    <?php } ?>
                                </select>  
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 text-right control-label col-form-label"><?php echo trans('premium-limit') ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="year_premium">
                                    <option value="">----</option>
                                     <option <?php if($feature->year_premium == 0){echo "selected";} ?> value="0"><?php echo trans('no') ?></option>
                                    <option <?php if($feature->year_premium == 1){echo "selected";} ?> value="1"><?php echo trans('yes') ?></option>
                                    <option <?php if($feature->year_premium == 2){echo "selected";} ?> value="2"><?php echo trans('unlimited') ?></option>
                                    <option <?php if($feature->year_premium == 3){echo "selected";} ?> value="3">3</option>
                                    <option <?php if($feature->year_premium == 4){echo "selected";} ?> value="4">4</option>
                                    <?php for ($i=1; $i < 100; $i++) { ?>
                                      <option <?php if($feature->year_premium == $i*5){echo "selected";} ?> value="<?php echo $i*5; ?>"><?php echo $i*5; ?></option>
                                    <?php } ?>
                                </select>  
                            </div>
                        </div>
                      </div>
                    </div>

                  </div>

                    

                    

                </div>

                <div class="modal-footer">
                    <!-- csrf token -->
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    <button type="submit" class="btn btn-info waves-effect pull-right"><?php echo trans('save-changes') ?></button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php endforeach; ?>


<?php foreach ($packages as $package): ?>
<div id="packageModal_<?php echo html_escape($package->id) ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-zoom modal-md">
        <form method="post" enctype="multipart/form-data" class="validate-form" action="<?php echo base_url('admin/package/update/'.$package->id)?>" role="form" novalidate>
            <div class="modal-content modal-md">
                <div class="modal-header">
                    <h4 class="modal-title" id="vcenter"><?php echo trans('update-package') ?> - <?php echo html_escape($package->name) ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-sm-4 text-right control-label col-form-label"><?php echo trans('name') ?></label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="name" value="<?php echo html_escape($package->name) ?>">
                        </div>
                    </div>
                   
                    <div class="form-group row">
                        <label class="col-sm-4 text-right control-label col-form-label"><?php echo trans('monthly-price') ?></label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="monthly_price" value="<?php echo html_escape($package->monthly_price) ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 text-right control-label col-form-label"><?php echo trans('yearly-price') ?></label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="price" value="<?php echo html_escape($package->price) ?>">
                        </div>
                    </div>

                    <div class="form-group row mt-20">
                        <label for="inputEmail3" class="col-sm-4 text-right control-label col-form-label"></label>
                        <div class="col-sm-8">
                          <input type="checkbox" name="is_special" value="1" id="md_checkbox_3" class="filled-in chk-col-blue" <?php if($package->is_special == 1){echo "checked";}?> />
                          <label for="md_checkbox_3"><?php echo trans('is-popular-packages') ?>?</label>
                        </div>
                    </div>


                </div>

                <div class="modal-footer">
                    <!-- csrf token -->
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    <button type="submit" class="btn btn-info waves-effect pull-right"><?php echo trans('save-changes') ?></button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php endforeach; ?>