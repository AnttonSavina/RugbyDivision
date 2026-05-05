<?php

require_once __DIR__ . '/Database.php';

class Oppose
{
    private $db;
    private $table = 'oppose';

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findByMatch(int $matchId): array
    {
        // Clubs opposés pour un match (rôle domicile/extérieur)
        $sql = "SELECT o.*, c.nom AS clubNom
                FROM {$this->table} o
                LEFT JOIN club c ON c.idClub = o.idClub
                WHERE o.idMatch = :idMatch";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idMatch', $matchId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addClubToMatch(int $matchId, int $clubId, string $role): bool
    {
        // Ajoute un club à un match avec son rôle (domicile/exterieur)
        $sql = "INSERT INTO {$this->table} (idMatch, idClub, role) VALUES (:idMatch, :idClub, :role)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idMatch', $matchId, PDO::PARAM_INT);
        $stmt->bindValue(':idClub', $clubId, PDO::PARAM_INT);
        $stmt->bindValue(':role', $role);
        return $stmt->execute();
    }

    public function deleteByMatchAndClub(int $matchId, int $clubId): bool
    {
        // Supprime le lien pour un club donné dans un match
        $sql = "DELETE FROM {$this->table} WHERE idMatch = :idMatch AND idClub = :idClub";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idMatch', $matchId, PDO::PARAM_INT);
        $stmt->bindValue(':idClub', $clubId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteByMatch(int $matchId): bool
    {
        // Supprime toutes les oppositions d'un match
        $sql = "DELETE FROM {$this->table} WHERE idMatch = :idMatch";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idMatch', $matchId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
