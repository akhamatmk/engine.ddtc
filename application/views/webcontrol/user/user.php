<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      User
      <small>All List</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>webcontrol/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">User</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Table User</h3>
          </div><!-- /.box-header -->
          <div class="box-body table-responsive">
            <table id="data-table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Registered Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
              foreach($user as $row)
              {
                if($row['user_status'] == 0)
                {
                  $status = '<span class="label label-danger">Not Active</span>';
                }
                if($row['user_status'] == 1)
                {
                  $status = '<span class="label label-success">Active</span>';
                }
              ?>
                <tr>
                  <td><?php echo $row['user_name']; ?></td>
                  <td><?php echo $row['user_email']; ?></td>
                  <td><?php echo $row['user_create']; ?></td>
                  <td><?php echo $status; ?></td>
                  <td>
                <?php
                  if($row['user_status'] == 0)
                  {
                  ?>
                    <a href="#" data-href="<?php echo site_url(); ?>webcontrol/user/publish/<?php echo $row['user_id']; ?>" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalInfo" data-title="Activate User" data-message="Are you sure you want to activate this user?" data-btext="Activate"><i class="fa fa-check-square-o"></i> Activate</a>
                  <?php
                  }
                ?>
                <?php
                  if($row['user_status'] == 1)
                  {
                  ?>
                    <a href="#" data-href="<?php echo site_url(); ?>webcontrol/user/unpublish/<?php echo $row['user_id']; ?>" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalInfo" data-title="Deactivate User" data-message="Are you sure you want to deactivate this user?" data-btext="Deactivate"><i class="fa fa-check-square-o"></i> Deactivate</a>
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
                  <th>Registered Date</th>
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