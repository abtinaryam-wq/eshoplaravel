<?php $coreConfigRepository = app('Webkul\Core\Repositories\CoreConfigRepository'); ?>

<?php
    $nameKey = $item['key'] . '.' . $field['name'];

    $name = $coreConfigRepository->getNameField($nameKey);

    $value = $coreConfigRepository->getValueByRepository($field);

    $validations = $coreConfigRepository->getValidations($field);

    $channelLocaleInfo = $coreConfigRepository->getChannelLocaleInfo($field, $channel, $locale);
?>

<?php if($field['type'] == 'depends'): ?>

    <?php echo $__env->make('admin::configuration.dependent-field-type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php else: ?>
    <div class="control-group <?php echo e($field['type']); ?>" <?php if($field['type'] == 'multiselect'): ?> :class="[errors.has('<?php echo e($name); ?>[]') ? 'has-error' : '']" <?php else: ?> :class="[errors.has('<?php echo e($name); ?>') ? 'has-error' : '']" <?php endif; ?>>

        <label for="<?php echo e($name); ?>" <?php echo e(!isset($field['validation']) || preg_match('/\brequired\b/', $field['validation']) == false ? '' : 'class=required'); ?>>

            <?php echo e(trans($field['title'])); ?>


            <span class="locale"><?php echo e($channelLocaleInfo); ?></span>

        </label>

        <?php if($field['type'] == 'text'): ?>

            <input type="text" v-validate="'<?php echo e($validations); ?>'" class="control" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" value="<?php echo e(old($nameKey) ?: (core()->getConfigData($nameKey, $channel, $locale) ? core()->getConfigData($nameKey, $channel, $locale) : (isset($field['default_value']) ? $field['default_value'] : ''))); ?>" data-vv-as="&quot;<?php echo e(trans($field['title'])); ?>&quot;">

        <?php elseif($field['type'] == 'password'): ?>

            <input type="password" v-validate="'<?php echo e($validations); ?>'" class="control" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" value="<?php echo e(old($nameKey) ?: core()->getConfigData($nameKey, $channel, $locale)); ?>" data-vv-as="&quot;<?php echo e(trans($field['title'])); ?>&quot;">

        <?php elseif($field['type'] == 'number'): ?>

            <input type="number" min="<?php echo e($field['name'] == 'minimum_order_amount' ? 1 : 0); ?>" v-validate="'<?php echo e($validations); ?>'" class="control" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" value="<?php echo e(old($nameKey) ?: core()->getConfigData($nameKey, $channel, $locale)); ?>" data-vv-as="&quot;<?php echo e(trans($field['title'])); ?>&quot;">

        <?php elseif($field['type'] == 'color'): ?>

            <input type="color" v-validate="'<?php echo e($validations); ?>'" class="control" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" value="<?php echo e(old($nameKey) ?: core()->getConfigData($nameKey, $channel, $locale)); ?>" data-vv-as="&quot;<?php echo e(trans($field['title'])); ?>&quot;">

        <?php elseif($field['type'] == 'textarea'): ?>

            <textarea v-validate="'<?php echo e($validations); ?>'" class="control" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" data-vv-as="&quot;<?php echo e(trans($field['title'])); ?>&quot;"><?php echo e(old($nameKey) ?: core()->getConfigData($nameKey, $channel, $locale) ?: (isset($field['default_value']) ? $field['default_value'] : '')); ?></textarea>

        <?php elseif($field['type'] == 'editor'): ?>

            <textarea v-validate="'<?php echo e($validations); ?>'" class="editor control" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" data-vv-as="&quot;<?php echo e(trans($field['title'])); ?>&quot;"><?php echo e(old($nameKey) ?: core()->getConfigData($nameKey, $channel, $locale) ?: (isset($field['default_value']) ? $field['default_value'] : '')); ?></textarea>

        <?php elseif($field['type'] == 'select'): ?>

            <select v-validate="'<?php echo e($validations); ?>'" class="control" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" data-vv-as="&quot;<?php echo e(trans($field['title'])); ?>&quot;" >

                <?php $selectedOption = core()->getConfigData($nameKey, $channel, $locale) ?? ''; ?>

                <?php if(isset($field['repository'])): ?>
                    <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <option value="<?php echo e($key); ?>" <?php echo e($key == $selectedOption ? 'selected' : ''); ?>>
                        <?php echo e(trans($option)); ?>

                        </option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $value = ! isset($option['value']) ? null : ( $value = ! $option['value'] ? 0 : $option['value'] );
                        ?>

                        <option value="<?php echo e($value); ?>" <?php echo e($value == $selectedOption ? 'selected' : ''); ?>>
                            <?php echo e(trans($option['title'])); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

            </select>

        <?php elseif($field['type'] == 'multiselect'): ?>

            <select v-validate="'<?php echo e($validations); ?>'" class="control" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>[]" data-vv-as="&quot;<?php echo e(trans($field['title'])); ?>&quot;"  multiple>

                <?php $selectedOption = core()->getConfigData($nameKey, $channel, $locale) ?? ''; ?>

                <?php if(isset($field['repository'])): ?>
                    <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <option value="<?php echo e($key); ?>" <?php echo e(in_array($key, explode(',', $selectedOption)) ? 'selected' : ''); ?>>
                            <?php echo e(trans($value[$key])); ?>

                        </option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $value = ! isset($option['value']) ? null : ( $value = ! $option['value'] ? 0 : $option['value'] );
                        ?>

                        <option value="<?php echo e($value); ?>" <?php echo e(in_array($option['value'], explode(',', $selectedOption)) ? 'selected' : ''); ?>>
                            <?php echo e(trans($option['title'])); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

            </select>

        <?php elseif($field['type'] == 'country'): ?>

            <?php $countryCode = core()->getConfigData($nameKey, $channel, $locale) ?? ''; ?>

            <country
                :country_code = "'<?php echo e($countryCode); ?>'"
                :validations = "'<?php echo e($validations); ?>'"
                :name = "'<?php echo e($name); ?>'"
            ></country>

        <?php elseif($field['type'] == 'state'): ?>

            <?php $stateCode = core()->getConfigData($nameKey, $channel, $locale) ?? ''; ?>

            <state
                :state_code = "'<?php echo e($stateCode); ?>'"
                :validations = "'<?php echo e($validations); ?>'"
                :name = "'<?php echo e($name); ?>'"
            ></state>

        <?php elseif($field['type'] == 'boolean'): ?>

            <?php $selectedOption = core()->getConfigData($nameKey, $channel, $locale) ?? (isset($field['default_value']) ? $field['default_value'] : ''); ?>

            <label class="switch">
                <input type="hidden" name="<?php echo e($name); ?>" value="0" />
                <input type="checkbox" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" value="1" <?php echo e($selectedOption ? 'checked' : ''); ?>>
                <span class="slider round"></span>
            </label>

        <?php elseif($field['type'] == 'image'): ?>

            <?php
                $src = Storage::url(core()->getConfigData($nameKey, $channel, $locale));
                $result = core()->getConfigData($nameKey, $channel, $locale);
            ?>

            <?php if($result): ?>
                <a href="<?php echo e($src); ?>" target="_blank">
                    <img src="<?php echo e($src); ?>" class="configuration-image"/>
                </a>
            <?php endif; ?>

            <input type="file" v-validate="'<?php echo e($validations); ?>'" class="control" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" value="<?php echo e(old($nameKey) ?: core()->getConfigData($nameKey, $channel, $locale)); ?>" data-vv-as="&quot;<?php echo e(trans($field['title'])); ?>&quot;" style="padding-top: 5px;">

            <?php if($result): ?>
                <div class="control-group" style="margin-top: 5px;">
                    <span class="checkbox">
                        <input type="checkbox" id="<?php echo e($name); ?>[delete]"  name="<?php echo e($name); ?>[delete]" value="1">

                        <label class="checkbox-view" for="delete"></label>
                            <?php echo e(__('admin::app.configuration.delete')); ?>

                    </span>
                </div>
            <?php endif; ?>

        <?php elseif($field['type'] == 'file'): ?>

            <?php
                $result = core()->getConfigData($nameKey, $channel, $locale);
                $src = explode("/", $result);
                $path = end($src);
            ?>

            <?php if($result): ?>
                <a href="<?php echo e(route('admin.configuration.download', [request()->route('slug'), request()->route('slug2'), $path])); ?>">
                    <i class="icon sort-down-icon download"></i>
                </a>
            <?php endif; ?>

            <input type="file" v-validate="'<?php echo e($validations); ?>'" class="control" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" value="<?php echo e(old($nameKey) ?: core()->getConfigData($nameKey, $channel, $locale)); ?>" data-vv-as="&quot;<?php echo e(trans($field['title'])); ?>&quot;" style="padding-top: 5px;">

            <?php if($result): ?>
                <div class="control-group" style="margin-top: 5px;">
                    <span class="checkbox">
                        <input type="checkbox" id="<?php echo e($name); ?>[delete]"  name="<?php echo e($name); ?>[delete]" value="1">

                        <label class="checkbox-view" for="delete"></label>
                            <?php echo e(__('admin::app.configuration.delete')); ?>

                    </span>
                </div>
            <?php endif; ?>

        <?php endif; ?>

        <?php if(isset($field['info'])): ?>
            <span class="control-info mt-10">{<?php echo trans($field['info']); ?>}</span>
        <?php endif; ?>

        <span class="control-error" <?php if($field['type'] == 'multiselect'): ?>  v-if="errors.has('<?php echo e($name); ?>[]')" <?php else: ?>  v-if="errors.has('<?php echo e($name); ?>')" <?php endif; ?>>
            <?php if($field['type'] == 'multiselect'): ?>
                {{ errors.first('<?php echo $name; ?>[]') }}
            <?php else: ?>
                {{ errors.first('<?php echo $name; ?>') }}
            <?php endif; ?>
        </span>

    </div>

<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
    <?php if($field['type'] == 'country'): ?>
        <script type="text/x-template" id="country-template">
            <div>
                <select type="text" v-validate="validations" class="control" :id="name" :name="name" v-model="country" data-vv-as="&quot;<?php echo e(__('admin::app.customers.customers.country')); ?>&quot;" @change="sendCountryCode">
                    <option value=""></option>

                    <?php $__currentLoopData = core()->countries(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <option value="<?php echo e($country->code); ?>"><?php echo e($country->name); ?></option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </script>

        <script>
            Vue.component('country', {

                template: '#country-template',

                inject: ['$validator'],

                props: ['country_code', 'name', 'validations'],

                data: function () {
                    return {
                        country: "",
                    }
                },

                mounted: function () {
                    this.country = this.country_code;
                    this.sendCountryCode()
                },

                methods: {
                    sendCountryCode: function () {
                        this.$root.$emit('countryCode', this.country)
                    },
                }
            });
        </script>

        <script type="text/x-template" id="state-template">
            <div>
                <input type="text" v-validate="validations" v-if="!haveStates()" class="control" v-model="state" :id="name" :name="name" data-vv-as="&quot;<?php echo e(__('admin::app.customers.customers.state')); ?>&quot;"/>

                <select v-validate="validations" v-if="haveStates()" class="control" v-model="state" :id="name" :name="name" data-vv-as="&quot;<?php echo e(__('admin::app.customers.customers.state')); ?>&quot;" >

                    <option value=""><?php echo e(__('admin::app.customers.customers.select-state')); ?></option>

                    <option v-for='(state, index) in countryStates[country]' :value="state.code">
                        {{ state.default_name }}
                    </option>

                </select>
            </div>
        </script>

        <script>
            Vue.component('state', {

                template: '#state-template',

                inject: ['$validator'],

                props: ['state_code', 'name', 'validations'],

                data: function () {
                    return {
                        state: "",

                        country: "",

                        countryStates: <?php echo json_encode(core()->groupedStatesByCountries(), 15, 512) ?>
                    }
                },

                mounted: function () {
                    this.state = this.state_code
                },

                methods: {
                    haveStates: function () {
                        let self = this;

                        self.$root.$on('countryCode', function (country) {
                            self.country = country;
                        });

                        if (this.countryStates[this.country] && this.countryStates[this.country].length)
                            return true;

                        return false;
                    },
                }
            });
        </script>
    <?php endif; ?>
<?php $__env->stopPush(); ?>


<?php if (! $__env->hasRenderedOnce('a69efd35-805c-4582-97ca-33ab2800a0d5')): $__env->markAsRenderedOnce('a69efd35-805c-4582-97ca-33ab2800a0d5');
$__env->startPush('scripts'); ?>
    <?php echo $__env->make('admin::layouts.tinymce', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        $(document).ready(function () {
            tinyMCEHelper.initTinyMCE({
                selector: 'textarea.editor',
                height: 200,
                width: "100%",
                plugins: 'image imagetools media wordcount save fullscreen code table lists link hr',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor link hr | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent  | removeformat | code | table',
                image_advtab: true,
            });
        });
    </script>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH C:\xampp\htdocs\eshoplaravel\packages\Webkul\Admin\src/resources/views/configuration/field-type.blade.php ENDPATH**/ ?>