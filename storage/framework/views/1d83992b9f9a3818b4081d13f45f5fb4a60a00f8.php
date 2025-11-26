<?php
    $isRendered = false;
    $advertisementTwo = null;
    $isLazyLoad = ! isset($lazyload) ? true : ( $lazyload ? true : false );
?>

<?php if(
    $velocityMetaData
    && $velocityMetaData->advertisement
): ?>
    <?php
        $advertisement = json_decode($velocityMetaData->advertisement, true);

        if (
            isset($advertisement[2])
            && is_array($advertisement[2])
        ) {
            $advertisementTwo = array_values(array_filter($advertisement[2]));
        }
    ?>

    <?php if($advertisementTwo): ?>
        <?php
            $isRendered = true;
        ?>

        <div class="container-fluid advertisement-two-container">
            <div class="row">
                <?php if( isset($advertisementTwo[0])): ?>
                    <a class="col-lg-9 col-md-12 no-padding">
                        <img
                            class="<?php echo e($isLazyLoad ? 'lazyload' : ''); ?>"
                            <?php if(! $isLazyLoad): ?> src="<?php echo e(Storage::url($advertisementTwo[0])); ?>" <?php endif; ?>
                            data-src="<?php echo e(Storage::url($advertisementTwo[0])); ?>" alt="" />
                    </a>
                <?php endif; ?>

                <?php if( isset($advertisementTwo[1])): ?>
                    <a class="col-lg-3 col-md-12 pr0">
                        <img
                            class="<?php echo e($isLazyLoad ? 'lazyload' : ''); ?>"
                            <?php if(! $isLazyLoad): ?> src="<?php echo e(Storage::url($advertisementTwo[1])); ?>" <?php endif; ?>
                            data-src="<?php echo e(Storage::url($advertisementTwo[1])); ?>" alt="" />
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php if(! $isRendered): ?>
    <div class="container-fluid advertisement-two-container">
        <div class="row">
            <a class="col-lg-9 col-md-12 no-padding">
                <img
                    class="<?php echo e($isLazyLoad ? 'lazyload' : ''); ?>"
                    <?php if(! $isLazyLoad): ?> src="<?php echo e(asset('/themes/velocity/assets/images/toster.webp')); ?>" <?php endif; ?>
                    data-src="<?php echo e(asset('/themes/velocity/assets/images/toster.webp')); ?>" alt="" />
            </a>

            <a class="col-lg-3 col-md-12 pr0">
                <img
                    class="<?php echo e($isLazyLoad ? 'lazyload' : ''); ?>"
                    <?php if(! $isLazyLoad): ?> src="<?php echo e(asset('/themes/velocity/assets/images/trimmer.webp')); ?>" <?php endif; ?>
                    data-src="<?php echo e(asset('/themes/velocity/assets/images/trimmer.webp')); ?>" alt="" />
            </a>
        </div>
    </div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\eshoplaravel/resources/themes/velocity/views/home/advertisements/advertisement-two.blade.php ENDPATH**/ ?>