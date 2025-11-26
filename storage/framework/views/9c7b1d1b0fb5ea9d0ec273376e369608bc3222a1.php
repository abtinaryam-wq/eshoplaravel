<?php $__env->startPush('css'); ?>
    <style>
        .table th.price, .table th.weight {
            width: 100px;
        }
        .table th.actions {
            width: 85px;
        }
        .table td.actions .icon {
            margin-top: 8px;
        }
        .table td.actions .icon.pencil-lg-icon {
            margin-right: 10px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo view_render_event('bagisto.admin.catalog.product.edit_form_accordian.customer_group_prices.before', ['product' => $product]); ?>


<customer-group-price-list></customer-group-price-list>

<?php echo view_render_event('bagisto.admin.catalog.product.edit_form_accordian.customer_group_prices.after', ['product' => $product]); ?>


<?php $__env->startPush('scripts'); ?>
    <script type="text/x-template" id="customer-group-price-list-template">
        <div>
            <div class="table" style="margin-top: 20px; overflow-x: unset;">
                <table>
                    <thead>
                        <tr>
                            <th><?php echo e(__('admin::app.catalog.products.customer-group')); ?></th>
                            <th>
                                <div class="control-group">
                                    <label class="required">
                                    <?php echo e(__('admin::app.catalog.products.qty')); ?>

                                    </label>
                                </div>
                           </th>
                            <th>
                                <div class="control-group">
                                    <label class="required">
                                    <?php echo e(__('admin::app.catalog.products.price')); ?>

                                    </label>
                                </div>
                           </th>
                            <th class="actions"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <customer-group-price-item v-for='(customerGroupPrice, index) in customer_group_prices' :customer-group-price="customerGroupPrice" :key="index" :index="index" @onRemoveCustomerGroupPrice="removeCustomerGroupPrice($event)"></customer-group-price-item>
                    </tbody>
                </table>

                <button type="button" class="btn btn-lg btn-primary" style="margin-top: 20px" @click="addCustomerGroupPrice()">
                    <?php echo e(__('admin::app.catalog.products.add-group-price')); ?>

                </button>
            </div>
        </div>
    </script>

    <script type="text/x-template" id="customer-group-price-item-template">
        <tr>
            <td>
                <div class="control-group">
                    <select :name="[inputName + '[customer_group_id]']" v-model="customerGroupPrice.customer_group_id" class="control">
                        <option value=""><?php echo e(__('admin::app.catalog.products.all-group')); ?></option>

                        <?php $__currentLoopData = app('Webkul\Customer\Repositories\CustomerGroupRepository')->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customerGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($customerGroup->id); ?>"><?php echo e($customerGroup->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </td>

            <td>
                <div class="control-group" :class="[errors.has(inputName + '[qty]') ? 'has-error' : '']">
                    <input type="text" v-validate="'required|numeric|min_value:0'" :name="[inputName + '[qty]']" v-model="customerGroupPrice.qty" class="control" data-vv-as="&quot;<?php echo e(__('admin::app.catalog.products.qty')); ?>&quot;"/>

                    <span class="control-error" v-if="errors.has(inputName + '[qty]')">{{ errors.first(inputName + '[qty]') }}</span>
                </div>
            </td>

            <td>
                <div class="control-group">
                    <select :name="[inputName + '[value_type]']" v-model="customerGroupPrice.value_type" class="control">
                        <option value="fixed"><?php echo e(__('admin::app.catalog.products.fixed')); ?></option>

                        <option value="discount"><?php echo e(__('admin::app.catalog.products.discount')); ?></option>
                    </select>
                </div>

                <div class="control-group">
                    <div class="control-group" :class="[errors.has(inputName + '[value]') ? 'has-error' : '']">
                        <input type="text" v-validate="{required: true, decimal: true, min_value: 0, ...(customerGroupPrice.value_type === 'discount' ? {max_value: 100} : {})}" :name="[inputName + '[value]']" v-model="customerGroupPrice.value" class="control" data-vv-as="&quot;<?php echo e(__('admin::app.datagrid.price')); ?>&quot;"/>

                        <span class="control-error" v-if="errors.has(inputName + '[value]')">{{ errors.first(inputName + '[value]') }}</span>
                    </div>
                </div>
            </td>

            <td class="actions">
                <i class="icon remove-icon" @click="removeCustomerGroupPrice()"></i>
            </td>
        </tr>
    </script>

    <script>
        Vue.component('customer-group-price-list', {
            template: '#customer-group-price-list-template',

            inject: ['$validator'],

            data: function() {
                return {
                    customer_group_prices: <?php echo json_encode($product->customer_group_prices()->get(), 15, 512) ?>
                }
            },

            methods: {
                addCustomerGroupPrice: function(item, key) {
                    this.customer_group_prices.push({
                        customer_group_id: '',
                        qty: 0,
                        value_type: 'fixed',
                        amount: 0
                    });
                },

                removeCustomerGroupPrice: function(customerGroupPrice) {
                    let index = this.customer_group_prices.indexOf(customerGroupPrice)

                    this.customer_group_prices.splice(index, 1)
                }
            }
        });

        Vue.component('customer-group-price-item', {
            template: '#customer-group-price-item-template',

            props: ['index', 'customerGroupPrice'],

            inject: ['$validator'],

            mounted: function() {
                if (! this.customerGroupPrice['customer_group_id']) {
                    this.customerGroupPrice['customer_group_id'] = '';
                }
            },

            computed: {
                inputName: function () {
                    if (this.customerGroupPrice.id) {
                        return 'customer_group_prices[' + this.customerGroupPrice.id + ']';
                    }

                    return 'customer_group_prices[customer_group_price_' + this.index + ']';
                }
            },

            methods: {
                removeCustomerGroupPrice: function () {
                    this.$emit('onRemoveCustomerGroupPrice', this.customerGroupPrice)
                }
            }
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\eshoplaravel\packages\Webkul\Admin\src/resources/views/catalog/products/accordians/customer-group-price.blade.php ENDPATH**/ ?>