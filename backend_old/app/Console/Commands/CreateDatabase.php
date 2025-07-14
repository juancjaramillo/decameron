<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use PDOException;

class CreateDatabase extends Command
{
    protected $signature = 'db:create';
    protected $description = 'Crea la base de datos si no existe';

    public function handle()
    {
        $connection = Config::get('database.default');
        $config     = Config::get("database.connections.{$connection}");
        $database   = $config['database'];
        $charset    = $config['charset'] ?? 'utf8';
        $collation  = $config['collation'] ?? 'utf8_unicode_ci';

        // Para MySQL usar: mysql:host=...
        // Para Postgres conectamos a 'postgres' por defecto:
        $dsnDb = ($connection === 'pgsql')
            ? "pgsql:host={$config['host']};port={$config['port']};dbname=postgres"
            : "mysql:host={$config['host']};port={$config['port']}";

        try {
            $pdo = new \PDO($dsnDb, $config['username'], $config['password']);
            if ($connection === 'pgsql') {
                // Postgres: verificamos existencia
                $stmt = $pdo->query("SELECT 1 FROM pg_database WHERE datname = '{$database}'");
                $exists = (bool) $stmt->fetchColumn();
                if (! $exists) {
                    $pdo->exec("CREATE DATABASE \"{$database}\" WITH ENCODING='{$charset}'");
                    $this->info("Base de datos {$database} creada.");
                } else {
                    $this->info("Base de datos {$database} ya existe.");
                }
            } else {
                // MySQL
                $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET {$charset} COLLATE {$collation}");
                $this->info("Base de datos {$database} lista (MySQL).");
            }
        } catch (PDOException $e) {
            $this->error("Error creando DB: {$e->getMessage()}");
            return 1;
        }

        return 0;
    }
}
