<!-- Title -->
<title>
    <?php echo $__env->yieldContent('title'); ?>
</title>




<?php echo $__env->yieldContent('css'); ?>


<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



<?php if(App::getlocale() == 'en' || App::getlocale() == 'fr'): ?>
    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(URL::asset('assets/img/brand/favicon.png'), false); ?>?v=<?php echo e(time(), false); ?>" type="image/x-icon" />
    <!-- Icons css -->
    <link href="<?php echo e(URL::asset('assets/css/icons.css'), false); ?>" rel="stylesheet">
    <!--  Custom Scroll bar-->
    <link href="<?php echo e(URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.css'), false); ?>" rel="stylesheet" />
    <!--  Right-sidemenu css -->
    <link href="<?php echo e(URL::asset('assets/plugins/sidebar/sidebar.css'), false); ?>" rel="stylesheet">
    <!-- Sidemenu css -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('assets/css/sidemenu.css'), false); ?>">
    <!-- Maps css -->
    <link href="<?php echo e(URL::asset('assets/plugins/jqvmap/jqvmap.min.css'), false); ?>" rel="stylesheet">
    <!-- style css -->
    <link href="<?php echo e(URL::asset('assets/css/style.css'), false); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/css/style-dark.css'), false); ?>" rel="stylesheet">
    <!---Skinmodes css-->
    <link href="<?php echo e(URL::asset('assets/css/skin-modes.css'), false); ?>" rel="stylesheet" />
<?php else: ?>
    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(URL::asset('assets/img/brand/favicon.png'), false); ?>?v=<?php echo e(time(), false); ?>" type="image/x-icon" />
    <!-- Icons css -->
    <link href="<?php echo e(URL::asset('assets/css/icons.css'), false); ?>" rel="stylesheet">
    <!--  Custom Scroll bar-->
    <link href="<?php echo e(URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.css'), false); ?>" rel="stylesheet" />
    <!--  Sidebar css -->
    <link href="<?php echo e(URL::asset('assets/plugins/sidebar/sidebar.css'), false); ?>" rel="stylesheet">
    <!-- Sidemenu css -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('assets/css-rtl/sidemenu.css'), false); ?>">
    <!--- Style css -->
    <link href="<?php echo e(URL::asset('assets/css-rtl/style.css'), false); ?>" rel="stylesheet">
    <!--- Dark-mode css -->
    <link href="<?php echo e(URL::asset('assets/css-rtl/style-dark.css'), false); ?>" rel="stylesheet">
    <!---Skinmodes css-->
    <link href="<?php echo e(URL::asset('assets/css-rtl/skin-modes.css'), false); ?>" rel="stylesheet">
<?php endif; ?>

<!-- Custom Logo Styling -->
<style>
    /* Logo above red line - outside menu */
    .sidebar-logo-container {
        padding: 5px 10px 0 !important;
        text-align: center;
        background: transparent;
        margin-bottom: 0 !important;
    }

    .sidebar-logo-link {
        display: inline-block;
    }

    .sidebar-main-logo {
        max-width: 140px;
        height: auto;
        display: block;
        margin: 0 auto;
    }

    /* Remove top margin from main-sidemenu to stick to logo */
    .app-sidebar .main-sidemenu {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    /* Remove top spacing from first category */
    .app-sidebar .side-menu .side-item-category:first-child {
        margin-top: 0 !important;
        padding-top: 8px !important;
    }

    /* Dark mode */
    .dark-mode .sidebar-logo-container {
        background: transparent;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .sidebar-logo-container {
            padding: 5px 8px 0 !important;
        }

        .sidebar-main-logo {
            max-width: 110px;
        }
    }
</style>
<?php /**PATH C:\Herd\MDSJEDPR\resources\views/layouts/head.blade.php ENDPATH**/ ?>