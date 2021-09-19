<!DOCTYPE html>
<html lang="en">
<head>

<link rel="icon" href="<?php echo base_url($settings->favicon) ?>">
<title><?php echo html_escape($settings->site_name); ?> - <?php if(isset($page_title)){echo html_escape($page_title);}else{echo "Dashboard";} ?></title>
<!-- Bootstrap 4.0-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/bootstrap.min.css">
<!-- Bootstrap 4.0-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/bootstrap-extend.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/master_style.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/skins/_all-skins.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/font-awesome.min.css">
</head>

<body>


    <?php $currency_symbol = helper_get_customer($invoice->customer)->currency_symbol ?>
    <div class="content-wrappers">
        <section class="content p-0">
        	
        	<?php if (isset($mode) && $mode == 'preview'): ?>
	        	<div class="preview-mood-top p-20 text-center">
	        		<a href="#" class="btn btn-default btn-rounded mr-5 disabled"><i class="fa fa-eye"></i> <?php echo trans('preview-mode') ?> </a>

	        		<?php if (isset($link) && $link != ''): ?>
	            		<a href="<?php echo html_escape($link) ?>" class="btn btn-default btn-rounded mr-5"><i class="fa fa-long-arrow-left"></i> <?php echo trans('back') ?> </a>
	        		<?php endif ?>
	        		<p class="mt-10 c-1038"><i class="fa fa-info-circle"></i> <?php echo trans('preview-mode-msg') ?> <?php echo html_escape($page) ?></p>
	        	</div>
        	<?php endif ?>

            <div class="readonly-title">
                <h2><?php echo trans('invoice') ?> <?php echo html_escape($invoice->number) ?> <?php echo trans('from') ?> - <?php echo html_escape($invoice->business_name) ?></h2>
            </div>
            <div class="readonly-top-bar">
                <?php echo trans('invoice') ?> <?php echo html_escape($invoice->number) ?> <i class="fa fa-circle"></i>

                <?php if($invoice->status == 2): ?>
                    <?php echo trans('amount-due') ?>: <?php if(!empty($currency_symbol)){echo html_escape($currency_symbol);} ?>0.00
                <?php else: ?>
                    <?php echo trans('amount-due') ?>: <?php if(!empty($currency_symbol)){echo html_escape($currency_symbol);} ?><?php echo html_escape($invoice->grand_total) ?>
                <?php endif ?> <i class="fa fa-circle"></i>
                <?php echo trans('due-on') ?>: <?php echo my_date_show($invoice->created_at) ?>

                
            </div>
            <div class="container">
                <div class="col-md-10 m-auto">
                    
                    <div class="row mb-10">
                        <div class="col-md-6">
                            <a href="#" class="btn btn-default btn-rounded mr-5 print_invoice"><i class="fa fa-print"></i> <?php echo trans('print') ?> </a>

                            <a href="<?php echo base_url('readonly/export_pdf/'.md5($invoice->id)) ?>" class="btn btn-default btn-rounded mr-5"><i class="fa fa-download"></i> <?php echo trans('download-pdf') ?> </a>
                        </div>
                        <div class="col-md-6 text-right mt-15">
                        	<?php if ($invoice->status == 0): ?>
                                <span data-toggle="tooltip" data-placement="right" title="<?php echo trans('approve-info') ?>" class="custom-label-sm label-light-default pull-right"><?php echo trans('draft') ?></span>
                            <?php elseif($invoice->status == 2): ?>
                                <span data-toggle="tooltip" data-placement="right" title="<?php echo trans('paid-info') ?>" class="custom-label-sm label-light-success pull-right"><?php echo trans('paid') ?></span>
                            <?php elseif($invoice->status == 1): ?>
                                <span data-toggle="tooltip" data-placement="right" title="<?php echo trans('unpaid-info') ?>" class="custom-label-sm label-light-danger pull-right"><?php echo trans('unpaid') ?></span>
                            <?php endif ?>
                        </div>
                    </div>

                    <div id="invoice_save_area mt-0" class="card inv save_area print_area">

                        <?php include"include/invoice_style_".$invoice->template_style.".php"; ?>

                    </div>
                </div>
            </div>
        </section>
    </div>


    <footer></footer>
<!-- jQuery 3 -->
<script src="<?php echo base_url() ?>assets/admin/js/jquery3.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url() ?>assets/admin/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/printThis.js"></script>
<script>
    $('.print_invoice').on("click", function () {
      $('.print_area').printThis({
        base: "https://jasonday.github.io/printThis/"
      });
    });
</script>
</body>
</html>