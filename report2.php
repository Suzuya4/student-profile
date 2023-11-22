<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "school_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL Query to count the top 10 town_citys with the most students
$queryToptown_citys = "
    SELECT
        p.name AS town_city,
        COUNT(s.id) AS student_count
    FROM
        town_city p
    JOIN
        student_details sd ON p.id = sd.town_city
    JOIN
        students s ON sd.student_id = s.id
    GROUP BY
        p.id, p.name
    ORDER BY
        student_count DESC
    LIMIT 10;
";

$resultToptown_citys = mysqli_query($conn, $queryToptown_citys);

if (mysqli_num_rows($resultToptown_citys) > 0) {
    $town_city_count_data = array();
    $label_chart_data = array();

    while ($row = mysqli_fetch_array($resultToptown_citys)) {
        $town_city_count_data[] = $row['student_count'];
        $label_chart_data[] = $row['town_city'];
    }

    mysqli_free_result($resultToptown_citys);
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
                        <h4 class="title">Top 10 town_citys with Most Students</h4>
                        <p class="category">Student Counts by town_city</p>
                    </div>
                    <div class="content">
                        <canvas id="myChartToptown_citys"></canvas>
                        <script>
                            const town_city_count_data = <?php echo json_encode($town_city_count_data); ?>;
                            const label_chart_data = <?php echo json_encode($label_chart_data); ?>;
                            const dataToptown_citys = {
                                labels: label_chart_data,
                                datasets: [{
                                    label: 'Student Count',
                                    data: town_city_count_data,
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
                                        'rgba(255, 206, 86, 0.7)'
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
                                        'rgba(255, 206, 86, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            };

                            const configToptown_citys = {
                                type: 'bar',
                                data: dataToptown_citys,
                                options: {
                                    aspectRatio: 2.5,
                                }
                            };

                            const myChartToptown_citys = new Chart(document.getElementById('myChartToptown_citys'), configToptown_citys);
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
