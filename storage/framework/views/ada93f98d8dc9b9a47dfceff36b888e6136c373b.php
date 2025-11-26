<?php $__env->startSection('page_title'); ?>
    <?php echo e(__('admin::app.configuration.title')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>

    <style>

        @media only screen and (max-width: 768px){
            .content-container .content .page-header .page-title .control-group .control{
                width: 100% !important;
                margin-top:-25px !important;
            }
        }

    </style>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <?php
            $locale = core()->checkRequestedLocaleCodeInRequestedChannel();
            $channel = core()->getRequestedChannelCode();
            $channelLocales = core()->getAllLocalesByRequestedChannel()['locales'];
        ?>

        <div class="configuration">
            <form method="POST" action="" @submit.prevent="onSubmit" enctype="multipart/form-data">

                <div class="page-header">

                    <div class="page-title">
                        <h1>
                            <?php echo e(__('admin::app.configuration.title')); ?>

                        </h1>

                        <div class="control-group">
                            <select class="control" id="channel-switcher" name="channel">
                                <?php $__currentLoopData = core()->getAllChannels(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channelModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <option value="<?php echo e($channelModel->code); ?>" <?php echo e(($channelModel->code) == $channel ? 'selected' : ''); ?>>
                                        <?php echo e(core()->getChannelName($channelModel)); ?>

                                    </option>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="control-group">
                            <select class="control" id="locale-switcher" name="locale">
                                <?php $__currentLoopData = $channelLocales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <option value="<?php echo e($localeModel->code); ?>" <?php echo e(($localeModel->code) == $locale ? 'selected' : ''); ?>>
                                        <?php echo e($localeModel->name); ?>

                                    </option>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="page-action">
                        <button type="submit" class="btn btn-lg btn-primary">
                            <?php echo e(__('admin::app.configuration.save-btn-title')); ?>

                        </button>
                    </div>
                </div>

                <div class="page-content">
                    <div class="form-container">
                        <?php echo csrf_field(); ?>

                        <?php if($groups = \Illuminate\Support\Arr::get($config->items, request()->route('slug') . '.children.' . request()->route('slug2') . '.children')): ?>

                            <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <accordian title="<?php echo e(__($item['name'])); ?>" :active="true">
                                    <div slot="body">

                                        <?php $__currentLoopData = $item['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <?php echo $__env->make('admin::configuration.field-type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                            <?php ($hint = $field['title'] . '-hint'); ?>
                                            <?php if($hint !== __($hint)): ?>
                                                <?php echo e(__($hint)); ?>

                                            <?php endif; ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </div>
                                </accordian>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php endif; ?>

                    </div>
                </div>

            </form>

        </div>   

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function () {
            $('#channel-switcher, #locale-switcher').on('change', function (e) {
                $('#channel-switcher').val()
                var query = '?channel=' + $('#channel-switcher').val() + '&locale=' + $('#locale-switcher').val();

                window.location.href = "<?php echo e(route('admin.configuration.index', [request()->route('slug'), request()->route('slug2')])); ?>" + query;
            })
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin::layouts.content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\eshoplaravel\packages\Webkul\Admin\src/resources/views/configuration/index.blade.php ENDPATH**/ ?>