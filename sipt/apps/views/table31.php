<link rel="stylesheet" href="<?= base_url(); ?>devgov/css/app.v1.css" type="text/css" />
<!--[if lt IE 9]> <script src="<?= base_url(); ?>devgov/js/ie/html5shiv.js"></script> <script src="<?= base_url(); ?>devgov/js/ie/respond.min.js"></script> <script src="<?= base_url(); ?>devgov/js/ie/excanvas.js"></script> <![endif]-->
<link rel="stylesheet" href="<?= base_url(); ?>devgov/js/bootstrap-datepicker/bootstrap-datepicker3.min.css" type="text/css" cache="false" />
<link rel="stylesheet" href="<?= base_url(); ?>devgov/js/bootstrap-dialog/bootstrap-dialog.min.css" type="text/css" cache="false" />
<script src="<?= base_url(); ?>devgov/js/app.v1.js"></script>
<script src="<?= base_url(); ?>devgov/js/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>devgov/js/bootstrap-dialog/bootstrap-dialog.min.js"></script>
<script src="<?= base_url(); ?>devgov/js/newtable/newtable.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>devgov/js/newtable/newtablehash.js" type="text/javascript"></script>
<section class="vbox">
<header class="header bg-white b-b b-light">
<p><?= $judul; ?></p>
</header>
<section class="scrollable wrapper">
  <div class="row">
    <div class="col-lg-12">
      <section class="panel panel-default">
        <header class="panel-heading">&nbsp;</header>
        <section class="chat-list panel-body">
          <?= $tabel; ?>
        </section>
      </section>
    </div>
  </div>
</section>
</section>

