<?php
require_once('lib/models/Auth.php');
require_once('lib/controllers/Search.php');
require_once('lib/models/User.php');
$tag = array_key_exists('tag', $_GET) ? preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['tag']) : "%";
$myAccount = array_key_exists('myAccount', $_GET) ? preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['myAccount']) : null;

if(array_key_exists('mine', $_GET)) {
    $user = Auth::loggedInAs();
} else {
    $user = null;
}

$photos = Search::photosByTag($tag, $user);
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
            <h2>Search for <?php echo $tag; ?></h2>
            <div class="btn-group vertical-rhythm">
                <a href="/search.php?tag=<?php echo $tag; ?>" class="btn btn-default">All Photos</a>

                <?php if(Auth::isLoggedIn()) { ?>
                    <a href="/search.php?tag=<?php echo $tag; ?>&mine" class="btn btn-default">My Photos</a>
                <?php } ?>
            </div>
            <div class="row">
                <?php foreach ($photos as $key => $photo) { ?>
                    <?php
                    $owner = User::find($photo->owner);
                    ?>
                    <div class="col-xs-3">
                        <div class="thumbnail">
                            <a href="/photo.php?photo=<?php echo $photo->getPID(); ?>"><img src="<?php echo $photo->data; ?>"></a>
                            <div class="caption">
                                <h4>by <a href="/user.php?user=<?php echo $owner->getUID(); ?>"><?php echo $owner->firstName; ?></a> <span class="label label-primary pull-right"><?php echo $photo->timeAgo(); ?></span></h4>
                                <p><?php echo count($photo->getLikes()); ?> likes and <?php echo count($photo->getComments()); ?> comments<p>
                                <p>
                                    <?php
                                    foreach ($photo->getTags() as $tag) {
                                        echo "<a href='/search.php?tag={$tag['tag']}' class='label label-default'>{$tag['tag']}</a> ";
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
