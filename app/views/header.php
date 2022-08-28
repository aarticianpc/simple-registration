<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo APP_URL.'css/style.css' ?>" />
    <title>Simple Registration::<?php echo !empty($title) ? $title : ''; ?></title>
</head>
<body>

<div id="header">
    <div class="container">
        <nav>
            <ul>
                <li class="logo">
                    <a href="<?php echo APP_URL; ?>">SR</a>
                </li>
            </ul>

            <ul>
                <?php if(empty($_SESSION['user'])): ?>
                    <li class="nav-item <?php echo (!empty($action) && $action === 'login') ? 'active': ''; ?>">
                        <a class="nav-link" href="<?php echo APP_URL; ?>">Login</a>
                    </li>
                    <li class="nav-item <?php echo (!empty($action) && $action === 'register') ? 'active': ''; ?>">
                        <a class="nav-link" href="<?php echo APP_URL.'user/register'; ?>">Register</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item <?php echo (!empty($action) && $action === 'login') ? 'active': ''; ?>">
                        <a class="nav-link" href="<?php echo APP_URL.'user/logout'; ?>">Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>

<div class="container">
<?php if(!empty($success)) : ?>
    <div class="alert alert-success"><?php echo !empty($success)? $success : ''; ?></div>
<?php endif; ?>

<?php if(!empty($error)) : ?>
    <div class="alert alert-error"><?php echo !empty($error)? $error : ''; ?></div>
<?php endif; ?>

<?php if(!empty($warning)) : ?>
    <div class="alert alert-warning"><?php echo !empty($warning)? $warning : ''; ?></div>
<?php endif; ?>

<?php if(!empty($info)) : ?>
    <div class="alert alert-info"><?php echo !empty($info) ? $info : ''; ?></div>
<?php endif; ?>
</div>
