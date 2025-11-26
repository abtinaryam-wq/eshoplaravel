<select v-validate="'<?php echo e($validations); ?>'" class="control" id="<?php echo e($attribute->code); ?>" name="<?php echo e($attribute->code); ?>" data-vv-as="&quot;<?php echo e($attribute->admin_name); ?>&quot;">

    <?php $selectedOption = old($attribute->code) ?: $product[$attribute->code] ?>

    <?php if($attribute->code != 'tax_category_id'): ?>

        <?php $__currentLoopData = $attribute->options()->orderBy('sort_order')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($option->id); ?>" <?php echo e($option->id == $selectedOption ? 'selected' : ''); ?>>
                <?php echo e($option->admin_name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php else: ?>

        <option value=""></option>

        <?php $__currentLoopData = app('Webkul\Tax\Repositories\TaxCategoryRepository')->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($taxCategory->id); ?>" <?php echo e($taxCategory->id == $selectedOption ? 'selected' : ''); ?>>
                <?php echo e($taxCategory->name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php endif; ?>

</select><?php /**PATH C:\xampp\htdocs\eshoplaravel\packages\Webkul\Admin\src/resources/views/catalog/products/field-types/select.blade.php ENDPATH**/ ?>