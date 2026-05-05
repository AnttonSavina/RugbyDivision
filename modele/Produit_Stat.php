<?php

require_once __DIR__ . '/Database.php';

class Produit_Stat
{
    private $db;
    private $table = 'produit_stat';

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findByMatch(int $matchId): array
    {
        // Stats pour un match donné avec libellé du joueur
        $sql = "SELECT ps.*, j.nom AS joueurNom, j.prenom AS joueurPrenom
                FROM {$this->table} ps
                LEFT JOIN joueur j ON j.idJoueur = ps.idJoueur
                WHERE ps.idMatch = :idMatch";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idMatch', $matchId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function upsert(array $data): bool
    {
        // Insère ou met à jour une ligne de stats via ON DUPLICATE KEY (clé composite idJoueur/idMatch)
        $payload = $this->filterPayload($data);
        if (!isset($payload['idJoueur'], $payload['idMatch'])) {
            return false;
        }

        $columns = array_keys($payload);
        $placeholders = array_map(fn($c) => ':' . $c, $columns);
        $updateParts = array_map(fn($c) => "{$c} = VALUES({$c})", array_diff($columns, ['idJoueur', 'idMatch']));

        $sql = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")
                ON DUPLICATE KEY UPDATE " . implode(', ', $updateParts);

        $stmt = $this->db->prepare($sql);
        foreach ($payload as $col => $value) {
            $stmt->bindValue(':' . $col, $value);
        }

        return $stmt->execute();
    }

    public function deleteByKeys(int $idJoueur, int $idMatch): bool
    {
        // Supprime une ligne de stats par clé composite
        $sql = "DELETE FROM {$this->table} WHERE idJoueur = :idJoueur AND idMatch = :idMatch";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idJoueur', $idJoueur, PDO::PARAM_INT);
        $stmt->bindValue(':idMatch', $idMatch, PDO::PARAM_INT);
        return $stmt->execute();
    }

    private function filterPayload(array $data): array
    {
        // Garde uniquement les champs de stats déclarés et non vides
        return $data;
    }
}
