<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Mahkamah Agung
      <small>Edit</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>webcontrol/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo site_url(); ?>webcontrol/mahkamahagung">Mahkamah Agung</a></li>
      <li class="active">Edit Mahkamah Agung</li>
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
            <h3 class="box-title">Mahkamah Agung Form</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <?php
            $attributes = array('role' => 'form', 'id' => 'form-ajax');
            echo form_open('webcontrol/mahkamahagung/edit/'.$this->uri->segment(4));
          ?>
            <div class="box-body">
              <div class="form-group">
                <?php echo form_label('Mahkamah Agung Number', 'ma_number'); ?>
                <?php
                  $data = array(
                    'id'            => 'ma_number',
                    'class'         => 'form-control',
                    'name'          => 'ma_number',
                    'placeholder'   => 'Number'
                  );
                  echo form_input($data, set_value('ma_number', $ma['ma_number'], FALSE));
                ?>
                <?php echo form_error('ma_number'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Mahkamah Agung Year', 'ma_year'); ?>
                <?php
                  $data = array(
                    'id'            => 'ma_year',
                    'class'         => 'form-control',
                    'name'          => 'ma_year',
                    'placeholder'   => 'Year'
                  );
                  echo form_input($data, set_value('ma_year', $ma['ma_year'], FALSE));
                ?>
                <?php echo form_error('ma_year'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Mahkamah Agung Content', 'ma_content'); ?>
                <?php
                  $data = array(
                    'id'            => 'ma_content',
                    'class'         => 'form-control ckeditor',
                    'name'          => 'ma_content',
                    'placeholder'   => 'Year'
                  );
                  echo form_textarea($data, set_value('ma_content', $ma['ma_content'], FALSE));
                ?>
                <?php echo form_error('ma_content'); ?>
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