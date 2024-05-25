<?php $__env->startSection('title', translate('My_Shopping_Cart')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta property="og:image" content="<?php echo e(dynamicStorage(path: 'storage/app/public/company')); ?>/<?php echo e($web_config['web_logo']->value); ?>"/>
    <meta property="og:title" content="<?php echo e($web_config['name']->value); ?> "/>
    <meta property="og:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="og:description"
          content="<?php echo e(substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160)); ?>">

    <meta property="twitter:card" content="<?php echo e(dynamicStorage(path: 'storage/app/public/company')); ?>/<?php echo e($web_config['web_logo']->value); ?>"/>
    <meta property="twitter:title" content="<?php echo e($web_config['name']->value); ?>"/>
    <meta property="twitter:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="twitter:description"
          content="<?php echo e(substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160)); ?>">
    <link rel="stylesheet" href="<?php echo e(dynamicStorage(path: 'public/assets/front-end/css/shop-cart.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-3 rtl px-0 px-md-3 text-align-direction" id="cart-summary">
        <?php echo $__env->make(VIEW_FILE_NAMES['products_cart_details_partials'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        cartQuantityInitialize();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.front-end.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u245523406/domains/neobooz.com/public_html/resources/themes/default/web-views/cart/cart-list.blade.php ENDPATH**/ ?>