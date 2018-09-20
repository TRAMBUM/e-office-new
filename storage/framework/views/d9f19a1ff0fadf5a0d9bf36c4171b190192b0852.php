<!DOCTYPE html>
<?php
$locale = Helpers::getLocale(); //return vi, en, zh, ja
?>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Diginet Corp.">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>eOFFICE</title>
    <?php echo $__env->make('layouts.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
<div class="app-body">
    <?php echo $__env->make('layouts.container', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
</body>
<?php echo $__env->yieldContent('script'); ?>
<div id="spinLoading" class="loading hide">Loading&#8230;</div>
</html>
<style>


</style>