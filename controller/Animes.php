<?php
require_once '../model/Anime.php';

//print_r('<pre>');
//print_r(weekData());

function weekData()
{
    $animes = getAllAnimes();
    $weekData = [
        'domingo' => [],
        'segunda' => [],
        'terça' => [],
        'quarta' => [],
        'quinta' => [],
        'sexta' => [],
        'sábado' => []
    ];

    foreach ($animes as $anime) {
        $day = $anime['day'];
        if (isset($weekData[$day])) {
            $weekData[$day][] = [
                'name' => $anime['name'],
                'image' => $anime['image_url'],
                'link' => $anime['link'],
                'time' => $anime['time'] ? substr($anime['time'], 0, 5) : '', // Format time to HH:MM if available
                'streaming' => getAnimeStreamingLinks($anime['id']) // You can add streaming platforms here if needed
            ];
        }
    }

    return $weekData;
}