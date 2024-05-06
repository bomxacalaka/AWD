<head>
  <style>
    .list-group-item {
      cursor: pointer;
    }

    .random-div {
      height: 50px;
      background-color: #ccc;
      margin-bottom: 10px;
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
  </style>
</head>
</style>
</head>


<h1><?= $title; ?></h1>
<!-- thin line under the title -->
<hr>

<div class="container mt-2">
  <div class="row">
    <div class="col-md-4">
      <ul class="list-group">
        <h2 class="mb-3">Dataset</h2>
        <a href="/dataset/uploads" class="btn btn-primary">Upload</a>
        <?php foreach ($datasets as $dataset): ?>
          <li class="list-group-item d-flex justify-content-center align-items-center"
            onclick="toggleCheckbox(this, 'datasets')">
            <div>
              <input class="form-check-input" id="datasets" type="checkbox" name="selected_datasets[]"
                value="<?php echo $dataset; ?>" id="<?php echo $dataset; ?>" style="display: none;">
              <label class="form-check-label" for="<?php echo $dataset; ?>">
                <?php echo $dataset; ?>
              </label>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="col-md-4">
      <ul class="list-group">
        <h2 class="mb-3">Model</h2>
        <a href="/model/uploads" class="btn btn-primary">Upload</a>
        <?php foreach ($models as $model): ?>
          <li class="list-group-item d-flex justify-content-center align-items-center"
            onclick="toggleCheckbox(this, 'models')">
            <div>
              <input class="form-check-input" id="models" type="checkbox" name="selected_models[]"
                value="<?php echo $model; ?>" id="<?php echo $model; ?>" style="display: none;">
              <label class="form-check-label" for="<?php echo $model; ?>">
                <?php echo $model; ?>
              </label>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="col-md-4">
      <ul class="list-group">
        <h2 class="mb-3">Script</h2>
        <a href="" class="btn btn-primary" style="pointer-events: none;">Pick</a>
        <?php foreach ($scripts as $script): ?>
          <li class="list-group-item d-flex justify-content-center align-items-center"
            onclick="toggleCheckbox(this, 'scripts')">
            <div>
              <input class="form-check-input" id="scripts" type="checkbox" name="selected_scripts[]"
                value="<?php echo $script; ?>" id="<?php echo $script; ?>" style="display: none;">
              <label class="form-check-label" for="<?php echo $script; ?>">
                <?php echo $script; ?>
              </label>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>

<div class="container mt-5">
  <div class="row">
    <div class="col">
    </div>
    <div class="col-md-auto">
      <button type="submit" id="runScriptButton" class="btn btn-primary">Submit</button>
    </div>
    <div class="col">
    </div>
  </div>
</div>

<hr>

<div class="container mt-2">
  <div class="row justify-content-center"> <!-- Center the content -->
    <div class="col-md-4">
      <ul class="list-group">

      </ul>
    </div>

    <ul class="list-group rounded" id="results">
      <h2 class="mb-3">Results</h2>
      <a href="" class="btn btn-primary" id="Appreciator" style="pointer-events: none; display: none;">Appreciate</a>
      <!-- Hide the button by default -->
      <!-- Results will be dynamically added here -->
    </ul>
    <div id="output"></div>

    <div class="col-md-4">
      <ul class="list-group">

      </ul>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-auto">
    </div>
  </div>
</div>


<div class="container mt-5">
  <div class="row">
    <div class="col">
    </div>
    <div class="col-md-auto">
      <button class="btn btn-primary" id="shareButton" style="display: none;">Publish</button>
    </div>
    <div class="col">
    </div>
  </div>
</div>


<script>
  // Function to toggle checkbox when clicking on list item
  function toggleCheckbox(li, listType) {
    const checkbox = li.querySelector('input[type="checkbox"]');
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');

    // Uncheck all checkboxes in the same list
    checkboxes.forEach((cb) => {
      if (cb.id === listType) {
        cb.checked = false;
        cb.parentElement.parentElement.style.backgroundColor = '#fff';
        cb.parentElement.parentElement.style.color = '#000';
      }
    });

    // Check the clicked checkbox
    checkbox.checked = true;
    li.style.backgroundColor = '#222';
    li.style.color = '#ffffff';
  }

  var count = 0;
  var results = [];
  // Function to make AJAX request to the PHP endpoint
  function runPythonScript() {
    // Get the selected datasets
    const selectedDatasets = Array.from(document.querySelectorAll('input[name="selected_datasets[]"]'))
      .filter(cb => cb.checked)
      .map(cb => cb.value);

    // Get the selected models
    const selectedModels = Array.from(document.querySelectorAll('input[name="selected_models[]"]'))
      .filter(cb => cb.checked)
      .map(cb => cb.value);

    // Get the selected scripts
    const selectedScripts = Array.from(document.querySelectorAll('input[name="selected_scripts[]"]'))
      .filter(cb => cb.checked)
      .map(cb => cb.value);

    // Make AJAX request to the PHP endpoint
    fetch('<?= site_url('test/run') ?>?datasets=' + selectedDatasets + '&models=' + selectedModels + '&script=' + selectedScripts)
      .then(response => response.json())
      .then(data => {
        console.log(data);

        let resultsString = '';
        for (const key in data) {
          resultsString += `<strong>${key}:</strong> ${data[key]}<br>`;
        }

        const toSelect = selectedDatasets + selectedModels + selectedScripts + resultsString;

        // Add the response to the results list
        const resultsList = document.getElementById('results');
        const listItem = document.createElement('li');
        listItem.classList.add('list-group-item');
        // Add all values from the response to the list item with a share button
        listItem.innerHTML += `<li class="list-group-item d-flex justify-content-center align-items-center" onclick="toggleCheckbox(this, 'results')">
            <div>
            <input class="form-check-input" id="results" type="checkbox" name="selected_results[]" value="${count}" id="${toSelect}" style="display: none;">
            <label class="form-check
            -label" for="${toSelect}">
            <strong>${selectedDatasets}</strong><br>+
            <br><strong>${selectedModels}</strong><br>+
            <br><strong>${selectedScripts}</strong><br>=
            <br><strong>${resultsString}</strong><br>
            </label>
            </div>
          </li>`
        // for (const key in data) {
        //   listItem.innerHTML += `
        //     <strong>${key}:</strong> ${data[key]}<br>`;
        // }
        // listItem.innerHTML += `
        //     </label>
        //     </div>
        //   </li>`
        resultsList.appendChild(listItem);


        // Scroll to the bottom of the list
        resultsList.scrollTop = resultsList.scrollHeight;


        // id="Appreciator" set to display: none; by default
        document.getElementById('Appreciator').style.display = 'block';

        // Share button set display: block; after the first result is added
        document.getElementById('shareButton').style.display = 'block';

        count++;
        results.push([selectedDatasets, selectedModels, selectedScripts, data]);
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

  // Share button event listener
  function shareB() {
    // Get the selected results
    const selectedResults = Array.from(document.querySelectorAll('input[name="selected_results[]"]'))
      .filter(cb => cb.checked)
      .map(cb => cb.value);

    sDataset = results[selectedResults][0];
    sModel = results[selectedResults][1];
    sScript = results[selectedResults][2];
    sData = results[selectedResults][3];
    sResults = "";
    for (const key in sData) {
      console.log(key, sData[key]);
      sResults += `,${key}:${sData[key]}`;
    }

    sEverything = `datasets=${sDataset}&models=${sModel}&scripts=${sScript}&results=${sResults}`;
    

    // Make AJAX request to the PHP endpoint
    fetch('<?= site_url('test/share') ?>?' + sEverything)
      .then(response => response.json())
      .then(data => {
        console.log(data);
      })
      .catch(error => {
        console.error('Error:', error);
      });
  };
  document.getElementById('shareButton').addEventListener('click', shareB);

  // Add event listener to the button to run the script
  document.getElementById('runScriptButton').addEventListener('click', runPythonScript);
</script>