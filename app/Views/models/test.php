
<h1 class="mb-4">Test Models</h1>
<hr>
<div class="container mt-5">
        <?php if (session()->has('success')) : ?>
            <div class="alert alert-success"><?= session()->get('success') ?></div>
        <?php endif ?>
        <form action="/test-models" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="dataset" class="form-label">Select or Drop Dataset:</label>
                <input type="file" class="form-control" id="dataset" name="dataset">
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
            <div class="mb-3">
                <label for="customModel" class="form-label">Upload Custom Model:</label>
                <input type="file" class="form-control" id="customModel" name="customModel">
            </div>
            <button type="submit" class="btn btn-primary">Test Model</button>
        </form>
    </div>