<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Putusan Pengadilan
      <small>All List</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>webcontrol/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Putusan Pengadilan</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Table Putusan Pengadilan</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="data-table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>Status</th>
                  <th>Create</th>
                  <th>Update</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
              foreach($pp as $row)
              {
                if($row['status'] == 0)
                {
                  $status = '<span class="label label-danger">Unpublish</span>';
                }
                if($row['status'] == 1)
                {
                  $status = '<span class="label label-success">Publish</span>';
                }
              ?>
                <tr>
                  <td><a href="<?php echo site_url(); ?>webcontrol/putusanpengadilan/view/<?php echo $row['id']; ?>">Nomor <?php echo $row['nomor']; ?></a></td>
                  <td><?php echo $status; ?></td>
                  <td>
                    <?php echo $row['created']; ?>
                  </td>
                  <td>
                    <?php echo $row['modified']; ?>
                  </td>
                  <td>
                    <a href="<?php echo site_url(); ?>webcontrol/putusanpengadilan/edit/<?php echo $row['id']; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Edit</a> 
                    <a href="#" data-href="<?php echo site_url(); ?>webcontrol/putusanpengadilan/delete/<?php echo $row['id']; ?>" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modalDanger" data-title="Delete Putusan Pengadilan" data-message="Are you sure you want to delete this data?" data-btext="Delete"><i class="fa fa-minus-square-o"></i> Delete</a>
                <?php
                  if($row['status'] == 0)
                  {
                  ?>
                    <a href="#" data-href="<?php echo site_url(); ?>webcontrol/putusanpengadilan/publish/<?php echo $row['id']; ?>" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalInfo" data-title="Publish Putusan Pengadilan" data-message="Are you sure you want to publish this data?" data-btext="Publish"><i class="fa fa-check-square-o"></i> Publish</a>
                  <?php
                  }
                ?>
                <?php
                  if($row['status'] == 1)
                  {
                  ?>
                    <a href="#" data-href="<?php echo site_url(); ?>webcontrol/putusanpengadilan/unpublish/<?php echo $row['id']; ?>" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalInfo" data-title="Unpublish Putusan Pengadilan" data-message="Are you sure you want to unpublish this data?" data-btext="Unpublish"><i class="fa fa-check-square-o"></i> Unpublish</a>
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
                  <th>Number</th>
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