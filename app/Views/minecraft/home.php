<head>
    <meta name="csrf-token" content="<?= csrf_token() ?>">
</head>

<?php foreach ($mc_info as $data): ?>
    <div class="data">
        <p><?= $data ?></p>
    </div>
<?php endforeach; ?>

<ul id="itemList"></ul>

<form id="modForm">
    <label for="modInput">Add Mod:</label>
    <input type="text" id="modInput" name="modInput">
    <button type="button" id="addModButton">Add</button>
</form>

<!-- forge add forms -->
<form id="forgeForm">
    <label for="forgeInput">Add Forge:</label>
    <input type="text" id="forgeInput" name="forgeInput">
    <button type="button" id="addForgeButton">Add</button>
</form>

<ul id="selectedMods">
    <?php foreach ($mods as $data): ?>
        <li><?= $data['name'] ?></li>
    <?php endforeach; ?>
</ul>

<ul id="forgeVersionsList">
<?php foreach ($forge_versions as $data): ?>
    <div class="data">
        <label><input type="checkbox" name="forgeVersions" value="<?= $data ?>"> <?= $data ?></label>
    </div>
<?php endforeach; ?>
</ul>

<button id="submitButton">Submit</button>

<!-- page view -->
<p>Page views: <?= $viewCount ?></p>


<script>
    console.log('<?= json_encode($test) ?>');
    // Array to hold selected mods
    let selectedMods = [];

    // Add mod button event listener
    document.getElementById('addModButton').addEventListener('click', function() {
        let modInput = document.getElementById('modInput').value.trim();
        // if (modInput !== '') {
        //     selectedMods.push(modInput);
        //     renderSelectedMods();
        //     document.getElementById('modInput').value = '';
        // }
        // Add mod to database
        fetch('<?= base_url('/server/addMod') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ mod: modInput })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                console.log(data);
            } else {
                alert('Failed to add mod.');
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Add forge button event listener
    document.getElementById('addForgeButton').addEventListener('click', function() {
        let forgeInput = document.getElementById('forgeInput').value.trim();
        // if (forgeInput !== '') {
        //     selectedMods.push(forgeInput);
        //     renderSelectedMods();
        //     document.getElementById('forgeInput').value = '';
        // }
        // Add forge to database
        fetch('<?= base_url('/server/addForge') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ forge: forgeInput })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                console.log(data);
            } else {
                alert('Failed to add forge.');
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Function to render selected mods
    function renderSelectedMods() {
        let selectedModsList = document.getElementById('selectedMods');
        selectedModsList.innerHTML = '';
        selectedMods.forEach(function(mod) {
            let li = document.createElement('li');
            li.textContent = mod;
            selectedModsList.appendChild(li);
        });
    }

    // Submit button event listener
    document.getElementById('submitButton').addEventListener('click', function() {
        let selectedForgeVersions = [];
        document.querySelectorAll('input[name="forgeVersions"]:checked').forEach(function(checkbox) {
            selectedForgeVersions.push(checkbox.value);
        });
        

        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('<?= base_url('/server/form') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ forgeVersions: selectedForgeVersions, mods: selectedMods })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                console.log(data.items);
            } else {
                alert('Failed to submit items.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
