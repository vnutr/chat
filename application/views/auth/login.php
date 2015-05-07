<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <? /*<link rel="icon" href="../../favicon.ico"> */ ?>

    <title><?= $this->page_name ?></title>

    <?php foreach($base->getCSS() as $css): ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url() . "css/$css" ?>" />
    <?php endforeach; ?>

    <?php if(!empty($this->_js_variables)): ?>
        <script type="text/javascript">
            <?php foreach($this->_js_variables as $var_key => $var_value): ?>
            <?php if(is_numeric($var_value)): ?>
            window.<?= $var_key ?> = <?= $var_value ?>;
            <?php else: ?>
            window.<?= $var_key ?> = '<?= $var_value ?>';
            <?php endif; ?>
            <?php endforeach; ?>
        </script>
    <?php endif; ?>

    <?php foreach($base->getJS() as $key_js => $value_js): ?>
        <?php if($value_js == Base_Controller::SCRIPT_HEAD): ?>
            <script src="<?= base_url() . "js/$key_js" ?>" type="text/javascript"></script>
        <?php endif ?>
    <?php endforeach; ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="<?= $this->router->class .'_'. $this->router->method ?>">

<div class="container">
    <form class="form-signin" method="post">
        <? if(!empty($errors)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $errors['Login'] ?>
            </div>
        <? endif; ?>
        <h2 class="form-signin-heading"><?= lang('auth_please_sign_in') ?></h2>
        <label for="inputEmail" class="sr-only"><?= lang('auth_email_address') ?></label>
        <input name="Login[email]" type="email" id="inputEmail" class="form-control" placeholder="<?= lang('auth_email_address') ?>" required autofocus>
        <label for="inputPassword" class="sr-only"><?= lang('auth_password') ?></label>
        <input name="Login[password]" type="password" id="inputPassword" class="form-control" placeholder="<?= lang('auth_password') ?>" required>
        <div class="checkbox">
            <label>
                <input name="Login[rememberMe]" type="checkbox" value="remember-me"><?= lang('auth_remember_me') ?>
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit"><?= lang('auth_sign_in') ?></button>
    </form>

</div> <!-- /container -->

<?php foreach($base->getJS() as $key_js => $value_js): ?>
    <?php if($value_js == Base_Controller::SCRIPT_FOOTER): ?>
        <script src="<?= base_url() . "js/$key_js" ?>" type="text/javascript"></script>
    <?php endif ?>
<?php endforeach; ?>
</body>
</html>
