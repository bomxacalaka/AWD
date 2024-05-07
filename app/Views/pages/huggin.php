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

    </style>
</head>

<h1 class="mb-4">HugginSet</h1>
        <hr>
        <h2>Search for a dataset</h2>
        <p>Enter the name of a dataset to display the first few rows.</p>
        <p>For example, try entering <code>rotten_tomatoes</code>.</p>
        <p>Click the <code>Display</code> button to show the dataset.</p>
        <p>For more information, visit the <a href="https://huggingface.co/datasets">Hugging Face Datasets</a> website.</p>
        <hr>
<div class="container mt-5">
<div class="search-container">
    <input type="text" id="searchInput" class="form-control search-input" placeholder="Search...">
    <button onclick="displayDataset()" class="btn btn-primary">Display</button>
</div>
</div>

<div class="container mt-5">
    <div class="search-container">
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped rounded" id="resultsTable">
                <tbody id="resultsBody">
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function displayDataset() {
        const searchInput = document.getElementById('searchInput').value || 'rotten_tomatoes';
        fetch('https://datasets-server.huggingface.co/first-rows?dataset=' + searchInput + '&config=default&split=train',
)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                console.log(data['rows'][0]['row']['text'], data['rows'][0]['row']['label']);
                const resultsBody = document.getElementById('resultsBody');
                resultsBody.innerHTML = '';
                // Add the titles to each column from data['features'][0]['name']
                data['features'].forEach(name => {
                    const th = document.createElement('th');
                    th.textContent = name['name'];
                    th.style.textTransform = 'capitalize';
                    th.style.fontWeight = 'bold';
                    th.style.border = '1px solid black';
                    th.style.padding = '5px';
                    th.style.textAlign = 'center';
                    th.style.backgroundColor = '#f0f0f0';
                    th.style.color = 'black';
                    th.style.borderRadius = '5px';
                    th.style.margin = '5px';
                    th.style.width = '50%';
                    th.style.height = '50%';
                    th.style.borderCollapse = 'collapse';
                    th.style.borderSpacing = '0';
                    th.style.borderStyle = 'solid';
                    th.style.borderWidth = '1px';
                    th.style.borderColor = 'black';
                    th.style.borderRadius = '5px';
                    resultsBody.appendChild(th);
                });
                data['rows'].forEach(row => {
                    const tr = document.createElement('tr');
                    const td1 = document.createElement('td');
                    td1.textContent = row['row']['text'];
                    const td2 = document.createElement('td');
                    td2.textContent = row['row']['label'];
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    resultsBody.appendChild(tr);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>