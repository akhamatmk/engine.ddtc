<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
      <small>TAX ENGINE</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <section class="content">

    <div class="row">

      <div class="col-md-6">
        <!-- TOP VIEW PERATURAN PAJAK -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Top View Peraturan Pajak</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <ul class="products-list product-list-in-box">
            <?php
              foreach($rp_top_view as $row)
              {
            ?>
              <li class="item">
                <a href="<?php echo site_url(); ?>webcontrol/peraturanpajak/view/<?php echo $row['id']; ?>" terget="_blank"><?php echo $row['jenis_dokumen_lengkap']; ?> Nomor: <?php echo $row['nomordokumen']; ?> <span class="label label-default pull-right"><?php echo $row['view']; ?></span></a>
              </li>
            <?php
              }
            ?>
            </ul>
          </div><!-- /.box-body -->
          <!--<div class="box-footer text-center">
            <a href="javascript::;" class="uppercase">View All Products</a>
          </div>--><!-- /.box-footer -->
        </div><!-- /.box -->
      </div><!-- /.col -->

      <div class="col-md-6">
        <!-- TOP DOWNLOAD PERATURAN PAJAK -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Top Download Peraturan Pajak</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <ul class="products-list product-list-in-box">
            <?php
              foreach($rp_top_download as $row)
              {
            ?>
              <li class="item">
                <a href="<?php echo site_url(); ?>webcontrol/peraturanpajak/view/<?php echo $row['id']; ?>" terget="_blank"><?php echo $row['jenis_dokumen_lengkap']; ?> Nomor: <?php echo $row['nomordokumen']; ?> <span class="label label-default pull-right"><?php echo $row['download']; ?></span></a>
              </li>
            <?php
              }
            ?>
            </ul>
          </div><!-- /.box-body -->
          <!--<div class="box-footer text-center">
            <a href="javascript::;" class="uppercase">View All Products</a>
          </div>--><!-- /.box-footer -->
        </div><!-- /.box -->
      </div><!-- /.col -->

    </div><!-- /.row -->

    <div class="row">

      <div class="col-md-6">
        <!-- TOP VIEW Putusan Pengadilan -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Top View Putusan Pengadilan</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <ul class="products-list product-list-in-box">
            <?php
              foreach($pp_top_view as $row)
              {
            ?>
              <li class="item">
                <a href="<?php echo site_url(); ?>webcontrol/putusanpengadilan/view/<?php echo $row['id']; ?>" target="_blank">Nomor <?php echo $row['nomor']; ?> <span class="label label-default pull-right"><?php echo $row['view']; ?></span></a>
              </li>
            <?php
              }
            ?>
            </ul>
          </div><!-- /.box-body -->
          <!--<div class="box-footer text-center">
            <a href="javascript::;" class="uppercase">View All Products</a>
          </div>--><!-- /.box-footer -->
        </div><!-- /.box -->
      </div><!-- /.col -->

      <div class="col-md-6">
        <!-- TOP DOWNLOAD Putusan Pengadilan -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Top Download Putusan Pengadilan</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <ul class="products-list product-list-in-box">
            <?php
              foreach($pp_top_download as $row)
              {
            ?>
              <li class="item">
                <a href="<?php echo site_url(); ?>webcontrol/putusanpengadilan/view/<?php echo $row['id']; ?>" target="_blank">Nomor <?php echo $row['nomor']; ?> <span class="label label-default pull-right"><?php echo $row['download']; ?></span></a>
              </li>
            <?php
              }
            ?>
            </ul>
          </div><!-- /.box-body -->
          <!--<div class="box-footer text-center">
            <a href="javascript::;" class="uppercase">View All Products</a>
          </div>--><!-- /.box-footer -->
        </div><!-- /.box -->
      </div><!-- /.col -->

    </div><!-- /.row -->

    <div class="row">

      <div class="col-md-6">
        <!-- TOP VIEW P3B -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Top View P3B</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <ul class="products-list product-list-in-box">
            <?php
              foreach($p3b_top_view as $row)
              {
            ?>
              <li class="item">
                <a href="<?php echo site_url(); ?>webcontrol/p3b/view/<?php echo $row['p3b_id']; ?>" target="_blank"><?php echo $row['p3b_country']; ?> <span class="label label-default pull-right"><?php echo $row['p3b_view']; ?></span></a>
              </li>
            <?php
              }
            ?>
            </ul>
          </div><!-- /.box-body -->
          <!--<div class="box-footer text-center">
            <a href="javascript::;" class="uppercase">View All Products</a>
          </div>--><!-- /.box-footer -->
        </div><!-- /.box -->
      </div><!-- /.col -->

      <div class="col-md-6">
        <!-- TOP DOWNLOAD P3B -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Top Download P3B</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <ul class="products-list product-list-in-box">
             <?php
              foreach($p3b_top_download as $row)
              {
            ?>
              <li class="item">
                <a href="<?php echo site_url(); ?>webcontrol/p3b/view/<?php echo $row['p3b_id']; ?>" target="_blank"><?php echo $row['p3b_country']; ?> <span class="label label-default pull-right"><?php echo $row['p3b_download']; ?></span></a>
              </li>
            <?php
              }
            ?>
            </ul>
          </div><!-- /.box-body -->
          <!--<div class="box-footer text-center">
            <a href="javascript::;" class="uppercase">View All Products</a>
          </div>--><!-- /.box-footer -->
        </div><!-- /.box -->
      </div><!-- /.col -->

    </div><!-- /.row -->

    <div class="row">

      <div class="col-md-6">
        <!-- TOP VIEW Mahkamah Agung -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Top View Putusan Mahkamah Agung</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <ul class="products-list product-list-in-box">
            <?php
              foreach($ma_top_view as $row)
              {
            ?>
              <li class="item">
                <a href="<?php echo site_url(); ?>webcontrol/mahkamahagung/view/<?php echo $row['ma_id']; ?>" target="_blank">Nomor <?php echo $row['ma_number']; ?> <span class="label label-default pull-right"><?php echo $row['ma_view']; ?></span></a>
              </li>
            <?php
              }
            ?>
            </ul>
          </div><!-- /.box-body -->
          <!--<div class="box-footer text-center">
            <a href="javascript::;" class="uppercase">View All Products</a>
          </div>--><!-- /.box-footer -->
        </div><!-- /.box -->
      </div><!-- /.col -->

      <div class="col-md-6">
        <!-- TOP DOWNLOAD Mahkamah Agung -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Top Download Putusan Mahkamah Agung</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <ul class="products-list product-list-in-box">
            <?php
              foreach($ma_top_download as $row)
              {
            ?>
              <li class="item">
                <a href="<?php echo site_url(); ?>webcontrol/mahkamahagung/view/<?php echo $row['ma_id']; ?>" target="_blank">Nomor <?php echo $row['ma_number']; ?> <span class="label label-default pull-right"><?php echo $row['ma_download']; ?></span></a>
              </li>
            <?php
              }
            ?>
            </ul>
          </div><!-- /.box-body -->
          <!--<div class="box-footer text-center">
            <a href="javascript::;" class="uppercase">View All Products</a>
          </div>--><!-- /.box-footer -->
        </div><!-- /.box -->
      </div><!-- /.col -->

    </div><!-- /.row -->

  </section><!-- /.content -->

</div><!-- /.content-wrapper -->