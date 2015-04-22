<?php
require_once('lib/models/Auth.php');
require_once('lib/models/Album.php');
require_once('lib/models/Photo.php');
require_once('lib/models/User.php');
require_once('lib/controllers/PhotoCtrl.php');
require_once('lib/utils/timeAgo.php');

$user = User::find(Auth::loggedInAs());
$albums = $user->getAlbums();
$alert = null;

if($_POST) {
    $alert = PhotoCtrl::create($_POST['album'], $_POST['newAlbum'], $_FILES['picture'], $_POST['caption'], $_POST['tags']);
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
        <?php require_once('partials/alert.php'); ?>

        <div class="container">
            <form method="post" class="login-form form-horizontal col-sm-6 col-md-offset-3" enctype="multipart/form-data">
                <div class="form-group form-group-lg">
                    <div class="col-xs-4" style="margin-left: 0; margin-right: 0; padding-left: 0;">
                        <select class="form-control" name="album">
                            <option value="0">New Album</option>
                            <?php foreach ($albums as $album) { ?>
                                <option value="<?php echo $album->getAID(); ?>"><?php echo $album->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-xs-8" style="margin-left: 0; padding-right: 0;">
                        <input type="text" name="newAlbum" class="form-control" placeholder="Title">
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-photo fa-2x"></i></span>
                        <input type="file" name="picture" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="3" placeholder="caption" name="caption"></textarea>
                </div>
                <div class="form-group form-group-lg">
                    <input type="text" name="tags" id="tags" class="form-control" placeholder="tag1, tag2, tag3">
                </div>
                <div class="form-group form-group-lg">
                    <div class="col-xs-4" style="margin-left: 0; margin-right: 0; padding-left: 0;">
                        <button class="recommendTags btn btn-lg btn-block btn-success pull-right">Recommend Tags</button>
                    </div>
                    <div class="col-xs-8 tag-cloud" style="margin-left: 0; padding-right: 0;"></div>
                </div>
                <div class="form-group form-group-lg">
                    <button type="submit" class="btn btn-lg btn-block btn-primary pull-right">Upload</button>
                </div>
            </form>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery.min.js"><\/script>')</script>

        <!-- Bootstrap Core: Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

        <script src="js/vendor/lodash.min.js"></script>
        <script src="js/main.js"></script>

        <script>
        $(document).ready(function() {
            $(".recommendTags").click(function(event) {
                event.preventDefault();

                $.getJSON("recommendTags.php?tags=" + $("#tags").val(), function(data) {
                    console.log(data);
                    var tags = [];
                    $.each(data, function(key, val) {
                        tags.push( "<button class='tag-cloud__tag' value='" + val + "'>" + val + "</button>" );
                    });

                    $(".tag-cloud").html(tags);
                });
            });

            $(".tag-cloud").on("click", ".tag-cloud__tag", function(event) {
                event.preventDefault();

                var tag = $(this).val();
                var currentTags = $("#tags").val();
                $("#tags").val(currentTags + ", " + tag);
            });
        });
        </script>

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
