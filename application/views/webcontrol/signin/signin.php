<div class="login-box">
  <div class="login-logo">
    <!--<a href="<?php echo site_url(); ?>"><b>TAX</b>ENGINE</a>-->
    <a href="<?php echo site_url(); ?>"><img src="http://engine.ddtc.co.id/assets/themes/images/logo_DDtax1_new.png"></a>
  </div><!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <?php
      $attributes = array('role' => 'form', 'id' => 'form-ajax');
      echo form_open('webcontrol/signin');
    ?>
      <div class="form-group has-feedback">
        <?php
          $data = array(
            'id'            => 'admin_email',
            'class'         => 'form-control',
            'name'          => 'admin_email',
            'placeholder'   => 'Email'
          );
          echo form_input($data, set_value('admin_email'));
        ?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <?php echo form_error('admin_email'); ?>
      </div>
      <div class="form-group has-feedback">
        <?php
          $data = array(
            'id'            => 'admin_password',
            'class'         => 'form-control',
            'name'          => 'admin_password',
            'placeholder'   => 'Password'
          );
          echo form_password($data, set_value('admin_password'));
        ?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <?php echo form_error('admin_password'); ?>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <?php
            $data = array(
              'id'            => 'btn-submit',
              'class'         => 'btn btn-primary btn-block btn-flat',
              'name'          => 'btn-submit',
              'type'          => 'submit',
              'content'       => 'Sign In'
            );
            echo form_button($data);
          ?>
        </div>
      </div>
    <?php
      echo form_close();

      echo $error;
    ?>

  </div><!-- /.login-box-body -->
</div><!-- /.login-box -->