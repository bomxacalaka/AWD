<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/png" href="/assets/logo.svg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    /*
        body {
      overflow-x: hidden;
    }


    .container {
      margin-top: 20px;
    }

    .left-block,
    .right-block {
      padding: 20px;
      border-radius: 8px;
    }

    .left-block {
      background-color: #f0f0f0;
      margin-right: 20px;
    }

    .right-block {
      background-color: #e0e0e0;
    }

    .form {
      margin-top: 20px;
    }

    .input,
    .file-input {
      width: 100%;
      margin-bottom: 15px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    .file-label {
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }
    */
    .btn {
      padding: 10px 20px;
      border: none;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }

    html,
    body {
      max-width: 100%;
      overflow-x: hidden;
    }

    .navbar {
      border-bottom: 1px solid #444;
    }
  </style>

</head>

<body>


  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-black">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="https://h.drbom.net/logo" alt="Logo" width="40" height="40" style="border-radius: 50%;">
      </a>


      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <form class="me-3">
          <div class="input-group">
            <input type="search" class="form-control rounded" placeholder="Search or jump to... ( / )"
              aria-label="Search" aria-describedby="search-addon">
          </div>
        </form>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="#">Pull request</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Issues</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Marketplace</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Explore</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="fas fa-plus"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              <img src="https://mdbootstrap.com/img/Photos/Avatars/img (31).jpg" class="rounded-circle" height="22"
                alt="" loading="lazy">
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown1">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End of Navbar -->

  <!-- Add some space below the header -->
  <div style="height: 50px;"></div>

  <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title; ?></title>
  <style>
    /* Styles for centering the card */
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      width: 3000px;
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
    <div class="card text-center bg-dark">