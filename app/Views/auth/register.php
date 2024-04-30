  <div class="container mt-5">
    <form method="post" action="<?= base_url('auth/save') ?>" autocomplete="off">
      <?= csrf_field(); ?>
      <?php if(!empty(session()->getFlashdata('fail'))) : ?>
      <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
      <?php endif ?>
      <?php if(!empty(session()->getFlashdata('success'))) : ?>
      <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
      <?php endif ?>
        <div class="col-lg-12 login-key">
          <i class="fa fa-key" aria-hidden="true"></i>
        </div>
        <h1 class="h3 mb-3 fw-normal">Registration Form</h1>
        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'userName') : '' ?></span>
        <div class="form-floating">
          <input type="text" class="form-control" name="userName" value="<?= set_value('userName'); ?>" placeholder=" ">
          <label for="floatingInput">First Name</label>
        </div>
        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'email') : '' ?></span>
        <div class="form-floating">
          <input type="text" class="form-control" name="email" value="<?= set_value('email'); ?>" placeholder=" ">
          <label for="floatingInput">Email address</label>
        </div>
        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'password') : '' ?></span>
        <div class="form-floating">
          <input type="password" class="form-control" name="password" value="<?= set_value('password'); ?>" placeholder=" ">
          <label for="floatingPassword">Password</label>
        </div>
        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'confirmPassword') : '' ?></span>
        <div class="form-floating">
          <input type="password" class="form-control" name="confirmPassword" value="<?= set_value('confirmPassword'); ?>" placeholder=" ">
          <label for="floatingPassword">Confirm Password</label>
        </div>
        <button class="btn btn-primary" type="submit">Register</button>
        <a href="<?= base_url('auth'); ?>" class="btn btn-link">Login</a>
      </div>
    </form>