<?php
namespace App;

use PDO;
use PDOException;

class Connection
{
    public static function getDb()
    {
        try {
            $conn = new PDO(
                "",
                "",
                "",
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]
            );

            return $conn;

        } catch (PDOException $e) {
            die("Erro de conexão com o banco: " . $e->getMessage());
        }
    }
}
?>