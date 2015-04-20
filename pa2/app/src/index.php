<?php
require_once('lib/controllers/Search.php');
require_once('lib/models/Photo.php');
require_once('lib/models/User.php');
$topUsers = Search::topUsers(12);
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
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">PicShare</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#">My photos</a></li>
                        <li><a href="#">Create album</a></li>
                        <li><a href="#">Friends</a></li>
                        <li><a href="#">Logout</a></li>
                    </ul>
                    <form class="navbar-form navbar-right" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="tags">
                        </div>
                        <button type="submit" class="btn btn-default">Search</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="cover">
            <?php foreach ($topUsers as $key => $user) { ?>
                <div class="cover__item">
                    <img src="http://lorempixel.com/300/300/" />
                    <div class="cover__item__info">
                        <div class="cover__item__info--vertical-align">
                            <h1>#<?php echo $key + 1; ?></h1>
                            <h3><a href="/user.php?user=<?php echo $user['uid']; ?>"><?php echo $user['firstName']; ?></a></h3>
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
                                <a href="/photo.php?photo=<?php echo $p->getPID(); ?>"><img src="http://lorempixel.com/300/300/"></a>
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
