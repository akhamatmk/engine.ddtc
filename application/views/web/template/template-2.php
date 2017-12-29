<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- URL Theme Color untuk Chrome, Firefox OS, Opera dan Vivaldi -->
	<meta name="theme-color" content="#08294C" />
	<!-- URL Theme Color untuk Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#08294C" />
	<!-- URL Theme Color untuk iOS Safari -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="#08294C" />
    <title><?php echo $title; ?></title>

    <?php
      if(isset($meta))
      {
        echo $meta;
      }
    ?>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/themes/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/css/dropdowns-enhancement.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,600,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/css/custom.css?v=8.1" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/css/datepicker.css" rel="stylesheet">
    <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" />
    <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />
    <link rel="icon" sizes="192x192" href="<?php echo base_url(); ?>favicon-highres.png">
    <link rel="icon" sizes="128x128" href="<?php echo base_url(); ?>favicon.png">
    <link rel="apple-touch-icon" sizes="128x128" href="<?php echo base_url(); ?>favicon.png">
    <link rel="apple-touch-icon-precomposed" sizes="128x128" href="<?php echo base_url(); ?>favicon.png">
    <!-- Opera Speed Dial Favicon -->
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>favicon-195.png" />
    <!-- For iPhone 4 Retina display: -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>favicon-114.png">
    <!-- For iPad: -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>favicon-72.png">
    <!-- For iPhone: -->
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo base_url(); ?>favicon-57.png">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-98562105-1', 'auto');
    ga('send', 'pageview');

  </script>
  </head>
  <body>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '502362226595981',
          xfbml      : true,
          version    : 'v2.3'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    </script>

    <?php include('header.php') ?>

    <div class="page-container parent <?php echo $container_class; ?>">

    <!-- KOLOM KIRI -->
    <?php //include('left.php') ?>

    <!-- KOLOM TENGAH -->
    <div class="col-md-9 center-content columns"> 
  
        <?php echo $contents; ?>

        <div class="footer">
          <div class="saranbox">
            <div class="saran-header" id="saran-box">
              <div class="col-md-6 col-xs-9 left"><span>Perlu bantuan?</span></div>
              <div class="col-md-6 col-xs-3 right"><span class="glyphicon glyphicon-resize-vertical"></span></div>
            </div>
            <div class="saran-body">
            <p>Mengalami kendala dalam menemukan dokumen yang Anda cari? Kami siap membantu, serta mengharapkan kritik dan saran dari Anda.</p>
            <form action="<?php echo site_url(); ?>user/feedback" method="post" id="form-saran">
              <textarea class="form-control" rows="3" placeholder="Tinggalkan pesan di sini" name="feedback_content" id="feedback_content"></textarea>
              <button class="btn btn-saran" id="btn-saran">Kirim</button>
              <div id="msg-saran"></div>
            </form>
            </div>
          </div>
        </div>

    </div>

    <!-- KOLOM KANAN -->
    <?php include('right.php') ?>
    
    <!-- MODAL DETAIL -->
    <div class="modal fade doc-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modaldocument" cur-doc-1="" cur-doc-2="" data-current-controller="<?php echo $this->router->fetch_class(); ?>">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="tools-mobile"><span class="glyphicon glyphicon-menu-hamburger" id="modal-tools"></span><span class="glyphicon glyphicon-remove" id="modal-close"></span></div>
          <div class="modal-tools">

            <!-- TOOLS CLOSE -->                
            <div class="modal-tools-item">
              <a title="close" id="btn-close" class="close_modal" data-dismiss="modal" aria-label="Close"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
            </div>

            <?php
              if(!$this->config->item('peraturan_pajak_login') || $this->user_auth->is_logged_in())
              {
            ?>
            <!-- TOOLS CARI -->
            <div class="modal-tools-item">
              <a title="cari" id="btn-cari"><span class="glyphicon glyphicon-search" aria-hidden="true"</span></a>
              <div class="modal-tools-item-content tools-item-cari">
                <div class="input-group">
                  <input type="text" id="carikata" class="form-control tools-form-cari" placeholder="Cari kata">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button" id="btn-carikata"><span class="glyphicon glyphicon-search"</span></button>
                  </span>
                </div>
                <div class="wordfound">Ditemukan : 
                  <span class="numword"></span>
                  <span class="wordbutton">
                  <button class="next" id="next" value="next"><span class="glyphicon glyphicon-chevron-down"></span></button>
                  <button class="prev" id="prev" value="prev"><span class="glyphicon glyphicon-chevron-up"></span></button>
                  </span>
                </div>
                  
              </div>
            </div>
            <?php
              }
            ?>

            <!-- TOOLS RIWAYAT -->                
            <div class="modal-tools-item">
              <a title="riwayat" id="btn-riwayat"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></a>
              <div class="modal-tools-item-content">
                  <div class="tools-item-title">STATUS</div>
                  <div id="list-status"></div>
                  <div class="tools-item-title">RIWAYAT</div>
                  <div id="list-riwayat"></div>
              </div>
            </div>

            <!-- TOOLS LAMPIRAN -->                
            <div class="modal-tools-item">
              <a title="lampiran" id="btn-lampiran"><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span></a>
              <div class="modal-tools-item-content">
                <div class="tools-item-title">LAMPIRAN</div>
                <div id="list-lampiran">Mencari lampiran...</div>
              </div>
            </div>

            <!-- TOOLS TERKAIT -->                
            <div class="modal-tools-item">
              <a title="terkait" id="btn-terkait"><span class="glyphicon glyphicon-link" aria-hidden="true"></span></a>
              <div class="modal-tools-item-content">
                  <div class="tools-item-title">TERKAIT</div>
                  <div id="list-terkait"></div>
              </div>
            </div>

            <?php
            if($this->user_auth->is_logged_in())
            {
            ?>

            <!-- TOOLS SALIN -->   
             <div class="modal-tools-item">
              <a title="salin" id="btn-salin" data-clipboard-target="modal-contents"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span></a>
              <div class="modal-tools-item-content">
                <div class="tools-item-title">SALIN DOKUMEN</div>
              </div>
            </div>

            <!-- TOOLS CETAK --> 
            <div class="modal-tools-item">
              <a title="cetak" id="btn-cetak"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></a>
              <div class="modal-tools-item-content">
                <div class="tools-item-title">SIMPAN/CETAK DOKUMEN</div>
              </div>
            </div>

            <!-- TOOLS SANDING --> 
            <div class="modal-tools-item">
              <a title="sandingkan" id="btn-sanding"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span></a>
              <div class="modal-tools-item-content">
                <div class="tools-item-title">SANDINGKAN DOKUMEN</div>
              </div>
            </div>

            <!-- TOOLS FAVORIT --> 
            <div class="modal-tools-item">
              <a title="favorit" class="btn-favorit"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></a>
              <div class="modal-tools-item-content">
                <div class="tools-item-title">FAVORIT</div>
              </div>
            </div>
      
            <?php
            }
            else
            {
            ?>
            <!-- TOOLS SALIN -->   
             <div class="modal-tools-item">
              <a title="salin" id="btn-salin" data-clipboard-target="modal-contents"><!-- class="inactive" -->
                <span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>
              </a>
              <div class="modal-tools-item-content">
                <div class="tools-item-title">SALIN DOKUMEN<!-- <br /><small>ru harus Masuk terlebih dahulu.</small> --></div>
              </div>
            </div>

            <!-- TOOLS CETAK --> 
            <div class="modal-tools-item">
              <a title="cetak" id="btn-cetak"><!-- class="inactive" -->
                <span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>
              </a>
              <div class="modal-tools-item-content">
                <div class="tools-item-title">SIMPAN/CETAK DOKUMEN<!-- <br /><small>Anda harus Masuk terlebih dahulu.</small> --></div>
              </div>
            </div>

            <!-- TOOLS SANDING --> 
            <div class="modal-tools-item">
              <a title="sandingkan" id="btn-sanding"><!-- class="inactive" -->
                <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
              </a>
              <div class="modal-tools-item-content">
                <div class="tools-item-title">SANDINGKAN DOKUMEN<!-- <br /><small>Anda harus Masuk terlebih dahulu.</small> --></div>
              </div>
            </div>

            <!-- TOOLS FAVORIT --> 
            <div class="modal-tools-item">
              <a title="favorit" class="btn-favorit inactive"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></a>
              <div class="modal-tools-item-content">
                <div class="tools-item-title">FAVORIT<br /><small>Anda harus Masuk terlebih dahulu.</small></div>
              </div>
            </div>
            <?php
            }
            ?>

            <!-- TOOLS SHARE -->
            <div class="modal-tools-item">
              <a title="share" id="btn-share"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span></a>
              <div class="modal-tools-item-content">
                <!-- <div class="tools-item-title">SHARE</div> -->
                <div class="tools-item-social list-social">
                  Tunggu..
                </div>
              </div>
            </div>
          
          </div>
            
          <!--<div class="doc-logo"><img src="<?php echo site_url(); ?>assets/themes/images/logo-doc-new.png"></div>-->
          <div class="modal-desc" id="modal-contents">

            <?php
              if($this->config->item('peraturan_pajak_login') && !$this->user_auth->is_logged_in())
              {
                $notlogin_class = "nologin";
              }
              else
              {
                $notlogin_class = "";
              }
            ?>

            <!-- KALO BUKAN COMPARE -->
            <div class="nocompare-content <?php echo $notlogin_class; ?>" id="nocompare-wrapper"><div id="loadingstate"><img src="<?php echo site_url(); ?>assets/themes/images/preloader.gif"><br>MEMUAT...</div></div>

            <!-- KALO COMPARE -->
            <div id="compare-wrapper">
              <div class="compare-content compare-left shadow-left">
                  <div class="compare-content-wide"> <!-- ARTIKEL PEMBANDING --> </div>
              </div>
              <div class="compare-content compare-right">
                <div class="compare-content-wide"><!-- ARTIKEL YG DIBANDINGKAN --> </div>
              </div>
            </div>
            <!-- END OF KALO COMPARE -->

          </div>

          <div class="compare-notif" id="compare-notifs">
            <div class="notif-title"><span class="glyphicon glyphicon-transfer"></span> Sandingkan dokumen di bawah ini</div>
            <div class="notif-content">
              <div class="col-md-9" id="doc-name">DOCUMENT OPENED</div>
              <div class="col-md-3 compare-add-item">
                <div><span id="compare-ico" class="glyphicon glyphicon-plus-sign btn-tambah"></span></div>
                <div id="compare-word">TAMBAH</div>
              </div>
            </div>
          </div>

          </div>
        </div>
      </div>
    
    <!-- EO MODAL DETAIL -->

    <!-- MODAL P3B -->
    <div class="modal fade doc-modal-p3b" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modaldocument-p3b" cur-doc-1="" cur-doc-2="" data-current-controller="<?php echo $this->router->fetch_class(); ?>">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="tools-mobile"><span class="glyphicon glyphicon-menu-hamburger" id="modal-tools-p3b"></span><span class="glyphicon glyphicon-remove" id="modal-close-p3b"></span></div>
          <div class="modal-tools">

            <!-- TOOLS CLOSE -->                
            <div class="modal-tools-item">
              <a title="close" id="btn-close" class="close_modal" data-dismiss="modal" aria-label="Close"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
            </div>

            <?php
              if(!$this->config->item('p3b_login') || $this->user_auth->is_logged_in())
              {
            ?>
            <!-- TOOLS CARI -->
            <div class="modal-tools-item">
                <a title="cari" id="btn-cari"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content tools-item-cari">
                    <div class="input-group">
                          <input type="text" id="carikata-p3b" class="form-control tools-form-cari" placeholder="Cari kata">
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="btn-carikata-p3b"><span class="glyphicon glyphicon-search"></span></button>
                          </span>
                    </div>
                    <div class="wordfound">Ditemukan : 
                      <span class="numword"></span>
                      <span class="wordbutton">
                          <button class="next" id="next-p3b" value="next"><span class="glyphicon glyphicon-chevron-down"></span></button>
                      <button class="prev" id="next-p3b" value="prev"><span class="glyphicon glyphicon-chevron-up"></span></button>
                      </span>
                    </div>                    
                </div>
            </div>
            <?php
              }
            ?>

            <!-- TOOLS RIWAYAT
            <div class="modal-tools-item">
                <a title="riwayat" id="btn-riwayat"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">RIWAYAT</div>
                </div>
            </div>
            -->

            <?php
            if($this->user_auth->is_logged_in())
            {
            ?>
            <div class="modal-tools-item">
                <a title="salin" id="btn-salin-p3b"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SALIN DOKUMEN</div>
                </div>
            </div>
            <div class="modal-tools-item">
                <a title="cetak" id="btn-cetak-p3b"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SIMPAN/CETAK DOKUMEN</div>
                </div>
                </div>
            <div class="modal-tools-item">
                <a title="sandingkan" id="btn-sanding-p3b"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SANDINGKAN DOKUMEN</div>
                </div>
            </div>
            <div class="modal-tools-item">
                <a title="favorit" id="btn-favorit-p3b"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">FAVORIT</div>
                </div>
            </div>
            <?php
            }
            else
            {
            ?>
            <div class="modal-tools-item">
                <a title="salin" id="btn-salin-p3b"><!-- class="inactive" -->
                  <span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>
                </a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SALIN DOKUMEN<!-- <br /><small>Anda harus Masuk terlebih dahulu.</small> --></div>
                </div>
            </div>
            <div class="modal-tools-item">
                <a title="cetak" id="btn-cetak-p3b"><!-- class="inactive" -->
                  <span class="glyphicon glyphicon-save-file" aria-hidden="true"></span>
                </a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SIMPAN/CETAK DOKUMEN<!-- <br /><small>Anda harus Masuk terlebih dahulu. </small> --></div>
                </div>
                </div>
            <div class="modal-tools-item">
                <a title="sandingkan" id="btn-sanding-p3b"><!-- class="inactive" -->
                  <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
                </a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SANDINGKAN DOKUMEN<!-- <br /><small>Anda harus Masuk terlebih dahulu.</small> --></div>
                </div>
            </div>
            <div class="modal-tools-item">
                <a title="favorit" class="btn-favorit-p3b inactive"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">FAVORIT<br /><small>Anda harus Masuk terlebih dahulu.</small></div>
                </div>
            </div>
            <?php
            }
            ?>

            <!-- TOOLS SHARE -->
            <div class="modal-tools-item">
              <a title="share" id="btn-share"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span></a>
              <div class="modal-tools-item-content">
                <!-- <div class="tools-item-title">SHARE</div> -->
                <div class="tools-item-social list-social">
                  Tunggu..
                </div>
              </div>
            </div>

          </div>
          
          <!-- <div class="doc-logo"><img src="<?php echo site_url(); ?>assets/themes/images/logo-doc-new.png"></div> -->
          <div class="modal-desc" id="modal-contents-p3b">

            <?php
              if($this->config->item('p3b_login') && !$this->user_auth->is_logged_in())
              {
                $notlogin_class = "nologin";
              }
              else
              {
                $notlogin_class = "";
              }
            ?>

            <!-- KALO BUKAN COMPARE -->
            <div class="nocompare-content nocompare-content-p3b <?php echo $notlogin_class; ?>" id="nocompare-wrapper-p3b"><div id="loadingstate"><img src="<?php echo site_url(); ?>assets/themes/images/preloader.gif"><br>MEMUAT...</div></div>

            <!-- KALO COMPARE -->
            <div id="compare-wrapper-p3b">
              <div class="compare-content compare-left-p3b shadow-left">
                  <div class="compare-content-wide"> <!-- ARTIKEL PEMBANDING --> </div>
              </div>
              <div class="compare-content compare-right-p3b">
                  <div class="compare-content-wide"><!-- ARTIKEL YG DIBANDINGKAN --> </div>
              </div>
            </div>
            <!-- END OF KALO COMPARE -->

          </div>
          
          <div class="compare-notif" id="compare-notifs-p3b">
            <div class="notif-title"><span class="glyphicon glyphicon-transfer"></span> Sandingkan dokumen di bawah ini</div>
            <div class="notif-content">
              <div class="col-md-9" id="doc-name-p3b">DOCUMENT OPENED</div>
              <div class="col-md-3 compare-add-item">
                <div><span id="compare-ico-p3b" class="glyphicon glyphicon-plus-sign btn-tambah"></span></div>
                <div id="compare-word-p3b">TAMBAH</div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- EO MODAL DETAIL -->

    <!-- MODAL PP -->
    <div class="modal fade doc-modal-pp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modaldocument-pp" cur-doc-1="" cur-doc-2="" data-current-controller="<?php echo $this->router->fetch_class(); ?>">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="tools-mobile"><span class="glyphicon glyphicon-menu-hamburger" id="modal-tools-pp"></span><span class="glyphicon glyphicon-remove" id="modal-close-pp"></span></div>
          <div class="modal-tools">

            <!-- TOOLS CLOSE -->                
            <div class="modal-tools-item">
              <a title="close" id="btn-close" class="close_modal" data-dismiss="modal" aria-label="Close"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
            </div>

            <?php
              if(!$this->config->item('putusan_pengadilan_login') || $this->user_auth->is_logged_in())
              {
            ?>
            <!-- TOOLS CARI -->
            <div class="modal-tools-item">
                <a title="cari" id="btn-cari"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content tools-item-cari">
                    <div class="input-group">
                          <input type="text" id="carikata-pp" class="form-control tools-form-cari" placeholder="Cari kata">
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="btn-carikata-pp"><span class="glyphicon glyphicon-search"></span></button>
                          </span>
                    </div>
                    <div class="wordfound">Ditemukan : 
                      <span class="numword"></span>
                      <span class="wordbutton">
                      <button class="next" id="next-pp" value="next"><span class="glyphicon glyphicon-chevron-down"></span></button>
                      <button class="prev" id="next-pp" value="prev"><span class="glyphicon glyphicon-chevron-up"></span></button>
                      </span>
                    </div>                    
                </div>
            </div>
            <?php
              }
            ?>

            <!-- TOOLS RIWAYAT
            <div class="modal-tools-item">
                <a title="riwayat" id="btn-riwayat"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">RIWAYAT</div>
                </div>
            </div>
            -->

            <?php
            if($this->user_auth->is_logged_in())
            {
            ?>
            <div class="modal-tools-item">
                <a title="salin" id="btn-salin-pp"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SALIN DOKUMEN</div>
                </div>
            </div>

            <div class="modal-tools-item">
                <a title="cetak" id="btn-cetak-pp"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SIMPAN/CETAK DOKUMEN</div>
                </div>
            </div>

            <div class="modal-tools-item">
                <a title="sandingkan" id="btn-sanding-pp"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SANDINGKAN DOKUMEN</div>
                </div>
            </div>

            <div class="modal-tools-item">
                <a title="favorit" id="btn-favorit-pp"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">FAVORIT</div>
                </div>
            </div>
            <?php
            }
            else
            {
            ?>
            <div class="modal-tools-item">
                <a title="salin" class="inactive"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SALIN DOKUMEN<br /><small>Anda harus Masuk terlebih dahulu.</small></div>
                </div>
            </div>

            <div class="modal-tools-item">
                <a title="cetak" class="inactive"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SIMPAN/CETAK DOKUMEN<br /><small>Anda harus Masuk terlebih dahulu.</small></div>
                </div>
            </div>

            <div class="modal-tools-item">
                <a title="sandingkan" class="inactive"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SANDINGKAN DOKUMEN<br /><small>Anda harus Masuk terlebih dahulu.</small></div>
                </div>
            </div>

            <div class="modal-tools-item">
                <a title="favorit" class="inactive"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">FAVORIT<br /><small>Anda harus Masuk terlebih dahulu.</small></div>
                </div>
            </div>
            <?php
            }
            ?>

            <!-- TOOLS SHARE -->
            <div class="modal-tools-item">
              <a title="share" id="btn-share"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span></a>
              <div class="modal-tools-item-content">
                <!-- <div class="tools-item-title">SHARE</div> -->
                <div class="tools-item-social list-social">
                  Tunggu..
                </div>
              </div>
            </div>

          </div>
          
          <!-- <div class="doc-logo"><img src="<?php echo site_url(); ?>assets/themes/images/logo-doc-new.png"></div> -->
          <div class="modal-desc" id="modal-contents-pp">

            <?php
              if($this->config->item('putusan_pengadilan_login') && !$this->user_auth->is_logged_in())
              {
                $notlogin_class = "nologin";
              }
              else
              {
                $notlogin_class = "";
              }
            ?>

            <!-- KALO BUKAN COMPARE -->
            <div class="nocompare-content nocompare-content-pp <?php echo $notlogin_class; ?>" id="nocompare-wrapper-pp"><div id="loadingstate"><img src="<?php echo site_url(); ?>assets/themes/images/preloader.gif"><br>MEMUAT...</div></div>

            <!-- KALO COMPARE -->
            <div id="compare-wrapper-pp">
              <div class="compare-content compare-left-pp shadow-left">
                  <div class="compare-content-wide"> <!-- ARTIKEL PEMBANDING --> </div>
              </div>
              <div class="compare-content compare-right-pp">
                  <div class="compare-content-wide"><!-- ARTIKEL YG DIBANDINGKAN --> </div>
              </div>
            </div>
            <!-- END OF KALO COMPARE -->

          </div>
          
          <div class="compare-notif" id="compare-notifs-pp">
            <div class="notif-title"><span class="glyphicon glyphicon-transfer"></span> Sandingkan dokumen di bawah ini</div>
            <div class="notif-content">
              <div class="col-md-9" id="doc-name-pp">DOCUMENT OPENED</div>
              <div class="col-md-3 compare-add-item">
                <div><span id="compare-ico-pp" class="glyphicon glyphicon-plus-sign btn-tambah"></span></div>
                <div id="compare-word-pp">TAMBAH</div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- EO MODAL DETAIL -->

    <!-- MODAL MA -->
    <div class="modal fade doc-modal-ma" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modaldocument-ma" cur-doc-1="" cur-doc-2="" data-current-controller="<?php echo $this->router->fetch_class(); ?>">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="tools-mobile"><span class="glyphicon glyphicon-menu-hamburger" id="modal-tools-ma"></span><span class="glyphicon glyphicon-remove" id="modal-close-ma"></span></div>
          <div class="modal-tools">

            <!-- TOOLS CLOSE -->                
            <div class="modal-tools-item">
              <a title="close" id="btn-close" class="close_modal" data-dismiss="modal" aria-label="Close"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
            </div>

            <?php
              if(!$this->config->item('putusan_ma_login') || $this->user_auth->is_logged_in())
              {
            ?>
            <!-- TOOLS CARI -->
            <div class="modal-tools-item">
                <a title="cari" id="btn-cari"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content tools-item-cari">
                    <div class="input-group">
                          <input type="text" id="carikata-ma" class="form-control tools-form-cari" placeholder="Cari kata">
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="btn-carikata-ma"><span class="glyphicon glyphicon-search"></span></button>
                          </span>
                    </div>
                    <div class="wordfound">Ditemukan : 
                      <span class="numword"></span>
                      <span class="wordbutton">
                      <button class="next" id="next-ma" value="next"><span class="glyphicon glyphicon-chevron-down"></span></button>
                      <button class="prev" id="next-ma" value="prev"><span class="glyphicon glyphicon-chevron-up"></span></button>
                      </span>
                    </div>                    
                </div>
            </div>
            <?php
              }
            ?>

            <?php
            if($this->user_auth->is_logged_in())
            {
            ?>
            <div class="modal-tools-item">
                <a title="salin" id="btn-salin-ma" data-clipboard-target="modal-contents-ma"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SALIN DOKUMEN</div>
                </div>
            </div>
            <div class="modal-tools-item">
                <a title="cetak" id="btn-cetak-ma"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SIMPAN/CETAK DOKUMEN</div>
                </div>
                </div>
            <div class="modal-tools-item">
                <a title="sandingkan" id="btn-sanding-ma"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SANDINGKAN DOKUMEN</div>
                </div>
            </div>
            <div class="modal-tools-item">
                <a title="favorit" id="btn-favorit-ma"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">FAVORIT</div>
                </div>
            </div>
            <?php
            }
            else
            {
            ?>
            <div class="modal-tools-item">
                <a title="salin" class="inactive"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SALIN DOKUMEN<br /><small>Anda harus Masuk terlebih dahulu.</small></div>
                </div>
            </div>
            <div class="modal-tools-item">
                <a title="cetak" class="inactive"><span class="glyphicon glyphicon-save-file" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SIMPAN/CETAK DOKUMEN<br /><small>Anda harus Masuk terlebih dahulu.</small></div>
                </div>
                </div>
            <div class="modal-tools-item">
                <a title="sandingkan" class="inactive"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">SANDINGKAN DOKUMEN<br /><small>Anda harus Masuk terlebih dahulu.</small></div>
                </div>
            </div>
            <div class="modal-tools-item">
                <a title="favorit" class="inactive"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></a>
                <div class="modal-tools-item-content">
                    <div class="tools-item-title">FAVORIT<br /><small>Anda harus Masuk terlebih dahulu.</small></div>
                </div>
            </div>
            <?php
            }
            ?>

            <!-- TOOLS SHARE -->
            <div class="modal-tools-item">
              <a title="share" id="btn-share"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span></a>
              <div class="modal-tools-item-content">
                <!-- <div class="tools-item-title">SHARE</div> -->
                <div class="tools-item-social list-social">
                  Tunggu..
                </div>
              </div>
            </div>

          </div>
          
          <!-- <div class="doc-logo"><img src="<?php echo site_url(); ?>assets/themes/images/logo-doc-new.png"></div> -->
          <div class="modal-desc" id="modal-contents-ma">

            <?php
              if($this->config->item('putusan_ma_login') && !$this->user_auth->is_logged_in())
              {
                $notlogin_class = "nologin";
              }
              else
              {
                $notlogin_class = "";
              }
            ?>

            <!-- KALO BUKAN COMPARE -->
            <div class="nocompare-content nocompare-content-ma <?php echo $notlogin_class; ?>" id="nocompare-wrapper-ma"><div id="loadingstate"><img src="<?php echo site_url(); ?>assets/themes/images/preloader.gif"><br>MEMUAT...</div></div>

            <!-- KALO COMPARE -->
            <div id="compare-wrapper-ma">
              <div class="compare-content compare-left-ma shadow-left">
                  <div class="compare-content-wide"> <!-- ARTIKEL PEMBANDING --> </div>
              </div>
              <div class="compare-content compare-right-ma">
                  <div class="compare-content-wide"><!-- ARTIKEL YG DIBANDINGKAN --> </div>
              </div>
            </div>
            <!-- END OF KALO COMPARE -->

          </div>
          
          <div class="compare-notif" id="compare-notifs-ma">
            <div class="notif-title"><span class="glyphicon glyphicon-transfer"></span> Sandingkan dokumen di bawah ini</div>
            <div class="notif-content">
              <div class="col-md-9" id="doc-name-ma">DOCUMENT OPENED</div>
              <div class="col-md-3 compare-add-item">
                <div><span id="compare-ico-ma" class="glyphicon glyphicon-plus-sign btn-tambah"></span></div>
                <div id="compare-word-ma">TAMBAH</div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- EO MODAL DETAIL -->

    <!-- Modal -->
    <div class="modal fade" id="modalInfoPer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" style="color: #F77B04" id="myModalLabel"><span class="glyphicon glyphicon-info-sign"></span> PANDUAN PENCARIAN</h4>
          </div>
          <div class="modal-body">
            <ul>
              <li><strong>Kolom Kata Kunci</strong><br /><small>Masukkan kata kunci yang ingin dicari.<br />
        Untuk kata kunci dengan jenis peraturan tidak harus spesifik. Misal Undang-Undang, cukup ditulis uu kemudian nomor peraturannya. <em>Contoh: uu 36</em><br />
        <strong>Panduan kata kunci jenis peraturan:</strong><br />
              Undang-Undang = uu<br />
              Peraturan Pemerintah Pengganti Undang-Undang = perpu<br />
              Peraturan Presiden = perpres<br />
              Peraturan Pemerintah= pp<br />
              Peraturan Menteri Keuangan = pmk<br />
              Keputusan Menteri Keuangan = kmk<br />
              Peraturan Dirjen Pajak = per<br />
              Keputusan Dirjen pajak = kep<br />
              Surat Edaran Dirjen Pajak = se<br /></small></li>
              <li><strong>Kolom Kategori</strong><br /><small>Pilih semua atau salah satu kategori untuk hasil yang lebih akurat.</small></li>
              <li><strong>Kolom Jenis Dokumen</strong><br /><small>Pilih semua atau salah satu jenis dokumen untuk hasil yang lebih akurat.</small></li>
              <li><strong>Metode</strong><br /><small>Pilih metode "Kalimat" untuk pencarian dokumen yang mengandung kalimat dari Kata Kunci.<br />Pilih metode "Dan" untuk pencarian dokumen yang mengandung semua kata dari Kata Kunci.<br />Pilih metode "Atau" untuk pencarian dokumen yang mengandung salah satu kata dari Kata Kunci.</small></li>
              <li><strong>Tanggal atau Tahun</strong><br /><small>Pilih Tanggal dan masukkan tanggal awal dan akhir untuk pencarian dokumen yang dikeluarkan pada tanggal tersebut.<br />Pilih Tahun untuk pencarian dokumen yang dikeluarkan pada tahun tersebut.</small></li>
              <li><strong>Nomor</strong><br /><small>Masukkan nomor dokumen (angka) untuk pencarian dokumen dengan nomor tersebut.</small></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalInfoPp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" style="color: #F77B04" id="myModalLabel"><span class="glyphicon glyphicon-info-sign"></span> PANDUAN PENCARIAN</h4>
          </div>
          <div class="modal-body">
            <ul>
              <li><strong>Kolom Kata Kunci</strong><br /><small>Masukkan kata kunci yang ingin dicari.</small></li>
              <li><strong>Kolom Nomor</strong><br /><small>Masukkan nomor dokumen (angka) untuk pencarian dokumen dengan nomor tersebut.</small></li>
              <li><strong>Kolom Jenis Putusan</strong><br /><small>Pilih semua atau salah satu jenis putusan untuk hasil yang lebih akurat.</small></li>
              <li><strong>Tahun</strong><br /><small>Pilih Tahun untuk pencarian dokumen yang dikeluarkan pada tahun tersebut.</small></li>
              <li><strong>Metode</strong><br /><small>Pilih metode "Kalimat" untuk pencarian dokumen yang mengandung kalimat dari Kata Kunci.<br /><!--Pilih metode "Dan" untuk pencarian dokumen yang mengandung semua kata dari Kata Kunci.<br />-->Pilih metode "Atau" untuk pencarian dokumen yang mengandung salah satu kata dari Kata Kunci.</small></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalInfoP3b" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" style="color: #F77B04" id="myModalLabel"><span class="glyphicon glyphicon-info-sign"></span> PANDUAN PENCARIAN</h4>
          </div>
          <div class="modal-body">
            <h4><strong>Satu Negara</strong></h4>
            <ul>
              <li><strong>Pilih Negara</strong><br /><small>Pilih salah satu negara yang ingin dilihat.</small></li>
            </ul>
            <h4><strong>Bandingkan Dua Negara</strong></h4>
            <ul>
              <li><strong>Pilih Negara</strong><br /><small>Pilih dua negara yang ingin dilihat.</small></li>
              <li><strong>Semua Pasal, Pasal, atau Pasal Tertentu</strong><br /><small>Pilih "Semua Pasal" untuk membanding semua pasal dari dua dokumen.<br />Pilih "Pasal" dan pilih pasal awal dan pasal akhir untuk membandingkan pasal tersebut dari dua dokumen.<br />Pilih "Pasal Tertentu" dan pilih pasal untuk membandingkan pasal tersebut dari dua dokumen.</small></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalInfoMa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" style="color: #F77B04" id="myModalLabel"><span class="glyphicon glyphicon-info-sign"></span> PANDUAN PENCARIAN</h4>
          </div>
          <div class="modal-body">
            <ul>
              <li><strong>Kolom Nomor</strong><br /><small>Masukkan nomor dokumen (angka) untuk pencarian dokumen dengan nomor tersebut.</small></li>
              <li><strong>Kolom Kata Kunci</strong><br /><small>Masukkan kata kunci yang ingin dicari.</small></li>
              <li><strong>Tahun</strong><br /><small>Pilih Tahun untuk pencarian dokumen yang dikeluarkan pada tahun tersebut.</small></li>
              <li><strong>Metode</strong><br /><small>Pilih metode "Kalimat" untuk pencarian dokumen yang mengandung kalimat dari Kata Kunci.<br /><!--Pilih metode "Dan" untuk pencarian dokumen yang mengandung semua kata dari Kata Kunci.<br />-->Pilih metode "Atau" untuk pencarian dokumen yang mengandung salah satu kata dari Kata Kunci.</small></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!--notification  modal-->
    <div class="modal fade" id="notificationModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="notification-title"></h4>
          </div>
          <div class="modal-body" id="notification-body"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- COMPARE NOTIF MAIN PAGE -->
    <div class="compare-notif-mainpage">
      <div class="notif-title"><span class="glyphicon glyphicon-transfer"></span> Dokumen Yang Ingin Dibandingkan</div>
      <div class="notif-content">
        <div class="col-md-12"><span class="glyphicon glyphicon-remove" id="notif-close-notif" title="hapus"></span><span id="doc-title"></span></div>
      </div>
    </div>

    <!-- MODAL LOGIN -->
      <div class="modal fade modal-login" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modallogin">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
              <div class="modal-desc" id="modal-contents">
              <h3>MASUK</h3>
                <form class="form-login" id="form-signin" action="<?php echo site_url(); ?>user/login" method="post" redirect="<?php echo current_url(); ?>">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" placeholder="Email" name="user_email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="user_password">
                  </div>
                  <div class="form-group">
                    <label><input type="checkbox" name="keep_login" style="height: auto;" value="1"> Tetap Masuk</label>
                  </div>
                  <div id="msg-signin"></div>
                  <button class="btn btn-default btn-login">MASUK</button> <br>- atau -<br>
                  <a href="<?php echo $pop_facebook_login; ?>" class="btn btn-default btn-facebook">LOGIN DENGAN FACEBOOK</a>
                </form>
                <div class="daftar-link">
                  Belum punya akun? Daftar <a href="" data-dismiss="modal" data-toggle="modal" data-target=".modal-daftar">disini</a>
                  <br /><br />
                  <!--<a href="" data-dismiss="modal" data-toggle="modal" data-target=".modal-lupa">Lupa password?</a>-->
          <a href="http://dannydarussalam.com/oldwebsite/password-recovery" target="blank_">Lupa Password?</a>
                </div>
              </div>
          </div>
        </div>
      </div>

      <!-- MODAL LUPA -->
      <div class="modal fade modal-lupa" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-lupapassword">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
              <div class="modal-desc" id="modal-contents">
              <h3>LUPA PASSWORD</h3>
                <form class="form-lupa" id="form-forgotpassword" action="<?php echo site_url(); ?>user/forgotpassword" method="post">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Masukkan alamat email Anda yang terdaftar</label>
                    <input type="email" class="form-control" placeholder="Email" id="f_user_email" name="user_email">
                  </div>
                  <div id="msg-forgotpassword"></div>
                  <button class="btn btn-default btn-login" id="btn-forgotpassword">KIRIM</button>
                </form>
              </div>
          </div>
        </div>
      </div>

      <!-- MODAL DAFTAR -->
      <div class="modal fade modal-daftar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modaldaftar">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
              <div class="modal-desc" id="modal-contents">
              <h3>DAFTAR</h3>
                <form class="form-login" id="form-signup" action="<?php echo site_url(); ?>user/register" method="post" redirect="<?php echo current_url(); ?>">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama</label>
                    <input type="text" class="form-control" placeholder="Nama" name="user_name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" placeholder="Email" name="user_email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="user_password">
                  </div>
                  <div id="msg-signup"></div>
                  <button class="btn btn-default btn-login">DAFTAR</button>
                <div class="daftar-link">Sudah Punya akun? Login <a href="" data-dismiss="modal" data-toggle="modal" data-target=".modal-login">disini</a></div>
              </div>
          </div>
        </div>
      </div>
          
      <div class="loading-layer" id="loading-print">
          <center><div><img src="<?php echo site_url(); ?>assets/themes/images/preloader.gif"><br>Mempersiapkan<br>Print File </div></center>
      </div>
          

    <script>
      var base_url = "<?php echo site_url(); ?>";
    </script>

    <script src="<?php echo base_url(); ?>assets/themes/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/js/dropdowns-enhancement.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/js/ZeroClipboard.js"></script>          
    <script src="<?php echo base_url(); ?>assets/themes/js/custom.js?v=7"></script>
    <script src="<?php echo base_url(); ?>assets/themes/js/form.js?v=6"></script>

    <script>
      var current_controller = "<?php echo $this->router->fetch_class(); ?>";

      if(current_controller == 'peraturan_pajak')
      {
        var cookie_pj = "<?php echo get_cookie('cookie_pj'); ?>";
        var cookie_pj_id = "<?php echo get_cookie('cookie_pj_id'); ?>";
        var cookie_pj_text = "<?php echo get_cookie('cookie_pj_text'); ?>";

        if(cookie_pj == 'yes')
        {
          $('#compare-ico').attr('doc_1', cookie_pj_id);
          $('#btn-sanding').hide();
          $('#doc-name').html(cookie_pj_text);
          $('.compare-notif-mainpage').find('span#doc-title').html(cookie_pj_text);
          $('.compare-notif-mainpage').show();
        }
      }

      if(current_controller == 'putusan_pengadilan_pajak')
      {
        var cookie_pp = "<?php echo get_cookie('cookie_pp'); ?>";
        var cookie_pp_id = "<?php echo get_cookie('cookie_pp_id'); ?>";
        var cookie_pp_text = "<?php echo get_cookie('cookie_pp_text'); ?>";

        if(cookie_pp == 'yes')
        {
          $('.doc-modal-pp').attr('cur-doc-2', cookie_pp_id);
          $('#btn-sanding-pp').hide();
          $('#doc-name-pp').html(cookie_pp_text);
          $('.compare-notif-mainpage').find('span#doc-title').html(cookie_pp_text);
          $('.compare-notif-mainpage').show();
        }
      }

      if(current_controller == 'p3b')
      {
        var cookie_p3b = "<?php echo get_cookie('cookie_p3b'); ?>";
        var cookie_p3b_id = "<?php echo get_cookie('cookie_p3b_id'); ?>";
        var cookie_p3b_text = "<?php echo get_cookie('cookie_p3b_text'); ?>";

        if(cookie_p3b == 'yes')
        {
          $('.doc-modal-p3b').attr('cur-doc-2', cookie_p3b_id);
          $('#btn-sanding-p3b').hide();
          $('#doc-name-p3b').html(cookie_p3b_text);
          $('.compare-notif-mainpage').find('span#doc-title').html(cookie_p3b_text);
          $('.compare-notif-mainpage').show();
        }
      }

      if(current_controller == 'putusan_mahkamah_agung')
      {
        var cookie_ma = "<?php echo get_cookie('cookie_ma'); ?>";
        var cookie_ma_id = "<?php echo get_cookie('cookie_ma_id'); ?>";
        var cookie_ma_text = "<?php echo get_cookie('cookie_ma_text'); ?>";

        if(cookie_ma == 'yes')
        {
          $('.doc-modal-ma').attr('cur-doc-2', cookie_ma_id);
          $('#btn-sanding-ma').hide();
          $('#doc-name-ma').html(cookie_ma_text);
          $('.compare-notif-mainpage').find('span#doc-title').html(cookie_ma_text);
          $('.compare-notif-mainpage').show();
        }
      }

    </script>
    <?php
      if(isset($javascript))
      {
        echo $javascript;
      }
    ?>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','//connect.facebook.net/en_US/fbevents.js');

fbq('init', '251334571729324');
fbq('init', '470671776443901');
fbq('track', "PageView");</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=251334571729324&ev=PageView&noscript=1"
/><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=470671776443901&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
  </body>
</html>