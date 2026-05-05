<?php

require_once __DIR__ . '/Database.php';

class Stade
{
    protected $table = 'stade';
    protected $primaryKey = 'idStade';

    protected function db(): PDO
    {
        return Database::getConnection();
    }

    public function findAll(string $orderBy = ''): array
    {
        // SELECT * générique avec ORDER BY optionnel sur la table courante
        $sql = "SELECT * FROM {$this->table}";
        if ($orderBy !== '') {
            $sql .= " ORDER BY {$orderBy}";
        }

        $stmt = $this->db()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        // Récupère une ligne par clé primaire
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";
        $stmt = $this->db()->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public function create(array $data)
    {
        // Insère le payload filtré; renvoie lastInsertId si dispo
        $payload = $this->filterPayload($data);
        if (empty($payload)) {
            return null;
        }

        $columns = array_keys($payload);
        $placeholders = array_map(fn($col) => ':' . $col, $columns);

        $sql = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $this->db()->prepare($sql);

        foreach ($payload as $col => $value) {
            $stmt->bindValue(':' . $col, $value);
        }

        $stmt->execute();

        try {
            return $this->db()->lastInsertId();
        } catch (PDOException $e) {
            return true;
        }
    }

    public function update($id, array $data): bool
    {
        // Met à jour une ligne par clé primaire avec le payload filtré
        $payload = $this->filterPayload($data);
        if (empty($payload)) {
            return false;
        }

        $setParts = array_map(fn($col) => "{$col} = :{$col}", array_keys($payload));
        $sql = "UPDATE {$this->table} SET " . implode(', ', $setParts) . " WHERE {$this->primaryKey} = :id";

        $stmt = $this->db()->prepare($sql);
        foreach ($payload as $col => $value) {
            $stmt->bindValue(':' . $col, $value);
        }
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }

    public function delete($id): bool
    {
        // Supprime une ligne par clé primaire
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db()->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    protected function filterPayload(array $data): array
    {
        // Puisque $fields est supprimé, on retourne simplement les données
        return $data;
    }
}
