<?php
    $cart = cart()->getCart();
    $cartItemsCount = $cart ? $cart->items->count() : trans('shop::app.minicart.zero');
?>

<mobile-header
    is-customer="<?php echo e(auth()->guard('customer')->check() ? 'true' : 'false'); ?>"
    heading= "<?php echo e(__('velocity::app.menu-navbar.text-category')); ?>"
    :header-content="<?php echo e(json_encode(app('Webkul\Velocity\Repositories\ContentRepository')->getAllContents())); ?>"
    category-count="<?php echo e($velocityMetaData ? $velocityMetaData->sidebar_category_count : 10); ?>"
    cart-items-count="<?php echo e($cartItemsCount); ?>"
    cart-route="<?php echo e(route('shop.checkout.cart.index')); ?>"
    :locale="<?php echo e(json_encode(core()->getCurrentLocale())); ?>"
    :all-locales="<?php echo e(json_encode(core()->getCurrentChannel()->locales()->orderBy('name')->get())); ?>"
    :currency="<?php echo e(json_encode(core()->getCurrentCurrency())); ?>"
    :all-currencies="<?php echo e(json_encode(core()->getCurrentChannel()->currencies)); ?>"
>

    
    <div class="row">
        <div class="col-6">
            <div class="hamburger-wrapper">
                <i class="rango-toggle hamburger"></i>
            </div>

            <a class="left" href="<?php echo e(route('shop.home.index')); ?>" aria-label="Logo">
                <img class="logo" src="<?php echo e(core()->getCurrentChannel()->logo_url ?? asset('themes/velocity/assets/images/logo-text.png')); ?>" alt="" />
            </a>
        </div>

        <div class="right-vc-header col-6">
            <a class="unset cursor-pointer">
                <i class="material-icons">search</i>
            </a>
            <a href="<?php echo e(route('shop.checkout.cart.index')); ?>" class="unset">
                <i class="material-icons text-down-3">shopping_cart</i>
                <div class="badge-wrapper">
                    <span class="badge"><?php echo e($cartItemsCount); ?></span>
                </div>
            </a>
        </div>
    </div>

    <template v-slot:greetings>
        <?php if(auth()->guard('customer')->guest()): ?>
            <a class="unset" href="<?php echo e(route('customer.session.index')); ?>">
                <?php echo e(__('velocity::app.responsive.header.greeting', ['customer' => 'Guest'])); ?>

            </a>
        <?php endif; ?>

        <?php if(auth()->guard('customer')->check()): ?>
            <a class="unset" href="<?php echo e(route('customer.profile.index')); ?>">
                <?php echo e(__('velocity::app.responsive.header.greeting', ['customer' => auth()->guard('customer')->user()->first_name])); ?>

            </a>
        <?php endif; ?>
    </template>

    <template v-slot:customer-navigation>
        <?php if(auth()->guard('customer')->check()): ?>
            <ul type="none" class="vc-customer-options">
                <li>
                    <a href="<?php echo e(route('customer.profile.index')); ?>" class="unset">
                        <i class="icon profile text-down-3"></i>
                        <span><?php echo e(__('shop::app.header.profile')); ?></span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo e(route('customer.address.index')); ?>" class="unset">
                        <i class="icon address text-down-3"></i>
                        <span><?php echo e(__('velocity::app.shop.general.addresses')); ?></span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo e(route('customer.reviews.index')); ?>" class="unset">
                        <i class="icon reviews text-down-3"></i>
                        <span><?php echo e(__('velocity::app.shop.general.reviews')); ?></span>
                    </a>
                </li>

                <?php if(core()->getConfigData('general.content.shop.wishlist_option')): ?>
                    <li>
                        <a href="<?php echo e(route('customer.wishlist.index')); ?>" class="unset">
                            <i class="icon wishlist text-down-3"></i>
                            <span><?php echo e(__('shop::app.header.wishlist')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if(core()->getConfigData('general.content.shop.compare_option')): ?>
                    <li>
                        <a href="<?php echo e(route('velocity.customer.product.compare')); ?>" class="unset">
                            <i class="icon compare text-down-3"></i>
                            <span><?php echo e(__('shop::app.customer.compare.text')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>

                <li>
                    <a href="<?php echo e(route('customer.orders.index')); ?>" class="unset">
                        <i class="icon orders text-down-3"></i>
                        <span><?php echo e(__('velocity::app.shop.general.orders')); ?></span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo e(route('customer.downloadable_products.index')); ?>" class="unset">
                        <i class="icon downloadables text-down-3"></i>
                        <span><?php echo e(__('velocity::app.shop.general.downloadables')); ?></span>
                    </a>
                </li>
            </ul>
        <?php endif; ?>
    </template>

    <template v-slot:extra-navigation>
        <li>
            <?php if(auth()->guard('customer')->check()): ?>
                <form id="customerLogout" action="<?php echo e(route('customer.session.destroy')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <?php echo method_field('DELETE'); ?>
                </form>

                <a
                    class="unset"
                    href="<?php echo e(route('customer.session.destroy')); ?>"
                    onclick="event.preventDefault(); document.getElementById('customerLogout').submit();">
                    <?php echo e(__('shop::app.header.logout')); ?>

                </a>
            <?php endif; ?>

            <?php if(auth()->guard('customer')->guest()): ?>
                <a
                    class="unset"
                    href="<?php echo e(route('customer.session.create')); ?>">
                    <span><?php echo e(__('shop::app.customer.login-form.title')); ?></span>
                </a>
            <?php endif; ?>
        </li>

        <li>
            <?php if(auth()->guard('customer')->guest()): ?>
                <a
                    class="unset"
                    href="<?php echo e(route('customer.register.index')); ?>">
                    <span><?php echo e(__('shop::app.header.sign-up')); ?></span>
                </a>
            <?php endif; ?>
        </li>
    </template>

    <template v-slot:logo>
        <a class="left" href="<?php echo e(route('shop.home.index')); ?>" aria-label="Logo">
            <img class="logo" src="<?php echo e(core()->getCurrentChannel()->logo_url ?? asset('themes/velocity/assets/images/logo-text.png')); ?>" alt="" />
        </a>
    </template>

    

    <template v-slot:search-bar>
        <div class="row">
            <div class="col-md-12">
                <?php echo $__env->make('velocity::shop.layouts.particals.search-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </template>

</mobile-header><?php /**PATH C:\xampp\htdocs\eshoplaravel/resources/themes/velocity/views/layouts/header/mobile.blade.php ENDPATH**/ ?>