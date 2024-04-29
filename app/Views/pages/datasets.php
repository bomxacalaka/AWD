<head>
  <style>
    .middle_card {
      position: relative;
      top: 50%;
      transform: translateY(-50%);
      padding: 10px;
    }
    .middle_parent {
      border: 2px solid black; /* Add border to the parent div */
      border-radius: 10px; /* Optional: Add some border radius for styling */
    }
    .bg-primary {
      background-color: #000 !important;
    }
    .border-primary {
      border-color: #000 !important;
    }
    .btn-primary {
      color: #fff;
      background-color: #000;
      border-color: #333;
    }
    .btn-primary:hover {
      color: #fff;
      background-color: #333;
      border-color: #333;
    }
  </style>
</head>
<div class="container py-3">

  <header>
    <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
      <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal text-light">Find Dataset</h1>
        <p class="fs-5 text-light">Load a dataset to the server to start using them. You can either use HuggingFace's
          repository or load one from a local drive.</p>
      </div>
    </div>
  </header>
  <main>
    <div class="row row-cols-1 row-cols-md-3 mb-3 text-center justify-content-center align-items-center">
      <div class="col col-md-4">
        <div class="card mb-4 rounded-3 shadow-sm">
          <div class="card-header py-3">
            <h4 class="my-0 fw-normal">Online Dataset</h4>
          </div>
          <div class="card-body">
            <a href="https://huggingface.co/datasets" target="_blank" class="text-muted fw-light">from<h1
                class="card-title pricing-card-title">HuggingFace</h1></a>

              <input type="text" name="text" class="form-control mb-3" placeholder="Type here">
            <button type="button" onclick="requestModel()" class="w-100 btn btn-lg btn-primary">Submit</button>
          </div>
        </div>
      </div>
      <div class="col col-md-2">
        <div class="middle_card text-center">
          <div class="card-body">
            <h1 class="card-title pricing-card-title text-light">OR<small class="text-muted fw-light"></small></h1>
          </div>
        </div>
      </div>
      <div class="col col-md-4">
        <div class="card mb-4 rounded-3 shadow-sm border-primary">
          <div class="card-header py-3 text-white bg-primary border-primary">
            <h4 class="my-0 fw-normal">Local Dataset</h4>
          </div>
          <div class="card-body">
            <small class="text-muted fw-light">from</small>
            <h1 class="card-title pricing-card-title">Drive</h1>
            <div class="input-group mb-3">
              <input type="file" class="form-control" id="fileUpload" name="fileUpload" onchange="updateFileName()">
            </div>
            <button type="button" onclick="uploadFile()" class="w-100 btn btn-lg btn-primary">Upload</button>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
</div>
<!-- End of Main content -->

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script>
  function updateFileName() {
    const fileInput = document.getElementById('fileUpload');
    const fileName = fileInput.files[0].name;
    const label = document.querySelector('.input-group-text');
    label.textContent = fileName;
  }

  function uploadFile() {
    const fileInput = document.getElementById('fileUpload');
    const file = fileInput.files[0];
    const formData = new FormData();
    formData.append('file', file);

    fetch('your-upload-endpoint-url', {
      method: 'POST',
      body: formData
    })
      .then(response => {
        if (response.ok) {
          return response.json();
        }
        throw new Error('Network response was not ok.');
      })
      .then(data => {
        console.log(data); // Handle the response data
      })
      .catch(error => {
        console.error('There was a problem with the upload:', error);
      });
  }
</script>
</body>

</html>