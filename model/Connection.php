<?php
function connection()
{
    try {
        $envPath = dirname(__DIR__) . '/.env';
        if (!is_file($envPath) || !is_readable($envPath)) {
            throw new RuntimeException('Arquivo .env não encontrado ou sem permissão de leitura.');
        }

        $config = parse_ini_file($envPath, false, INI_SCANNER_RAW);
        if ($config === false) {
            throw new RuntimeException('Não foi possível ler o arquivo .env.');
        }

        foreach (['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD'] as $key) {
            if (!isset($config[$key]) || $config[$key] === '') {
                throw new RuntimeException("Configuração {$key} ausente no arquivo .env.");
            }
        }

        $pdo = new PDO(
            "mysql:host={$config['DB_HOST']};dbname={$config['DB_NAME']}",
            $config['DB_USER'],
            $config['DB_PASSWORD']
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erro na conexão: " . $e->getMessage());
    }
}