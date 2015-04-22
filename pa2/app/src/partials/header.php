<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/models/Auth.php"); ?>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">PicShare</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php if(Auth::isLoggedIn()) { ?>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/">Home</a></li>
                    <li><a href="/user.php?user=<?php echo Auth::loggedInAs(); ?>">My photos</a></li>
                    <li><a href="/upload.php">Upload Photo</a></li>
                    <li><a href="/friends.php">Friends</a></li>
                    <li><a href="/logout.php">Logout</a></li>
                </ul>
            <?php } else { ?>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="/login.php">Login</a></li>
                    <li><a href="/register.php">Register</a></li>
                </ul>
            <?php } ?>
            <form action="/search.php" class="navbar-form navbar-right" role="search">
                <div class="form-group">
                    <input type="text" name="tag" class="form-control" placeholder="tag">
                </div>
                <button type="submit" class="btn btn-default">Search</button>
            </form>
        </div>
    </div>
</nav>
