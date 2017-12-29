<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Area
      <small>Edit</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo site_url(); ?>webcontrol/area">Area</a></li>
      <li class="active">Edit Area</li>
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
            <h3 class="box-title">Area Form</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <?php
            $attributes = array('role' => 'form', 'id' => 'form-ajax');
            echo form_open('webcontrol/area/edit/'.$this->uri->segment(4));
          ?>
            <div class="box-body">
              <div class="form-group">
                <?php echo form_label('Area Name', 'area_name'); ?>
                <?php
                  $data = array(
                    'id'            => 'area_name',
                    'class'         => 'form-control',
                    'name'          => 'area_name',
                    'placeholder'   => 'Area Name'
                  );
                  echo form_input($data, set_value('area_name', $area['area']));
                ?>
                <?php echo form_error('area_name'); ?>
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
              if($this->session->flashdata('warning'))
              {
                echo $this->session->flashdata('warning');
              }
            ?>

          <?php
            echo form_close();
          ?>
        </div><!-- /.box -->
      </div><!--/.col (left) -->
    </div><!-- /.row -->
  </section><!-- /.content -->

</div><!-- /.content-wrapper -->