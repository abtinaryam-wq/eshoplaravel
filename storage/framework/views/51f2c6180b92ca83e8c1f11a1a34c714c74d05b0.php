<?php $__env->startSection('page_title'); ?>
    <?php echo e(__('admin::app.settings.sliders.title')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <?php
            $locale = core()->getRequestedLocaleCode('locale', false);

            $channel = core()->getRequestedChannelCode(false);
        ?>

        <div class="page-header">
            <div class="page-title">
                <h1><?php echo e(__('admin::app.settings.sliders.title')); ?></h1>
            </div>

            <div class="page-action">
                <?php if(bouncer()->hasPermission('settings.sliders.create')): ?>
                    <a href="<?php echo e(route('admin.sliders.store')); ?>" class="btn btn-lg btn-primary">
                        <?php echo e(__('admin::app.settings.sliders.add-title')); ?>

                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="page-content">
            <datagrid-plus src="<?php echo e(route('admin.sliders.index')); ?>"></datagrid-plus>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        function reloadPage(getVar, getVal) {
            let url = new URL(window.location.href);

            url.searchParams.set(getVar, getVal);

            window.location.href = url.href;
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin::layouts.content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\eshoplaravel\packages\Webkul\Admin\src/resources/views/settings/sliders/index.blade.php ENDPATH**/ ?>