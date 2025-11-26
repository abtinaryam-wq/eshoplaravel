<?php
    $searchQuery = request()->input();

    if (
        $searchQuery
        && ! empty($searchQuery)
    ) {
        $searchQuery = implode('&', array_map(
            function ($v, $k) {
                if (is_array($v)) {
                    if (is_array($v)) {
                        $key = array_keys($v)[0];

                        return $k. "[$key]=" . implode('&' . $k . '[]=', $v);
                    } else {
                        return $k. '[]=' . implode('&' . $k . '[]=', $v);
                    }
                } else {
                    return $k . '=' . $v;
                }
            },
            $searchQuery,
            array_keys($searchQuery)
        ));
    } else {
        $searchQuery = false;
    }
?>

<?php echo view_render_event('bagisto.shop.layout.header.locale.before'); ?>

    <div class="d-inline-block">
        <div class="dropdown">
            <div class="locale-icon">
                <img src="<?php echo e(core()->getCurrentLocale()->image_url); ?>" alt="" width="20" height="20" />
            </div>

            <select
                class="btn btn-link dropdown-toggle control locale-switcher styled-select"
                onchange="window.location.href = this.value"
                aria-label="Locale"
                <?php if(count(core()->getCurrentChannel()->locales) == 1): ?>
                    disabled="disabled"
                <?php endif; ?>>

                <?php $__currentLoopData = core()->getCurrentChannel()->locales()->orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $locale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(
                        isset($searchQuery)
                        && $searchQuery
                    ): ?>
                        <option
                            value="?<?php echo e($searchQuery); ?>&locale=<?php echo e($locale->code); ?>"
                            <?php echo e($locale->code == app()->getLocale() ? 'selected' : ''); ?>>
                            <?php echo e($locale->name); ?>

                        </option>
                    <?php else: ?>
                        <option value="?locale=<?php echo e($locale->code); ?>" <?php echo e($locale->code == app()->getLocale() ? 'selected' : ''); ?>><?php echo e($locale->name); ?></option>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <div class="select-icon-container">
                <span class="select-icon rango-arrow-down"></span>
            </div>
        </div>
    </div>

<?php echo view_render_event('bagisto.shop.layout.header.locale.after'); ?>


<?php echo view_render_event('bagisto.shop.layout.header.currency-item.before'); ?>


    <?php if(core()->getCurrentChannel()->currencies->count() > 1): ?>
        <div class="d-inline-block">
            <div class="dropdown">
            <span class="currency-icon">
                <?php echo e(core()->getCurrentCurrency()->symbol); ?>

            </span>

               <select
                    class="btn btn-link dropdown-toggle control locale-switcher styled-select"
                    onchange="window.location.href = this.value" aria-label="Locale">
                    <?php $__currentLoopData = core()->getCurrentChannel()->currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(
                            isset($searchQuery)
                            && $searchQuery
                        ): ?>
                            <option value="?<?php echo e($searchQuery); ?>&currency=<?php echo e($currency->code); ?>" <?php echo e($currency->code == core()->getCurrentCurrencyCode() ? 'selected' : ''); ?>><?php echo e($currency->code); ?></option>
                        <?php else: ?>
                            <option value="?currency=<?php echo e($currency->code); ?>" <?php echo e($currency->code == core()->getCurrentCurrencyCode() ? 'selected' : ''); ?>><?php echo e($currency->code); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </select>

                <div class="select-icon-container">
                    <span class="select-icon rango-arrow-down"></span>
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php echo view_render_event('bagisto.shop.layout.header.currency-item.after'); ?>

<?php /**PATH C:\xampp\htdocs\eshoplaravel/resources/themes/velocity/views/layouts/top-nav/locale-currency.blade.php ENDPATH**/ ?>