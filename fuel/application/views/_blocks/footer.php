<hr class="featurette-divider">
<footer class="footer">
    <div class="container">
        <div class="col-md-6 colophon">
            &copy; <?php echo fuel_var('site_name') ?> <?php date('Y') ?> 
            &middot; <a href="/blog/">Blog</a>
        </div>
        <div class="col-md-6"><p class="pull-right"><a href="#">^</a></p></div>
    </div>
</footer>
<?php echo js('vendor/bootstrap.min') ?>
<?php echo js('plugins') ?>
<?php echo js('main') ?>
<?php echo js($js) ?>
<script>
    (function (b, o, i, l, e, r) {
        b.GoogleAnalyticsObject = l;
        b[l] || (b[l] =
                function () {
                    (b[l].q = b[l].q || []).push(arguments)
                });
        b[l].l = +new Date;
        e = o.createElement(i);
        r = o.getElementsByTagName(i)[0];
        e.src = '//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e, r)
    }(window, document, 'script', 'ga'));
    ga('create', '<?php echo fuel_var('analytics_id') ?>', 'auto');
    ga('send', 'pageview');
</script>
</body>
</html>