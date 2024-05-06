<style>
        /* Custom CSS for the leaderboard */
        .container {
            padding-top: 50px;
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead th {
            background-color: #343a40;
            color: #ffffff;
            font-weight: bold;
            border-color: #343a40;
        }

        .table tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }
    </style>
</head>

<body>
    <h1 class="mb-4 text-center">Leaderboard</h1>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Model Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Assuming $users is an array containing user data with their model scores
                    $users = [
                        ['username' => 'User1', 'score' => 85],
                        ['username' => 'User2', 'score' => 92],
                        ['username' => 'User3', 'score' => 78],
                        // Add more users here
                    ];

                    // Loop through each user and display their data in table rows
                    foreach ($users as $index => $user) {
                        echo "<tr>";
                        echo "<th scope='row'>" . ($index + 1) . "</th>";
                        echo "<td>" . $user['username'] . "</td>";
                        echo "<td>" . $user['score'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>