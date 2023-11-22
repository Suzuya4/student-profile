<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "school_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query04 = "SELECT birthday, COUNT(gender) as order_count 
    FROM school_db.students 
    GROUP BY birthday, gender 
    ORDER BY order_count DESC 
    LIMIT 20;
    ";
$result04 = mysqli_query($conn, $query04);

if (mysqli_num_rows($result04) > 0) {
    $order_count = array();
    $label_barchart = array();

    while ($row = mysqli_fetch_array($result04)) {
        $order_count[] = $row['order_count'];
        $label_barchart[] = $row['birthday'];
    }

    mysqli_free_result($result04);
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
                            <h4 class="title">Top 20 most Birthday counts</h4>
                            <p class="category">Student Birthday</p>
                        </div>
                        <div class="content">
                            <canvas id="myChartTopFive"></canvas>
                            <script>
                                const order_count_data = <?php echo json_encode($order_count); ?>;
                                const label_barchart_data = <?php echo json_encode($label_barchart); ?>;
                                const data4 = {
                                    labels: label_barchart_data,
                                    datasets: [{
                                        label: 'Birthday Count',
                                        data: order_count_data,
                                        backgroundColor: [
                                            'rgba(255, 69, 96, 0.7)',
                                            'rgba(30, 144, 255, 0.7)',
                                            'rgba(255, 215, 0, 0.7)',
                                            'rgba(0, 128, 128, 0.7)',
                                            'rgba(138, 43, 226, 0.7)',
                                            'rgba(255, 140, 0, 0.7)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 69, 96, 1)',
                                            'rgba(30, 144, 255, 1)',
                                            'rgba(255, 215, 0, 1)',
                                            'rgba(0, 128, 128, 1)',
                                            'rgba(138, 43, 226, 1)',
                                            'rgba(255, 140, 0, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                };

                                const config4 = {
                                    type: 'bar',
                                    data: data4,
                                    options: {
                                        indexAxis: 'y',
                                        scales: {
                                            x: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                };

                                const myChartTopFive = new Chart(document.getElementById('myChartTopFive'), config4);
                            </script>
                        </div>
                        <hr>
                        <div class="stats">
                            <i class="fa fa-history"></i> Updated 3 minutes ago
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>