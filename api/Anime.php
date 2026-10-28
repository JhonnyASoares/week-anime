<?php 
require_once '../model/Anime.php';

header('Content-Type: application/json; charset=utf-8');

if (isset($_GET['animes'])) {
    $animes = getAnimes();
    echo json_encode($animes);
    exit;
}

if (!isset($_POST['name'], $_POST['day'], $_POST['link'], $_POST['image_url']) ||
    $_POST['name'] === '' ||
    $_POST['day'] === '' ||
    $_POST['link'] === '' ||
    $_POST['image_url'] === '') {
    echo json_encode([
        "success" => false,
        "message" => "Erro! Dados faltantes.",
    ]);
    exit;
}
        
registerAnime();


function registerAnime()
{
    $message = 'adicionar';

    try {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $day = $_POST['day'];
        $link = $_POST['link'];
        $image_url = $_POST['image_url'];
        $time = $_POST['time'] === '' ? null : $_POST['time']; // Use null if time is not provided
        $streamingPlatforms = $_POST['streaming'] ?? []; // Use an empty array if no streaming platforms are selected
        
        if ($id && !empty($id)) {
            $animeId = $id;
            
            updateAnime($animeId, $name, $day, $link, $image_url, $time);
            
            deleteStreamingLink($animeId);
            $message = 'atualizar';
        } else {

            // Call the function to add the anime to the database
            $animeId = addAnime($name, $day, $link, $image_url, $time);
        }


        foreach ($streamingPlatforms as $platformId) {
            addStreamingLink($animeId, $platformId);
        }

        echo json_encode([
            "success" => true,
            '$streamingPlatforms' => $streamingPlatforms,
            "data" => $_POST,
            "message" => "Sucesso ao ". $message ." anime!"
        ]);
    } catch (Exception $e) {

        echo json_encode([
            "success" => false,
            "message" => "Erro ao ". $message ." o anime: " . $e->getMessage()
        ]);
    }
}


function getAnimes()
{
    try {
        $animes = getAllAnimes();
        foreach ($animes as &$anime) {
            $anime['time'] = $anime['time'] ? substr($anime['time'], 0, 5) : ''; // Format time to HH:MM if available
            $anime['streaming'] = getAnimeStreamingId($anime['id']);
        }
        return $animes;
    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "message" => "Erro ao buscar os animes: " . $e->getMessage()
        ]);
        exit;
    }
}