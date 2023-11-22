<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "newschool_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>School Database Report</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
</head>
<body>

<div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="header">
                            <h4 class="title">Count of Gender</h4>
                            <p class="category">Students</p>
                        </div>
                        <div class="content">
                            <canvas id="chartGender"></canvas>
                            <?php
                                $query = "SELECT
                                    COUNT(students.gender) AS allGender
                                FROM
                                    newschool_db.students
                                GROUP BY gender";

                                $result = mysqli_query($conn, $query);

                                if(mysqli_num_rows($result) > 0){
                                    $gender = array();

                                    while ($row = mysqli_fetch_array($result)){
                                        $gender[] = $row['allGender'];
                                    }

                                    mysqli_free_result($result);
                                    mysqli_close($conn);
                                } else {
                                    echo "No records matching your query were found.";
                                }
                                ?>

                                <script>
                                    const allGender = <?php echo json_encode($gender); ?>;
                                    const dataGender = {
                                        labels: ['Male', 'Female'], // Add labels for each gender
                                        datasets: [{
                                            label: 'Total Orders',
                                            data: allGender,
                                            backgroundColor: [
                                                'rgba(255, 0, 0, 0.7)',
                                                'rgba(0, 128, 255, 0.7)',
                                            ],
                                            borderColor: [
                                                'rgba(255, 0, 0, 1)',
                                                'rgba(0, 128, 255, 1)',
                                            ],
                                            hoverOffset: 4,
                                            borderWidth: 1
                                        }]
                                    };

                                    const configGender = {
                                        type: 'doughnut',
                                        data: dataGender,
                                        options: {
                                        aspectRatio: 2.5, // Adjust this value to control the size of the chart
                                        },
                                    };

                                    const chartGender = new Chart(document.getElementById('chartGender'), configGender);
                                </script>
                            <hr>
                            <div class="stats">
                                <i class="fa fa-history"></i> Updated 3 minutes ago
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
