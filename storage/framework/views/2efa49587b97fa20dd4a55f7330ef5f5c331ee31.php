<?php $__env->startSection('page_title'); ?>
    <?php echo e(__('velocity::app.admin.meta-data.title')); ?>

<?php $__env->stopSection(); ?>

<?php
    $locale = core()->checkRequestedLocaleCodeInRequestedChannel();

    $channel = core()->getRequestedChannelCode();

    $channelLocales = core()->getAllLocalesByRequestedChannel()['locales'];

    $metaRoute = $metaData
        ? route('velocity.admin.store.meta-data', ['id' => $metaData->id])
        : route('velocity.admin.store.meta-data', ['id' => 'new']);
?>

<?php $__env->startPush('css'); ?>
    <style>
        @media only screen and (max-width: 680px){
            .content-container .content .page-header .page-title {
                float: left;
                width: 100%;
                margin-bottom: 12px;
            }

            .content-container .content .page-header .page-action button {
                position: absolute;
                right: 2px;
                top: 10px !important;
            }

            .content-container .content .page-header .control-group {
                margin-top:16px !important;
                width: 100% !important;
                margin-left: 0px !important;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <form
            method="POST"
            enctype="multipart/form-data"
            action="<?php echo e($metaRoute); ?>"
            @submit.prevent="onSubmit"
            >
            <?php echo csrf_field(); ?>

            <div class="page-header">
                <div class="page-title">
                    <h1><?php echo e(__('velocity::app.admin.meta-data.title')); ?></h1>
                </div>

                <input type="hidden" name="locale" value="<?php echo e($locale); ?>" />

                <input type="hidden" name="channel" value="<?php echo e($channel); ?>" />

                <div class="control-group">
                    <select class="control" id="channel-switcher" name="channel">
                        <?php $__currentLoopData = core()->getAllChannels(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channelModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <option
                                value="<?php echo e($channelModel->code); ?>" <?php echo e(($channelModel->code) == $channel ? 'selected' : ''); ?>>
                                <?php echo e(core()->getChannelName($channelModel)); ?>

                            </option>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="control-group">
                    <select class="control" id="locale-switcher" name="locale">
                        <?php $__currentLoopData = $channelLocales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <option
                                value="<?php echo e($localeModel->code); ?>" <?php echo e(($localeModel->code) == $locale ? 'selected' : ''); ?>>
                                <?php echo e($localeModel->name); ?>

                            </option>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        <?php echo e(__('velocity::app.admin.meta-data.update-meta-data')); ?>

                    </button>
                </div>
            </div>

            <accordian :title="'<?php echo e(__('velocity::app.admin.meta-data.general')); ?>'" :active="true">
                <div slot="body">
                    <div class="control-group">
                        <label style="width:100%;">
                            <?php echo e(__('velocity::app.admin.meta-data.activate-slider')); ?>

                            <span class="locale">[<?php echo e($channel); ?> - <?php echo e($locale); ?>]</span>
                        </label>

                        <label class="switch">
                            <input
                                id="slides"
                                name="slides"
                                type="checkbox"
                                class="control"
                                data-vv-as="&quot;slides&quot;"
                                <?php echo e($metaData && $metaData->slider ? 'checked' : ''); ?> />

                            <span class="slider round"></span>
                        </label>
                    </div>

                    <div class="control-group">
                        <label style="width:100%;">
                            <?php echo e(__('velocity::app.admin.meta-data.sidebar-categories')); ?>

                            <span class="locale">[<?php echo e($channel); ?> - <?php echo e($locale); ?>]</span>
                        </label>

                        <input
                            type="number"
                            min="0"
                            class="control"
                            id="sidebar_category_count"
                            name="sidebar_category_count"
                            value="<?php echo e($metaData ? $metaData->sidebar_category_count : '10'); ?>" />
                    </div>

                    <div class="control-group">
                        <label style="width:100%;">
                            <?php echo e(__('velocity::app.admin.meta-data.header_content_count')); ?>

                            <span class="locale">[<?php echo e($channel); ?> - <?php echo e($locale); ?>]</span>
                        </label>

                        <input
                            type="number"
                            min="0"
                            class="control"
                            id="header_content_count"
                            name="header_content_count"
                            value="<?php echo e($metaData ? $metaData->header_content_count : '5'); ?>" />
                    </div>

                    <div class="control-group">
                        <label style="width:100%;">
                            <?php echo e(__('velocity::app.admin.meta-data.home-page-content')); ?>

                            <span class="locale">[<?php echo e($channel); ?> - <?php echo e($locale); ?>]</span>
                        </label>

                        <textarea
                            class="control"
                            id="home_page_content"
                            name="home_page_content">
                            <?php echo e($metaData ? $metaData->home_page_content : ''); ?>

                        </textarea>
                    </div>

                    <div class="control-group">
                        <label style="width:100%;">
                            <?php echo e(__('velocity::app.admin.meta-data.product-policy')); ?>

                            <span class="locale">[<?php echo e($channel); ?> - <?php echo e($locale); ?>]</span>
                        </label>

                        <textarea
                            class="control"
                            id="product-policy"
                            name="product_policy">
                            <?php echo e($metaData ? $metaData->product_policy : ''); ?>

                        </textarea>
                    </div>

                </div>
            </accordian>

            <accordian :title="'<?php echo e(__('velocity::app.admin.meta-data.images')); ?>'" :active="false">
                <div slot="body">
                    <div class="control-group">
                        <label><?php echo e(__('velocity::app.admin.meta-data.advertisement-four')); ?></label>

                        <?php
                            $images = [
                                4 => [],
                                3 => [],
                                2 => [],
                            ];

                            $index = 0;

                            foreach ($metaData->get('locale')->all() as $key => $value) {
                                if ($value->locale == $locale) {
                                    $index = $key;
                                }
                            }

                            $advertisement = json_decode($metaData->get('advertisement')->all()[$index]->advertisement, true);
                        ?>

                        <?php if(! isset($advertisement[4]) || ! count($advertisement[4])): ?>
                            <?php
                                $images[4][] = [
                                    'id' => 'image_1',
                                    'url' => asset('/themes/velocity/assets/images/big-sale-banner.webp'),
                                ];
                                $images[4][] = [
                                    'id' => 'image_2',
                                    'url' => asset('/themes/velocity/assets/images/seasons.webp'),
                                ];
                                $images[4][] = [
                                    'id' => 'image_3',
                                    'url' => asset('/themes/velocity/assets/images/deals.webp'),
                                ];
                                $images[4][] = [
                                    'id' => 'image_4',
                                    'url' => asset('/themes/velocity/assets/images/kids.webp'),
                                ];
                            ?>

                            <image-wrapper
                                :multiple="true"
                                input-name="images[4]"
                                :images='<?php echo json_encode($images[4], 15, 512) ?>'
                                :button-label="'<?php echo e(__('velocity::app.admin.meta-data.add-image-btn-title')); ?>'">
                            </image-wrapper>
                        <?php else: ?>
                            <?php $__currentLoopData = $advertisement[4]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $images[4][] = [
                                        'id' => 'image_' . $index,
                                        'url' => Storage::url($image),
                                    ];
                                ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <image-wrapper
                                :multiple="true"
                                input-name="images[4]"
                                :images='<?php echo json_encode($images[4], 15, 512) ?>'
                                :button-label="'<?php echo e(__('velocity::app.admin.meta-data.add-image-btn-title')); ?>'">
                            </image-wrapper>
                        <?php endif; ?>

                        <span class="control-info mt-10"><?php echo e(__('velocity::app.admin.meta-data.image-four-resolution')); ?></span>
                    </div>

                    <div class="control-group">
                        <label><?php echo e(__('velocity::app.admin.meta-data.advertisement-three')); ?></label>
                        <?php if(! isset($advertisement[3]) || ! count($advertisement[3])): ?>
                            <?php
                                $images[3][] = [
                                    'id' => 'image_1',
                                    'url' => asset('/themes/velocity/assets/images/headphones.webp'),
                                ];
                                $images[3][] = [
                                    'id' => 'image_2',
                                    'url' => asset('/themes/velocity/assets/images/watch.webp'),
                                ];
                                $images[3][] = [
                                    'id' => 'image_3',
                                    'url' => asset('/themes/velocity/assets/images/kids-2.webp'),
                                ];
                            ?>

                            <image-wrapper
                                input-name="images[3]"
                                :images='<?php echo json_encode($images[3], 15, 512) ?>'
                                :button-label="'<?php echo e(__('velocity::app.admin.meta-data.add-image-btn-title')); ?>'">
                            </image-wrapper>
                        <?php else: ?>
                            <?php $__currentLoopData = $advertisement[3]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $images[3][] = [
                                        'id' => 'image_' . $index,
                                        'url' => Storage::url($image),
                                    ];
                                ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <image-wrapper
                                input-name="images[3]"
                                :images='<?php echo json_encode($images[3], 15, 512) ?>'
                                :button-label="'<?php echo e(__('velocity::app.admin.meta-data.add-image-btn-title')); ?>'">
                            </image-wrapper>
                        <?php endif; ?>
                        <span class="control-info mt-10"><?php echo e(__('velocity::app.admin.meta-data.image-three-resolution')); ?></span>
                    </div>

                    <div class="control-group">
                        <label><?php echo e(__('velocity::app.admin.meta-data.advertisement-two')); ?></label>

                        <?php if(! isset($advertisement[2]) || ! count($advertisement[2])): ?>
                            <?php
                                $images[2][] = [
                                    'id' => 'image_1',
                                    'url' => asset('/themes/velocity/assets/images/toster.webp'),
                                ];
                                $images[2][] = [
                                    'id' => 'image_2',
                                    'url' => asset('/themes/velocity/assets/images/trimmer.webp'),
                                ];
                            ?>

                            <image-wrapper
                                input-name="images[2]"
                                :images='<?php echo json_encode($images[2], 15, 512) ?>'
                                :button-label="'<?php echo e(__('velocity::app.admin.meta-data.add-image-btn-title')); ?>'">
                            </image-wrapper>
                        <?php else: ?>
                            <?php $__currentLoopData = $advertisement[2]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $images[2][] = [
                                        'id' => 'image_' . $index,
                                        'url' => Storage::url($image),
                                    ];
                                ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <image-wrapper
                                input-name="images[2]"
                                :images='<?php echo json_encode($images[2], 15, 512) ?>'
                                :button-label="'<?php echo e(__('velocity::app.admin.meta-data.add-image-btn-title')); ?>'">
                            </image-wrapper>
                        <?php endif; ?>
                        <span class="control-info mt-10"><?php echo e(__('velocity::app.admin.meta-data.image-two-resolution')); ?></span>
                    </div>
                </div>
            </accordian>

            <accordian :title="'<?php echo e(__('velocity::app.admin.meta-data.footer')); ?>'" :active="false">
                <div slot="body">
                    <div class="control-group">
                        <label style="width:100%;">
                            <?php echo e(__('velocity::app.admin.meta-data.subscription-content')); ?>

                            <span class="locale">[<?php echo e($channel); ?> - <?php echo e($locale); ?>]</span>
                        </label>

                        <textarea
                            class="control"
                            id="subscription_bar_content"
                            name="subscription_bar_content">
                            <?php echo e($metaData ? $metaData->subscription_bar_content : ''); ?>

                        </textarea>
                    </div>

                    <div class="control-group">
                        <label style="width:100%;">
                            <?php echo e(__('velocity::app.admin.meta-data.footer-left-content')); ?>

                            <span class="locale">[<?php echo e($channel); ?> - <?php echo e($locale); ?>]</span>
                        </label>

                        <textarea
                            class="control"
                            id="footer_left_content"
                            name="footer_left_content">
                            <?php echo e($metaData ? $metaData->footer_left_content : ''); ?>

                        </textarea>
                    </div>

                    <div class="control-group">
                        <label style="width:100%;">
                            <?php echo e(__('velocity::app.admin.meta-data.footer-middle-content')); ?>

                            <span class="locale">[<?php echo e($channel); ?> - <?php echo e($locale); ?>]</span>
                        </label>

                        <textarea
                            class="control"
                            id="footer_middle_content"
                            name="footer_middle_content">
                            <?php echo e($metaData ? $metaData->footer_middle_content : ''); ?>

                        </textarea>
                    </div>
                </div>
            </accordian>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('vendor/webkul/admin/assets/js/tinyMCE/tinymce.min.js')); ?>"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            tinymce.init({
                height: 200,
                width: "100%",
                image_advtab: true,
                valid_elements : '*[*]',
                selector: 'textarea#home_page_content,textarea#footer_left_content,textarea#subscription_bar_content,textarea#footer_middle_content,textarea#product-policy',
                plugins: 'image imagetools media wordcount save fullscreen code',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | code',
            });

            $('#channel-switcher, #locale-switcher').on('change', function (e) {
                $('#channel-switcher').val()

                if (event.target.id == 'channel-switcher') {
                    let locale = "<?php echo e($channelLocales->first()->code); ?>";

                    $('#locale-switcher').val(locale);
                }

                var query = '?channel=' + $('#channel-switcher').val() + '&locale=' + $('#locale-switcher').val();

                window.location.href = "<?php echo e(route('velocity.admin.meta-data')); ?>" + query;
            })
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin::layouts.content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\eshoplaravel\packages\Webkul\Velocity\src/resources/views/admin/meta-info/meta-data.blade.php ENDPATH**/ ?>