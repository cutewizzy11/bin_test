<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corporate Results Entry</title>
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
        }

        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 16px;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            font-size: 14px;
            color: #555;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Corporate Results Entry</h1>
        <form method="post" action="">
            <label for="polling_unit_uniqueid">Polling Unit Unique ID:</label>
            <input type="text" name="polling_unit_uniqueid" id="polling_unit_uniqueid" required>

            <label for="party_abbreviation">Party Abbreviation:</label>
            <input type="text" name="party_abbreviation" id="party_abbreviation" required>

            <label for="party_score">Party Score:</label>
            <input type="number" name="party_score" id="party_score" required>

            <label for="entered_by_user">Entered By User:</label>
            <input type="text" name="entered_by_user" id="entered_by_user" required>

            <label for="user_ip_address">User IP Address:</label>
            <input type="text" name="user_ip_address" id="user_ip_address" required>

            <input type="submit" name="submit" value="Submit Results">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Your PHP code to handle form submission
            $polling_unit_uniqueid = $_POST['polling_unit_uniqueid'];
            $party_abbreviation = $_POST['party_abbreviation'];
            $party_score = $_POST['party_score'];
            $entered_by_user = $_POST['entered_by_user'];
            $user_ip_address = $_POST['user_ip_address'];
        
            // Connect to the database
            $mysqli = new mysqli("localhost", "root", "", "election");
        
            // Check for connection errors
            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error);
            }
        
            // Prepare and execute a query to insert the results into the database
            $query = "INSERT INTO announced_pu_results (polling_unit_uniqueid, party_abbreviation, party_score, entered_by_user, date_entered, user_ip_address) VALUES (?, ?, ?, ?, NOW(), ?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("ssiss", $polling_unit_uniqueid, $party_abbreviation, $party_score, $entered_by_user, $user_ip_address);
            
            if ($stmt->execute()) {
                echo "<p>Results have been successfully recorded.</p>";
            } else {
                echo "<p>Error: " . $mysqli->error . "</p>";
            }
        
            // Close the database connection
            $stmt->close();
            $mysqli->close();
        }        
        ?>
    </div>
</body>
</html>
