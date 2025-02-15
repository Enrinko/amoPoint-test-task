<?php
require_once __DIR__. '/Connection.php';
use src\php\Connection;

try {
    $connection = new Connection();
    // Получаем уникальные посещения по часам
    $hourlyVisits = $connection->get("SELECT DATE_FORMAT(visit_time, '%Y-%m-%d %H:00:00') AS hour, COUNT(DISTINCT ip) AS unique_visits FROM visits GROUP BY hour");

    // Получаем количество посещений по городам
    $cityVisits = $connection->get("SELECT city, COUNT(*) AS count FROM visits GROUP BY city");

    // Подготовка данных для графиков
    $hourData = [];
    while ($row = $hourlyVisits->fetch_assoc()) {
        $hourData[] = $row;
    }

    $cityData = [];
    while ($row = $cityVisits->fetch_assoc()) {
        $cityData[] = $row;
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    exit; // Завершаем выполнение скрипта в случае ошибки
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>График посещений по часам</h1>
    <canvas id="hourlyChart"></canvas>
    <h1>Круговая диаграмма по городам</h1>
    <canvas id="cityChart"></canvas>

    <script>
        const hourData = <?php echo json_encode($hourData); ?>;
        const cityData = <?php echo json_encode($cityData); ?>;

        // График посещений по часам
        const hourlyLabels = hourData.map(data => data.hour);
        const uniqueVisits = hourData.map(data => data.unique_visits);

        const ctxHourly = document.getElementById('hourlyChart').getContext('2d');
        new Chart(ctxHourly, {
            type: 'line',
            data: {
                labels: hourlyLabels,
                datasets: [{
                    label: 'Уникальные посещения',
                    data: uniqueVisits,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Время'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Количество уникальных посещений'
                        }
                    }
                }
            }
        });

        // Круговая диаграмма по городам
        const cityLabels = cityData.map(data => data.city);
        const cityCounts = cityData.map(data => data.count);

        const ctxCity = document.getElementById('cityChart').getContext('2d');
        new Chart(ctxCity, {
            type: 'pie',
            data: {
                labels: cityLabels,
                datasets: [{
                    label: 'Посещения по городам',
                    data: cityCounts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Посещения по городам'
                    }
                }
            }
        });
    </script>
</body>
</html>