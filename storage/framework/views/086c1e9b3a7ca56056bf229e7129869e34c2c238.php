<?php $__env->startSection('page_title'); ?>
    <?php echo e(__('admin::app.settings.sliders.edit-title')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <?php $locale = core()->getRequestedLocaleCode(); ?>

        <form method="POST" action="<?php echo e(route('admin.sliders.update', $slider->id)); ?>" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '<?php echo e(route('admin.sliders.index')); ?>'"></i>

                        <?php echo e(__('admin::app.settings.sliders.edit-title')); ?>


                        <?php if($slider->locale): ?>
                            <span class="locale">[<?php echo e($slider->locale); ?>]</span>
                        <?php endif; ?>

                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        <?php echo e(__('admin::app.settings.sliders.save-btn-title')); ?>

                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="form-container">

                    <?php echo csrf_field(); ?>

                    <?php echo view_render_event('bagisto.admin.settings.slider.edit.before'); ?>


                    <div class="control-group multi-select" :class="[errors.has('locale[]') ? 'has-error' : '']">
                        <label for="locale"><?php echo e(__('admin::app.datagrid.locale')); ?></label>

                        <select class="control" id="locale" name="locale[]" data-vv-as="&quot;<?php echo e(__('admin::app.datagrid.locale')); ?>&quot;" value="" v-validate="'required'" multiple>
                            <?php $__currentLoopData = core()->getAllLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option value="<?php echo e($localeModel->code); ?>" <?php echo e(in_array($localeModel->code, explode(',', $slider->locale)) ? 'selected' : ''); ?>>
                                    <?php echo e($localeModel->name); ?>

                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                        <span class="control-error" v-if="errors.has('locale[]')">{{ errors.first('locale[]') }}</span>
                    </div>

                    <div class="control-group" :class="[errors.has('title') ? 'has-error' : '']">
                        <label for="title" class="required"><?php echo e(__('admin::app.settings.sliders.name')); ?></label>
                        <input type="text" class="control" name="title" v-validate="'required'" data-vv-as="&quot;<?php echo e(__('admin::app.settings.sliders.name')); ?>&quot;" value="<?php echo e($slider->title ?: old('title')); ?>">
                        <span class="control-error" v-if="errors.has('title')">{{ errors.first('title') }}</span>
                    </div>

                    <?php $channels = core()->getAllChannels() ?>
                    <div class="control-group" :class="[errors.has('channel_id') ? 'has-error' : '']">
                        <label for="channel_id"><?php echo e(__('admin::app.settings.sliders.channels')); ?></label>
                        <select class="control" id="channel_id" name="channel_id" data-vv-as="&quot;<?php echo e(__('admin::app.settings.sliders.channels')); ?>&quot;" value="" v-validate="'required'">
                            <?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($channel->id); ?>" <?php if($channel->id == $slider->channel_id): ?> selected <?php endif; ?>>
                                    <?php echo e(__(core()->getChannelName($channel))); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <span class="control-error" v-if="errors.has('channel_id')">{{ errors.first('channel_id') }}</span>
                    </div>

                    <div class="control-group date">
                        <label for="expired_at"><?php echo e(__('admin::app.settings.sliders.expired-at')); ?></label>
                        <date>
                            <input type="text" name="expired_at" class="control" value="<?php echo e(old('expired_at') ?: $slider->expired_at); ?>"/>
                        </date>
                    </div>

                    <div class="control-group">
                        <label for="sort_order"><?php echo e(__('admin::app.settings.sliders.sort-order')); ?></label>
                        <input type="text" class="control" id="sort_order" name="sort_order" value="<?php echo e($slider->sort_order ?? old('sort_order')); ?>"/>
                    </div>

                    <div class="control-group <?php echo $errors->has('image.*') ? 'has-error' : ''; ?>">
                        <label class="required"><?php echo e(__('admin::app.catalog.categories.image')); ?></label>
                        <span class="control-info mt-10"><?php echo e(__('admin::app.settings.sliders.image-size')); ?></span>
                        
                        <image-wrapper button-label="<?php echo e(__('admin::app.settings.sliders.image')); ?>" input-name="image" :multiple="false" :images='"<?php echo e(Storage::url($slider->path)); ?>"'></image-wrapper>

                        <span class="control-error" v-if="<?php echo $errors->has('image.*'); ?>">
                            <?php $__currentLoopData = $errors->get('image.*'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo str_replace($key, 'Image', $message[0]); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </span>
                    </div>

                    <div class="control-group">
                        <label for="content"><?php echo e(__('admin::app.settings.sliders.content')); ?></label>

                        <div class="panel-body">
                            <textarea id="tiny" class="control" id="add_content" name="content" rows="5"><?php echo e($slider->content ? : old('content')); ?></textarea>
                        </div>

                        <span class="control-error" v-if="errors.has('content')">{{ errors.first('content') }}</span>
                    </div>

                    <?php echo view_render_event('bagisto.admin.settings.slider.edit.after', ['slider' => $slider]); ?>

                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('admin::layouts.tinymce', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        $(document).ready(function () {
            tinyMCEHelper.initTinyMCE({
                selector: 'textarea#tiny',
                height: 200,
                width: "100%",
                plugins: 'image imagetools media wordcount save fullscreen code table lists link hr',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor link hr | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | code | table',
                image_advtab: true,
                templates: [
                    { title: 'Test template 1', content: 'Test 1' },
                    { title: 'Test template 2', content: 'Test 2' }
                ],
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin::layouts.content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\eshoplaravel\packages\Webkul\Admin\src/resources/views/settings/sliders/edit.blade.php ENDPATH**/ ?>