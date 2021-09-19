<div class="content-wrapper">
  <!-- Main content -->
  <section class="content"> 
    <div class="row">
        <div class="col-md-4">
            <div class="box add_area">
              <div class="box-header">
                <h3 class="box-title"><?php echo trans('subscription') ?> </h3>
              </div>

              <div class="box-body">
                <p><?php echo trans('your-subscription') ?>: <strong><?php echo trans('free-trial-of') ?> <?php echo settings()->trial_days.' '. trans('days') ?></strong></p>
                <p><?php echo trans('billing-frequency') ?> : <strong><?php echo settings()->trial_days.' '. trans('days') ?></strong> </p>
                <p><?php echo trans('created') ?> : <strong><?php echo my_date_show(user()->created_at) ?></strong> 
                <strong class="text-danger">(<?php echo date_dif(date('Y-m-d'), user()->trial_expire) ?> <?php echo trans('days-left') ?>)</strong></strong></p>
              </div>
            </div>
        </div>

        <div class="col-md-8">
              <div class="box add_area">
                <div class="box-header">
                  <h3 class="box-title"><?php echo trans('upgrade-plan') ?> </h3>
                </div>

                <div class="box-body">
                 
                  <div class="col-md-12 col-sm-12 col-xs-12 scroll table-responsive mt-20 p-0">
                    <div class="col-md-12 col-sm-12 col-xs-12 scroll">

                      <div class="pricing-switcher mb-5 text-center">
                          <p class="fieldset">
                              <input type="radio" name="billing_type" value="monthly" class="switch_price" id="monthly-1" checked>
                              <label for="monthly-1"><?php echo trans('monthly') ?></label> &emsp;&emsp;
                              <input type="radio" name="billing_type" value="yearly" class="switch_price" id="yearly-1">
                              <label for="yearly-1"><?php echo trans('yearly') ?></label>
                              <span class="switch"></span>
                          </p>
                      </div>

                      <table class="table table-hover">
                          <tbody>
                              <tr>
                                  <td width="30%"><h2></h2></td>
                                  <?php $i=1; foreach ($packages as $package): ?>
                                    <td class="text-center">
                                      <h2 class="mt-10"><?php echo html_escape($package->name); ?></h2>
                                      <h4 class="mb-15">
                                      
                                      <span class="price_year"><?php echo currency_to_symbol(settings()->currency); ?><?php echo round($package->price); ?> <?php echo trans('per-year') ?></span>
                                      <span class="price_month"><?php echo currency_to_symbol(settings()->currency); ?><?php echo round($package->monthly_price); ?> <?php echo trans('per-month') ?></span>
                                      </h4>
                                    </td>
                                  <?php $i++; endforeach; ?>
                              </tr>
                              
                              <?php foreach ($features as $feature): ?>
                                <tr class="monthly_row" style="display: none;">
                                    <td width="30%"><?php echo html_escape($feature->name); ?></td>
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
                                </tr>

                                <tr class="yearly_row">
                                    <td width="30%"><?php echo html_escape($feature->name); ?></td>
                                    <td class="text-center">
                                      <?php if ($feature->year_basic == 0): ?>
                                        <p class="mb-0 feature-item"><i class="fa fa-times text-danger"></i></p>
                                      <?php elseif($feature->year_basic == 1): ?>
                                        <p class="mb-0 feature-item"><i class="fa fa-check text-success"></i></p>
                                      <?php elseif($feature->year_basic == 2): ?>
                                        <p class="mb-0 feature-item"><?php echo trans('unlimited') ?></p>
                                      <?php else: ?>
                                        <?php echo html_escape($feature->year_basic); ?>
                                      <?php endif ?>
                                    </td>
                                    <td class="text-center">
                                      <?php if ($feature->year_standared == 0): ?>
                                        <p class="mb-0 feature-item"><i class="fa fa-times text-danger"></i></p>
                                      <?php elseif($feature->year_standared == 1): ?>
                                        <p class="mb-0 feature-item"><i class="fa fa-check text-success"></i></p>
                                      <?php elseif($feature->year_standared == 2): ?>
                                        <p class="mb-0 feature-item"><?php echo trans('unlimited') ?></p>
                                      <?php else: ?>
                                        <?php echo html_escape($feature->year_standared); ?>
                                      <?php endif ?>
                                    </td>
                                    <td class="text-center">
                                      <?php if ($feature->year_premium == 0): ?>
                                        <p class="mb-0 feature-item"><i class="fa fa-times text-danger"></i></p>
                                      <?php elseif($feature->year_premium == 1): ?>
                                        <p class="mb-0 feature-item"><i class="fa fa-check text-success"></i></p>
                                      <?php elseif($feature->year_premium == 2): ?>
                                        <p class="mb-0 feature-item"><?php echo trans('unlimited') ?></p>
                                      <?php else: ?>
                                        <?php echo html_escape($feature->year_premium); ?>
                                      <?php endif ?>
                                    </td>
                                </tr>
                              <?php endforeach ?>


                              <tr>
                                  <td></td>
                                  <?php $b=1; foreach ($packages as $package): ?>
                                      <td class="<?php if($b==2){echo"active";} ?> text-center">
                                          <a href="<?php echo base_url('admin/subscription/upgrade/'.$package->slug) ?>" class="btn btn-<?php if($b==2){echo"info";}else{echo "default";} ?> package_btn"><?php if($b==1){echo"Upgrade";}else{echo "Upgrade";} ?></a>
                                      </td>
                                  <?php $b++; endforeach; ?>
                                  <input type="hidden" name="billing_type" class="billing_type" value="monthly">
                              </tr>
                          </tbody>
                      </table>
                    </div>
                  </div>

                </div>
              </div>
        </div>
    </div>
  </section>

</div>
