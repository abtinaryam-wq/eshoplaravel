<header class="sticky-header">
    <div class="row remove-padding-margin velocity-divide-page">
        <a class="left navbar-brand" href="<?php echo e(route('shop.home.index')); ?>" aria-label="Logo">
            <img class="logo" src="<?php echo e(core()->getCurrentChannel()->logo_url ?? asset('themes/velocity/assets/images/logo-text.png')); ?>" alt="" />
        </a>

        <div class="right searchbar">
            <div class="row">
                <div class="col-lg-5 col-md-12">
                    <?php echo $__env->make('velocity::shop.layouts.particals.search-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <div class="col-lg-7 col-md-12 vc-full-screen">
                    <div class="left-wrapper">

                        <?php echo view_render_event('bagisto.shop.layout.header.wishlist.before'); ?>


                            <?php echo $__env->make('velocity::shop.layouts.particals.wishlist', ['isText' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php echo view_render_event('bagisto.shop.layout.header.wishlist.after'); ?>


                        <?php echo view_render_event('bagisto.shop.layout.header.compare.before'); ?>


                            <?php echo $__env->make('velocity::shop.layouts.particals.compare', ['isText' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php echo view_render_event('bagisto.shop.layout.header.compare.after'); ?>


                        <?php echo view_render_event('bagisto.shop.layout.header.cart-item.before'); ?>


                            <?php echo $__env->make('shop::checkout.cart.mini-cart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php echo view_render_event('bagisto.shop.layout.header.cart-item.after'); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript">
        (() => {
            document.addEventListener('scroll', e => {
                scrollPosition = Math.round(window.scrollY);

                if (scrollPosition > 50) {
                    document.querySelector('header').classList.add('header-shadow');
                } else {
                    document.querySelector('header').classList.remove('header-shadow');
                }
            });
        })();
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\eshoplaravel/resources/themes/velocity/views/layouts/header/index.blade.php ENDPATH**/ ?>