<?php

class DbPDO
{
    private static string $server = 'localhost';
    private static string $username = 'root';
    private static string $password = '';
    private static string $database = 'table_test_php';
    private static ?PDO $db = null;

    public static function connect(): ?PDO {
        if (self::$db == null){
            try {
                self::$db = new PDO("mysql:host=".self::$server.";dbname=".self::$database, self::$username, self::$password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$db->beginTransaction();

                $sql = "TRUNCATE TABLE user";
                if (self::$db->exec($sql) !== false){
                    echo "Contenu supprimé";
                }
                else{
                    echo "Problème";
                }
            }
            catch (PDOException $e) {
                echo "Erreur de la connexion à la dn : " . $e->getMessage();
                self::$db->rollBack(); // On restaure les anciens données en cas d'erreur
            }
        }
        return self::$db;
    }
}