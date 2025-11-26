<?php
    $showCompare = core()->getConfigData('general.content.shop.compare_option') == "1" ? true : false;
?>

<?php if($showCompare): ?>

    <compare-component-with-badge
        is-customer="<?php echo e(auth()->guard('customer')->check() ? 'true' : 'false'); ?>"
        is-text="<?php echo e(isset($isText) && $isText ? 'true' : 'false'); ?>"
        src="<?php echo e(auth()->guard('customer')->check() ? route('velocity.customer.product.compare') : route('velocity.product.compare')); ?>">
    </compare-component-with-badge>

<?php endif; ?><?php /**PATH C:\xampp\htdocs\eshoplaravel\packages\Webkul\Velocity\src/resources/views/shop/layouts/particals/compare.blade.php ENDPATH**/ ?>