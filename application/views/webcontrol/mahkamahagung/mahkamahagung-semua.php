<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Mahkamah Agung
      <small>All List</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>webcontrol/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Mahkamah Agung</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Table Mahkamah Agung</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
			<div class="dataTables_wrapper form-inline dt-bootstrap" id="data-table_wrapper">
				<div class="row">
					<div class="col-sm-6">
						<div id="data-table_length" class="dataTables_length">
							<label>Show 
								<select class="form-control input-sm form-controlcustom" aria-controls="data-table" name="data-table_length">
									<option selected disabled>-</option>
									<option value="10">10</option>
									<option value="25">25</option>
									<option value="50">50</option>
									<option value="100">100</option>
								</select> 
								entries
							</label>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="dataTables_filter" id="data-table_filter">
							<form class="formcustom">
								<label>Search:
									<input aria-controls="data-table" placeholder="" class="form-control input-sm" type="search">
								</label>
							</form>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<table class="table table-bordered table-striped">
						  <thead>
							<tr>
							  <th>Number</th>
							  <th>View</th>
							  <th>Download</th>
							  <th>Status</th>
							  <th>Create</th>
							  <th>Update</th>
							  <th>Action</th>
							</tr>
						  </thead>
						  <tbody>
						  <?php
						  foreach($ma as $row)
						  {
							if($row['ma_status'] == 0)
							{
							  $status = '<span class="label label-danger">Save to draft</span>';
							}
							if($row['ma_status'] == 1)
							{
							  $status = '<span class="label label-info">Submitted</span>';
							}
							if($row['ma_status'] == 2)
							{
							  $status = '<span class="label label-warning">Need Revision</span>';
							}
							if($row['ma_status'] == 3)
							{
							  $status = '<span class="label label-success">Publish</span>';
							}
							if($row['ma_status'] == 4)
							{
							  $status = '<span class="label label-danger">Unpublish</span>';
							}
						  ?>
							<tr>
							  <td><a href="<?php echo site_url(); ?>webcontrol/mahkamahagung/view/<?php echo $row['ma_id']; ?>">Nomor <?php echo $row['ma_number']; ?></a></td>
							  <td>
								<?php echo $row['ma_view']; ?>
							  </td>
							  <td>
								<?php echo $row['ma_download']; ?>
							  </td>
							  <td><?php echo $status; ?></td>
							  <td>
								<?php echo $row['ma_create']; ?>
							  </td>
							  <td>
								<?php echo $row['ma_update']; ?>
							  </td>
							  <td>
								<a href="<?php echo site_url(); ?>webcontrol/mahkamahagung/edit/<?php echo $row['ma_id']; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Edit</a> 
								<a href="#" data-href="<?php echo site_url(); ?>webcontrol/mahkamahagung/delete/<?php echo $row['ma_id']; ?>" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modalDanger" data-title="Delete Mahkamah Agung" data-message="Are you sure you want to delete this data?" data-btext="Delete"><i class="fa fa-minus-square-o"></i> Delete</a>
							<?php
							  if($row['ma_status'] == 4)
							  {
							  ?>
								<a href="#" data-href="<?php echo site_url(); ?>webcontrol/mahkamahagung/publish/<?php echo $row['ma_id']; ?>" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalInfo" data-title="Publish Mahkamah Agung" data-message="Are you sure you want to publish this data?" data-btext="Publish"><i class="fa fa-check-square-o"></i> Publish</a>
							  <?php
							  }
							?>
							<?php
							  if($row['ma_status'] == 3)
							  {
							  ?>
								<a href="#" data-href="<?php echo site_url(); ?>webcontrol/mahkamahagung/unpublish/<?php echo $row['ma_id']; ?>" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalInfo" data-title="Unpublish Mahkamah Agung" data-message="Are you sure you want to unpublish this data?" data-btext="Unpublish"><i class="fa fa-check-square-o"></i> Unpublish</a>
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
							  <th>View</th>
							  <th>Download</th>
							  <th>Status</th>
							  <th>Create</th>
							  <th>Update</th>
							  <th>Action</th>
							</tr>
						  </tfoot>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-5">
						<div aria-live="polite" role="status" id="data-table_info" class="dataTables_info">
							Showing <?php echo number_format($current_page_start); ?> to <?php echo number_format($current_page_end); ?> of <?php echo number_format($total_rows); ?> entries
						</div>
					</div>
					<div class="col-sm-7">
						<div id="data-table_paginate" class="dataTables_paginate paging_simple_numbers">
							<?php echo $paging; ?>
						</div>
					</div>
				</div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
	</div>
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->