<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html>
<head>
    <title>LGA Results</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 400px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        h2 {
            font-size: 20px;
            color: #333;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>LGA Results</h1>

    <form method="post" action="">
        <label for="lga">Select Local Government Area:</label>
        <select name="lga" id="lga">
            <!-- Populate the select box with LGAs from your database -->
            <?php
            // Connect to the database
            $mysqli = new mysqli("localhost", "root", "", "election");
            
            // Check for connection errors
            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error);
            }
            
            // Query to get a list of unique LGAs
            $query = "SELECT DISTINCT polling_unit_uniqueid FROM announced_pu_results";
            $result = $mysqli->query($query);
            
            // Populate the select box
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['polling_unit_uniqueid'] . "'>" . $row['polling_unit_uniqueid'] . "</option>";
            }
            
            // Close the database connection
            $mysqli->close();
            ?>
        </select>
        <input type="submit" value="Show Results">
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the selected LGA ID
        $selectedLGA = $_POST['lga'];

        // Connect to the database
        $mysqli = new mysqli("localhost", "root", "", "election");
        
        // Check for connection errors
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Prepare and execute a query to retrieve the summed results for the selected LGA
        $query = "SELECT SUM(party_score) AS total_score FROM announced_pu_results WHERE polling_unit_uniqueid = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $selectedLGA); // Assuming polling_unit_uniqueid is a string
        $stmt->execute();

        // Get the total score
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $totalScore = $row['total_score'];

        echo "<h2>Total Score for Selected Polling Unit Unique ID: $totalScore</h2>";

        // Close the database connection
        $stmt->close();
        $mysqli->close();
    }
    ?>
</body>
</html>
