<?php $__env->startSection('page_title'); ?>
    <?php echo e(__('admin::app.settings.channels.edit-title')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <?php $locale = core()->getRequestedLocaleCode(); ?>

        <form method="POST" action="<?php echo e(route('admin.channels.update', ['id' => $channel->id, 'locale' => $locale])); ?>" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '<?php echo e(route('admin.channels.index')); ?>'"></i>

                        <?php echo e(__('admin::app.settings.channels.edit-title')); ?>

                    </h1>

                    <div class="control-group">
                        <select class="control" id="locale-switcher" onChange="window.location.href = this.value">
                            <?php $__currentLoopData = core()->getAllLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option value="<?php echo e(route('admin.channels.edit', $channel->id) . '?locale=' . $localeModel->code); ?>" <?php echo e(($localeModel->code) == $locale ? 'selected' : ''); ?>>
                                    <?php echo e($localeModel->name); ?>

                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        <?php echo e(__('admin::app.settings.channels.save-btn-title')); ?>

                    </button>
                </div>
            </div>

            <div class="page-content">

                <div class="form-container">
                    <?php echo csrf_field(); ?>
                    <input name="_method" type="hidden" value="PUT">

                    <?php echo view_render_event('bagisto.admin.settings.channel.edit.before'); ?>


                    
                    <accordian title="<?php echo e(__('admin::app.settings.channels.general')); ?>" :active="true">
                        <div slot="body">

                            <div class="control-group" :class="[errors.has('code') ? 'has-error' : '']">
                                <label for="code" class="required"><?php echo e(__('admin::app.settings.channels.code')); ?></label>
                                <input type="text" v-validate="'required'" class="control" id="code" name="code" data-vv-as="&quot;<?php echo e(__('admin::app.settings.channels.code')); ?>&quot;" value="<?php echo e($channel->code); ?>" disabled="disabled"/>
                                <input type="hidden" name="code" value="<?php echo e($channel->code); ?>"/>
                                <span class="control-error" v-if="errors.has('code')">{{ errors.first('code') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('<?php echo e($locale); ?>[name]') ? 'has-error' : '']">
                                <label for="name" class="required">
                                    <?php echo e(__('admin::app.settings.channels.name')); ?>

                                    <span class="locale">[<?php echo e($locale); ?>]</span>
                                </label>
                                <input v-validate="'required'" class="control" id="name" name="<?php echo e($locale); ?>[name]" data-vv-as="&quot;<?php echo e(__('admin::app.settings.channels.name')); ?>&quot;" value="<?php echo e(old($locale)['name'] ?? ($channel->translate($locale)['name'] ?? $channel->name)); ?>"/>
                                <span class="control-error" v-if="errors.has('<?php echo e($locale); ?>[name]')">{{ errors.first('<?php echo $locale; ?>[page_title]') }}</span>
                            </div>

                            <div class="control-group">
                                <label for="description">
                                    <?php echo e(__('admin::app.settings.channels.description')); ?>

                                    <span class="locale">[<?php echo e($locale); ?>]</span>
                                </label>
                                <textarea class="control" id="description" name="<?php echo e($locale); ?>[description]"><?php echo e(old($locale)['description'] ?? ($channel->translate($locale)['description'] ?? $channel->description)); ?></textarea>
                            </div>

                            <div class="control-group" :class="[errors.has('inventory_sources[]') ? 'has-error' : '']">
                                <label for="inventory_sources" class="required"><?php echo e(__('admin::app.settings.channels.inventory_sources')); ?></label>
                                <?php $selectedOptionIds = old('inventory_sources') ?: $channel->inventory_sources->pluck('id')->toArray() ?>
                                <select v-validate="'required'" class="control" id="inventory_sources" name="inventory_sources[]" data-vv-as="&quot;<?php echo e(__('admin::app.settings.channels.inventory_sources')); ?>&quot;" multiple>
                                    <?php $__currentLoopData = app('Webkul\Inventory\Repositories\InventorySourceRepository')->findWhere(['status' => 1]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventorySource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($inventorySource->id); ?>" <?php echo e(in_array($inventorySource->id, $selectedOptionIds) ? 'selected' : ''); ?>>
                                            <?php echo e($inventorySource->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="control-error" v-if="errors.has('inventory_sources[]')">{{ errors.first('inventory_sources[]') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('root_category_id') ? 'has-error' : '']">
                                <label for="root_category_id" class="required"><?php echo e(__('admin::app.settings.channels.root-category')); ?></label>
                                <?php $selectedOption = old('root_category_id') ?: $channel->root_category_id ?>
                                <select v-validate="'required'" class="control" id="root_category_id" name="root_category_id" data-vv-as="&quot;<?php echo e(__('admin::app.settings.channels.root-category')); ?>&quot;">
                                    <?php $__currentLoopData = app('Webkul\Category\Repositories\CategoryRepository')->getRootCategories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php echo e($selectedOption == $category->id ? 'selected' : ''); ?>>
                                            <?php echo e($category->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="control-error" v-if="errors.has('root_category_id')">{{ errors.first('root_category_id') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('hostname') ? 'has-error' : '']">
                                <label for="hostname"><?php echo e(__('admin::app.settings.channels.hostname')); ?></label>
                                <input type="text" v-validate="''" class="control" id="hostname" name="hostname" value="<?php echo e($channel->hostname); ?>" placeholder="<?php echo e(__('admin::app.settings.channels.hostname-placeholder')); ?>"/>

                                <span class="control-error" v-if="errors.has('hostname')">{{ errors.first('hostname') }}</span>
                            </div>

                        </div>
                    </accordian>

                    
                    <accordian title="<?php echo e(__('admin::app.settings.channels.currencies-and-locales')); ?>" :active="true">
                        <div slot="body">

                            <div class="control-group" :class="[errors.has('locales[]') ? 'has-error' : '']">
                                <label for="locales" class="required"><?php echo e(__('admin::app.settings.channels.locales')); ?></label>
                                <?php $selectedOptionIds = old('locales') ?: $channel->locales->pluck('id')->toArray() ?>
                                <select v-validate="'required'" class="control" id="locales" name="locales[]" data-vv-as="&quot;<?php echo e(__('admin::app.settings.channels.locales')); ?>&quot;" multiple>
                                    <?php $__currentLoopData = core()->getAllLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($localeModel->id); ?>" <?php echo e(in_array($localeModel->id, $selectedOptionIds) ? 'selected' : ''); ?>>
                                            <?php echo e($localeModel->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="control-error" v-if="errors.has('locales[]')">{{ errors.first('locales[]') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('default_locale_id') ? 'has-error' : '']">
                                <label for="default_locale_id" class="required"><?php echo e(__('admin::app.settings.channels.default-locale')); ?></label>
                                <?php $selectedOption = old('default_locale_id') ?: $channel->default_locale_id ?>
                                <select v-validate="'required'" class="control" id="default_locale_id" name="default_locale_id" data-vv-as="&quot;<?php echo e(__('admin::app.settings.channels.default-locale')); ?>&quot;">
                                    <?php $__currentLoopData = core()->getAllLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeModel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($localeModel->id); ?>" <?php echo e($selectedOption == $localeModel->id ? 'selected' : ''); ?>>
                                            <?php echo e($localeModel->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="control-error" v-if="errors.has('default_locale_id')">{{ errors.first('default_locale_id') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('currencies[]') ? 'has-error' : '']">
                                <label for="currencies" class="required"><?php echo e(__('admin::app.settings.channels.currencies')); ?></label>
                                <?php $selectedOptionIds = old('currencies') ?: $channel->currencies->pluck('id')->toArray() ?>
                                <select v-validate="'required'" class="control" id="currencies" name="currencies[]" data-vv-as="&quot;<?php echo e(__('admin::app.settings.channels.currencies')); ?>&quot;" multiple>
                                    <?php $__currentLoopData = core()->getAllCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($currency->id); ?>" <?php echo e(in_array($currency->id, $selectedOptionIds) ? 'selected' : ''); ?>>
                                            <?php echo e($currency->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="control-error" v-if="errors.has('currencies[]')">{{ errors.first('currencies[]') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('base_currency_id') ? 'has-error' : '']">
                                <label for="base_currency_id" class="required"><?php echo e(__('admin::app.settings.channels.base-currency')); ?></label>
                                <?php $selectedOption = old('base_currency_id') ?: $channel->base_currency_id ?>
                                <select v-validate="'required'" class="control" id="base_currency_id" name="base_currency_id" data-vv-as="&quot;<?php echo e(__('admin::app.settings.channels.base-currency')); ?>&quot;">
                                    <?php $__currentLoopData = core()->getAllCurrencies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($currency->id); ?>" <?php echo e($selectedOption == $currency->id ? 'selected' : ''); ?>>
                                            <?php echo e($currency->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="control-error" v-if="errors.has('base_currency_id')">{{ errors.first('base_currency_id') }}</span>
                            </div>

                        </div>
                    </accordian>

                    
                    <accordian title="<?php echo e(__('admin::app.settings.channels.design')); ?>" :active="true">
                        <div slot="body">
                            <div class="control-group">
                                <label for="theme"><?php echo e(__('admin::app.settings.channels.theme')); ?></label>

                                <?php $selectedOption = old('theme') ?: $channel->theme ?>

                                <select class="control" id="theme" name="theme">
                                    <?php $__currentLoopData = config('themes.themes'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $themeCode => $theme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($themeCode); ?>" <?php echo e($selectedOption == $themeCode ? 'selected' : ''); ?>>
                                            <?php echo e($theme['name']); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="control-group">
                                <label for="home_page_content">
                                    <?php echo e(__('admin::app.settings.channels.home_page_content')); ?>

                                    <span class="locale">[<?php echo e($locale); ?>]</span>
                                </label>
                                <textarea class="control" id="home_page_content" name="<?php echo e($locale); ?>[home_page_content]"><?php echo e(old($locale)['home_page_content'] ?? ($channel->translate($locale)['home_page_content'] ?? $channel->home_page_content)); ?></textarea>
                            </div>

                            <div class="control-group">
                                <label for="footer_content">
                                    <?php echo e(__('admin::app.settings.channels.footer_content')); ?>

                                    <span class="locale">[<?php echo e($locale); ?>]</span>
                                </label>
                                <textarea class="control" id="footer_content" name="<?php echo e($locale); ?>[footer_content]"><?php echo e(old($locale)['footer_content'] ?? ($channel->translate($locale)['footer_content'] ?? $channel->footer_content)); ?></textarea>
                            </div>

                            <div class="control-group">
                                <label><?php echo e(__('admin::app.settings.channels.logo')); ?></label>

                                <image-wrapper button-label="<?php echo e(__('admin::app.catalog.products.add-image-btn-title')); ?>" input-name="logo" :multiple="false" :images='"<?php echo e($channel->logo_url); ?>"'></image-wrapper>
                            
                                <span class="control-info mt-10"><?php echo e(__('admin::app.settings.channels.logo-size')); ?></span>
                            </div>

                            <div class="control-group">
                                <label><?php echo e(__('admin::app.settings.channels.favicon')); ?></label>

                                <image-wrapper button-label="<?php echo e(__('admin::app.catalog.products.add-image-btn-title')); ?>" input-name="favicon" :multiple="false" :images='"<?php echo e($channel->favicon_url); ?>"'></image-wrapper>
                                
                                <span class="control-info mt-10"><?php echo e(__('admin::app.settings.channels.favicon-size')); ?></span> 
                            </div>

                        </div>
                    </accordian>

                    <?php
                        $home_seo = $channel->translate($locale)['home_seo'] ?? $channel->home_seo;
                        $seo = json_decode($home_seo);
                    ?>

                    
                    <accordian title="<?php echo e(__('admin::app.settings.channels.seo')); ?>" :active="true">
                        <div slot="body">
                            <div class="control-group" :class="[errors.has('<?php echo e($locale); ?>[seo_title]') ? 'has-error' : '']">
                                <label for="seo_title" class="required">
                                    <?php echo e(__('admin::app.settings.channels.seo-title')); ?>

                                    <span class="locale">[<?php echo e($locale); ?>]</span>
                                </label>

                                <input v-validate="'required'" class="control" id="seo_title" name="<?php echo e($locale); ?>[seo_title]" data-vv-as="&quot;<?php echo e(__('admin::app.settings.channels.seo-title')); ?>&quot;" value="<?php echo e($seo->meta_title ?? (old($locale)['seo_title'] ?? '')); ?>"/>

                                <span class="control-error" v-if="errors.has('<?php echo e($locale); ?>[seo_title]')">{{ errors.first('<?php echo $locale; ?>[page_title]') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('<?php echo e($locale); ?>[seo_description]') ? 'has-error' : '']">
                                <label for="seo_description" class="required">
                                    <?php echo e(__('admin::app.settings.channels.seo-description')); ?>

                                    <span class="locale">[<?php echo e($locale); ?>]</span>
                                </label>

                                <textarea v-validate="'required'" class="control" id="seo_description" name="<?php echo e($locale); ?>[seo_description]" data-vv-as="&quot;<?php echo e(__('admin::app.settings.channels.seo-description')); ?>&quot;"><?php echo e($seo->meta_description ?? (old($locale)['seo_description'] ?? '')); ?></textarea>

                                <span class="control-error" v-if="errors.has('<?php echo e($locale); ?>[seo_description]')">{{ errors.first('<?php echo $locale; ?>[page_title]') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('<?php echo e($locale); ?>[seo_keywords]') ? 'has-error' : '']">
                                <label for="seo_keywords" class="required">
                                    <?php echo e(__('admin::app.settings.channels.seo-keywords')); ?>

                                    <span class="locale">[<?php echo e($locale); ?>]</span>
                                </label>

                                <textarea v-validate="'required'" class="control" id="seo_keywords" name="<?php echo e($locale); ?>[seo_keywords]" data-vv-as="&quot;<?php echo e(__('admin::app.settings.channels.seo-keywords')); ?>&quot;"><?php echo e($seo->meta_keywords ?? (old($locale)['seo_keywords'] ?? '')); ?></textarea>

                                <span class="control-error" v-if="errors.has('<?php echo e($locale); ?>[seo_keywords]')">{{ errors.first('<?php echo $locale; ?>[page_title]') }}</span>
                            </div>
                        </div>
                    </accordian>

                    
                    <accordian title="<?php echo e(__('admin::app.settings.channels.maintenance-mode')); ?>" :active="true">
                        <div slot="body">
                            <div class="control-group">
                                <label for="maintenance-mode-status"><?php echo e(__('admin::app.status')); ?></label>
                                <label class="switch">
                                    <input type="hidden" name="is_maintenance_on" value="0" />
                                    <input type="checkbox" id="maintenance-mode-status" name="is_maintenance_on" value="1" <?php echo e($channel->is_maintenance_on ? 'checked' : ''); ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            <div class="control-group">
                                <label for="maintenance-mode-text">
                                    <?php echo e(__('admin::app.settings.channels.maintenance-mode-text')); ?>

                                    <span class="locale">[<?php echo e($locale); ?>]</span>
                                </label>
                                <input class="control" id="maintenance-mode-text" name="<?php echo e($locale); ?>[maintenance_mode_text]" value="<?php echo e(old('maintenance_mode_text') ?? ($channel->translate($locale)['maintenance_mode_text'] ?? $channel->maintenance_mode_text)); ?>"/>
                            </div>

                            <div class="control-group">
                                <label for="allowed-ips"><?php echo e(__('admin::app.settings.channels.allowed-ips')); ?></label>
                                <input class="control" id="allowed-ips" name="allowed_ips" value="<?php echo e(old('allowed_ips') ?: $channel->allowed_ips); ?>"/>
                            </div>
                        </div>
                    </accordian>

                    <?php echo view_render_event('bagisto.admin.settings.channel.edit.after'); ?>

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
                selector: 'textarea#home_page_content,textarea#footer_content',
                height: 200,
                width: "100%",
                plugins: 'image imagetools media wordcount save fullscreen code table lists link hr',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor link hr | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | code | table',
                image_advtab: true,
                valid_elements : '*[*]',
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin::layouts.content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\eshoplaravel\packages\Webkul\Admin\src/resources/views/settings/channels/edit.blade.php ENDPATH**/ ?>