<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Feedback
      <small>All List</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>webcontrol/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Feedback</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Table Feedback</h3>
          </div><!-- /.box-header -->
          <div class="box-body table-responsive">
            <table id="data-table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Name</th>
                  <th>Feedback</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
              foreach($feedback as $row)
              {
                if($row['feedback_status'] == 0)
                {
                  $status = '<span class="label label-danger">Not Accepted</span>';
                }
                if($row['feedback_status'] == 1)
                {
                  $status = '<span class="label label-success">Accepted</span>';
                }

                $user = get_user_data($row['feedback_user']);

              ?>
                <tr>
                  <td><?php echo $row['feedback_create']; ?></td>
                  <td><?php echo $user['user_name']; ?></td>
                  <td><?php echo $this->typography->nl2br_except_pre(word_wrap($row['feedback_content'], 100)); ?></td>
                  <td><?php echo $status; ?></td>
                  <td>
                <?php
                  if($row['feedback_status'] == 0)
                  {
                  ?>
                    <a href="#" data-href="<?php echo site_url(); ?>webcontrol/feedback/publish/<?php echo $row['feedback_id']; ?>" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalInfo" data-title="Accept Feedback" data-message="Are you sure you want to accept this feedback?" data-btext="Accept"><i class="fa fa-check-square-o"></i> Accept</a>
                  <?php
                  }
                ?>
                <?php
                  if($row['feedback_status'] == 1)
                  {
                  ?>
                    <a href="#" data-href="<?php echo site_url(); ?>webcontrol/feedback/unpublish/<?php echo $row['feedback_id']; ?>" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalInfo" data-title="Reject Feedback" data-message="Are you sure you want to reject this feedback?" data-btext="Reject"><i class="fa fa-check-square-o"></i> Reject</a>
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
                  <th>Date</th>
                  <th>Name</th>
                  <th>Feedback</th>
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