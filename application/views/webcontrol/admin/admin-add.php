<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Admin
      <small>Add New</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>webcontrol/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo site_url(); ?>webcontrol/admin">Admin</a></li>
      <li class="active">Add New</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Admin Form</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <?php
            $attributes = array('role' => 'form', 'id' => 'form-ajax');
            echo form_open_multipart('webcontrol/admin/add');
          ?>
            <div class="box-body">
              <?php
                if($this->session->flashdata('warning'))
                {
                  echo $this->session->flashdata('warning');
                }
              ?>
              <div class="form-group">
                <?php echo form_label('Admin Name', 'admin_name'); ?>
                <?php
                  $data = array(
                    'id'            => 'admin_name',
                    'class'         => 'form-control',
                    'name'          => 'admin_name',
                    'placeholder'   => 'Admin Name'
                  );
                  echo form_input($data, set_value('admin_name'));
                ?>
                <?php echo form_error('admin_name'); ?>
              </div>
              <div class="form-group">
                <?php echo form_label('Admin Email', 'admin_email'); ?>
                <?php
                  $data = array(
                    'id'            => 'admin_email',
                    'class'         => 'form-control',
                    'name'          => 'admin_email',
                    'placeholder'   => 'Admin Email'
                  );
                  echo form_input($data, set_value('admin_email'));
                ?>
                <?php echo form_error('admin_email'); ?>
              </div>
              <div class="form-group">
                <?php echo form_label('Admin Password', 'admin_password'); ?>
                <?php
                  $data = array(
                    'id'            => 'admin_password',
                    'class'         => 'form-control',
                    'name'          => 'admin_password',
                    'placeholder'   => 'Admin Password'
                  );
                  echo form_password($data, set_value('admin_password'));
                ?>
                <?php echo form_error('admin_password'); ?>
              </div>
              <div class="form-group">
                <?php echo form_label('Admin Re-Password', 'admin_repassword'); ?>
                <?php
                  $data = array(
                    'id'            => 'admin_repassword',
                    'class'         => 'form-control',
                    'name'          => 'admin_repassword',
                    'placeholder'   => 'Admin Re-Password'
                  );
                  echo form_password($data, set_value('admin_repassword'));
                ?>
                <?php echo form_error('admin_repassword'); ?>
              </div>
              <div class="form-group">
                <?php echo form_label('Admin Level', 'admin_level'); ?>
                <?php
                  $options = array(
                    '0'            => 'Choose Level',
                    '1'            => 'Super Admin',
                    '2'            => 'Admin',
                    '3'            => 'Editor'
                  );

                  $data = array(
                    'class'        => 'form-control'
                  );

                  echo form_dropdown('admin_level', $options, set_value('admin_level'), $data);
                ?>
                <?php echo form_error('admin_level'); ?>
              </div>
              <div class="form-group">
                <?php echo form_label('Admin Image', 'admin_image'); ?>
                <?php
                  $data = array(
                    'id'            => 'admin_image',
                    'class'         => '',
                    'name'          => 'admin_image',
                    'placeholder'   => 'Admin Image'
                  );
                  echo form_upload($data);
                ?>
                <?php echo $error; ?>
              </div>
            </div><!-- /.box-body -->

            <div class="box-footer">
              <?php
                $data = array(
                  'id'            => 'btn-submit',
                  'class'         => 'btn btn-primary',
                  'name'          => 'btn-submit',
                  'type'          => 'submit',
                  'content'       => 'Save'
                );
                echo form_button($data);
              ?>
            </div>

          <?php
            echo form_close();
          ?>
        </div><!-- /.box -->
      </div><!--/.col (left) -->
    </div><!-- /.row -->
  </section><!-- /.content -->

</div><!-- /.content-wrapper -->