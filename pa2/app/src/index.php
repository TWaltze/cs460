<?php
require_once('lib/models/Auth.php');
require_once('lib/controllers/Search.php');
require_once('lib/models/Photo.php');
require_once('lib/models/User.php');

$topUsers = Search::topUsers(10);
$popularPhotos = Search::popularPhotos(3);
$popularTags = Search::popularTags(10);
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

        <div class="cover">
            <?php foreach ($topUsers as $key => $user) { ?>
                <div class="cover__item">
                    <?php
                        $userPhotos = $user->getPhotos();

                        if(!empty($userPhotos)) {
                            echo "
                            <div class='cover__item__background'>
                                <img src='{$userPhotos[0]->data}' />
                            </div>";
                        }
                    ?>
                    <div class="cover__item__info">
                        <div class="cover__item__info--vertical-align">
                            <h1>#<?php echo $key + 1; ?></h1>
                            <h3><a href="/user.php?user=<?php echo $user->getUID(); ?>"><?php echo $user->firstName; ?></a></h3>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="container">
            <div class="col-xs-8">
                <h2>You may like these photos</h2>
                <div class="row">
                    <?php foreach ($popularPhotos as $key => $photo) { ?>
                        <?php
                            $p = Photo::find($photo['pid']);
                            $user = User::find($photo['owner']);
                        ?>
                        <div class="col-xs-4">
                            <div class="thumbnail">
                                <a href="/photo.php?photo=<?php echo $p->getPID(); ?>"><img src="<?php echo $p->data; ?>"></a>
                                <div class="caption">
                                    <h4>by <a href="/user.php?user=<?php echo $user->getUID(); ?>"><?php echo $user->firstName; ?></a> <span class="label label-primary pull-right">4 hours ago</span></h4>
                                    <p><?php echo count($p->getLikes()); ?> likes and <?php echo count($p->getComments()); ?> comments<p>
                                    <p>
                                        <?php
                                        foreach ($p->getTags() as $tag) {
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
            <div class="col-xs-4">
                <h2>Popular tags</h2>
                <div class="tag-cloud">
                    <?php
                    foreach ($popularTags as $tag) {
                        echo "<a href='/search.php?tag={$tag['tag']}' class='tag-cloud__tag'>{$tag['tag']} <span class='badge'>{$tag['count']}</span></a>";
                    }
                    ?>
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
