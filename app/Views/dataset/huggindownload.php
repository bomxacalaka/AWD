<!-- This is your view template -->
<head>
    <style>
        /* Additional custom styling can be added here */
        .search-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .search-input {
            flex: 1;
            margin-right: 10px;
        }
        .btn-short {
      width: 40%;
    }
        .btn-long {
      width: 100%;
    }
    </style>
</head>

<!-- 2 columns for back button and title -->
<div class="container">
    <div class="row justify-content-between align-items-center col-md-6">
        <div class="col-auto">
            <a href="/dataset" class="btn btn-primary btn-long">Back</a>
        </div>
        <h1 class="mb-4">HugginSet</h1>
        <!-- instructions -->
        <p>Enter the dataset name to download the dataset.</p>
        <p>Example: <code>m-a-p/COIG-CQIA</code></p>
        <p>It will be downloaded to your private storage.</p>
        <hr>
        <!-- Display flash messages (success or error) -->
        <?php if (session()->has('success')) : ?>
            <div class="alert alert-success"><?= session()->get('success') ?></div>
        <?php endif ?>
        <?php if (session()->has('error')) : ?>
            <div class="alert alert-danger"><?= session()->get('error') ?></div>
        <?php endif ?>
    </div>
</div>

<!-- status placeholder -->
<div id="status"></div>
<div class="container mt-5">
    <div class="search-container">
        <input type="text" id="searchInput" class="form-control search-input" placeholder="Enter dataset name...">
        <button onclick="downloadDataset()" class="btn btn-primary">Download</button>
    </div>
</div>

<script>
    function downloadDataset() {
        const searchInput = document.getElementById('searchInput').value.trim() || 'm-a-p/COIG-CQIA';
        
        const url = `huggin/download?dataset=${encodeURIComponent(searchInput)}`;
        fetch(url)
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
                alert('An error occurred while downloading the dataset.');
            });
    }
</script>

