<?php
require_once('lib/models/Auth.php');
require_once('lib/models/User.php');
require_once('lib/controllers/Search.php');

$user = User::find(Auth::loggedInAs());
$friends = $user->getFriends();
$alert = null;

$users = [];
if(array_key_exists('search', $_GET)) {
    $users = Search::users($_GET['search']);
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
        <?php require('partials/alert.php'); ?>

        <div class="container">
            <div class="col-xs-8">
                <h2>Your Friends (<?php echo count($friends); ?>)</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Profile</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($friends as $friend) { ?>
                            <tr>
                                <td><?php echo $friend->firstName; ?></td>
                                <td><?php echo $friend->lastName; ?></td>
                                <td><?php echo $friend->email; ?></td>
                                <td><a href="user.php?user=<?php echo $friend->getUID(); ?>">Profile</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-xs-4">
                <h2>Search</h2>
                <form action="" class="form-group">
                    <div class="input-group">
                        <input type="email" class="form-control" name="search" placeholder="email">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>

                <div class="list-group">
                    <?php foreach ($users as $user) { ?>
                        <a href="user.php?user=<?php echo $user->getUID(); ?>" class="list-group-item"><?php echo $user->firstName . " " . $user->lastName; ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php require('partials/footer.php'); ?>

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
