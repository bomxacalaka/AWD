<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Script run</title>
</head>
<body>
    <div class="container">
        <button id="runScriptButton">Run Script</button>
        <div id="output"></div>
    </div>

    <script>
        // Function to make AJAX request to the PHP endpoint
        function runPythonScript() {
            // Make AJAX request to the PHP endpoint
            fetch('<?= site_url('python') ?>')
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // Update HTML content with the response
                    document.getElementById('output').innerHTML = `
                        <p>Loss: ${data.data.loss}</p>
                        <p>Accuracy: ${data.data.accuracy}</p>
                    `;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Add event listener to the button to run the script
        document.getElementById('runScriptButton').addEventListener('click', runPythonScript);
    </script>
</body>
</html>
