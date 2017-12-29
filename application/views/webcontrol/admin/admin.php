<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Admin
      <small>All List</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>webcontrol/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Admin</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Table Admin</h3>
          </div><!-- /.box-header -->
          <div class="box-body table-responsive">
            <table id="data-table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Level</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
              foreach($admin as $row)
              {
                if($row['admin_status'] == 0)
                {
                  $status = '<span class="label label-danger">Not Active</span>';
                }
                if($row['admin_status'] == 1)
                {
                  $status = '<span class="label label-success">Active</span>';
                }

                if($row['admin_level'] == 1) $level = "Super Admin";
                if($row['admin_level'] == 2) $level = "Admin";
                if($row['admin_level'] == 3) $level = "Editor";

              ?>
                <tr>
                  <td><?php echo $row['admin_name']; ?></td>
                  <td><?php echo $row['admin_email']; ?></td>
                  <td><?php echo $level; ?></td>
                  <td><?php echo $status; ?></td>
                  <td>
                    <a href="<?php echo site_url(); ?>webcontrol/admin/edit/<?php echo $row['admin_id']; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Edit</a> 
                    <a href="#" data-href="<?php echo site_url(); ?>webcontrol/admin/delete/<?php echo $row['admin_id']; ?>" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modalDanger" data-title="Delete Admin" data-message="Are you sure you want to delete this admin?" data-btext="Delete"><i class="fa fa-minus-square-o"></i> Delete</a>
                <?php
                  if($row['admin_status'] == 0)
                  {
                  ?>
                    <a href="#" data-href="<?php echo site_url(); ?>webcontrol/admin/publish/<?php echo $row['admin_id']; ?>" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalInfo" data-title="Activate Admin" data-message="Are you sure you want to activate this admin?" data-btext="Activate"><i class="fa fa-check-square-o"></i> Activate</a>
                  <?php
                  }
                ?>
                <?php
                  if($row['admin_status'] == 1)
                  {
                  ?>
                    <a href="#" data-href="<?php echo site_url(); ?>webcontrol/admin/unpublish/<?php echo $row['admin_id']; ?>" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalInfo" data-title="Deactivate Admin" data-message="Are you sure you want to deactivate this admin?" data-btext="Deactivate"><i class="fa fa-check-square-o"></i> Deactivate</a>
                  <?php
                  }
                ?>
                  </td>
                </tr>
              <?php
              }
              ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Level</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->