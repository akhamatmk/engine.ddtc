<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Putusan Pengadilan
      <small>Edit</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>webcontrol/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo site_url(); ?>webcontrol/putusanpengadilan">Putusan Pengadilan</a></li>
      <li class="active">Edit Putusan Pengadilan</li>
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
            <h3 class="box-title">Putusan Pengadilan Form</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <?php
            $attributes = array('role' => 'form', 'id' => 'form-ajax');
            echo form_open('webcontrol/putusanpengadilan/edit/'.$this->uri->segment(4));
          ?>
            <div class="box-body">
              <div class="form-group">
                <?php echo form_label('Nomor', 'nomor'); ?>
                <?php
                  $data = array(
                    'id'            => 'nomor',
                    'class'         => 'form-control',
                    'name'          => 'nomor',
                    'placeholder'   => 'Nomor'
                  );
                  echo form_input($data, set_value('nomor', $pp['nomor'], FALSE));
                ?>
                <?php echo form_error('nomor'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Tahun Keputusan', 'tahun_keputusan'); ?>
                <?php
                  $data = array(
                    'id'            => 'tahun_keputusan',
                    'class'         => 'form-control',
                    'name'          => 'tahun_keputusan',
                    'placeholder'   => 'Tahun Keputusan'
                  );
                  echo form_input($data, set_value('tahun_keputusan', $pp['tahun_keputusan'], FALSE));
                ?>
                <?php echo form_error('tahun_keputusan'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Tahun Pajak', 'tahun_pajak'); ?>
                <?php
                  $data = array(
                    'id'            => 'tahun_pajak',
                    'class'         => 'form-control',
                    'name'          => 'tahun_pajak',
                    'placeholder'   => 'Tahun Keputusan'
                  );
                  echo form_input($data, set_value('tahun_pajak', $pp['tahun_pajak'], FALSE));
                ?>
                <?php echo form_error('tahun_pajak'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Jenis Pajak', 'jenis_pajak'); ?>
                <?php
                  $data = array(
                    'id'            => 'jenis_pajak',
                    'class'         => 'form-control',
                    'name'          => 'jenis_pajak',
                    'placeholder'   => 'Jenis Pajak'
                  );
                  echo form_input($data, set_value('jenis_pajak', $pp['jenis_pajak'], FALSE));
                ?>
                <?php echo form_error('jenis_pajak'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Isi Putusan', 'isi_putusan'); ?>
                <?php
                  $data = array(
                    'id'            => 'isi_putusan',
                    'class'         => 'form-control ckeditor',
                    'name'          => 'isi_putusan',
                    'placeholder'   => 'Isi Putusan'
                  );
                  echo form_textarea($data, set_value('isi_putusan', $pp['isi_putusan'], FALSE));
                ?>
                <?php echo form_error('isi_putusan'); ?>
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