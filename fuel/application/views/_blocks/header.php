<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo fuel_var('page_title', '') ?></title>
        <meta name="keywords" content="<?php echo fuel_var('meta_keywords') ?>">
        <meta name="description" content="<?php echo fuel_var('meta_description') ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <?php echo css('bootstrap.min') ?>
        <?php echo css('bootstrap-theme.min') ?>
        <?php echo css('font-awesome.min') ?>
        <?php echo css('main') ?>
        <?php echo css($css) ?>
        <?php echo js('vendor/modernizr-2.8.3-respond-1.4.2.min') ?>
        <?= jquery('1.11.2', 'vendor/jquery-1.11.2.min') ?>
    </head>
    <body role="document" class="<?php echo fuel_var('body_class', '') ?>">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="/"><?php echo $this->fuel->config('site_name') ?></a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <?php echo fuel_nav(array('container_tag_class' => 'nav navbar-nav topmenu', 'item_id_prefix' => 'topmenu_', 'subcontainer_tag_class' => array('dropdown-menu'))); ?>
                    </div><!--/.nav-collapse -->
                </div>
            </nav>