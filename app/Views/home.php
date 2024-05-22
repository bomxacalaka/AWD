<head>
    <style>
        .btn-primary {
            width: 40%;
            padding: 10px;
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<header>
    <h1>Welcome toa <code>Model Appreciator</code></h1>
    <hr>
    <p>This website allows you to train and test machine learning models conveniently.</p>
</header>
<main>
    <section>
        <h2>What is Model Appreciator?</h2>
        <p>Model Appreciator is a platform where you can train machine learning models by running code or Docker containers on your computer. You can then send the results back to the server for testing and deployment. Whether you're a beginner or an expert, Model Appreciator provides the tools you need to develop and deploy machine learning models efficiently.</p>
    </section>
    <section>
    <?php if (!session()->get('loggedUserId')): ?>
            <h2>Get Started</h2>
            <p>You can check models and use them on the Models section.</p>
            <p>For training your models, simply sign in or register for an account.</p>
            <div class="gap-2">
                <a href="<?= base_url('/auth'); ?>" class="btn btn-primary">Login</a>
                <a href="<?= base_url('/auth/register'); ?>" class="btn btn-success">Register</a>
            </div>
        <?php endif; ?>
    </section>
</main>

<!-- 
<input type="file" id="fileInput" accept="image/*">
<br>
<button id="downloadQuadrants">Download Quadrants</button> -->

<script>
window.onload = function() {
    // Function to split the image
    function splitImage(img) {
        // Create four separate canvases
        var canvas1 = document.createElement('canvas');
        var ctx1 = canvas1.getContext('2d');
        canvas1.width = img.width / 2;
        canvas1.height = img.height / 2;
        ctx1.drawImage(img, 0, 0, canvas1.width, canvas1.height, 0, 0, canvas1.width, canvas1.height);

        var canvas2 = document.createElement('canvas');
        var ctx2 = canvas2.getContext('2d');
        canvas2.width = img.width / 2;
        canvas2.height = img.height / 2;
        ctx2.drawImage(img, canvas1.width, 0, canvas2.width, canvas2.height, 0, 0, canvas2.width, canvas2.height);

        var canvas3 = document.createElement('canvas');
        var ctx3 = canvas3.getContext('2d');
        canvas3.width = img.width / 2;
        canvas3.height = img.height / 2;
        ctx3.drawImage(img, 0, canvas1.height, canvas3.width, canvas3.height, 0, 0, canvas3.width, canvas3.height);

        var canvas4 = document.createElement('canvas');
        var ctx4 = canvas4.getContext('2d');
        canvas4.width = img.width / 2;
        canvas4.height = img.height / 2;
        ctx4.drawImage(img, canvas1.width, canvas1.height, canvas4.width, canvas4.height, 0, 0, canvas4.width, canvas4.height);

        // Return the canvases
        return [canvas1, canvas2, canvas3, canvas4];
    }

    // Function to handle file input change
    document.getElementById('fileInput').addEventListener('change', function(event) {
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function(event) {
            var img = new Image();
            img.onload = function() {
                // Split the image
                var canvases = splitImage(img);
                // Append the canvases to the body for display
                canvases.forEach(function(canvas) {
                    document.body.appendChild(canvas);
                });
            };
            img.src = event.target.result;
        };

        reader.readAsDataURL(file);
    });

    // Function to handle downloading quadrants
    document.getElementById('downloadQuadrants').addEventListener('click', function() {
        var canvases = document.getElementsByTagName('canvas');
        for (var i = 0; i < canvases.length; i++) {
            var canvas = canvases[i];
            var dataURL = canvas.toDataURL("image/jpeg");
            var a = document.createElement('a');
            a.href = dataURL;
            a.download = 'quadrant' + (i + 1) + '.jpg';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    });
};
</script>