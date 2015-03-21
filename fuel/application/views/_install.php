<?php fuel_set_var('page_title', 'Welcome to FUEL CMS') ?>
<?php fuel_set_var('heading', 'Welcome to FUEL CMS v' . FUEL_VERSION) ?>
<section>
    <header>
        <div class="col-md-2 icon_block">
            <span class="glyphicon glyphicon-edit"></span>
        </div>
        <div class="col-md-8">
            <h3>Getting Started</h3>
        </div>
    </header>
    <ol>
        <li>
            <div class="col-md-2 icon_block">
                <div class="circle">1</div>
            </div>
            <div class="col-md-8">
                <h4>Change the Apache .htaccess file</h4>
                <p>Change the Apache .htaccess found at the root of FUEL CMS's installation folder to the proper RewriteBase directory. The default is your web server's root directory (e.g "/"), but if you have FUEL CMS installed in a sub folder, you will need to add the path to line 5.
                    If you are using the folder it was zipped up in from GitHub, it would be <strong>RewriteBase /FUEL-CMS-master/</strong>.</p>
                <p>In some server environments, you may need to add a "?" after index.php in the .htaccess like so: <code>RewriteRule .* index.php?/$0 [L]</code></p>
                <p class="callout"><strong>NOTE:</strong> This is the only step needed if you want to use FUEL <em>without</em> the CMS.</p>
            </div>
        </li>
        <li>
            <div class="col-md-2 icon_block">
                <div class="circle">2</div>
            </div>
            <div class="col-md-8">
                <h4>Install the database</h4>
                <p>Install the FUEL CMS database by first creating the database in MySQL and then importing the <strong>fuel/install/fuel_schema.sql</strong> file. After creating the database, change the database configuration found in <strong>fuel/application/config/database.php</strong> to include your hostname (e.g. localhost), username, password and the database to match the new database you created.</p>
            </div>
        </li>
        <li>
            <div class="col-md-2 icon_block">
                <div class="circle">3</div>
            </div>
            <div class="col-md-8">
                <h4>Make folders writable</h4>
                <p>Make the following folders writable (666 = rw-rw-rw, 777 = rwxrwxrwx, etc.):</p>
                <ul class="writable">
                    <li class="alert alert-<?= (is_really_writable(APPPATH . 'cache/')) ? 'success' : 'danger'; ?>">
                        <strong><?= APPPATH . 'cache/' ?></strong><br><span>(folder for holding cache files)</span>
                    </li>
                    <li class="alert alert-<?= (is_really_writable(APPPATH . 'cache/dwoo/')) ? 'success' : 'danger'; ?>">
                        <strong><?= APPPATH . 'cache/dwoo/' ?></strong><br><span>(folder for holding template cache files)</span>
                    </li>
                    <li class="alert alert-<?= (is_really_writable(APPPATH . 'cache/dwoo/compiled')) ? 'success' : 'danger'; ?>">
                        <strong><?= APPPATH . 'cache/dwoo/compiled' ?></strong><br><span>(for writing compiled template files)</span>
                    </li>
                    <li class="alert alert-<?= (is_really_writable(assets_server_path('', 'images'))) ? 'success' : 'danger'; ?>">
                        <strong><?= WEB_ROOT . 'assets/images' ?></strong><br><span>(for managing image assets in the CMS)</span>
                    </li>
                </ul>
            </div>
        </li>

        <?php
        if ($this->config->item('encryption_key') == '' OR
                $this->config->item('fuel_mode', 'fuel') == 'views' OR ! $this->config->item('admin_enabled', 'fuel')
        ) :
            ?>
            <li>
                <div class="col-md-2 icon_block">
                    <div class="circle">4</div>
                </div>
                <div class="col-md-8">
                    <h4>Make configuration changes</h4>
                    <ul class="writable">
                        <?php if ($this->config->item('encryption_key') == '') : ?>
                            <li>In the <strong>fuel/application/config/config.php</strong>, <a href="http://jeffreybarke.net/tools/codeigniter-encryption-key-generator/">change the <code>$config['encryption_key']</code> to your own unique key</a>.</li></li>
                        <?php endif; ?>
                        <?php if (!$this->config->item('admin_enabled', 'fuel')) : ?>
                            <li>In the <strong>fuel/application/config/MY_fuel.php</strong> file, change the <code>$config['admin_enabled']</code> configuration property to <code>TRUE</code>. If you do not want the CMS accessible, leave it as <strong>FALSE</strong>.</li>
                        <?php endif; ?>
                        <?php if ($this->config->item('fuel_mode', 'fuel') == 'views') : ?>
                            <li>In the <strong>fuel/application/config/MY_fuel.php</strong> file, change the <code>$config['fuel_mode']</code> configuration property to <code>AUTO</code>. This must be done only if you want to view pages created in the CMS.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>
        <?php endif; ?>
    </ol>
    <div>
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <h4>That's it!</h4>
            <p>To access the FUEL admin, go to:</p>
            <ul>
                <li><a href="<?= site_url('fuel') ?>"><?= site_url('fuel') ?></a></li>
                <li>Username: <strong>admin</strong></li>
                <li>Password: <strong>admin</strong> (you can and should change this password and admin user information after logging in)</li>
            </ul>
        </div>
    </div>
</section>
<section>
    <header>
        <div class="col-md-2 icon_block">
            <div class="logo"><span class="glyphicon glyphicon-random"></span></div>
        </div>
        <div class="col-md-8">
            <h3>What's Next?</h3>
        </div>
    </header>
    <ol>
        <li>
            <div class="col-md-2">
                <div class="circle"><span class="glyphicon glyphicon-book"></span></div>
            </div>
            <div class="col-md-8">
                <a class="btn btn-success btn-lg" href="http://docs.getfuelcms.com" style="margin-top: 20px;">User Guide &raquo;</a>
                <h4>Visit the <a href="http://docs.getfuelcms.com">1.0 user guide</a> online</h4>
            </div>
        </li>
        <li>
            <div class="col-md-2">
                <div class="circle"><span class="glyphicon glyphicon-user"></span></div>
            </div>
            <div class="col-md-8">
                <h4>Get rolling</h4>
                <p>FUEL CMS is open source and on GitHub for a good reason. The communities involvement is an important part of it's success.
                    If you have any ideas for improvement, or even better, a <a href="https://help.github.com/articles/creating-a-pull-request">GitHub pull request</a>, please let us know.</p>
                <ul class="bullets">
                    <li>Need help? Visit the <a href="http://forum.getfuelcms.com">FUEL CMS Forum</a>.</li>
                    <li>Found a bug? <a href="https://github.com/daylightstudio/FUEL-CMS/issues">Report it on GitHub</a>.</li>
                    <li>Subscribe to our <a href="http://twitter.com/fuelcms">Twitter feed</a> for FUEL CMS notifications.</li>
                    <li>Visit our <a href="http://www.getfuelcms.com/blog">blog</a> for tips and news.</li>
                    <li>Visit our <a href="http://www.getfuelcms.com/developers">developer page</a> for additional modules.</li>
                </ul>
                <p>To change the contents of this homepage, edit the <strong>fuel/application/views/home.php</strong> file.</p>
                <p>Happy coding!</p>
            </div>
        </li>
    </ol>
</section>