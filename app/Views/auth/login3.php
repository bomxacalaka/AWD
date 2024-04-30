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
  <div class="container mt-5">
    <div class="card text-center bg-dark">
      <h1 class="h3 mb-3 fw-normal">Model Appreciator</h1>
      <form>
        <div class="form-floating">
          <input type="email" class="form-control" id="floatingInput" placeholder=" " required>
          <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="floatingPassword" placeholder=" " required>
          <label for="floatingPassword">Password</label>
        </div>
        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-primary" type="submit">Login</button>
      </form>
    </div>
  </div>
</body>