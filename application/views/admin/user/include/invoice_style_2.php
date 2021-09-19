<?php include'invoice_val.php'; ?>

<div class="card-body p-0">
    <div class="row p-35 invtem_top_2">
        <div class="col-6 text-left">
            <h3 class="mb-1"><?php echo html_escape($title) ?></h3>
            <p class="text-muted"><?php echo html_escape($summary) ?></p>
            <p class="mb-0"><strong><?php echo html_escape($business_name) ?></strong></p>
            <span class="mb-0 invbiz"><?php echo $business_address ?></span>
            
            <?php if (!empty($biz_number)): ?>
            <p class="mb-0"><?php echo trans('business').' '.trans('number') ?>: <?php echo html_escape($biz_number) ?></p>
            <?php endif ?>

            <?php if (!empty($biz_vat_code)): ?>
            <p class="mb-0"><?php echo trans('tax').'/vat '.trans('number') ?>: <?php echo html_escape($biz_vat_code) ?></p>
            <?php endif ?>

            <p class=""><?php echo html_escape($country) ?></p>
        </div>

        <div class="col-6 text-right">
            <img width="130px" src="<?php echo base_url($logo) ?>" alt="">
        </div>
    </div>

    <hr class="my-5">

    <div class="row bill_area">
        <div class="col-4">
            <h5 class="font-weight-bold"><?php echo trans('bill-to') ?></h5>
            <?php if (empty($customer_id)): ?>
                <p class="mb-1"><?php echo trans('empty-customer') ?></p>
            <?php else: ?>
                <p class="mb-1">
                    <?php if (!empty(helper_get_customer($customer_id))): ?>
                        <p class="mb-0"><strong><?php echo helper_get_customer($customer_id)->name ?></strong></p>
                        <p class="mt-0 mb-0"><?php echo helper_get_customer($customer_id)->address ?> <?php echo helper_get_customer($customer_id)->country ?></p>
                        <p class="mt-0 mb-0"><?php echo helper_get_customer($customer_id)->phone ?></p>
                        
                        <?php if (!empty($cus_number)): ?>
                        <p class="mt-0 mb-0"><?php echo trans('business').' '.trans('number') ?>: <?php echo html_escape($cus_number) ?></p>
                        <?php endif ?>

                        <?php if (!empty($cus_vat_code)): ?>
                        <p class="mt-0"><?php echo trans('tax').'/vat '.trans('number') ?>: <?php echo html_escape($cus_vat_code) ?></p>
                        <?php endif ?>

                    <?php endif ?>
                </p>
            <?php endif ?>
        </div>

        <div class="col-8 text-right">
            <table class="tables pull-right">
                <tr>
                    <td><b class="mr-10"><?php if(isset($page) && $page == 'Invoice'){echo trans('invoice-number');}else{echo trans('estimate-number');} ?>:</b></td>
                    <td class="text-left" colspan="1"><?php echo html_escape($number) ?></td>
                </tr>
                <tr>
                    <td><b class="mr-10"><?php if(isset($page) && $page == 'Invoice'){echo trans('invoice-date');}else{echo trans('estimate-date');} ?>:</b></td>
                    <td class="text-left" colspan="1"><?php echo my_date_show($date) ?></td>
                </tr>
                <?php if (!empty($poso_number)): ?>
                <tr>
                    <td><b class="mr-10"><?php echo trans('p.o.s.o.-number') ?>:</b></td>
                    <td class="text-left" colspan="1"><?php echo html_escape($poso_number) ?></td>
                </tr>
                <?php endif ?>
                <?php if(isset($page) && $page == 'Invoice'):?>
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
                <?php else: ?>
                    <tr>
                        <td><b class="mr-10"><?php echo trans('expires-on') ?>:</b></td>
                        <td class="text-left">
                        <?php echo my_date_show($invoice->expire_on) ?>
                    </td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <div class="row p-0 table_area">
        <div class="col-12 table-responsive">
            <table class="table">
                <thead class="pre_head2">
                    <tr class="pre_head_tr2">
                        <th class="border-0"><?php echo trans('items') ?></th>
                        <th class="border-0"><?php echo trans('price') ?></th>
                        <th class="border-0"><?php echo trans('quantity') ?></th>
                        <th class="border-0"><?php echo trans('amount') ?></th>
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

                    <?php if (!empty($taxes)): ?>
                        <?php foreach ($taxes as $tax): ?>
                            <?php if ($tax != 0): ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right"><strong><?php echo get_tax_id($tax)->type_name.' ('.get_tax_id($tax)->name.'-'.get_tax_id($tax)->number.') '.get_tax_id($tax)->rate.'%' ?></strong></td>
                                    <td><span><?php if(!empty($currency_symbol)){echo html_escape($currency_symbol);} ?><?php echo number_format($sub_total * (get_tax_id($tax)->rate / 100), 2) ?></span></td>
                                </tr>
                            <?php endif ?>
                        <?php endforeach ?>
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

    <div class="p-30 text-center">
        <p class="text-center"><?php echo $footer_note ?></p>
    </div>
</div>