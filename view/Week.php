<?php
require_once '../controller/Animes.php';
require_once '../controller/Streaming.php';

$animes = weekData();
$stream = streamingData();

?>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Week Anime</title>
    <link rel="stylesheet" type="text/css" href="/view/css/week.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="shortcut icon" href="/rem.ico">
    <link rel="icon" href="/rem.ico">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body> 
<!-- Irei fazer um site de animes, para listar os animes lançados na semana, cada dia da semana terá uma seção, com os respectivos animes -->
<div class="container">
    <h1>Animes da Semana</h1>
    <?php foreach ($animes as $day => $animeList) { 
        $dayId = 'day-' . strtolower($day);
    ?>
    <div class="line"></div>
        <div class="day-section">
            <h2>
                <span>
                    <?= $day == 'domingo' || $day == 'sábado' ? ucfirst($day) : ucfirst($day) . '-feira' ?>
                </span>
                <button 
                    class="toggle-day" 
                    type="button"
                    onclick="toggleDay('<?= $dayId ?>', this)"
                    aria-label="Expandir ou ocultar animes"
                >
                    −
                </button>
            
            </h2>

            <div class="anime-list" id="<?= $dayId ?>">
                <?php foreach ($animeList as $anime) { ?>
                    <a href="<?= $anime['link'] ?>" target="_blank">
                        <div class="anime-card" style="background-image: url(<?= $anime['image'] ?>); --cor1: <?= isset($anime['streaming']) && sizeof($anime['streaming']) > 0 ? $stream[$anime['streaming'][0]]['color'] : '#ffe600' ?>; --cor2: <?= isset($anime['streaming']) && sizeof($anime['streaming']) > 1 ? $stream[$anime['streaming'][1]]['color'] : '#9c33ff' ?>;">
                            <div class="card-overlay">
                                <div class="anime-time">
                                    <?= isset($anime['time']) && $anime['time'] != '' ? "<span>" . $anime['time'] . "</span>" : '' ?>
                                </div>
                                <div class="streaming-icons">
                                    <?php if (isset($anime['streaming']) && sizeof($anime['streaming']) > 0) {
                                        foreach ($anime['streaming'] as $streaming) {
                                            if (isset($stream[$streaming])) {
                                                echo '<img class="streaming-icon" src="' . $stream[$streaming]['url'] . '">';
                                            }
                                        }
                                    } ?>
                                </div>
                            </div>
                            <div class="anime-name">
                                <span><?= $anime['name'] ?></span>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>
<script src="/view/js/week.js"></script>
</body>