<?php
require_once('lib/controllers/UserCtrl.php');

$error = null;
if($_POST) {
    $error = UserCtrl::login($_POST['email'], $_POST['password']);
}
?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">

        <link rel="stylesheet" href="styles/main.css">

        <script src="js/vendor/modernizr.min.js"></script>
    </head>
    <body>
        <?php require_once('partials/header.php'); ?>

        <div class="container">
            <form method="post" class="login-form form-horizontal col-sm-6 col-md-offset-3">
                <div class="form-group form-group-lg">
                    <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                </div>
                <div class="form-group form-group-lg">
                    <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
                </div>
                <div class="form-group form-group-lg">
                    <?php if ($error) {?>
                        <div class="alert alert-danger col-sm-8" role="alert"><?php echo $error; ?></div>
                    <?php } else { ?>
                        <div class="col-sm-8" role="alert"></div>
                    <?php } ?>
                    <div class="col-sm-4 button-container">
                        <button type="submit" class="btn btn-lg btn-block btn-primary pull-right">Login</button>
                    </div>
                </div>
            </form>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery.min.js"><\/script>')</script>

        <!-- Bootstrap Core: Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

        <script src="js/vendor/lodash.min.js"></script>
        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script>
    </body>
</html>
