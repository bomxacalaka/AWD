<head>
  <style>
        .btn-primary {
      width: 100%;
      padding: 10px;
      background-color: #000;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
  <form method="post" action="<?= base_url('/auth/check') ?>" autocomplete="off">
        <?= csrf_field(); ?>
        <?php if(!empty(session()->getFlashdata('fail'))) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
        <?php endif ?>
        <?php  if(!empty(session()->getFlashdata('success'))) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('success'); ?></div>
        <?php endif ?>
    <div class="col-lg-12 login-key">
                    <i class="fa fa-key" aria-hidden="true"></i>
                </div>
      <h1 class="h3 mb-3 fw-normal">Model Appreciator</h1>
      <form>
        <span class="text-danger"><?= isset($validation) ? $validation->getError('email') : '' ?></span>
        <div class="form-floating">
            <input type="email" class="form-control" name="email" id="floatingInput" value="<?= set_value('email'); ?>" placeholder=" ">
            <label for="floatingInput">Email address</label>
        </div>
        <span class="text-danger"><?= isset($validation) ? $validation->getError('password') : '' ?></span>
        <div class="form-floating">
        <input type="password" class="form-control" name="password" id="floatingPassword" placeholder=" " value="<?= set_value('password'); ?>">
          <label for="floatingPassword">Password</label>
        </div>
        <div class="checkbox mb-3">
        <!-- <label>
            <input type="checkbox" name="remember" value="1"> Remember me
          </label> -->
        </div>
        <button class="btn btn-primary" type="submit">Login</button>
      </form>
      <a href="<?= base_url('/auth/register'); ?>" class="btn btn-link">Register</a>
    </form>
