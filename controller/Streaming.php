<?php
require_once '../model/Streaming.php';

function streamingData()
{
    $streamingPlatforms = getAllStreamingPlatforms();
    $streams = [];
    foreach ($streamingPlatforms as $platform) {
        $streams[$platform['name']] = [
            'url' => $platform['image_url'],
            'color' => '#' . $platform['color'],
        ];
    }
    return $streams;
}

function streamingFullData()
{
    $streamingPlatforms = getAllStreamingPlatforms();
    return $streamingPlatforms;
}