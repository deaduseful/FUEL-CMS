<?php $this->load->view('_blocks/header') ?>
<div class="container" role="main">
    <header class="page_header">
        <h1><?php echo fuel_var('heading') ?></h1>
    </header>
    <section id="main_inner">
        <?php echo fuel_var('body', 'This is a default layout. To change this layout go to the fuel/application/views/_layouts/main.php file.'); ?>
    </section>
</div>
<?php $this->load->view('_blocks/footer') ?>
