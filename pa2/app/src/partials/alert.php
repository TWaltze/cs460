<?php if($alert) { ?>
    <div class="alert alert-<?php echo $alert->class ?> remove-bottom-margin remove-radius" role="alert">
        <p class="container"><?php echo $alert->message; ?></p>
    </div>
<?php } ?>
