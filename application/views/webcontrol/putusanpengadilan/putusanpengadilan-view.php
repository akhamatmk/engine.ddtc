<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Putusan Pengadilan
      <small>View</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>webcontrol/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo site_url(); ?>webcontrol/mahkamahagung"><i class="fa fa-dashboard"></i> Putusan Pengadilan</a></li>
      <li class="active">View</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box box-primary">
          <div class="box-body">
            <?php
              $pp_full = '<h1 class="text-center">' .$pp['nomor']. '</h1>';

              $pp_full .= $pp['isi_putusan'];

              echo $pp_full;
            ?>
          </div><!-- /.box-body -->
        </div><!-- /.box -->

      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->