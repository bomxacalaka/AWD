<h1 class="mb-4">Create Model</h1>
<hr>
<div class="container mt-5">
        <?php if (session()->has('success')) : ?>
            <div class="alert alert-success"><?= session()->get('success') ?></div>
        <?php endif ?>
        <form action="/create-model" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="dataset" class="form-label">Select Dataset:</label>
                <select class="form-select" id="dataset" name="dataset">
                    <option value="huggingface">Hugging Face Dataset</option>
                    <option value="upload">Upload ZIP File</option>
                </select>
            </div>
            <div id="hfTextInput" style="display: none;">
                <div class="mb-3">
                    <label for="hfText" class="form-label">Hugging Face Text Input:</label>
                    <input type="text" class="form-control" id="hfText" name="hfText">
                </div>
            </div>
            <div id="uploadSection" style="display: none;">
                <div class="mb-3">
                    <label for="zipFile" class="form-label">Upload ZIP File:</label>
                    <input type="file" class="form-control" id="zipFile" name="zipFile">
                </div>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Select Model:</label>
                <select class="form-select" id="model" name="model">
                    <option value="model1">Model 1</option>
                    <option value="model2">Model 2</option>
                    <option value="model3">Model 3</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Model</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show/hide input fields based on dataset selection
        document.getElementById('dataset').addEventListener('change', function() {
            var hfTextInput = document.getElementById('hfTextInput');
            var uploadSection = document.getElementById('uploadSection');
            if (this.value === 'huggingface') {
                hfTextInput.style.display = 'block';
                uploadSection.style.display = 'none';
            } else if (this.value === 'upload') {
                hfTextInput.style.display = 'none';
                uploadSection.style.display = 'block';
            } else {
                hfTextInput.style.display = 'none';
                uploadSection.style.display = 'none';
            }
        });
    </script>