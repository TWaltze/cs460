<?php
require_once('lib/controllers/UserCtrl.php');

$email = array_key_exists('email', $_POST) ? $_POST['email'] : null;
$first = array_key_exists('first', $_POST) ? $_POST['first'] : null;
$last = array_key_exists('last', $_POST) ? $_POST['last'] : null;
$dob = array_key_exists('dob', $_POST) ? $_POST['dob'] : null;
$password = array_key_exists('password', $_POST) ? $_POST['password'] : null;
$alert = null;

if($_POST) {
    $alert = UserCtrl::create(
        $email,
        $password,
        $first,
        $last,
        $dob
    );
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
        <?php require('partials/header.php'); ?>
        <?php require_once('partials/alert.php'); ?>

        <div class="container">
            <form method="post" class="login-form form-horizontal col-sm-6 col-md-offset-3">
                <div class="form-group form-group-lg">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>">
                </div>
                <div class="row">
                    <div class="form-group form-group-lg col-xs-6" style="margin-left: 0; margin-right: 0; padding-left: 0;">
                        <input type="text" name="first" class="form-control" placeholder="First Name" value="<?php echo $first; ?>">
                    </div>
                    <div class="form-group form-group-lg col-xs-6" style="margin-left: 0; padding-right: 0;">
                        <input type="text" name="last" class="form-control" placeholder="Last Name" value="<?php echo $last; ?>">
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <input type="text" name="dob" class="form-control" placeholder="Birthday" value="<?php echo $dob; ?>">
                </div>
                <div class="form-group form-group-lg">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group form-group-lg">
                    <button type="submit" class="btn btn-lg btn-block btn-primary pull-right">Register</button>
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
