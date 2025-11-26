<?php $productFlatRepository = app('Webkul\Product\Repositories\ProductFlatRepository'); ?>

<?php
    $productChannels = $productFlatRepository->findWhere([
        'product_id' => $product->id
    ])->pluck('channel')->unique()->toArray();
?>

<accordian title="<?php echo e(__('admin::app.catalog.products.channel')); ?>" :active="false">
    <div slot="body">
        <div class="control-group multi-select" :class="[errors.has('channels[]') ? 'has-error' : '']">
            <label for="channels" class="required"><?php echo e(__('admin::app.catalog.products.channel')); ?></label>

            <select class="control" name="channels[]" v-validate="'required'" data-vv-as="&quot;<?php echo e(__('admin::app.catalog.products.channel')); ?>&quot;" multiple>
                <?php $__currentLoopData = app('Webkul\Core\Repositories\ChannelRepository')->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($channel->id); ?>" <?php echo e(in_array($channel->code, $productChannels) ? 'selected' : ''); ?>>
                        <?php echo e(core()->getChannelName($channel)); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <span class="control-error" v-if="errors.has('channels[]')">
                {{ errors.first('channels[]') }}
            </span>
        </div>
    </div>
</accordian><?php /**PATH C:\xampp\htdocs\eshoplaravel\packages\Webkul\Admin\src/resources/views/catalog/products/accordians/channels.blade.php ENDPATH**/ ?>