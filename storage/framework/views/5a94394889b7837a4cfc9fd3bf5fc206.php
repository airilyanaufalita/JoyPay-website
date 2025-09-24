<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo e($title ?? 'JoyPay'); ?></title>
    <style>

    </style>
</head>
<body>
<?php
        $page = $page ?? 'default';
        echo '<!-- Debug: Page set to ' . $page . ' -->';  // Tambah ini buat cek
    ?>
<?php if(!in_array($page ?? '', ['forgot-password', 'reset-password', 'login', 'register', 'kloter-bergabung', 'kloter-user'])): ?>
    <?php if(auth()->guard()->check()): ?>
        <?php echo $__env->make('layouts.header-user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
<?php endif; ?>

    <main>
        
        <?php
            $page = $page ?? 'default';
        ?>

        <?php switch($page):
            case ('dashboard'): ?>
                <?php echo $__env->make('pages.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>

            <?php case ('home'): ?>
                <?php echo $__env->make('pages.home', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>

            <?php case ('informasi'): ?>
                <?php echo $__env->make('pages.informasi', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>

            <?php case ('kamus'): ?>
                <?php echo $__env->make('pages.kamus', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>

<?php case ('profil'): ?>
    <?php echo $__env->make('profile.profil', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php break; ?>
<?php case ('kloter'): ?>
    <?php echo $__env->make('kloters.index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php break; ?>
            <?php case ('kloteraktif'): ?>
                <?php echo $__env->make('pages.kloteraktif', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>
                <?php case ('kloter-detail'): ?>
    <?php echo $__env->make('pages.kloter-detail', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php break; ?>
    <?php case ('kloter-bergabung'): ?>
    <?php echo $__env->make('pages.kloter-bergabung', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php break; ?>
        <?php case ('kloter-bayar'): ?>
    <?php echo $__env->make('pages.kloter-bayar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php break; ?>
        <?php case ('kloter-user'): ?>
    <?php echo $__env->make('pages.kloter-user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php break; ?>
 <?php case ('forgot-password'): ?>
    <?php echo $__env->make('auth.forgot-password', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php break; ?>
        
<?php case ('reset-password'): ?>
    <?php echo $__env->make('auth.reset-password', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php break; ?>

    <?php case ('pemenang'): ?>
    <?php echo $__env->make('pages.pemenang', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php break; ?>
<?php case ('pemenang-detail'): ?>
    <?php echo $__env->make('pages.pemenang-detail', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php break; ?>

            <?php case ('login'): ?>
                <?php echo $__env->make('auth.login', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php break; ?>

            <?php case ('register'): ?>
                <?php echo $__env->make('auth.register', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> 
                <?php break; ?>

            <?php default: ?>
                <p>Halaman tidak ditemukan</p>
        <?php endswitch; ?>
    </main>
    <?php if(!in_array($page ?? '', ['forgot-password', 'reset-password', 'login', 'register', 'kloter-bergabung', 'kloter-user'])): ?>
        <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\joypayy\resources\views/layouts/app.blade.php ENDPATH**/ ?>