<?php
require_once('lib/models/Auth.php');
require_once('lib/models/User.php');
require_once('lib/controllers/UserCtrl.php');

$id = intval(preg_replace('/\D/', '', $_GET['user']));
$user = User::find($id);
$alert = null;

if(array_key_exists('friend', $_GET)) {
    $alert = UserCtrl::friend($user->getUID());
}

if(array_key_exists('delete', $_GET)) {
    $alert = UserCtrl::deleteAlbum($_GET['delete']);
}

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
        <?php require('partials/alert.php'); ?>

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
                                <a href="/album.php?album=<?php echo $album->getAID(); ?>"><img src="<?php echo $photos[0]->data; ?>"></a>
                                <div class="caption">
                                    <h4><a href="/album.php?album=<?php echo $album->getAID(); ?>"><?php echo $album->name; ?></a></h4>
                                    <ul class="list-group">
                                        <li class="list-group-item">Created <?php echo $album->timeAgo(); ?></li>
                                        <li class="list-group-item">Contains <?php echo count($photos); ?> photos</li>
                                        <li class="list-group-item">
                                            <a href="?user=<?php echo $user->getUID(); ?>&delete=<?php echo $album->getAID();?>" class="btn btn-danger btn-block">
                                                Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-4">
                <h2>
                    Profile

                    <?php if (Auth::isLoggedIn() && Auth::loggedInAs() != $user->getUID()) { ?>
                        <?php
                            if ($user->isFriendsWith(Auth::loggedInAs())) {
                                $friendStyle = "danger";
                                $friendText = "remove as friend";
                            } else {
                                $friendStyle = "success";
                                $friendText = "add as friend";
                            }
                        ?>

                        <a href="<?php echo strtok($_SERVER["REQUEST_URI"],'?') . "?user={$user->getUID()}"; ?>&friend" class="btn btn-<?php echo $friendStyle; ?> btn" style="line-height: normal;" role="button">
                            <?php echo $friendText; ?>
                        </a>

                    <?php } ?>
                </h2>
                <ul class="list-group">
                    <?php if($user->firstName || $user->lastName) { ?>
                    <li class="list-group-item"><?php echo $user->firstName . " " . $user->lastName; ?></li>
                    <?php } ?>

                    <?php if($user->dob) { ?>
                    <li class="list-group-item"><?php echo $user->dob; ?></li>
                    <?php } ?>

                    <?php if($user->gender) { ?>
                    <li class="list-group-item"><?php echo $user->gender; ?></li>
                    <?php } ?>

                    <?php if($user->city || $user->state || $user->country) { ?>
                    <li class="list-group-item">
                        <?php
                            echo $user->city . " " . $user->state;

                            if($user->state && $user->country) {
                                echo ", ";
                            }

                            echo $user->country;
                        ?>
                    </li>
                    <?php } ?>

                    <?php if($user->school) { ?>
                    <li class="list-group-item"><?php echo $user->school; ?></li>
                    <?php } ?>
                </ul>
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
