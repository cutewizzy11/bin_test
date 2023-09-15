<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Polling Unit Results</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            max-width: 800px;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .no-results {
            font-size: 18px;
            color: #555;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Polling Unit Results</h1>

    <?php
    // Connect to the database
    $mysqli = new mysqli("localhost", "root", "", "election");
    
    // Check for connection errors
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    
    // Get the uniqueid from the URL parameter
    $uniqueid = $_GET['uniqueid'];
    
    // Prepare and execute a query to retrieve results for the specified uniqueid
    $query = "SELECT * FROM polling_unit WHERE uniqueid = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $uniqueid); // Assuming uniqueid is an integer
    $stmt->execute();
    
    // Process and display the results
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<h2>Results for Polling Unit with Unique ID: $uniqueid</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Ward ID</th><th>LGA ID</th><th>Unique Ward ID</th><th>Polling Unit Number</th><th>Polling Unit Description</th><th>Latitude</th><th>Longitude</th><th>Entered By User</th><th>Date Entered</th><th>User IP Address</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['ward_id'] . "</td>";
            echo "<td>" . $row['lga_id'] . "</td>";
            echo "<td>" . $row['uniquewardid'] . "</td>";
            echo "<td>" . $row['polling_unit_number'] . "</td>";
            echo "<td>" . $row['polling_unit_description'] . "</td>";
            echo "<td>" . $row['lat'] . "</td>";
            echo "<td>" . $row['long'] . "</td>";
            echo "<td>" . $row['entered_by_user'] . "</td>";
            echo "<td>" . $row['date_entered'] . "</td>";
            echo "<td>" . $row['user_ip_address'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "No results found for Polling Unit with Unique ID: $uniqueid";
    }
    
    // Close the database connection
    $stmt->close();
    $mysqli->close();
    ?>
</body>
</html>
