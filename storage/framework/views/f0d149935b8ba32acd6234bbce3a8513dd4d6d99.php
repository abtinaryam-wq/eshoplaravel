<?php echo view_render_event('bagisto.admin.catalog.product.edit_form_accordian.inventories.before', ['product' => $product]); ?>


<accordian title="<?php echo e(__('admin::app.catalog.products.inventories')); ?>" :active="false">
    <div slot="body">

        <?php echo view_render_event('bagisto.admin.catalog.product.edit_form_accordian.inventories.controls.before', ['product' => $product]); ?>


        <?php $__currentLoopData = $inventorySources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventorySource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php

                $qty = 0;
                foreach ($product->inventories as $inventory) {
                    if ($inventory->inventory_source_id == $inventorySource->id) {
                        $qty = $inventory->qty;
                        
                        break;
                    }
                }

                $qty = old('inventories[' . $inventorySource->id . ']') ?: $qty;

            ?>
            <div class="control-group" :class="[errors.has('inventories[<?php echo e($inventorySource->id); ?>]') ? 'has-error' : '']">
                <label><?php echo e($inventorySource->name); ?></label>

                <input type="text" v-validate="'numeric|min:0'" name="inventories[<?php echo e($inventorySource->id); ?>]" class="control" value="<?php echo e($qty); ?>" data-vv-as="&quot;<?php echo e($inventorySource->name); ?>&quot;"/>
                
                <span class="control-error" v-if="errors.has('inventories[<?php echo e($inventorySource->id); ?>]')">{{ errors.first('inventories[<?php echo $inventorySource->id; ?>]') }}</span>
            </div>
        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php echo view_render_event('bagisto.admin.catalog.product.edit_form_accordian.inventories.controls.after', ['product' => $product]); ?>


    </div>
</accordian>

<?php echo view_render_event('bagisto.admin.catalog.product.edit_form_accordian.inventories.after', ['product' => $product]); ?><?php /**PATH C:\xampp\htdocs\eshoplaravel\packages\Webkul\Admin\src/resources/views/catalog/products/accordians/inventories.blade.php ENDPATH**/ ?>