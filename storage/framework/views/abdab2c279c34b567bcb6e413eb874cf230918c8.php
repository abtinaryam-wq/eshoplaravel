<?php if($categories->count()): ?>

<?php echo view_render_event('bagisto.admin.catalog.product.edit_form_accordian.categories.before', ['product' => $product]); ?>


<accordian title="<?php echo e(__('admin::app.catalog.products.categories')); ?>" :active="false">
    <div slot="body">

        <?php echo view_render_event('bagisto.admin.catalog.product.edit_form_accordian.categories.controls.before', ['product' => $product]); ?>


        <tree-view behavior="normal" value-field="id" name-field="categories" input-type="checkbox" items='<?php echo json_encode($categories, 15, 512) ?>' value='<?php echo json_encode($product->categories->pluck("id"), 15, 512) ?>' fallback-locale="<?php echo e(config('app.fallback_locale')); ?>"></tree-view>

        <?php echo view_render_event('bagisto.admin.catalog.product.edit_form_accordian.categories.controls.after', ['product' => $product]); ?>


    </div>
</accordian>

<?php echo view_render_event('bagisto.admin.catalog.product.edit_form_accordian.categories.after', ['product' => $product]); ?>


<?php endif; ?><?php /**PATH C:\xampp\htdocs\eshoplaravel\packages\Webkul\Admin\src/resources/views/catalog/products/accordians/categories.blade.php ENDPATH**/ ?>