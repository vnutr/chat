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

<body>
<nav class="navbar navbar-inverse">
    <div class="container">
        <? if($base->Auth_model->is_logged_in()): ?>
            <a href="/auth/logout" class="btn pull-right"><i class="fa fa-power-off"></i></a>
            <a href="/" class="btn pull-right">Chat</a>
            <div class="header-hello-section"><?= 'Hello, '.$base->getUser()['first_name'].' '.$base->getUser()['last_name'] ?></div>
        <? endif; ?>
    </div>
</nav>
<div class="container">

    <div class="blog-header">
        <h1 class="blog-title"><?= $base->title ?></h1>
    </div>

    <div class="row">

        <div class="col-sm-12 blog-main">