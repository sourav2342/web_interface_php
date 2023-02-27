// check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // get the temperature value from the POST request
    $temp = $_POST['temp'];

    // add the temperature value to a file
    $file = 'temp_data.txt';
    file_put_contents($file, $temp . PHP_EOL, FILE_APPEND);
}

// read the temperature data from the file
$data = file_get_contents('temp_data.txt');

// create an array of temperature values
$values = explode(PHP_EOL, $data);

// remove the last empty value
array_pop($values);

// convert the temperature values to a JavaScript array
$jsArray = '[' . implode(',', $values) . ']';
?>

<!-- display the temperature data as a graph using Chart.js library -->
<html>
<head>
    <title>Temperature Data Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="tempChart"></canvas>
    <script>
        // create a new Chart.js line chart
        var ctx = document.getElementById('tempChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo $jsArray; ?>,
                datasets: [{
                    label: 'Temperature Data',
                    data: <?php echo $jsArray; ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
