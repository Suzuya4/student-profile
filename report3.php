<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "school_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL Query to get the count of students by birth month
$queryBirthMonthDistribution = "
    SELECT
        MONTH(birthday) AS birth_month,
        COUNT(id) AS student_count
    FROM
        students
    GROUP BY
        birth_month;
";

$resultBirthMonthDistribution = mysqli_query($conn, $queryBirthMonthDistribution);

if (mysqli_num_rows($resultBirthMonthDistribution) > 0) {
    $birth_month_count_data = array();
    $label_chart_data = array();

    // Initialize an array to hold month data in chronological order
    $monthsInOrder = array(
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    );

    // Initialize the month data array with 0 counts for each month
    $monthData = array_fill_keys($monthsInOrder, 0);

    while ($row = mysqli_fetch_array($resultBirthMonthDistribution)) {
        // Update the count for the corresponding month
        $monthData[$monthsInOrder[$row['birth_month'] - 1]] = $row['student_count'];
    }

    // Separate the data into count and labels arrays
    $birth_month_count_data = array_values($monthData);
    $label_chart_data = array_keys($monthData);

    mysqli_free_result($resultBirthMonthDistribution);
    mysqli_close($conn);
} else {
    echo "No records matching your query were found.";
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
                        <h4 class="title">Distribution of Students by Birth Month</h4>
                        <p class="category">Number of Students</p>
                    </div>
                    <div class="content">
                        <canvas id="myChartBirthMonthDistribution"></canvas>
                        <script>
                            const birth_month_count_data = <?php echo json_encode($birth_month_count_data); ?>;
                            const label_chart_data = <?php echo json_encode($label_chart_data); ?>;
                            const dataBirthMonthDistribution = {
                                labels: label_chart_data,
                                datasets: [{
                                    label: 'Number of Students',
                                    data: birth_month_count_data,
                                    backgroundColor: [
                                        'rgba(255, 69, 96, 0.7)',
                                        'rgba(30, 144, 255, 0.7)',
                                        'rgba(255, 215, 0, 0.7)',
                                        'rgba(0, 128, 128, 0.7)',
                                        'rgba(138, 43, 226, 0.7)',
                                        'rgba(255, 140, 0, 0.7)',
                                        'rgba(75, 192, 192, 0.7)',
                                        'rgba(255, 99, 132, 0.7)',
                                        'rgba(54, 162, 235, 0.7)',
                                        'rgba(255, 206, 86, 0.7)',
                                        'rgba(255, 69, 96, 0.7)',
                                        'rgba(30, 144, 255, 0.7)',
                                    ],
                                    borderColor: [
                                        'rgba(255, 69, 96, 1)',
                                        'rgba(30, 144, 255, 1)',
                                        'rgba(255, 215, 0, 1)',
                                        'rgba(0, 128, 128, 1)',
                                        'rgba(138, 43, 226, 1)',
                                        'rgba(255, 140, 0, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(255, 69, 96, 1)',
                                        'rgba(30, 144, 255, 1)',
                                    ],
                                    borderWidth: 1
                                }]
                            };

                            const configBirthMonthDistribution = {
                                type: 'bar',
                                data: dataBirthMonthDistribution,
                                options: {
                                    aspectRatio: 2.5,
                                    indexAxis: 'y',
                                    scales: {
                                        x: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            };

                            const myChartBirthMonthDistribution = new Chart(document.getElementById('myChartBirthMonthDistribution'), configBirthMonthDistribution);
                        </script>
                    </div>
                    <hr>
                    <div class="stats">
                        <i class="fa fa-history"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
