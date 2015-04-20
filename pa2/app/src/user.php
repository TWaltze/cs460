<?php
require_once('lib/models/User.php');
$id = intval(preg_replace('/\D/', '', $_GET['user']));
$user = User::find($id);
$albums = $user->getAlbums();
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

        <div class="container">
            <div class="col-xs-8">
                <h2><?php echo $user->firstName; ?>'s albums</h2>
                <div class="row">
                    <?php foreach ($albums as $key => $album) { ?>
                        <?php
                        $photos = $album->getPhotos();
                        ?>
                        <div class="col-xs-4">
                            <div class="thumbnail">
                                <a href="/album.php?album=<?php echo $album->getAID(); ?>"><img src="http://lorempixel.com/300/300/"></a>
                                <div class="caption">
                                    <h4><a href="/album.php?album=<?php echo $album->getAID(); ?>"><?php echo $album->name; ?></a></h4>
                                    <ul class="list-group">
                                        <li class="list-group-item">Created <?php echo $album->timeAgo(); ?></li>
                                        <li class="list-group-item">Contains <?php echo count($photos); ?> photos</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-4">
                <h2>Profile</h2>
                <ul class="list-group">
                    <li class="list-group-item"><?php echo $user->firstName . " " . $user->lastName; ?></li>
                    <li class="list-group-item"><?php echo $user->dob; ?></li>
                    <li class="list-group-item"><?php echo $user->gender; ?></li>
                    <li class="list-group-item"><?php echo $user->city . " " . $user->state . ", " . $user->country; ?></li>
                    <li class="list-group-item"><?php echo $user->school; ?></li>
                </ul>
            </div>
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
