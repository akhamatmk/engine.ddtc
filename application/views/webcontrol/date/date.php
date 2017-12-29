<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Date
      <small>All List</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Date</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Table Date</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="data-table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Area</th>
                  <th>Name</th>
                  <th>Quota</th>
                  <th>Status</th>
                  <th>Create</th>
                  <th>Update</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
              foreach($date as $row)
              {
                if($row['status'] == 0)
                {
                  $status = '<span class="label label-danger">Not published</span>';
                }
                if($row['status'] == 1)
                {
                  $status = '<span class="label label-success">Publish</span>';
                }

                $area = get_area_data($row['area_id']);
              ?>
                <tr>
                  <td><?php echo $area['area']; ?></td>
                  <td><?php echo $row['kategori']; ?></td>
                  <td><?php echo $row['kuota']; ?></td>
                  <td><?php echo $status; ?></td>
                  <td><?php echo nice_date($row['dibuat'], 'D, d M Y - H:i:s'); ?></td>
                  <td><?php echo nice_date($row['diganti'], 'D, d M Y - H:i:s'); ?></td>
                  <td>
                    <a href="<?php echo site_url(); ?>webcontrol/date/edit/<?php echo $row['id']; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Edit</a> 
                    <a href="#" data-href="<?php echo site_url(); ?>webcontrol/date/delete/<?php echo $row['id']; ?>" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modalDanger" data-title="Delete Date" data-message="Are you sure you want to delete this date?" data-btext="Delete"><i class="fa fa-minus-square-o"></i> Delete</a>
                <?php
                  if($row['status'] == 0)
                  {
                  ?>
                    <a href="#" data-href="<?php echo site_url(); ?>webcontrol/date/publish/<?php echo $row['id']; ?>" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalInfo" data-title="Publish Date" data-message="Are you sure you want to publish this date?" data-btext="Publish"><i class="fa fa-check-square-o"></i> Publish</a>
                  <?php
                  }
                ?>
                <?php
                  if($row['status'] == 1)
                  {
                  ?>
                    <a href="#" data-href="<?php echo site_url(); ?>webcontrol/date/unpublish/<?php echo $row['id']; ?>" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalInfo" data-title="Unpublish Date" data-message="Are you sure you want to unpublish this date?" data-btext="Unpublish"><i class="fa fa-check-square-o"></i> Unpublish</a>
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
                  <th>Area</th>
                  <th>Name</th>
                  <th>Quota</th>
                  <th>Status</th>
                  <th>Create</th>
                  <th>Update</th>
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