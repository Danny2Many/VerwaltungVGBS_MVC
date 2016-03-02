<?php $view->extend('base.html.php') ?>

<?php $view['slots']->start('body') ?>
    <h1>String: <?php echo $view->escape($String) ?>
<?php $view['slots']->stop() ?>