<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <style>
    /* Styles for centering the card */
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      width: 300px;
      padding: 20px;
      border: 1px solid #333;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      color: #fff;
    }
    /* Custom styles for the form */
    .form-floating input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .form-floating label {
      color: #ccc; /* Change hint color */
    }
    .form-floating input:focus::placeholder {
      color: transparent; /* Hide placeholder text when input is focused */
    }
    .btn-primary {
      width: 100%;
      padding: 10px;
      background-color: #000;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .btn-primary:hover {
      background-color: #333;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <form method="post" action="<?= base_url('auth/save') ?>" autocomplete="off">
      <?= csrf_field(); ?>
      <?php if(!empty(session()->getFlashdata('fail'))) : ?>
      <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
      <?php endif ?>
      <?php if(!empty(session()->getFlashdata('success'))) : ?>
      <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
      <?php endif ?>
      <div class="card text-center bg-dark">
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
  </div>
</body>
