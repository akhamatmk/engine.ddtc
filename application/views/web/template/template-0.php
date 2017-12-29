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

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/themes/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/css/dropdowns-enhancement.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,600,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/css/custom.css?v=8" rel="stylesheet">
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
  <body class="homeintro">
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

    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo site_url(); ?>peraturan-pajak#_=_">Peraturan Pajak</a></li>
          <?php
            if(!$this->user_auth->is_logged_in())
            {
          ?>
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Masuk<span class="caret"></span></a>
              <div class="dropdown-menu dropdown-masuk">
                <form class="form-login" id="form-signin" action="<?php echo site_url(); ?>user/login" method="post" redirect="<?php echo site_url(); ?>home">
                      <input type="email" name="user_email" class="form-control" placeholder="email">
                      <input type="password" name="user_password" class="form-control" placeholder="password">
                      <button type="submit" class="btn btn-primary btn-lg btn-block btn-log" id="btn-signin">Masuk</button>
                      <p> atau </p>
                      <a href="<?php echo $facebook_login; ?>" class="btn btn-primary btn-lg btn-block btn-log btn-log-fb">Masuk Dengan Facebook</a>
                      <div id="msg-signin"></div>
                      <!--<div class="btn-forget-pass"><a href="" data-toggle="modal" data-target="#modal-lupapassword">Lupa Password?</a></div>-->
					  <div class="btn-forget-pass"><a href="http://dannydarussalam.com/oldwebsite/password-recovery" target="blank_">Lupa Password?</a></div>
                </form>
              </div>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Daftar<span class="caret"></span></a>
              <div class="dropdown-menu dropdown-masuk" role="menu">
                <form class="form-login" id="form-signup" action="<?php echo site_url(); ?>user/register" method="post" redirect="<?php echo site_url(); ?>home">
                      <input type="text" name="user_name" class="form-control" placeholder="nama">
                      <input type="email" name="user_email" class="form-control" placeholder="email">
                      <input type="password" name="user_password" class="form-control" placeholder="password">
                      <label><input type="checkbox" name="keep_login" value="1"> Tetap Masuk</label>
                      <button type="submit" class="btn btn-primary btn-lg btn-block btn-log" id="btn-signup">Daftar</button>
                      <p> atau </p>
                      <a href="<?php echo $facebook_login; ?>" class="btn btn-primary btn-lg btn-block btn-log btn-log-fb">Daftar Dengan Facebook</a>
                      <div id="msg-signup"></div>
                </form>
              </div>
            </li>
          <?php
            }
            else
            {
          ?>
            <li>
              <a href="<?php echo site_url(); ?>user">Signed in as <?php echo $this->session->userdata('user_name'); ?></a>
            </li>
            <li>
              <a href="<?php echo site_url(); ?>user/logout">Keluar</a>
            </li>
          <?php
            }
          ?>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    
    <div class="homeintro-container"><?php echo $contents; ?></div>

    <!-- Lupa password modal -->
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modal-lupapassword">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <center>
            Lupa Password?
            <form action="<?php echo site_url('user/forgotpassword'); ?>" method="post" id="form-forgotpassword">
              <div class="form-group">
                <label for="exampleInputEmail1">Masukkan Email Anda</label>
                <input type="email" class="form-control" id="f_user_email" placeholder="Email" name="user_email">
              </div>
              <button type="submit" class="btn" id="btn-forgotpassword">Kirim</button>
              <div id="msg-forgotpassword"></div>
            </form>
            </center>
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

    <script>
      var base_url = "<?php echo site_url(); ?>";
    </script>

    <script src="<?php echo base_url(); ?>assets/themes/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/js/custom.js?v=7"></script>
    <script src="<?php echo base_url(); ?>assets/themes/js/form.js?v=6"></script>

  <?php
    $error_facebook_login = $this->session->flashdata('error_facebook_login');

    if($error_facebook_login != "")
    {
  ?>
    <script>
      $(document).ready(function()
      {
        var notification_body = "<?php echo $this->session->flashdata('error_facebook_login'); ?>";
        $('#notificationModal').find('#notification-title').html('Notification');
        $('#notificationModal').find('#notification-body').html('<p>'+notification_body+'</p>');
        $('#notificationModal').modal('show');
      });
    </script>
  <?php
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