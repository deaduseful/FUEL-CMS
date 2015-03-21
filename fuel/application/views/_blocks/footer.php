<hr class="featurette-divider">
<footer class="footer">
    <div class="container">
        <div class="col-md-6 colophon">
            &copy; <?php echo $this->fuel->config('site_name') ?> <?php date('Y') ?> 
            &middot; <a href="/blog/">Blog</a>
        </div>
        <div class="col-md-6"><p class="pull-right"><a href="#">^</a></p></div>
    </div>
</footer>
<?php echo js('vendor/bootstrap.min') ?>
<?php echo js('plugins') ?>
<?php echo js('main') ?>
<?php echo js($js) ?>
</body>
</html>