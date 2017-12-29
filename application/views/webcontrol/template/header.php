<?php
  $admin_id = $this->session->admin_id;

  $admin = get_admin_data($admin_id);
?>
<header class="main-header">
  <!-- Logo -->
  <a href="<?php echo site_url(); ?>home" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>T</b>AX</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>TAX</b>ENGINE</span>
  </a>

  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo base_url(); ?>assets/upload/images/<?php echo $admin['admin_avatar']; ?>" class="user-image" alt="User Image">
            <span class="hidden-xs"><?php echo $admin['admin_name']; ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="<?php echo base_url(); ?>assets/upload/images/<?php echo $admin['admin_avatar']; ?>" class="img-circle" alt="User Image">
              <p>
              <?php
                $admin_level = $admin['admin_level'];
                if($admin_level == 1) $level = 'Super Admin';
                if($admin_level == 2) $level = 'Admin';
                if($admin_level == 3) $level = 'Editor';

                echo $admin['admin_name'].' - '.$level;
              ?>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-right">
                <a href="<?php echo site_url(); ?>webcontrol/admin/signout" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>

  </nav>
</header> 