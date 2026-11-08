
<?php

$apiKey = 'f00c38e0279b7bc85480c3fe775d518c';

$city = 'Mures';

$url = 'https://api.openweathermap.org/data/2.5/forecast?q='
     . urlencode($city)
     . '&appid=' . urlencode($apiKey)
     . '&units=metric';

$response = @file_get_contents($url);
$data = $response ? json_decode($response, true) : null;

$days = [];

if (isset($data['list']) && is_array($data['list'])) {
    foreach ($data['list'] as $item) {
        // Group the 3-hour forecasts by date.
        $date = date('Y-m-d', $item['dt']);

        if (!isset($days[$date])) {
            $days[$date] = [
                'temps' => [],
                'humidity' => [],
                'wind' => [],
                'weather' => $item['weather'][0],
                'icon' => $item['weather'][0]['icon']
            ];
        }

        $days[$date]['temps'][] = $item['main']['temp'];
        $days[$date]['humidity'][] = $item['main']['humidity'];
        $days[$date]['wind'][] = $item['wind']['speed'];
    }
}

// Keep only five dates.
$days = array_slice($days, 0, 5, true);
?>

<div class="weather-container">
    <header class="header">
        <p class="eyebrow">WEATHER FORECAST</p>
        <h1><?= htmlspecialchars($city) ?></h1>
        <p class="subtitle">Your next five days at a glance</p>
    </header>

    <?php if (!$data || !isset($data['list'])): ?>
        <p class="error">
            Could not load weather. Check your API key
            and internet connection.
        </p>
    <?php else: ?>

    <div class="weather-grid">
        <?php foreach ($days as $date => $day): ?>
            <?php
            $temps = $day['temps'];
            $description = $day['weather']['description'];
            $icon = $day['icon'];
            $avgTemp = array_sum($temps) / count($temps);
            $minTemp = min($temps);
            $maxTemp = max($temps);
            $avgHumidity = round(
                array_sum($day['humidity']) /
                count($day['humidity'])
            );
            $avgWind = array_sum($day['wind']) /
                       count($day['wind']);
            ?>

            <article class="weather-card">
                <p class="day">
                    <?= date('l', strtotime($date)) ?>
                </p>

                <p class="date">
                    <?= date('M j', strtotime($date)) ?>
                </p>

                <img
                    class="weather-icon"
                    src="https://openweathermap.org/img/wn/<?= htmlspecialchars($icon) ?>@2x.png"
                    alt="<?= htmlspecialchars($description) ?>"
                >

                <h2>
                    <?= round($avgTemp) ?>&deg;C
                </h2>

                <p class="description">
                    <?= htmlspecialchars(ucfirst($description)) ?>
                </p>

                <div class="temp-range">
                    <span>High <?= round($maxTemp) ?>&deg;</span>
                    <span>Low <?= round($minTemp) ?>&deg;</span>
                </div>

                <div class="details">
                    <p>
                        <span>💧 Humidity</span>
                        <strong><?= $avgHumidity ?>%</strong>
                    </p>
                    <p>
                        <span>💨 Wind</span>
                        <strong><?= round($avgWind, 1) ?> m/s</strong>
                    </p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <?php endif; ?>