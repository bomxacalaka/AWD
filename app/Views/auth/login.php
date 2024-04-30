<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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


<body>
  <div class="container mt-5">
  <form method="post" action="<?= base_url('auth/check') ?>" autocomplete="off">
        <?= csrf_field(); ?>
        <?php if(!empty(session()->getFlashdata('fail'))) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
        <?php endif ?>
        <?php  if(!empty(session()->getFlashdata('success'))) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('success'); ?></div>
        <?php endif ?>
    <div class="card text-center bg-dark">
    <div class="col-lg-12 login-key">
                    <i class="fa fa-key" aria-hidden="true"></i>
                </div>
      <h1 class="h3 mb-3 fw-normal">Model Appreciator</h1>
      <form>
        <div class="form-floating">
            <input type="email" class="form-control" name="email" id="floatingInput" value="<?= set_value('email'); ?>" placeholder=" " required>
            <span class="text-danger"><?= isset($validation) ? $validation->getError('email') : '' ?></span>
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
        <input type="password" class="form-control" name="password" id="floatingPassword" placeholder=" " required value="<?= set_value('password'); ?>">
                            <span class="text-danger"><?= isset($validation) ? $validation->getError('password') : '' ?></span>
          <label for="floatingPassword">Password</label>
        </div>
        <div class="checkbox mb-3">
        <!-- <label>
            <input type="checkbox" name="remember" value="1"> Remember me
          </label> -->
        </div>
        <button class="btn btn-primary" type="submit">Login</button>
      </form>
      <a href="<?= base_url('auth/register'); ?>" class="btn btn-link">Register</a>
    </div>
    </form>
  </div>
</body>