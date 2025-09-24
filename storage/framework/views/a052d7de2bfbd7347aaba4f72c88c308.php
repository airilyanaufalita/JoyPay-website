<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title', 'Admin Panel'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            margin: 0;
        }
        .sidebar {
            width: 250px;
            background: #2d2d2d;
            min-height: 100vh;
            color: white;
        }
        .sidebar a {
            display: block;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #444;
        }
        .content {
            flex: 1;
            padding: 20px;
            background: #f4f6f9;
        }
    </style>
</head>
<body>

    
    <?php echo $__env->make('pages.admin.layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div class="content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\joypayy\resources\views/pages/admin/layouts/app.blade.php ENDPATH**/ ?>