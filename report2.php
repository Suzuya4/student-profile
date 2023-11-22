<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "newschool_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL Query to count the top 10 provinces with the most students
$queryTopProvinces = "
    SELECT
        p.name AS province_name,
        COUNT(s.id) AS student_count
    FROM
        province p
    JOIN
        student_details sd ON p.id = sd.province
    JOIN
        students s ON sd.student_id = s.id
    GROUP BY
        p.id, p.name
    ORDER BY
        student_count DESC
    LIMIT 10;
";

$resultTopProvinces = mysqli_query($conn, $queryTopProvinces);

if (mysqli_num_rows($resultTopProvinces) > 0) {
    $province_count_data = array();
    $label_chart_data = array();

    while ($row = mysqli_fetch_array($resultTopProvinces)) {
        $province_count_data[] = $row['student_count'];
        $label_chart_data[] = $row['province_name'];
    }

    mysqli_free_result($resultTopProvinces);
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
                        <h4 class="title">Top 10 Provinces with Most Students</h4>
                        <p class="category">Student Counts by Province</p>
                    </div>
                    <div class="content">
                        <canvas id="myChartTopProvinces"></canvas>
                        <script>
                            const province_count_data = <?php echo json_encode($province_count_data); ?>;
                            const label_chart_data = <?php echo json_encode($label_chart_data); ?>;
                            const dataTopProvinces = {
                                labels: label_chart_data,
                                datasets: [{
                                    label: 'Student Count',
                                    data: province_count_data,
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

                            const configTopProvinces = {
                                type: 'bar',
                                data: dataTopProvinces,
                                options: {
                                    aspectRatio: 2.5,
                                }
                            };

                            const myChartTopProvinces = new Chart(document.getElementById('myChartTopProvinces'), configTopProvinces);
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
