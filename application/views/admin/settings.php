<div class="content-wrapper">

   <section class="content">
      
      <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/settings/update') ?>" role="form" class="form-horizontal">

        <div class="nav-tabs-custom">
            
            <ul class="nav nav-tabs admin">
              <li><a class="active" href="#content1" data-toggle="tab"><i class="fa fa-cog"></i> <span class="hidden-xs"><?php echo trans('general-settings') ?></span></a></li>
              <li><a href="#content2" data-toggle="tab"><i class="fa fa-envelope"></i> <span class="hidden-xs"><?php echo trans('email-settings') ?></span></a></li>
              <li><a href="#content3" data-toggle="tab"><i class="fa fa-refresh"></i> <span class="hidden-xs"><?php echo trans('recaptcha-settings') ?></span> v2</a></li>
              <li><a href="#content5" data-toggle="tab"><i class="fa fa-cog"></i> <span class="hidden-xs"><?php echo trans('social-settings') ?></span></a></li>
              <li><a href="#content6" data-toggle="tab"><i class="fa fa-file-text-o"></i> <span class="hidden-xs"><?php echo trans('terms-of-service') ?></span></a></li>
            </ul>

            <div class="row mt-20">
              <div class="col-md-8">
                <div class="tab-content box">

          
                    <div class="box-header">
                      <h3 class="box-title"><?php echo trans('update-settings') ?></h3>
                    </div>
             
                    <!-- tab 1 -->
                    <div class="active tab-pane" id="content1">
                
                        <div class="box-body">

                          <div class="row">

                            <div class="col-md-4">
                              <div class="form-group">
                                  <div class="col-sm-12">
                                      <img width="200px" src="<?php echo base_url($settings->hero_img); ?>">
                                      <div style="position:relative;" class="m-t-5">
                                          <a class='btn btn-default' href='javascript:;'>
                                              <i class="fa fa-cloud-upload"></i> <?php echo trans('update') ?>
                                              <input type="file" style='position:absolute;z-index:2;top:0;left:0;height:38px;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="photo3" size="200"  onchange='$("#upload-hero").html($(this).val());'>
                                          </a>
                                          &nbsp;
                                          <span class='label label-default' id="upload-hero"></span>
                                      </div>
                                  </div>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-group">
                                  <div class="col-sm-12 pt-50">
                                      <img width="100px" src="<?php echo base_url($settings->favicon); ?>">
                                      <div style="position:relative;" class="m-t-5">
                                          <a class='btn btn-default' href='javascript:;'>
                                              <i class="fa fa-cloud-upload"></i> <?php echo trans('upload-favicon') ?>
                                              <input type="file" style='position:absolute;z-index:2;top:0;left:0;height:38px;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="photo1" size="40"  onchange='$("#upload-favicon").html($(this).val());'>
                                          </a>
                                          &nbsp;
                                          <span class='label label-default' id="upload-favicon"></span>
                                      </div>
                                  </div>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-group">
                                  
                                  <div class="col-sm-12 pt-50">
                                      <img width="200px" src="<?php echo base_url($settings->logo); ?>">
                                      <div style="position:relative;" class="m-t-5">
                                          <a class='btn btn-default' href='javascript:;'>
                                              <i class="fa fa-cloud-upload"></i> <?php echo trans('upload-logo') ?>
                                              <input type="file" style='position:absolute;z-index:2;top:0;left:0;height:38px;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="photo2" size="40"  onchange='$("#upload-logo").html($(this).val());'>
                                          </a>
                                          &nbsp;
                                          <span class='label label-default' id="upload-logo"></span>
                                      </div>
                                  </div>
                              </div>
                            </div>
                          </div>


                          

                          <div class="form-group m-t-20">
                              <label class="col-sm-2 control-label" for="example-input-normal"><?php echo trans('application-name') ?></label>
                              <div class="col-sm-12">
                                  <input type="text" name="site_name" value="<?php echo html_escape($settings->site_name); ?>" class="form-control" >
                              </div>
                          </div>

                          <div class="form-group m-t-20">
                              <label class="col-sm-2 control-label" for="example-input-normal"><?php echo trans('application-title') ?></label>
                              <div class="col-sm-12">
                                  <input type="text" name="site_title" value="<?php echo html_escape($settings->site_title); ?>" class="form-control" >
                              </div>
                          </div>

                          <div class="form-group">
                              <label class="col-sm-2 control-label" for="example-input-normal"><?php echo trans('keywords') ?></label>
                              <div class="col-sm-12">
                                  <input type="text" data-role="tagsinput" name="keywords" value="<?php echo html_escape($settings->keywords); ?>" class="form-control" >
                              </div>
                          </div>

                          <div class="form-group">
                              <label class="col-sm-2 control-label" for="example-input-normal"><?php echo trans('description') ?></label>
                              <div class="col-sm-12">
                                  <textarea class="form-control" name="description" rows="4"><?php echo html_escape($settings->description); ?></textarea>
                              </div>
                          </div>
                          

                          <div class="form-group">
                              <label class="col-sm-2 control-label" for="example-input-normal"><?php echo trans('footer-about') ?></label>
                              <div class="col-sm-12">
                                  <textarea class="form-control" name="footer_about"><?php echo html_escape($settings->footer_about); ?></textarea>
                              </div>
                          </div>
                          
                          <div class="form-group">
                              <label class="col-sm-2 control-label" for="example-input-normal"><?php echo trans('admin-email') ?></label>
                              <div class="col-sm-12">
                                  <input type="email" name="admin_email" class="form-control" value="<?php echo html_escape(user()->email); ?>">
                              </div>
                          </div>

                          <div class="form-group">
                              <label class="col-sm-2 control-label" for="example-input-normal"><?php echo trans('copyright') ?></label>
                              <div class="col-sm-12">
                                  <input type="text" name="copyright" class="form-control" value="<?php echo html_escape($settings->copyright); ?>">
                              </div>
                          </div>

                          <!-- <div class="form-group m-b-20">
                              <label class="col-sm-2 control-label" for="example-input-normal"> Pagination Limit</label>
                              <div class="col-sm-12">
                                <input type="number" name="pagination_limit" class="form-control" value="<?php //echo html_escape($settings->pagination_limit); ?>">
                                  
                              </div>
                          </div> -->
                        </div>
                  
                    </div>

                    <!-- tab 2 -->
                    <div class="tab-pane" id="content2" aria-hidden="false">
                      <div class="box-body">
                        <div class="callout callout-default">
                            <h4><i class="icon-info"></i> <?php echo trans('gmail-smtp') ?></h4>

                            <p><?php echo trans('gmail-host') ?>:&nbsp;&nbsp;smtp.gmail.com</br>
                            <?php echo trans('gmail-port') ?>:&nbsp;&nbsp;465</p>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('mail-protocol') ?></label>

                            <select name="mail_protocol" class="form-control custom-select">
                                <option value="smtp" <?php echo ($settings->mail_protocol == "smtp") ? "selected" : ""; ?>>smtp</option>
                                <option value="mail" <?php echo ($settings->mail_protocol == "mail") ? "selected" : ""; ?>>mail</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('mail-title') ?></label>
                            <input type="text" class="form-control" name="mail_title"
                                   value="<?php echo html_escape($settings->mail_title); ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('mail-host') ?></label>
                            <input type="text" class="form-control" name="mail_host"
                                   value="<?php echo html_escape($settings->mail_host); ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('mail-port') ?></label>
                            <input type="text" class="form-control" name="mail_port"
                                    value="<?php echo html_escape($settings->mail_port); ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('mail-username') ?></label>
                            <input type="text" class="form-control" name="mail_username"
                                    value="<?php echo html_escape($settings->mail_username); ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('mail-password') ?></label>
                            <input type="password" class="form-control" name="mail_password"
                                    value="<?php echo base64_decode($settings->mail_password); ?>">
                        </div>
                      </div>
                    </div>

                    <!-- tab 3 -->
                    <div class="tab-pane" id="content3" aria-hidden="false">
                      <div class="box-body">
                        <div class="form-group m-t-20">
                            <label class="col-sm-2 control-label" for="example-input-normal"><?php echo trans('captcha-site-key') ?></label>
                            <div class="col-sm-12">
                                <input type="text" name="captcha_site_key" value="<?php echo html_escape($settings->captcha_site_key); ?>" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group m-t-20">
                            <label class="col-sm-2 control-label" for="example-input-normal"><?php echo trans('captcha-secret-key') ?></label>
                            <div class="col-sm-12">
                                <input type="text" name="captcha_secret_key" value="<?php echo html_escape($settings->captcha_secret_key); ?>" class="form-control" >
                            </div>
                        </div>
                      </div>
                    </div>

                
                    <!-- tab 5 -->
                    <div class="tab-pane" id="content5" aria-hidden="false">
                      <div class="box-body">
                        <div class="form-group m-t-20">
                            <label class="col-sm-2 control-label" for="example-input-normal">Facebook</label>
                            <div class="col-sm-12">
                                <input type="text" name="facebook" value="<?php echo html_escape($settings->facebook); ?>" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group m-t-20">
                            <label class="col-sm-2 control-label" for="example-input-normal">Twitter</label>
                            <div class="col-sm-12">
                                <input type="text" name="twitter" value="<?php echo html_escape($settings->twitter); ?>" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group m-t-20">
                            <label class="col-sm-2 control-label" for="example-input-normal">Instagram</label>
                            <div class="col-sm-12">
                                <input type="text" name="instagram" value="<?php echo html_escape($settings->instagram); ?>" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group m-t-20">
                            <label class="col-sm-2 control-label" for="example-input-normal">Linkedin</label>
                            <div class="col-sm-12">
                                <input type="text" name="linkedin" value="<?php echo html_escape($settings->linkedin); ?>" class="form-control" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="example-input-normal">Google Analytics</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" name="google_analytics" rows="8"><?php echo base64_decode($settings->google_analytics) ?></textarea>
                            </div>
                        </div>
                      </div>
                    </div>

                    <!-- tab 6 -->
                    <div class="tab-pane" id="content6" aria-hidden="false">
                      <div class="box-body">
                        <div class="form-group m-t-20">
                            <label class="col-sm-2 control-label" for="example-input-normal">Terms of service</label>
                            <textarea id="ckEditor" class="form-control" name="terms_service"><?php echo $settings->terms_service; ?></textarea>
                        </div>
                      </div>
                    </div>
         

                </div>
              </div>

              <div class="col-md-4">

                <div class="box">
                  <div class="box-header">
                    <h3 class="box-title"><?php echo trans('preferences') ?></h3>
                  </div>

                  <div class="box-body">

                    <div class="form-group row mb-20">
                      <label class="mt-5 col-md-5"><strong><?php echo trans('enable-multilingual') ?></strong></label>
                      <div class="switch col-md-7">
                        <input type="checkbox" name="enable_multilingual" value="1" <?php if(settings()->enable_multilingual == 1){echo 'checked';} ?> data-toggle="toggle" data-onstyle="info" data-width="100">
                      </div>
                    </div>

                    <div class="form-group row mb-20">
                      <label class="mt-5 col-md-5"><strong>Google reCaptcha</strong></label>
                      <div class="switch col-md-7">
                        <input type="checkbox" name="enable_captcha" value="1" <?php if(settings()->enable_captcha == 1){echo 'checked';} ?> data-toggle="toggle" data-onstyle="info" data-width="100">
                      </div>
                    </div>

                    <div class="form-group row mb-20">
                      <label class="mt-5 col-md-5"><strong><?php echo trans('registration-system') ?></strong></label>
                      <div class="switch col-md-7">
                        <input type="checkbox" name="enable_registration" value="1" <?php if(settings()->enable_registration == 1){echo 'checked';} ?> data-toggle="toggle" data-onstyle="info" data-width="100">
                      </div>
                    </div>

                    <div class="form-group row mb-20">
                      <label class="mt-5 col-md-5"><strong><?php echo trans('email-verification') ?></strong></label>
                      <div class="switch col-md-7">
                        <input type="checkbox" name="enable_email_verify" value="1" <?php if(settings()->enable_email_verify == 1){echo 'checked';} ?> data-toggle="toggle" data-onstyle="info" data-width="100">
                      </div>
                    </div>

                    <div class="form-group row mb-20">
                      <label class="mt-5 col-md-5"><strong><?php echo trans('enable-payment') ?></strong></label>
                      <div class="switch col-md-7">
                        <input type="checkbox" name="enable_paypal" value="1" <?php if(settings()->enable_paypal == 1){echo 'checked';} ?> data-toggle="toggle" data-onstyle="info" data-width="100">
                      </div>
                    </div>

                    <div class="form-group row mb-20">
                      <label class="mt-5 col-md-5"><strong><?php echo trans('delete').' '.trans('invoice') ?></strong></label>
                      <div class="switch col-md-7">
                        <input type="checkbox" name="enable_delete_invoice" value="1" <?php if(settings()->enable_delete_invoice == 1){echo 'checked';} ?> data-toggle="toggle" data-onstyle="info" data-width="100">
                      </div>
                    </div>

                    <div class="form-group row mb-20">
                      <label class="mt-5 col-md-5"><strong><?php echo trans('discount') ?></strong></label>
                      <div class="switch col-md-7">
                        <input type="checkbox" name="enable_discount" value="1" <?php if(settings()->enable_discount == 1){echo 'checked';} ?> data-toggle="toggle" data-onstyle="info" data-width="100">
                      </div>
                    </div>

                    <div class="form-group row mb-20">
                      <label class="mt-5 col-md-5"><strong><?php echo trans('blogs') ?></strong></label>
                      <div class="switch col-md-7">
                        <input type="checkbox" name="enable_blog" value="1" <?php if(settings()->enable_blog == 1){echo 'checked';} ?> data-toggle="toggle" data-onstyle="info" data-width="100">
                      </div>
                    </div>

                    <div class="form-group row mb-20">
                      <label class="mt-5 col-md-5"><strong><?php echo trans('faqs') ?></strong></label>
                      <div class="switch col-md-7">
                        <input type="checkbox" name="enable_faq" value="1" <?php if(settings()->enable_faq == 1){echo 'checked';} ?> data-toggle="toggle" data-onstyle="info" data-width="100">
                      </div>
                    </div>

                  </div>
                </div>


                <div class="box">
                  <div class="box-header">
                    <h3 class="box-title"><?php echo trans('set-trial-days') ?></h3>
                  </div>

                  <div class="box-body">
                    <div class="form-group m-t-20">
                        <label class="col-sm-12 control-label" for="example-input-normal"><?php echo trans('free-trial-of') ?></label>
                        <div class="col-sm-12">
                            <select class="form-control" name="trial_days">
                              <?php for ($t=1; $t < 31; $t++) { ?>
                                <option <?php if($settings->trial_days == $t){echo "selected";} ?> value="<?php echo $t; ?>"><?php echo $t; ?> days</option>
                              <?php } ?>
                            </select>
                        </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <!-- csrf token -->
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

            <div class="text-left">
                <div class="pull-left mb-20">
                    <button type="submit" class="btn btn-info waves-effect w-md waves-light m-b-5"><i class="fa fa-check"></i> <?php echo trans('save-changes') ?></button>
                </div>
            </div>

        </div>

      </form>

    </section>

</div>



