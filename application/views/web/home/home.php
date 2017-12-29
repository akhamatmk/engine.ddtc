<div class="home-box">
  <div class="home-boxcontent">      
      <img src="<?php echo base_url(); ?>assets/themes/images/logo_DDtax1_new.png">
      <h2></h2>
      <!--<h2>Portal Peraturan Perpajakan Indonesia</h2>-->
      
      <div class="col-md-6 col-md-offset-3">            
        <form class="home-form" action="<?php echo site_url(); ?>home" method="post">
          <div class="col-xs-12">
            <div class="input-group">
              <input type="text" name="key" class="form-control" placeholder="Cari di Semua Dokumen">
              <span class="input-group-btn">
                <input type="submit" name="submit" value="GO" class="btn btn-default btn-search">
              </span>
            </div>
          </div>
        </form>
        <div class="clearfix"></div>
        <?php echo form_error('key'); ?>
        <p class="home-link"><a href="<?php echo site_url(); ?>peraturan-pajak">Peraturan Pajak</a> | <a href="<?php echo site_url(); ?>p3b">P3B</a> | <a href="<?php echo site_url(); ?>putusan-pengadilan-pajak">Putusan Pengadilan Pajak</a> | <a href="<?php echo site_url(); ?>putusan-mahkamah-agung">Putusan Mahkamah Agung</a></p>
      </div>

      <div class="clearfix"></div>
<!--
      <div class="home-detail">
          <div class="tbold">juga dilengkapi dengan</div>
            <div class="col-md-12">
              <div class="col-md-2 col-xs-offset-1 rightborder"><center><div class="home-icons"><img src="<?php echo base_url(); ?>assets/themes/images/icon_p3b.svg"></div></center><div class="home-icon-text">P3b<br>&nbsp;</div></div>
              <div class="col-md-2 rightborder"><center><div class="home-icons"><img src="<?php echo base_url(); ?>assets/themes/images/icon_putusan_pengadilan.svg"></div></center><div class="home-icon-text">Putusan Pengadilan<br>&nbsp;</div></div>
              <div class="col-md-2 rightborder"><center><div class="home-icons"><img src="<?php echo base_url(); ?>assets/themes/images/icon_istilah_pajak.svg" ></div></center><div class="home-icon-text">Istilah Pajak<br><span>SEGERA!</span></div></div>
              <div class="col-md-2 rightborder"><center><div class="home-icons"><img src="<?php echo base_url(); ?>assets/themes/images/icon_hitung_pajak.svg"  ></div></center><div class="home-icon-text">Hitung Pajak<br><span>SEGERA!</span></div></div>
              <div class="col-md-2"><center><div class="home-icons"><img src="<?php echo base_url(); ?>assets/themes/images/icon_publikasi_pajak.svg"  ></div></center><div class="home-icon-text">Publikasi Pajak<br><span>SEGERA!</span></div></div>
            </div>
      </div>
-->
      <div class="clearfix"></div>
  </div>
</div>

<center>
      <!--<div class="logofooter">
        <img src="<?php echo base_url(); ?>assets/themes/images/logofooter.jpg" height="50" >
      </div>-->
    <div class="home-footer"><a href="<?php echo site_url(''); ?>">Home</a> | <a href="<?php echo site_url('info/frequently-asked-question'); ?>">FAQ</a> | <a href="<?php echo site_url('info/disclaimer'); ?>">Disclaimer</a> | <a href="https://ddtc.co.id/about-us/contact-us/" target="_blank">Contact</a></div>
</center>