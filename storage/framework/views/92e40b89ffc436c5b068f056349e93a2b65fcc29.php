<?php echo view_render_event('bagisto.shop.layout.header.account-item.before'); ?>


<div id="account">
    <div class="d-inline-block welcome-content dropdown-toggle">
        <?php if(auth()->guard('customer')->user() && auth()->guard('customer')->user()->image): ?>
            <i class="align-vertical-top"><img class= "profile-small-icon" src="<?php echo e(auth('customer')->user()->image_url); ?>" alt="<?php echo e(auth('customer')->user()->first_name); ?>"/></i>
        <?php else: ?>
            <i class="material-icons align-vertical-top">perm_identity</i>
        <?php endif; ?>

        <span class="text-center">
            <?php echo e(__('velocity::app.header.welcome-message', [
                    'customer_name' => auth()->guard('customer')->user()
                        ? auth()->guard('customer')->user()->first_name
                        : trans('velocity::app.header.guest')
                    ]
                )); ?>

        </span>

        <span class="rango-arrow-down"></span>
    </div>

    <?php if(auth()->guard('customer')->guest()): ?>
        <div class="dropdown-list" style="width: 290px">
            <div class="modal-content dropdown-container">
                <div class="modal-header no-border pb0">
                    <label class="fs18 grey"><?php echo e(__('shop::app.header.title')); ?></label>
                </div>

                <div class="fs14 content">
                    <p class="no-margin"><?php echo e(__('shop::app.header.dropdown-text')); ?></p>
                </div>

                <div class="modal-footer">
                    <a href="<?php echo e(route('customer.session.index')); ?>" class="theme-btn fs14 fw6">
                        <?php echo e(__('shop::app.header.sign-in')); ?>

                    </a>

                    <a href="<?php echo e(route('customer.register.index')); ?>" class="theme-btn fs14 fw6">
                        <?php echo e(__('shop::app.header.sign-up')); ?>

                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if(auth()->guard('customer')->check()): ?>
        <div class="dropdown-list">
            <div class="dropdown-label">
                <?php echo e(auth()->guard('customer')->user()->first_name); ?>

            </div>

            <div class="dropdown-container">
                <ul type="none">
                    <li>
                        <a href="<?php echo e(route('customer.profile.index')); ?>" class="unset"><?php echo e(__('shop::app.header.profile')); ?></a>
                    </li>

                    <li>
                        <a href="<?php echo e(route('customer.orders.index')); ?>" class="unset"><?php echo e(__('velocity::app.shop.general.orders')); ?></a>
                    </li>

                    <?php
                        $showCompare = core()->getConfigData('general.content.shop.compare_option') == "1" ? true : false;

                        $showWishlist = core()->getConfigData('general.content.shop.wishlist_option') == "1" ? true : false;
                    ?>

                    <?php if($showWishlist): ?>
                        <li>
                            <a href="<?php echo e(route('customer.wishlist.index')); ?>" class="unset"><?php echo e(__('shop::app.header.wishlist')); ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if($showCompare): ?>
                        <li>
                            <a href="<?php echo e(route('velocity.customer.product.compare')); ?>" class="unset"><?php echo e(__('velocity::app.customer.compare.text')); ?></a>
                        </li>
                    <?php endif; ?>

                    <li>
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
                    </li>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php echo view_render_event('bagisto.shop.layout.header.account-item.after'); ?>

<?php /**PATH C:\xampp\htdocs\eshoplaravel/resources/themes/velocity/views/layouts/top-nav/login-section.blade.php ENDPATH**/ ?>