<?php
require_once '../model/Connection.php';

function getAllStreamingPlatforms()
{
    $stmt = connection()->prepare("SELECT * FROM streaming");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}