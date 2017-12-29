<nav class="navbar navbar-default navbar-page">
  <div class="">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo site_url(); ?>home"><img src="<?php echo site_url(); ?>assets/themes/images/logo_taxone_new.png" height="60"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <form class="navbar-form navbar-left formheader" role="search" method="post" action="<?php echo site_url(); ?>peraturan-pajak/topsearch">
          <div class="form-group has-success has-feedback">
            <label class="control-label sr-only" for="inputGroupSuccess4">Input group with success</label>
            <div class="input-group">
              <span class="input-group-addon search-icon"><span class="glyphicon glyphicon-search"></span></span>
              <input type="text" class="form-control" name="key" placeholder="Cari semua dokumen">
              <input type="hidden" class="form-control" name="rurl" value="<?php echo current_url(); ?>">
            </div>
          </div>
      </form>
      
      <ul class="nav navbar-nav  navbar-menu">
        <li class="profilmenu">
          <?php 
            if($this->user_auth->is_logged_in()){
                echo "<a href=".site_url()."user/settings>".$this->session->userdata('user_name')."</a>";
            }else{ 
                echo '<a href="'.site_url().'home">Guest</a>';
            }
          ?>
        </li>
        <li><a href="<?php echo site_url(); ?>peraturan-pajak">Peraturan Pajak</a></li>
        <li><a href="<?php echo site_url(); ?>p3b">P3B</a></li>
        <li><a href="<?php echo site_url(); ?>putusan-pengadilan-pajak">Putusan Pengadilan</a></li>
        <li><a href="<?php echo site_url(); ?>putusan-mahkamah-agung">Putusan Mahkamah Agung</a></li>

      </ul>

      <div class="nav navbar-nav navbar-right navbar-profile">
        <div class="col-md-2 col-xs-4 profile-picture">
        <?php
          if($this->session->userdata('user_auth') == 'Facebook' && $this->session->userdata('user_image') == 'prof_pic.png')
          {
            $session = $this->session->userdata();
            $id = $session['fb_data']['me']['id'];
        ?>
          <img src="http://graph.facebook.com/v2.5/<?php echo $id; ?>/picture?height=62&width=62" class="img-responsive img-circle">
        <?php
          }
          else if($this->session->userdata('user_auth') == 'Facebook' && $this->session->userdata('user_image') != 'prof_pic.png')
          {
        ?>
          <img src="<?php echo site_url('timthumb.php?src='.site_url('assets/upload/images/'.$this->session->userdata('user_image').'&w=65&h=65')); ?>" class="img-responsive img-circle">
        <?php
          }
          else
          {
            if($this->user_auth->is_logged_in())
            {
        ?>
          <img src="<?php echo site_url('timthumb.php?src='.site_url('assets/upload/images/'.$this->session->userdata('user_image').'&w=65&h=65')); ?>" class="img-responsive img-circle">
        <?php
            }
            else
            {
        ?>
          <img src="<?php echo site_url(); ?>assets/upload/images/prof_pic.png" class="img-responsive img-circle">
        <?php
            }
          }
        ?>
        </div>
        <div class="col-md-10 col-xs-8 profile-text">
          Halo!
          <div class="profile-name">
            <?php 
              if($this->user_auth->is_logged_in()) echo $this->session->userdata('user_name');
              else echo 'Guest';
            ?> 
          </div>
          <div class="profile-last-login">
            <!--Terakhir Login 3 Hari yang lalu -->
          </div>
          <?php
          if($this->user_auth->is_logged_in())
          {
          ?>
          <div class="change-profile"><a href="<?php echo site_url(); ?>user/settings">Pengaturan</a> | <a href="<?php echo site_url(); ?>user/logout">Logout</a></div>
          <?php
          }
          else
          {
          ?>
          <div class="change-profile"><a href="#" id="inside-login">Masuk</a></div>
          <?php
          }
          ?>
        </div>
      </div>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="clearfix"></div>