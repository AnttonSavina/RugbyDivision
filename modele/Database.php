<?php

class Database
{
    private static string $host = "localhost";
    private static int $port = 3306;
    private static string $dbName = "rugbydivision";
    private static string $username = "root";
    private static string $password = "";
    private static ?PDO $conn = null;

    /**
     * Connexion PDO unique partagée par tous les modèles.
     */
    public static function getConnection(): PDO
    {
        if (self::$conn === null) {
            // Hôte/port explicites et timeout court pour éviter les blocages si MySQL est indisponible
            $dsn = "mysql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$dbName . ";charset=utf8";
            try {
                self::$conn = new PDO($dsn, self::$username, self::$password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_TIMEOUT => 5,
                ]);
            } catch (PDOException $e) {
                die("Erreur de connexion a la base de donnees : " . $e->getMessage());
            }
        }

        return self::$conn;
    }
}
