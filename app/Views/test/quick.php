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
<div class="container">
    <div class="row justify-content-between align-items-center col-md-6">
        <!-- <div class="col-auto">
            <a href="/back" class="btn btn-secondary">Back</a>
        </div> -->
        <h1 class="mb-4"><?= $data['title'] ?></h1>
        <hr>
        <!-- Display flash messages (success or error) -->
        <?php if (session()->has('success')) : ?>
            <div class="alert alert-success"><?= session()->get('success') ?></div>
            <!-- set vars to data -->
            <?php session()->set('model', $data['model']); ?>
            <?php session()->set('user_id', $data['user_id']); ?>
        <?php endif ?>
        <?php if (session()->has('error')) : ?>
            <div class="alert alert-danger"><?= session()->get('error') ?></div>
        <?php endif ?>

        <!-- Display user's current profile picture (if available) -->
        <?php if ($data['user_id']) : ?>
            <img src="<?= base_url('/test/quick/pic/current/' . $data['user_id']) ?>" class="img-fluid rounded mb-4" alt="Profile Picture" width="200" height="200">
        <?php endif ?>
        <div id="cameraContainer">
    <video id="cameraFeed" width="400" height="300" autoplay></video>
</div>
<!-- 
        <div class="mb-3 mt-3">
        <button onclick="capture()" class="btn btn-primary" id="captureButton">Capture</button>
        </div>
        <div class="mb-3 mt-3">
        <button onclick="predict()" class="btn btn-primary">Predict</button>
        </div> -->

        <!-- Display the status of the prediction -->
        <div id="status"></div>
        
    </div>
</div>



  <canvas id="canvas" style="display:none;"></canvas>
  <!-- <button id="uploadButton">Upload Picture</button> -->

  <script>
    const video = document.getElementById('cameraFeed');
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    // const captureButton = document.getElementById('captureButton');
    // const uploadButton = document.getElementById('uploadButton');

    // Access the device camera and stream the feed to the video element
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(stream => {
        video.srcObject = stream;
      })
      .catch(error => {
        console.error('Error accessing camera:', error);
      });

    // Capture the current frame from the video feed and display it on canvas
    function capture() {
      ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
      uploadFromCanvas();
    }

    // Capture the frame when the capture button is clicked
    // captureButton.addEventListener('click', capture);

    // Send the captured image to the server when upload button is clicked
    function uploadFromCanvas() {
      const imageData = canvas.toDataURL(); // Get image data from canvas
      // Simulate uploading by logging the image data
      const file = dataURLtoFile(imageData, 'profile_picture.png');
        const formData = new FormData();
        formData.append('profile_picture', file);

        fetch('/test/quick/pic', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.status === 'success') {
                    // Display success message on successful on the page
                    document.getElementById('status').innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    predict();
                } else {
                    // Display error message on the page
                    document.getElementById('status').innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while uploading the profile picture.');
            });
    }

    // Function to convert base64 image to file
    function dataURLtoFile(dataurl, filename) {
      const arr = dataurl.split(',');
      const mime = arr[0].match(/:(.*?);/)[1];
      const bstr = atob(arr[1]);
      let n = bstr.length;
      const u8arr = new Uint8Array(n);
      while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
      }
      return new File([u8arr], filename, { type: mime });
    }

    function predict() {
        // const model = document.getElementById('model').value;
        // const user_id = document.getElementById('user_id').value;
        const url = `quick/predict`;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.status === 'success') {
                    document.getElementById('status').innerHTML = `<div class="alert alert-success">${data.output.prediction}</div>`;
                } else {
                    document.getElementById('status').innerHTML = `<div class="alert alert-danger">Failed</div>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function uploadPic() {
        const file = document.getElementById('file').files[0];
        const formData = new FormData();
        formData.append('profile_picture', file);

        fetch('/test/quick/pic', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.status === 'success') {
                    // Display success message on successful on the page
                    document.getElementById('status').innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                } else {
                    // Display error message on the page
                    document.getElementById('status').innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while uploading the profile picture.');
            });
    }
    
    setInterval(capture, 1500);
</script>