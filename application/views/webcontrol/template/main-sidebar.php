<?php
  $class = $this->router->fetch_class();
  $method = $this->router->fetch_method();

  $admin_id = $this->session->admin_id;

  $admin = get_admin_data($admin_id);
?>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo base_url(); ?>assets/upload/images/<?php echo $admin['admin_avatar']; ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $admin['admin_name'] ?></p>
        <?php
          $admin_level = $admin['admin_level'];
          if($admin_level == 1) $level = 'Super Admin';
          if($admin_level == 2) $level = 'Admin';
          if($admin_level == 3) $level = 'Editor';

          echo $level;
        ?>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>

      <!--Home-->
      <li class="treeview <?php echo ($class == "home") ? 'active' : ''; ?>">
        <a href="<?php echo site_url('webcontrol/home'); ?>">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>

      <!--Admin-->
      <li class="treeview <?php echo ($class == "admin") ? 'active' : ''; ?>">
        <a href="#">
          <i class="fa fa-user"></i> <span>Admin</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($class == "admin" && $method == "index") ? 'active' : ''; ?>"><a href="<?php echo site_url('webcontrol/admin'); ?>"><i class="fa fa-circle-o"></i>All Admin</a></li>
          <li class="<?php echo ($class == "admin" && $method == "add") ? 'active' : ''; ?>"><a href="<?php echo site_url('webcontrol/admin/add'); ?>"><i class="fa fa-circle-o"></i>Add New</a></li>
        </ul>
      </li>

      <!--User-->
      <li class="treeview <?php echo ($class == "user") ? 'active' : ''; ?>">
        <a href="#">
          <i class="fa fa-users"></i> <span>User</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($class == "user" && $method == "index") ? 'active' : ''; ?>"><a href="<?php echo site_url('webcontrol/user'); ?>"><i class="fa fa-circle-o"></i>All User</a></li>
        </ul>
      </li>

      <!--Feedback-->
      <li class="treeview <?php echo ($class == "feedback") ? 'active' : ''; ?>">
        <a href="#">
          <i class="fa fa-balance-scale"></i> <span>Feedback</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($class == "feedback" && $method == "index") ? 'active' : ''; ?>"><a href="<?php echo site_url('webcontrol/feedback'); ?>"><i class="fa fa-circle-o"></i>All Feedback</a></li>
        </ul>
      </li>

      <li class="header">DOCUMENT</li>

      <!--Peraturan Pajak-->
      <li class="treeview <?php echo ($class == "peraturanpajak") ? 'active' : ''; ?>">
        <a href="#">
          <i class="fa fa-file"></i> <span>Peraturan Pajak</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($class == "peraturanpajak" && $method == "index") ? 'active' : ''; ?>"><a href="<?php echo site_url('webcontrol/peraturanpajak/semua'); ?>"><i class="fa fa-circle-o"></i>All Data</a></li>
          <li class="<?php echo ($class == "peraturanpajak" && $method == "add") ? 'active' : ''; ?>"><a href="<?php echo site_url('webcontrol/peraturanpajak/add'); ?>"><i class="fa fa-circle-o"></i>Add New</a></li>
        </ul>
      </li>

      <!--Putusan Pengadilan-->
      <li class="treeview <?php echo ($class == "putusanpengadilan") ? 'active' : ''; ?>">
        <a href="#">
          <i class="fa fa-file"></i> <span>Putusan Pengadilan</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($class == "putusanpengadilan" && $method == "index") ? 'active' : ''; ?>"><a href="<?php echo site_url('webcontrol/putusanpengadilan/semua'); ?>"><i class="fa fa-circle-o"></i>All Data</a></li>
          <li class="<?php echo ($class == "putusanpengadilan" && $method == "add") ? 'active' : ''; ?>"><a href="<?php echo site_url('webcontrol/putusanpengadilan/add'); ?>"><i class="fa fa-circle-o"></i>Add New</a></li>
        </ul>
      </li>

      <!--P3B-->
      <li class="treeview <?php echo ($class == "p3b") ? 'active' : ''; ?>">
        <a href="#">
          <i class="fa fa-file"></i> <span>P3B</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($class == "p3b" && $method == "index") ? 'active' : ''; ?>"><a href="<?php echo site_url('webcontrol/p3b/semua'); ?>"><i class="fa fa-circle-o"></i>All Data</a></li>
          <li class="<?php echo ($class == "p3b" && $method == "add") ? 'active' : ''; ?>"><a href="<?php echo site_url('webcontrol/p3b/add'); ?>"><i class="fa fa-circle-o"></i>Add New</a></li>
        </ul>
      </li>

      <!--Mahkamah Agung-->
      <li class="treeview <?php echo ($class == "mahkamahagung") ? 'active' : ''; ?>">
        <a href="#">
          <i class="fa fa-file"></i> <span>Mahkamah Agung</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($class == "mahkamahagung" && $method == "index") ? 'active' : ''; ?>"><a href="<?php echo site_url('webcontrol/mahkamahagung/semua'); ?>"><i class="fa fa-circle-o"></i>All Data</a></li>
          <li class="<?php echo ($class == "mahkamahagung" && $method == "add") ? 'active' : ''; ?>"><a href="<?php echo site_url('webcontrol/mahkamahagung/add'); ?>"><i class="fa fa-circle-o"></i>Add New</a></li>
        </ul>
      </li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>