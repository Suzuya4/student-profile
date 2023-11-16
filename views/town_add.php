<?php
include_once("../db.php"); // Include the Database class file
include_once("../student.php"); // Include the Student class file
include_once("../student_details.php"); // Include the Student class file
include_once("../town_city.php");
include_once("../province.php");




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [    
    'name' => $_POST['name'],
    ];
    // Instantiate the Database and Student classes
    $database = new Database();
    $student = new TownCity($database);
    $town_id = $student->create($data);
    
    if ($town_id) {
        // Student record successfully created
        
        // Retrieve student details from the form
        $studentDetailsData = [
            'id' => $town_id, // Use the obtained student ID
            // Other student details fields
        ];

        // Create student details linked to the student
        $studentDetails = new StudentDetails($database);
        
        if ($studentDetails->create($studentDetailsData)) {
            echo "Record inserted successfully.";
        } else {
            echo "Failed to insert the record.";
        }
    }

    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">

    <title>Add Student Data</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h1>Add Student Data</h1>
    <form action="" method="post" class="centered-form">
        <label for="name">Town Name:</label>
        <input type="text" name="name" id="name" required>

        <input type="submit" value="Add Town">
    </form>
    </div>
    
    <?php include('../templates/footer.html'); ?>
</body>
</html>
