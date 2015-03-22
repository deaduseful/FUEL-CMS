<?php fuel_set_var('page_title', 'Welcome to FUEL CMS') ?>
<?php fuel_set_var('heading', 'Welcome to FUEL CMS v' . FUEL_VERSION) ?>
<?php $this->load->helper('form'); ?>
<?php
if ($this->input->post('rewrite')) {
    $file = '.htaccess';
    if (is_really_writable($file)) {
        $contents = file_get_contents($file);
        $search = '#RewriteBase /';
        $replacement = $this->input->post('rewrite');
        $output = str_replace($search, $replacement, $contents);
        if ($contents != $output) {
            file_put_contents($file, $output);
        }
    }
}
if ($this->input->post('submit_database')) {
    $file = 'fuel/application/config/database.php';
    if (is_really_writable($file)) {
        $contents = file_get_contents($file);
        $replace = array();
        $replace['$db[\'default\'][\'hostname\'] = \'localhost\''] = '$db[\'default\'][\'hostname\'] = \'' . $this->input->post('db_host') . '\'';
        $replace['$db[\'default\'][\'username\'] = \'\''] = '$db[\'default\'][\'username\'] = \'' . $this->input->post('db_user') . '\'';
        $replace['$db[\'default\'][\'password\'] = \'\''] = '$db[\'default\'][\'password\'] = \'' . $this->input->post('db_pass') . '\'';
        $replace['$db[\'default\'][\'database\'] = \'\''] = '$db[\'default\'][\'database\'] = \'' . $this->input->post('db_name') . '\'';
        $output = str_replace(array_keys($replace), array_values($replace), $contents);
        if ($contents != $output) {
            file_put_contents($file, $output);
        }
    }
    $sql_file = 'fuel/install/fuel_schema.sql';
    $input = file_get_contents($sql_file);
    // Remove /* */ comments (http://ostermiller.org/findcomment.html)
    $input = preg_replace('#/\*(.|[\r\n])*?\*/#', "\n", $input);
    // Remove # style comments
    $input = preg_replace('/\n{2,}/', "\n", preg_replace('/^#.*$/m', "\n", $input));

    function split_sql_file($sql, $delimiter = ';') {
        $sql = str_replace("\r", '', $sql);
        $data = preg_split('/' . preg_quote($delimiter, '/') . '$/m', $sql);
        $data = array_map('trim', $data);
        // The empty case
        $end_data = end($data);
        if (empty($end_data)) {
            unset($data[key($data)]);
        }
        return $data;
    }

    $sqls = split_sql_file($input);
    $this->ci = & get_instance();
    $this->ci->load->database();
    foreach ($sqls as $sql) {
        if ($sql) {
            $this->ci->db->query($sql);
            if ($this->ci->db->_error_message()) {
                $errors[] = $this->ci->db->_error_message();
            }
        }
    }
}

function generate_token($len = 32) {
    $chars = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
        'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
    );
    shuffle($chars);
    $num_chars = count($chars) - 1;
    $token = '';
    for ($i = 0; $i < $len; $i++) {
        $token .= $chars[mt_rand(0, $num_chars)];
    }
    return $token;
}
if ($this->input->post('encryption_key')) {
    $file = 'fuel/application/config/config.php';
    $key = $this->input->post('encryption_key');
    $contents = file_get_contents($file);
    $search = '$config[\'encryption_key\'] = \'\'';
    $replace = '$config[\'encryption_key\'] = \'' . $key . '\'';
    $output = str_replace($search, $replace, $contents);
    if ($contents != $output) {
        file_put_contents($file, $output);
    }
}
if ($this->input->post('submit_admin_enabled')) {
    $file = 'fuel/application/config/MY_fuel.php';
    $contents = file_get_contents($file);
    $search = '$config[\'admin_enabled\'] = FALSE';
    $replace = '$config[\'admin_enabled\'] = TRUE';
    $output = str_replace($search, $replace, $contents);
    if ($contents != $output) {
        file_put_contents($file, $output);
    }
}
if ($this->input->post('submit_fuel_mode')) {
    $file = 'fuel/application/config/MY_fuel.php';
    $contents = file_get_contents($file);
    $search = '$config[\'fuel_mode\'] = \'views\'';
    $replace = '$config[\'fuel_mode\'] = \'AUTO\'';
    $output = str_replace($search, $replace, $contents);
    if ($contents != $output) {
        file_put_contents($file, $output);
    }
}
?>
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
                <p>Change the Apache .htaccess found at the root of FUEL CMS's installation folder to the proper RewriteBase directory.</p>
                <p>The default is your web server's root directory (e.g "/"), but if you have FUEL CMS installed in a sub folder, you will need to replace the line which reads <code>RewriteBase /</code>.</p>
                <p>If you are using the folder it was zipped up in from GitHub, it would be <code>RewriteBase /FUEL-CMS-master/</code>.</p>
                    <?php if (dirname($_SERVER['PHP_SELF']) != '/') : ?>
                    <p>In this instance, it would appear to be <code>RewriteBase <?php echo dirname($_SERVER['PHP_SELF']) ?>/</code>.
                        <?php if (is_really_writable('.htaccess')) : ?>
                            <?php echo form_open(''); ?>
                            <?php echo form_input('rewrite', 'RewriteBase ' . dirname($_SERVER['PHP_SELF']) . '/'); ?>
                            <?php echo form_submit('submit', 'Set RewriteBase'); ?>
                            <?php echo form_close(); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </p>
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
                <p>First create the database in MySQL.</p>
                <p>Change the database configuration found in <code>fuel/application/config/database.php</code> to include your hostname (e.g. localhost), username, password and the database to match the new database you created.</p>
                <p>Then import the <code>fuel/install/fuel_schema.sql</code> file.</p>
                <?php if (is_really_writable('fuel/application/config/database.php')) : ?>
                    <?php echo form_open(''); ?>
                    <?php echo form_label('Database Hostname', 'db_host'); ?>
                    <?php echo form_input('db_host', 'localhost'); ?><br>
                    <?php echo form_label('Database Username', 'db_user'); ?>
                    <?php echo form_input('db_user', $this->input->post('db_user')); ?><br>
                    <?php echo form_label('Database Password', 'db_pass'); ?>
                    <?php echo form_password('db_pass', $this->input->post('db_pass')); ?><br>
                    <?php echo form_label('Database Name', 'db_name'); ?>
                    <?php echo form_input('db_name', $this->input->post('db_name')); ?><br>
                    <?php echo form_submit('submit_database', 'Set Database'); ?>
                    <?php echo form_close(); ?>
                <?php endif; ?>
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
        <?php if ($this->config->item('encryption_key') == '' OR $this->config->item('fuel_mode', 'fuel') == 'views' OR ! $this->config->item('admin_enabled', 'fuel')) : ?>
            <li>
                <div class="col-md-2 icon_block">
                    <div class="circle">4</div>
                </div>
                <div class="col-md-8">
                    <h4>Make configuration changes</h4>
                    <ul class="writable">
                        <?php if ($this->config->item('encryption_key') == '') : ?>
                            <li>In the <code>fuel/application/config/config.php</code>, change the <code>$config['encryption_key']</code> to your own unique key. <?php echo form_open('') . form_input('encryption_key', generate_token()) . form_submit('submit', 'Set Encryption Key') . form_close(); ?></li>
                        <?php endif; ?>
                        <?php if (!$this->config->item('admin_enabled', 'fuel')) : ?>
                            <li>In the <code>fuel/application/config/MY_fuel.php</code> file, change the <code>$config['admin_enabled']</code> configuration property to <code>TRUE</code>. If you do not want the CMS accessible, leave it as <strong>FALSE</strong>. <?php echo form_open('') . form_submit('submit_admin_enabled', 'Set Admin Enabled') . form_close(); ?></li>
                        <?php endif; ?>
                        <?php if ($this->config->item('fuel_mode', 'fuel') == 'views') : ?>
                            <li>In the <code>fuel/application/config/MY_fuel.php</code> file, change the <code>$config['fuel_mode']</code> configuration property to <code>AUTO</code>. This must be done only if you want to view pages created in the CMS. <?php echo form_open('') . form_submit('submit_fuel_mode', 'Set Fuel Mode to AUTO') . form_close(); ?></li>
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