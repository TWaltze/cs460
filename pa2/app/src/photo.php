<?php
require_once('lib/models/Auth.php');
require_once('lib/models/Album.php');
require_once('lib/models/Photo.php');
require_once('lib/models/User.php');
require_once('lib/controllers/PhotoCtrl.php');
require_once('lib/utils/timeAgo.php');

$id = intval(preg_replace('/\D/', '', $_GET['photo']));
$photo = Photo::find($id);
$owner = User::find($photo->owner);
$tags = $photo->getTags();
$alert = null;

if(array_key_exists('like', $_GET)) {
    $alert = PhotoCtrl::like($photo->getPID());
}

if(array_key_exists('delete', $_GET) && $owner->getUID() == Auth::loggedInAs()) {
    $photo->delete();
    header("Location: /album.php?album={$photo->album}");
}

if(array_key_exists('comment', $_POST)) {
    $alert = PhotoCtrl::comment($photo->getPID(), $_POST['comment']);
}

$comments = $photo->getComments();
$likes = $photo->getLikes();
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

        <div class="cover push-down">
            <img class="img-responsive center-block" src="<?php echo $photo->data; ?>">
        </div>
        <div class="container">
            <p class="lead"><?php echo $photo->caption; ?></p>
            <ul class="list-inline">
                <li>By <a href="/user.php?user=<?php echo $owner->getUID(); ?>"><?php echo $owner->firstName . " " . $owner->lastName; ?></a></li>
                <li>Posted <?php echo $photo->timeAgo(); ?></li>
                <li><?php echo count($likes); ?> likes</li>
                <li><?php echo count($comments); ?> comments</li>

                <?php if (Auth::isLoggedIn()) { ?>
                    <?php
                        if ($photo->likedByUser(Auth::loggedInAs())) {
                            $likeStyle = "danger";
                        } else {
                            $likeStyle = "success";
                        }
                    ?>
                    <li><a href="<?php echo strtok($_SERVER["REQUEST_URI"],'?') . "?photo={$photo->getPID()}"; ?>&like" class="btn btn-<?php echo $likeStyle; ?>" style="line-height: normal;" role="button"><i class="fa fa-thumbs-up fa-2x"></i></a></li>
                <?php } ?>

                <?php if ($owner->getUID() == Auth::loggedInAs()) { ?>
                    <li><a href="<?php echo strtok($_SERVER["REQUEST_URI"],'?') . "?photo={$photo->getPID()}"; ?>&delete" class="btn btn-danger" style="line-height: normal;" role="button"><i class="fa fa-trash fa-2x"></i></a></li>
                <?php } ?>
            </ul>
            <ul class="list-inline">
                <?php
                foreach ($photo->getTags() as $tag) {
                    echo "<li><a href='/search.php?tag={$tag['tag']}' class='label label-default'>{$tag['tag']}</a></li> ";
                }
                ?>
            </ul>
        </div>
        <div class="container">
            <div class="col-xs-8">
                <h3>Comments</h3>
                <?php foreach ($comments as $comment) { ?>
                    <?php
                    if($comment['author']) {
                        $author = User::find($comment['author']);
                        $uid = $author->getUID();
                        $name = $author->firstName . " " . $author->lastName;
                    } else {
                        $uid = null;
                        $name = "Anon";
                    }
                    ?>
                    <div>
                        <h4>
                            <?php
                            if($uid) {
                                echo "<a href='/user.php?user=$uid'>$name</a>";
                            } else {
                                echo $name;
                            }
                            ?>
                        </h4>
                        <p><?php echo $comment['comment']; ?></p>
                        <small class="">posted <?php echo timeAgo($comment['createdAt']); ?></small>
                    </div>
                <?php } ?>
                <div>
                    <h4>Add Comment</h4>
                    <form method="post" action="">
                        <div class="form-group">
                            <textarea class="form-control" rows="3" placeholder="comment" name="comment"></textarea>
                        </div>
                        <input type="submit" value="post" class="btn btn-primary pull-right" />
                    </form>
                </div>
            </div>
            <div class="col-xs-4">
                <h3>Likes</h3>
                <ul class="list-inline">
                    <?php
                    foreach ($likes as $like) {
                        $user = User::find($like['user']);
                        echo "<li><a href='/user.php?user={$user->getUID()}'>{$user->firstName}</a></li>";
                    }
                    ?>
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
