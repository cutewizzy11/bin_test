<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to the Dashboard</h1>
    
    <button onclick="redirectToPage1()">Test 1</button>
    <button onclick="redirectToPage2()">Test 2</button>
    <button onclick="redirectToPage3()">Test 3</button>

    <script>
        function redirectToPage1() {
            // Redirect to your PHP page 1
            window.location.href = 'display_polling_unit.php?uniqueid=25';
        }

        function redirectToPage2() {
            // Redirect to your PHP page 2
            window.location.href = 'display_lga_results.php';
        }

        function redirectToPage3() {
            // Redirect to your PHP page 3
            window.location.href = 'input_new_unit.php';
        }
    </script>
</body>
</html>
