<?php $__env->startSection('page_title'); ?>
    <?php echo e(__('admin::app.catalog.products.title')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content" style="height: 100%;">
        <div class="page-header">
            <div class="page-title">
                <h1><?php echo e(__('admin::app.catalog.products.title')); ?></h1>
            </div>

            <div class="page-action">
                <div class="export-import" @click="showModal('downloadDataGrid')">
                    <i class="export-icon"></i>

                    <span>
                        <?php echo e(__('admin::app.export.export')); ?>

                    </span>
                </div>
                <?php if(bouncer()->hasPermission('catalog.products.create')): ?>
                    <a href="<?php echo e(route('admin.catalog.products.create')); ?>" class="btn btn-lg btn-primary">
                        <?php echo e(__('admin::app.catalog.products.add-product-btn-title')); ?>

                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php echo view_render_event('bagisto.admin.catalog.products.list.before'); ?>


        <div class="page-content">
            <datagrid-plus src="<?php echo e(route('admin.catalog.products.index')); ?>"></datagrid-plus>
        </div>

        <?php echo view_render_event('bagisto.admin.catalog.products.list.after'); ?>

    </div>

    <modal id="downloadDataGrid" :is-open="modalIds.downloadDataGrid">
        <h3 slot="header"><?php echo e(__('admin::app.export.download')); ?></h3>

        <div slot="body">
            <export-form></export-form>
        </div>
    </modal>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('admin::export.export', ['gridName' => app('Webkul\Admin\DataGrids\ProductDataGrid')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        function reloadPage(getVar, getVal) {
            let url = new URL(window.location.href);

            url.searchParams.set(getVar, getVal);

            window.location.href = url.href;
        }

        function showEditQuantityForm(productId) {
            $(`#product-${productId}-quantity`).hide();

            $(`#edit-product-${productId}-quantity-form-block`).show();
        }

        function cancelEditQuantityForm(productId) {
            $(`#edit-product-${productId}-quantity-form-block`).hide();

            $(`#product-${productId}-quantity`).show();
        }

        function saveEditQuantityForm(updateSource, productId) {
            let quantityFormData = $(`#edit-product-${productId}-quantity-form`).serialize();

            axios
                .post(updateSource, quantityFormData)
                .then(function (response) {
                    let data = response.data;

                    $(`#inventoryErrors${productId}`).text('');

                    $(`#edit-product-${productId}-quantity-form-block`).hide();

                    $(`#product-${productId}-quantity-anchor`).text(data.updatedTotal);

                    $(`#product-${productId}-quantity`).show();
                })
                .catch(function ({ response }) {
                    let { data } = response;

                    $(`#inventoryErrors${productId}`).text(data.message);
                });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin::layouts.content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\eshoplaravel\packages\Webkul\Admin\src/resources/views/catalog/products/index.blade.php ENDPATH**/ ?>