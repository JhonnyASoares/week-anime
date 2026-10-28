<?php
require_once 'Connection.php';

function addAnime($name, $day, $link, $image_url, $time)
{ 
    $pdo = connection();
    $stmt = $pdo->prepare("INSERT INTO anime (name, day, link, image_url, time) VALUES (:name, :day, :link, :image_url, :time)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':day', $day);
    $stmt->bindParam(':link', $link);
    $stmt->bindParam(':image_url', $image_url);
    $stmt->bindParam(':time', $time);
    $stmt->execute();
    return $pdo->lastInsertId(); // Return the ID of the newly inserted anime
}


function updateAnime($id, $name, $day, $link, $image_url, $time){
    $pdo = connection();
    $stmt = $pdo->prepare("UPDATE anime SET name = :name, day = :day, link = :link, image_url = :image_url, time = :time WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':day', $day);
    $stmt->bindParam(':link', $link);
    $stmt->bindParam(':image_url', $image_url);
    $stmt->bindParam(':time', $time);
    $stmt->execute();
    return $pdo->lastInsertId(); // Esta retornando 0, ent n funciona aqui
};

function addStreamingLink($animeId, $streamingId)
{
    $stmt = connection()->prepare("INSERT INTO stream_week_link (anime_id, streaming_id) VALUES (:animeId, :streamingId)");
    $stmt->bindParam(':animeId', $animeId);
    $stmt->bindParam(':streamingId', $streamingId);
    $stmt->execute();
}

function deleteStreamingLink($animeId) {
    $stmt = connection()->prepare("DELETE FROM stream_week_link WHERE anime_id = :animeId");
    $stmt->bindParam(':animeId', $animeId);
    $stmt->execute();
}

function getAnimeStreamingLinks($animeId)
{
    $stmt = connection()->prepare("SELECT s.name FROM stream_week_link as swl INNER JOIN streaming as s ON s.id = swl.streaming_id WHERE swl.anime_id = :animeId");
    $stmt->bindParam(':animeId', $animeId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function getAnimeStreamingId($animeId)
{
    $stmt = connection()->prepare("SELECT swl.streaming_id FROM stream_week_link as swl WHERE swl.anime_id = :animeId");
    $stmt->bindParam(':animeId', $animeId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function getAllAnimes()
{
    $stmt = connection()->prepare("SELECT * FROM anime ORDER BY name");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deleteAllAnimes()
{
    $stmt = connection()->prepare("DELETE FROM anime");
    $stmt->execute();
}