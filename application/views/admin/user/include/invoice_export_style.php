<?php include'invoice_val.php'; ?>

<div class="card-body p-0">
    <div class="row p-35" style="padding-top: 40px">
        <div class="col-md-6 text-left" style="width: 50%; float: left;">
            <img width="130px" src="<?php echo base_url($logo) ?>" alt="" style="margin-top: -10px">
        </div>
        <div class="col-md-6 text-right" style="width: 50%; margin-top: -100px; float: right;">
            <p class="font-weight-bold mb-1"><?php echo html_escape($title) ?></p>
            <p class="text-muted"><?php echo html_escape($summary) ?></p>
            <p class="mb-0"><strong><?php echo html_escape($business_name) ?></strong></p>
            <p class="mb-0"><?php echo html_escape($business_address) ?></p>
            <p class=""><?php echo html_escape($country) ?></p>
        </div>
    </div>

    <hr class="my-5">

    <div class="row bill_area" style="margin-top:30px; margin-bottom: 30px">
        <div class="col-md-8" style="width: 70%; float: left;">
            <h5 class="font-weight-bold"><?php echo trans('bill-to') ?></h5>
            <?php if (empty($customer_id)): ?>
                <p class="mb-1"><?php echo trans('empty-customer') ?></p>
            <?php else: ?>
                <p class="mb-1">
                    <?php if (!empty(helper_get_customer($customer_id))): ?>
                        <p class="mb-0"><strong><?php echo helper_get_customer($customer_id)->name ?></strong></p>
                        <p class="mt-0 mb-0"><?php echo helper_get_customer($customer_id)->country ?></p>
                        <p class="mt-0 mb-0"><?php echo helper_get_customer($customer_id)->phone ?></p>
                        <p class="mt-0 mb-0"><?php echo helper_get_customer($customer_id)->address ?></p>
                    <?php endif ?>
                </p>
            <?php endif ?>
        </div>

        <div class="col-md-4 text-right" style="width: 30%; float: right;">
            <table class="tables pull-right" style="margin-top: -80px">
                <tr>
                    <td><b class="mr-10"><?php echo trans('invoice-number') ?>:</b></td>
                    <td class="text-left" colspan="1"><?php echo html_escape($number) ?></td>
                </tr>
                <tr>
                    <td><b class="mr-10"><?php echo trans('invoice-date') ?>:</b></td>
                    <td class="text-left" colspan="1"><?php echo my_date_show($date) ?></td>
                </tr>
                <tr>
                    <td><b class="mr-10"><?php echo trans('due-date') ?>:</b></td>
                    <td class="text-left">
                        <?php echo my_date_show($payment_due) ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-left">
                        <?php if ($due_limit == 1): ?>
                            <p><?php echo trans('on-receipt') ?></p>
                        <?php else: ?>
                            <p><?php echo trans('within') ?> <?php echo html_escape($due_limit) ?> <?php echo trans('days') ?></p>
                        <?php endif ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row p-0 table_area">
        <div class="col-md-12">
            <table class="table">
                <thead class="pre_head">
                    <tr class="pre_head_tr">
                        <th class="border-0" style="color: #000 !important; font-weight: bold;"><?php echo trans('items') ?></th>
                        <th class="border-0" style="color: #000 !important; font-weight: bold;"><?php echo trans('price') ?></th>
                        <th class="border-0" style="color: #000 !important; font-weight: bold;"><?php echo trans('quantity') ?></th>
                        <th class="border-0" style="color: #000 !important; font-weight: bold;"><?php echo trans('amount') ?></th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (isset($page_title) && $page_title == 'Invoice Preview'): ?>
                        <?php if (!empty($this->session->userdata('item'))): ?>
                            <?php $total_items = count($this->session->userdata('item')); ?>
                        <?php else: ?>
                            <?php $total_items = 0; ?>
                        <?php endif ?>
                        
                        <?php if (empty($total_items)): ?>
                            <tr>
                                <td colspan="4" class="text-center"><?php echo trans('empty-items') ?></td>
                            </tr>
                        <?php else: ?>
                            <?php for ($i=0; $i < $total_items; $i++) { ?>
                                <tr>
                                    <td width="50%">
                                    <?php $product_id = $this->session->userdata('item')[$i] ?>
                                    
                                    <?php if (is_numeric($product_id)) {
                                        echo helper_get_product($product_id)->name;
                                    } else {
                                        echo html_escape($product_id);
                                    } ?>
                                    </td>
                                    <td><?php if(!empty($currency_symbol)){echo html_escape($currency_symbol);} ?> <?php echo $this->session->userdata('price')[$i] ?></td>
                                    <td><?php echo $this->session->userdata('quantity')[$i] ?></td>
                                    <td><?php if(!empty($currency_symbol)){echo html_escape($currency_symbol);} ?> <?php echo number_format($this->session->userdata('quantity')[$i] * $this->session->userdata('total_price')[$i], 2) ?></td>
                                </tr>
                            <?php } ?>
                        <?php endif ?>
                    <?php else: ?>
                        <?php $items = helper_get_invoice_items($invoice->id) ?>
                        <?php if (empty($items)): ?>
                            <tr>
                                <td colspan="4" class="text-center"><?php echo trans('empty-items') ?></td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td width="50%"><?php echo html_escape($item->item_name) ?></td>
                                    <td><?php if(!empty($currency_symbol)){echo html_escape($currency_symbol);} ?> <?php echo html_escape($item->price) ?></td>
                                    <td><?php echo html_escape($item->qty) ?></td>
                                    <td><?php if(!empty($currency_symbol)){echo html_escape($currency_symbol);} ?> <?php echo number_format($item->qty*$item->total, 2) ?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    <?php endif ?>

                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-right"><strong><?php echo trans('sub-total') ?></strong></td>
                        <td><span><?php if(!empty($currency_symbol)){echo html_escape($currency_symbol);} ?> <?php echo html_escape($sub_total) ?></span></td>
                    </tr>
                    <?php if (!empty($tax)): ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-right"><strong><?php echo trans('tax') ?> <?php echo html_escape($tax) ?>%</strong></td>
                            <td><span><?php if(!empty($currency_symbol)){echo html_escape($currency_symbol);} ?><?php echo number_format($sub_total * ($tax / 100), 2) ?></span></td>
                        </tr>
                    <?php endif ?>
                    <?php if (!empty($discount)): ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-right"><strong><?php echo trans('discount') ?> <?php echo html_escape($discount) ?>%</strong></td>
                            <td><span><?php if(!empty($currency_symbol)){echo html_escape($currency_symbol);} ?><?php echo number_format($sub_total * ($discount / 100), 2) ?></span></td>
                        </tr>
                    <?php endif ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-right"><strong><?php echo trans('grand-total') ?></strong></td>
                        <td><span><?php if(!empty($currency_symbol)){echo html_escape($currency_symbol);} ?> <?php echo html_escape($grand_total) ?></span></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <div class="p-30">
        <p class="text-center"><?php echo html_escape($footer_note) ?></p>
    </div>
</div>