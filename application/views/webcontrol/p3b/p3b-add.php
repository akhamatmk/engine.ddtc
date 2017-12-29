<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      P3B
      <small>Add New</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>webcontrol/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo site_url(); ?>webcontrol/p3b">P3B</a></li>
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
            <h3 class="box-title">P3B Form</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <?php
            $attributes = array('role' => 'form', 'id' => 'form-ajax');
            echo form_open('webcontrol/p3b/add');
          ?>
            <div class="box-body">
              <div class="form-group">
                <?php echo form_label('Country', 'p3b_country'); ?>
                <?php
                  $data = array(
                    'id'            => 'p3b_country',
                    'class'         => 'form-control',
                    'name'          => 'p3b_country',
                    'placeholder'   => 'Country'
                  );
                  echo form_input($data, set_value('p3b_country', null, FALSE));
                ?>
                <?php echo form_error('p3b_country'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Signed Date', 'p3b_date_signed'); ?>
                <?php
                  $data = array(
                    'id'            => 'p3b_date_signed',
                    'class'         => 'form-control',
                    'name'          => 'p3b_date_signed',
                    'placeholder'   => 'Signed Date'
                  );
                  echo form_input($data, set_value('p3b_date_signed', null, FALSE));
                ?>
                <?php echo form_error('p3b_date_signed'); ?>
              </div>

              <div class="form-group">
                <?php echo form_label('Effective Date', 'p3b_date_effective'); ?>
                <?php
                  $data = array(
                    'id'            => 'p3b_date_effective',
                    'class'         => 'form-control',
                    'name'          => 'p3b_date_effective',
                    'placeholder'   => 'Effective Date'
                  );
                  echo form_input($data, set_value('p3b_date_effective', null, FALSE));
                ?>
                <?php echo form_error('p3b_date_effective'); ?>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <?php echo form_label('Header [ID]', 'p3b_header_id'); ?>
                    <?php
                      $data = array(
                        'id'            => 'p3b_header_id',
                        'class'         => 'form-control ckeditor',
                        'name'          => 'p3b_header_id'
                      );
                      echo form_textarea($data, set_value('p3b_header_id', null, FALSE));
                    ?>
                    <?php echo form_error('p3b_header_id'); ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <?php echo form_label('Header [EN]', 'p3b_header_en'); ?>
                    <?php
                      $data = array(
                        'id'            => 'p3b_header_en',
                        'class'         => 'form-control ckeditor',
                        'name'          => 'p3b_header_en'
                      );
                      echo form_textarea($data, set_value('p3b_header_en', null, FALSE));
                    ?>
                    <?php echo form_error('p3b_header_en'); ?>
                  </div>
                </div>
              </div>

            <?php
            $p3b_article_title = array();

            for($i = 0 ; $i < 40 ; $i++)
            {
            ?>
              <hr>
              <div class="row">
                <div class="col-md-12">
                  <h4 class="text-center">ARTICLE <?php echo $i+1; ?></h4>
                  <input type="hidden" value="<?php echo $i+1; ?>" name="check[]">
                  <div class="form-group">
                    <?php echo form_label('Chapter', 'p3b_chapter[]'); ?>
                    <?php
                      $options = array(
                        '0'            => 'None',
                        '1'            => 'Chapter I',
                        '2'            => 'Chapter II',
                        '3'            => 'Chapter III',
                        '4'            => 'Chapter IV',
                        '5'            => 'Chapter V',
                        '6'            => 'Chapter VI',
                        '7'            => 'Chapter VII',
                        '8'            => 'Chapter VIII',
                        '9'            => 'Chapter IX',
                        '10'           => 'Chapter X',
                        '11'           => 'Chapter XI',
                        '12'           => 'Chapter XII',
                        '13'           => 'Chapter XIII',
                        '14'           => 'Chapter XIV',
                        '15'           => 'Chapter XV',
                      );

                      $data = array(
                        'class'        => 'form-control'
                      );

                      echo form_dropdown('p3b_chapter[]', $options, set_value('p3b_chapter[]'), $data);
                    ?>
                    <?php echo form_error('p3b_chapter[]'); ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <?php echo form_label('Chapter Title [ID]', 'p3b_chapter_title_id[]'); ?>
                    <?php
                      $data = array(
                        'id'            => 'p3b_chapter_title_id[]',
                        'class'         => 'form-control',
                        'name'          => 'p3b_chapter_title_id[]',
                        'placeholder'   => 'Chapter Title [ID]'
                      );
                      echo form_input($data, set_value('p3b_chapter_title_id[]', null, FALSE));
                    ?>
                    <?php echo form_error('p3b_chapter_title_id[]'); ?>
                  </div>
                  <div class="form-group">
                    <?php echo form_label('Article Title [ID]', 'p3b_article_title_id[]'); ?>
                    <?php
                      $data = array(
                        'id'            => 'p3b_article_title_id[]',
                        'class'         => 'form-control',
                        'name'          => 'p3b_article_title_id[]',
                        'placeholder'   => 'Article Title [ID]'
                      );
                      echo form_input($data, set_value('p3b_article_title_id[]', null, FALSE));
                    ?>
                    <?php echo form_error('p3b_article_title_id[]'); ?>
                  </div>
                  <div class="form-group">
                    <?php echo form_label('Article Content [ID]', 'p3b_article_content_id[]'); ?>
                    <?php
                      $data = array(
                        'id'            => 'p3b_article_content_id[]',
                        'class'         => 'form-control ckeditor',
                        'name'          => 'p3b_article_content_id[]'
                      );
                      echo form_textarea($data, set_value('p3b_article_content_id[]', null, FALSE));
                    ?>
                    <?php echo form_error('p3b_article_content_id[]'); ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <?php echo form_label('Chapter Title [EN]', 'p3b_chapter_title_en[]'); ?>
                    <?php
                      $data = array(
                        'id'            => 'p3b_chapter_title_en[]',
                        'class'         => 'form-control',
                        'name'          => 'p3b_chapter_title_en[]',
                        'placeholder'   => 'Chapter Title [EN]'
                      );
                      echo form_input($data, set_value('p3b_chapter_title_id[]', null, FALSE));
                    ?>
                    <?php echo form_error('p3b_chapter_title_id[]'); ?>
                  </div>
                  <div class="form-group">
                    <?php echo form_label('Article Title [EN]', 'p3b_article_title_en[]'); ?>
                    <?php
                      $data = array(
                        'id'            => 'p3b_article_title_en[]',
                        'class'         => 'form-control',
                        'name'          => 'p3b_article_title_en[]',
                        'placeholder'   => 'Article Title [EN]'
                      );
                      echo form_input($data, set_value('p3b_article_title_en[]', null, FALSE));
                    ?>
                    <?php echo form_error('p3b_article_title_en[]'); ?>
                  </div>
                  <div class="form-group">
                    <?php echo form_label('Article Content [EN]', 'p3b_article_content_en[]'); ?>
                    <?php
                      $data = array(
                        'id'            => 'p3b_article_content_en[]',
                        'class'         => 'form-control ckeditor',
                        'name'          => 'p3b_article_content_en[]'
                      );
                      echo form_textarea($data, set_value('p3b_article_content_en[]', null, FALSE));
                    ?>
                    <?php echo form_error('p3b_article_content_en[]'); ?>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
              <hr>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <?php echo form_label('Protocol [ID]', 'p3b_protocol_id'); ?>
                    <?php
                      $data = array(
                        'id'            => 'p3b_protocol_id',
                        'class'         => 'form-control ckeditor',
                        'name'          => 'p3b_protocol_id'
                      );
                      echo form_textarea($data, set_value('p3b_protocol_id', null, FALSE));
                    ?>
                    <?php echo form_error('p3b_protocol_id'); ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <?php echo form_label('Protocol [EN]', 'p3b_protocol_en'); ?>
                    <?php
                      $data = array(
                        'id'            => 'p3b_protocol_en',
                        'class'         => 'form-control ckeditor',
                        'name'          => 'p3b_protocol_en'
                      );
                      echo form_textarea($data, set_value('p3b_protocol_en', null, FALSE));
                    ?>
                    <?php echo form_error('p3b_protocol_en'); ?>
                  </div>
                </div>
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