<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/dist/css/skins/_all-skins.min.css">
    <!-- Custom -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/dist/css/custom.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <?php include('header.php'); ?>

      <?php include('main-sidebar.php'); ?>

      <?php echo $contents; ?>

      <?php include('footer.php'); ?>

      <?php //include('control-sidebar.php'); ?>

    </div><!-- ./wrapper -->

    <div class="modal modal-danger" id="modalDanger">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button class="close" aria-label="Close" data-dismiss="modal" type="button">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <p></p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-outline pull-left" data-dismiss="modal" type="button">Close</button>
            <button class="btn btn-outline" type="button" id="confirm"></button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal modal-info" id="modalInfo">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <p></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline" id="confirm"></button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal modal-primary" id="modalStock">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Stock Details</h4>
          </div>
          <div class="modal-body">
            <p></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url(); ?>assets/themes/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url(); ?>assets/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url(); ?>assets/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>assets/adminlte/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/adminlte/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>assets/adminlte/dist/js/demo.js"></script>
    <!-- page script -->
    <script>
      $(function () {
        $("#data-table").DataTable();
      });
    </script>

    <!-- Dialog show event handler "Danger"-->
    <script type="text/javascript">
      $('#modalDanger').on('show.bs.modal', function (e) {
          $message = $(e.relatedTarget).attr('data-message');
          $(this).find('.modal-body p').text($message);
          $title = $(e.relatedTarget).attr('data-title');
          $(this).find('.modal-title').text($title);
          $btext = $(e.relatedTarget).attr('data-btext');
          $(this).find('.modal-footer').find('#confirm').text($btext);

          $href = $(e.relatedTarget).attr('data-href');
          $(this).find('.modal-footer #confirm').attr('data-href', $href);
      });

      <!-- Form confirm (yes/ok) handler, submits form -->
      $('#modalDanger').find('.modal-footer #confirm').on('click', function(){
          var href = $(this).attr('data-href');

          window.location.href = href;
      });
    </script>

    <!-- Dialog show event handler "Info"-->
    <script type="text/javascript">
      $('#modalInfo').on('show.bs.modal', function (e) {
          $message = $(e.relatedTarget).attr('data-message');
          $(this).find('.modal-body p').text($message);
          $title = $(e.relatedTarget).attr('data-title');
          $(this).find('.modal-title').text($title);
          $btext = $(e.relatedTarget).attr('data-btext');
          $(this).find('.modal-footer').find('#confirm').text($btext);

          $href = $(e.relatedTarget).attr('data-href');
          $(this).find('.modal-footer #confirm').attr('data-href', $href);
      });

      <!-- Form confirm (yes/ok) handler, submits form -->
      $('#modalInfo').find('.modal-footer #confirm').on('click', function(){
          var href = $(this).attr('data-href');

          window.location.href = href;
      });
    </script>

    <script type="text/javascript">
		(function($) {
			$.QueryString = (function(a) {
				if (a == "") return {};
				var b = {};
				for (var i = 0; i < a.length; ++i)
				{
					var p=a[i].split('=');
					if (p.length != 2) continue;
					b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
				}
				return b;
			})(window.location.search.substr(1).split('&'))
		})(jQuery);
		var thisshow = $.QueryString['show'];
		var thissearch = $.QueryString['search'];
		if (window.location.href.indexOf('show=') > -1) {
			$('.paginationcustom').find('a').each(function() { 
				var thishref = $(this).attr('href');
				//alert(thishref + '?show=' + thisshow);
				if (window.location.href.indexOf('search=') > -1) {
					$(this).attr('href', thishref + '?show=' + thisshow + '&search=' + thissearch);
				} else {
					$(this).attr('href', thishref + '?show=' + thisshow);
				}
			});
			$('.form-control option[value='+ thisshow +']').prop('selected', true);
		} else {
			$('.paginationcustom').find('a').each(function() { 
				var thishref = $(this).attr('href');
				if (window.location.href.indexOf('search=') > -1) {
					$(this).attr('href', thishref + '?search=' + thissearch);
				}
			});
			$('.form-control option[value='+ thisshow +']').prop('selected', true);
		}
		$(document).on('change', '.form-controlcustom', function(){
			var oriurl = window.location.href.split('?');
			var selectedshow = $(this).find(':selected').text();
			if (window.location.href.indexOf('show=') > -1) {
				if (window.location.href.indexOf('search=') > -1) {
					window.location.href = oriurl[0] + '?show=' + selectedshow + '&search=' + thissearch;
				} else {
					window.location.href = oriurl[0] + '?show=' + selectedshow;
				}
			} else {
				if (window.location.href.indexOf('search=') > -1) {
					window.location.href = oriurl[0] + '?show=' + selectedshow + '&search=' + thissearch;
				} else {
					window.location.href = oriurl[0] + '?show=' + selectedshow;
				}
			}
		});
		$('.formcustom').submit(function(){
			var oriurl = window.location.href.split('?');
			oriurl = oriurl[0].replace(/[0-9]/g, '1');
			var thissearchnew = $(this).find('.input-sm').val();
			if(thissearchnew.length > 0) {
				if (thisshow) {
					if (thissearch) {
						window.location.href = oriurl + '?show=' + thisshow + '&search=' + thissearchnew;
					} else {
						window.location.href = oriurl + '?show=' + thisshow + '&search=' + thissearchnew;
					}
				} else {
					if (thissearch) {
						window.location.href = oriurl + '?search=' + thissearchnew;
					} else {
						window.location.href = oriurl + '?search=' + thissearchnew;
					}
				}
			} else {
				if (thisshow) {
					window.location.href = oriurl + '?show=' + thisshow;
				} else {
					window.location.href = oriurl;
				}
			}
			return false;
		});
		if(thissearch) {
			$('.formcustom .input-sm').val(thissearch);
		}
    </script>

  </body>
</html>
