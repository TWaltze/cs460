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
        <div class="cover push-down">
            <img class="img-responsive center-block" src="http://lorempixel.com/1500/500/">
        </div>
        <div class="container">
            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            <ul class="list-inline">
                <li>By <a href="">username</a></li>
                <li>Posted 4 days ago</li>
                <li>163 likes</li>
                <li>33 comments</li>
            </ul>
            <ul class="list-inline">
                <li><a href="#" class="label label-default">tag</a></li>
                <li><a href="#" class="label label-default">tag</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="col-xs-8">
                <h3>Comments</h3>
                <div>
                    <h4><a href="">username</a></h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <small class="">posted 4 days ago</small>
                </div>
                <div>
                    <h4><a href="">username</a></h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <small class="">posted 4 days ago</small>
                </div>
            </div>
            <div class="col-xs-4">
                <h3>Likes</h3>
                <ul class="list-inline">
                    <li><a href="">username</a></li>
                    <li><a href="">username</a></li>
                    <li><a href="">username</a></li>
                    <li><a href="">username</a></li>
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
