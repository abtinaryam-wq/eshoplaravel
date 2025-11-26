<?php
    $isRendered = false;
    $advertisementFour = null;
    $isLazyLoad = ! isset($lazyload) ? true : ( $lazyload ? true : false );
?>

<?php if(
    $velocityMetaData
    && $velocityMetaData->advertisement
): ?>
    <?php
        $advertisement = json_decode($velocityMetaData->advertisement, true);

        if (
            isset($advertisement[4])
            && is_array($advertisement[4])
        ) {
            $advertisementFour = array_values(array_filter($advertisement[4]));
        }
    ?>

    <?php if($advertisementFour): ?>
        <?php
            $isRendered = true;
        ?>

        <div class="container-fluid advertisement-four-container">
            <div class="row">
                <div class="col-lg-4 col-12 advertisement-container-block no-padding">
                    <?php if(isset($advertisementFour[0])): ?>
                        <a <?php if(isset($one)): ?> href="<?php echo e($one); ?>" <?php endif; ?> aria-label="Advertisement">
                            <img
                                class="<?php echo e($isLazyLoad ? 'lazyload' : ''); ?>"
                                <?php if(! $isLazyLoad): ?> src="<?php echo e(Storage::url($advertisementFour[0])); ?>" <?php endif; ?>
                                data-src="<?php echo e(Storage::url($advertisementFour[0])); ?>" alt="" />
                        </a>
                    <?php endif; ?>
                </div>

                <div class="col-lg-4 col-12 advertisement-container-block offers-ct-panel">
                    <?php if(isset($advertisementFour[1])): ?>
                        <a <?php if(isset($two)): ?> href="<?php echo e($two); ?>" <?php endif; ?> class="row col-12 remove-padding-margin" aria-label="Advertisement">
                            <img
                                class="offers-ct-top <?php echo e($isLazyLoad ? 'lazyload' : ''); ?>"
                                <?php if(! $isLazyLoad): ?> src="<?php echo e(Storage::url($advertisementFour[1])); ?>" <?php endif; ?>
                                data-src="<?php echo e(Storage::url($advertisementFour[1])); ?>" alt="" />
                        </a>
                    <?php endif; ?>

                    <div style="height: 10px;"></div>

                    <?php if(isset($advertisementFour[2])): ?>
                        <a <?php if(isset($three)): ?> href="<?php echo e($three); ?>" <?php endif; ?> class="row col-12 remove-padding-margin" aria-label="Advertisement">
                            <img
                                class="offers-ct-bottom <?php echo e($isLazyLoad ? 'lazyload' : ''); ?>"
                                <?php if(! $isLazyLoad): ?> src="<?php echo e(Storage::url($advertisementFour[2])); ?>" <?php endif; ?>
                                data-src="<?php echo e(Storage::url($advertisementFour[2])); ?>" alt="" />
                        </a>
                    <?php endif; ?>
                </div>

                <div class="col-lg-4 col-12 advertisement-container-block no-padding">
                    <?php if(isset($advertisementFour[3])): ?>
                        <a <?php if(isset($four)): ?> href="<?php echo e($four); ?>" <?php endif; ?> aria-label="Advertisement">
                            <img
                                class="<?php echo e($isLazyLoad ? 'lazyload' : ''); ?>"
                                <?php if(! $isLazyLoad): ?> src="<?php echo e(Storage::url($advertisementFour[3])); ?>" <?php endif; ?>
                                data-src="<?php echo e(Storage::url($advertisementFour[3])); ?>" alt="" />
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php if(! $isRendered): ?>
    <div class="container-fluid advertisement-four-container">
        <div class="row">
            <div class="col-lg-4 col-12 advertisement-container-block no-padding">
                <a <?php if(isset($one)): ?> href="<?php echo e($one); ?>" <?php endif; ?> aria-label="Advertisement">
                    <img
                        class="<?php echo e($isLazyLoad ? 'lazyload' : ''); ?>"
                        <?php if(! $isLazyLoad): ?> src="<?php echo e(asset('/themes/velocity/assets/images/big-sale-banner.webp')); ?>" <?php endif; ?>
                        data-src="<?php echo e(asset('/themes/velocity/assets/images/big-sale-banner.webp')); ?>" alt="" />
                </a>
            </div>

            <div class="col-lg-4 col-12 advertisement-container-block offers-ct-panel">
                <a <?php if(isset($two)): ?> href="<?php echo e($two); ?>" <?php endif; ?> aria-label="Advertisement">
                    <img
                        class="offers-ct-top <?php echo e($isLazyLoad ? 'lazyload' : ''); ?>"
                        <?php if(! $isLazyLoad): ?> src="<?php echo e(asset('/themes/velocity/assets/images/seasons.webp')); ?>" <?php endif; ?>
                        data-src="<?php echo e(asset('/themes/velocity/assets/images/seasons.webp')); ?>" alt="" />
                </a>

                <div style="height: 10px;"></div>

                <a <?php if(isset($three)): ?> href="<?php echo e($three); ?>" <?php endif; ?> aria-label="Advertisement">
                    <img
                        class="offers-ct-bottom <?php echo e($isLazyLoad ? 'lazyload' : ''); ?>"
                        <?php if(! $isLazyLoad): ?> src="<?php echo e(asset('/themes/velocity/assets/images/deals.webp')); ?>" <?php endif; ?>
                        data-src="<?php echo e(asset('/themes/velocity/assets/images/deals.webp')); ?>" alt="" />
                </a>
            </div>

            <div class="col-lg-4 col-12 advertisement-container-block no-padding">
                <a <?php if(isset($four)): ?> href="<?php echo e($four); ?>" <?php endif; ?> aria-label="Advertisement">
                    <img
                        class="<?php echo e($isLazyLoad ? 'lazyload' : ''); ?>"
                        <?php if(! $isLazyLoad): ?> src="<?php echo e(asset('/themes/velocity/assets/images/kids.webp')); ?>" <?php endif; ?>
                        data-src="<?php echo e(asset('/themes/velocity/assets/images/kids.webp')); ?>" alt="" />
                </a>
            </div>
        </div>
    </div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\eshoplaravel/resources/themes/velocity/views/home/advertisements/advertisement-four.blade.php ENDPATH**/ ?>