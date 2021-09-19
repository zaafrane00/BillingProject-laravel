<a href="#" class="cancel-inv">&times;</a>
<?php foreach ($products as $product): ?>
    <div data-id="<?php echo html_escape($product->id) ?>" class="row inv-item" id="inv_item_<?php echo html_escape($product->id) ?>">
        <div class="col-6">
            <p class="mb-0"><?php echo html_escape($product->name) ?></p>
            <p class="mb-0 text-muted"><?php echo character_limiter($product->details, 50) ?></p>
        </div>
        <div class="col-6 text-right">
            <span class="currency_wrapper"></span><?php echo html_escape($product->price) ?>
        </div>
    </div>
<?php endforeach ?>