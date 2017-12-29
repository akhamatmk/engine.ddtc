<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Peraturan Pajak
      <small>Add New</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>webcontrol/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo site_url(); ?>webcontrol/peraturanpajak">Peraturan Pajak</a></li>
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
            <h3 class="box-title">Peraturan Pajak Form</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <?php
            $attributes = array('role' => 'form', 'id' => 'form-ajax');
            echo form_open_multipart('webcontrol/peraturanpajak/add');
          ?>
            <div class="box-body">
              <div class="form-group">
                <?php echo form_label('Nomor Dokumen', 'nomordokumen'); ?>
                <?php
                  $data = array(
                    'id'            => 'nomordokumen',
                    'class'         => 'form-control',
                    'name'          => 'nomordokumen',
                    'placeholder'   => 'Nomor Dokumen'
                  );
                  echo form_input($data, set_value('nomordokumen', null, FALSE));
                ?>
                <?php echo form_error('nomordokumen'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Kelompok', 'kelompok'); ?>
                <?php
                  $options = array( '0' => 'Pilih Kelompok' );

                  foreach($kelompok as $row)
                  {
                    $options[$row['idk']] = $row['kelompok'];
                  }

                  $data = array(
                    'class'        => 'form-control'
                  );

                  echo form_dropdown('kelompok', $options, set_value('kelompok'), $data);
                ?>
                <?php echo form_error('kelompok'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Jenis Dokumen', 'jenisdok2'); ?>
                <?php
                  $options = array( '0' => 'Pilih Jenis Dokumen' );

                  foreach($jenisdok as $row)
                  {
                    $options[$row['IDJenis']] = $row['Desc'];
                  }

                  $data = array(
                    'class'        => 'form-control'
                  );

                  echo form_dropdown('jenisdok2', $options, set_value('jenisdok2'), $data);
                ?>
                <?php echo form_error('jenisdok2'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Jenis Dokumen Lengkap', 'jenis_dokumen_lengkap'); ?>
                <?php
                  $data = array(
                    'id'            => 'jenis_dokumen_lengkap',
                    'class'         => 'form-control',
                    'name'          => 'jenis_dokumen_lengkap',
                    'placeholder'   => 'Jenis Dokumen Lengkap'
                  );
                  echo form_input($data, set_value('jenis_dokumen_lengkap', null, FALSE));
                ?>
                <?php echo form_error('jenis_dokumen_lengkap'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Nomor', 'nomor'); ?>
                <?php
                  $data = array(
                    'id'            => 'nomor',
                    'class'         => 'form-control',
                    'name'          => 'nomor',
                    'placeholder'   => 'Nomor'
                  );
                  echo form_input($data, set_value('nomor', null, FALSE));
                ?>
                <?php echo form_error('nomor'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Tahun', 'tahun'); ?>
                <?php
                  $data = array(
                    'id'            => 'tahun',
                    'class'         => 'form-control',
                    'name'          => 'tahun',
                    'placeholder'   => 'Tahun'
                  );
                  echo form_input($data, set_value('tahun', null, FALSE));
                ?>
                <?php echo form_error('tahun'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Tanggal', 'tanggal', null, FALSE); ?>
                <?php
                  $data = array(
                    'id'            => 'tanggal',
                    'class'         => 'form-control',
                    'name'          => 'tanggal',
                    'placeholder'   => 'Tanggal'
                  );
                  echo form_input($data, set_value('tanggal', null, FALSE));
                ?>
                <?php echo form_error('tanggal'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Perihal', 'perihal'); ?>
                <?php
                  $data = array(
                    'id'            => 'perihal',
                    'class'         => 'form-control',
                    'name'          => 'perihal',
                    'placeholder'   => 'Perihal'
                  );
                  echo form_textarea($data, set_value('perihal', null, FALSE));
                ?>
                <?php echo form_error('perihal'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Body Final', 'body_final'); ?>
                <?php
                  $data = array(
                    'id'            => 'body_final',
                    'class'         => 'form-control ckeditor',
                    'name'          => 'body_final',
                    'placeholder'   => 'Body Final'
                  );
                  echo form_textarea($data, set_value('body_final', null, FALSE));
                ?>
                <?php echo form_error('body_final'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Lamp Filename', 'lamp1_filename'); ?>
                <?php
                  $data = array(
                    'id'            => 'lamp1_filename',
                    'class'         => 'form-control',
                    'name'          => 'lamp1_filename',
                    'placeholder'   => 'Lamp Filename'
                  );
                  echo form_input($data, set_value('lamp1_filename', null, FALSE));
                ?>
                <?php echo form_error('lamp1_filename'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Upload Lamp', 'lamp1_file'); ?>
                <?php
                  $data = array(
                    'id'            => 'lamp1_file',
                    'class'         => 'form-control',
                    'name'          => 'lamp1_file',
                    'placeholder'   => 'Lamp File'
                  );
                  echo form_upload($data, set_value('lamp1_file'));
                ?>
                <?php echo $error_lamp1_file; ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Topik', 'topik'); ?>
                <?php
                  $options = array( '0' => 'Pilih Topik' );

                  foreach($topik as $row)
                  {
                    $options[$row['topik_name']] = $row['topik_name'];
                  }

                  $data = array(
                    'class'        => 'form-control'
                  );

                  echo form_dropdown('topik', $options, set_value('topik'), $data);
                ?>
                <?php echo form_error('topik'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('RegStatus', 'regstatus'); ?>
                <?php
                  $options = array( 
                    '0' => 'Berlaku', 
                    '1' => 'Sudah Tidak Berlaku Karena Diganti/Dicabut', 
                    '2' => 'Perubahan atau penyempurnaan', 
                    '3' => 'DiRalat', 
                    '4' => 'Perubahan dan kondisi terakhir tidak berlaku karena diganti/dicabut', 
                    '5' => 'Diralat dan kondisi terakhir tidak berlaku karena diganti/dicabut', 
                    '6' => 'Beberapa kali diubah',
                    '8' => 'Beberapa kali diubah dan sekarang tidak berlaku karena diganti/dicabut', 
                    );

                  $data = array(
                    'class'        => 'form-control'
                  );

                  echo form_dropdown('regstatus', $options, set_value('regstatus'), $data);
                ?>
                <?php echo form_error('regstatus'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('View', 'view'); ?>
                <?php
                  $data = array(
                    'id'            => 'view',
                    'class'         => 'form-control',
                    'name'          => 'view',
                    'placeholder'   => 'View'
                  );
                  echo form_input($data, set_value('view', null, FALSE));
                ?>
                <?php echo form_error('view'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Sync', 'sync'); ?>
                <?php
                  $options = array( 
                    '0' => 'Pilih Sync', 
                    'tkb' => 'TKB', 
                    'taxes' => 'TX', 
                    'jdi' => 'JDI', 
                    'ortax' => 'O',
                    );

                  $data = array(
                    'class'        => 'form-control'
                  );

                  echo form_dropdown('sync', $options, set_value('sync'), $data);
                ?>
                <?php echo form_error('sync'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('ID_TKB', 'id_tkb'); ?>
                <?php
                  $data = array(
                    'id'            => 'id_tkb',
                    'class'         => 'form-control',
                    'name'          => 'id_tkb',
                    'placeholder'   => 'ID_TKB'
                  );
                  echo form_input($data, set_value('id_tkb', null, FALSE));
                ?>
                <?php echo form_error('id_tkb'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('ID_TR', 'id_tr'); ?>
                <?php
                  $data = array(
                    'id'            => 'id_tr',
                    'class'         => 'form-control',
                    'name'          => 'id_tr',
                    'placeholder'   => 'ID_TR'
                  );
                  echo form_input($data, set_value('id_tr', null, FALSE));
                ?>
                <?php echo form_error('id_tr'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('ID_BC', 'id_bc'); ?>
                <?php
                  $data = array(
                    'id'            => 'id_bc',
                    'class'         => 'form-control',
                    'name'          => 'id_bc',
                    'placeholder'   => 'ID_BC'
                  );
                  echo form_input($data, set_value('id_bc', null, FALSE));
                ?>
                <?php echo form_error('id_bc'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('ID_DJ', 'id_dj'); ?>
                <?php
                  $data = array(
                    'id'            => 'id_dj',
                    'class'         => 'form-control',
                    'name'          => 'id_dj',
                    'placeholder'   => 'ID_DJ'
                  );
                  echo form_input($data, set_value('id_dj', null, FALSE));
                ?>
                <?php echo form_error('id_dj'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('ID_JDI', 'id_jdi'); ?>
                <?php
                  $data = array(
                    'id'            => 'id_jdi',
                    'class'         => 'form-control',
                    'name'          => 'id_jdi',
                    'placeholder'   => 'ID_JDI'
                  );
                  echo form_input($data, set_value('id_jdi', null, FALSE));
                ?>
                <?php echo form_error('id_jdi'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('ID_O', 'id_o'); ?>
                <?php
                  $data = array(
                    'id'            => 'id_o',
                    'class'         => 'form-control',
                    'name'          => 'id_o',
                    'placeholder'   => 'ID_O'
                  );
                  echo form_input($data, set_value('id_o', null, FALSE));
                ?>
                <?php echo form_error('id_o'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('ID_TF', 'id_tf'); ?>
                <?php
                  $data = array(
                    'id'            => 'id_tf',
                    'class'         => 'form-control',
                    'name'          => 'id_tf',
                    'placeholder'   => 'ID_TF'
                  );
                  echo form_input($data, set_value('id_tf', null, FALSE));
                ?>
                <?php echo form_error('id_tf'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Publish', 'publish'); ?>
                <?php
                  $options = array( '0' => 'No', '1' => 'Yes' );

                  $data = array(
                    'class'        => 'form-control'
                  );

                  echo form_dropdown('publish', $options, set_value('publish'), $data);
                ?>
                <?php echo form_error('publish'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Upload PDF', 'file_pdf'); ?>
                <?php
                  $data = array(
                    'id'            => 'file_pdf',
                    'class'         => 'form-control',
                    'name'          => 'file_pdf',
                    'placeholder'   => 'File PDF'
                  );
                  echo form_upload($data, set_value('file_pdf'));
                ?>
                <?php echo $error_file_pdf; ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Reviewed', 'reviewed'); ?>
                <?php
                  $options = array( '0' => 'No', '1' => 'Yes' );

                  $data = array(
                    'class'        => 'form-control'
                  );

                  echo form_dropdown('reviewed', $options, set_value('reviewed'), $data);
                ?>
                <?php echo form_error('reviewed'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Linklist', 'linklist'); ?>
                <?php
                  $options = array( '0' => 'Pilih Topik' );

                  foreach($linklist as $row)
                  {
                    $options[$row['id']] = $row['nomordokumen'];
                  }

                  $data = array(
                    'class'           => 'form-control select2',
                    'multiple'        => 'multiple',
                    'data-placeholder'=> 'Select a Linklist',
                  );

                  echo form_dropdown('linklist[]', $options, set_value('linklist'), $data);
                ?>
                <?php echo form_error('linklist[]'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Statuslist', 'statuslist'); ?>
                <?php
                  $options = array( '0' => 'Pilih Statuslist' );

                  foreach($statuslist as $row)
                  {
                    $options[$row['id']] = $row['nomordokumen'];
                  }

                  $data = array(
                    'class'           => 'form-control select2',
                    'multiple'        => 'multiple',
                    'data-placeholder'=> 'Select a Statuslist',
                  );

                  echo form_dropdown('statuslist[]', $options, set_value('statuslist'), $data);
                ?>
                <?php echo form_error('statuslist[]'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Historylist', 'historylist'); ?>
                <?php
                  $options = array( '0' => 'Pilih Historylist' );

                  foreach($historylist as $row)
                  {
                    $options[$row['id']] = $row['nomordokumen'];
                  }

                  $data = array(
                    'class'           => 'form-control select2',
                    'multiple'        => 'multiple',
                    'data-placeholder'=> 'Select a Historylist',
                  );

                  echo form_dropdown('historylist[]', $options, set_value('historylist'), $data);
                ?>
                <?php echo form_error('historylist[]'); ?>
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