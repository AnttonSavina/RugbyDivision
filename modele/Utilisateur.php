<?php

require_once __DIR__ . '/Database.php';

class Utilisateur
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'idUtilisateur';

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
        // Hash le mot de passe avant insertion
        if (isset($data['motDePasse'])) {
            $data['motDePasse'] = password_hash($data['motDePasse'], PASSWORD_BCRYPT);
        }
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

    public function authenticate(string $mail, string $password): ?array
    {
        // Authentifie avec rétro-compatibilité (clair/md5) et rehash si nécessaire
        $sql = "SELECT * FROM {$this->table} WHERE LOWER(mail) = LOWER(:mail) LIMIT 1";
        $stmt = $this->db()->prepare($sql);
        $stmt->bindValue(':mail', $mail);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            return null;
        }

        $hash = $user['motDePasse'] ?? '';
        $valid = false;

        if ($hash && password_verify($password, $hash)) {
            $valid = true;
            if (password_needs_rehash($hash, PASSWORD_BCRYPT)) {
                $this->updatePasswordHash((int)$user[$this->primaryKey], $password);
                $user['motDePasse'] = password_hash($password, PASSWORD_BCRYPT);
            }
        } elseif ($hash === $password) {
            // ancien mot de passe en clair : on re-hash
            $valid = true;
            $this->updatePasswordHash((int)$user[$this->primaryKey], $password);
            $user['motDePasse'] = password_hash($password, PASSWORD_BCRYPT);
        } elseif (strlen($hash) === 32 && md5($password) === $hash) {
            // ancien hash md5
            $valid = true;
            $this->updatePasswordHash((int)$user[$this->primaryKey], $password);
            $user['motDePasse'] = password_hash($password, PASSWORD_BCRYPT);
        }

        return $valid ? $user : null;
    }

    private function updatePasswordHash(int $id, string $plain): void
    {
        // Rehash et met à jour le mot de passe avec bcrypt
        $newHash = password_hash($plain, PASSWORD_BCRYPT);
        $sql = "UPDATE {$this->table} SET motDePasse = :hash WHERE {$this->primaryKey} = :id";
        $stmt = $this->db()->prepare($sql);
        $stmt->bindValue(':hash', $newHash);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateRole(int $id, int $role): bool
    {
        // Met à jour le rôle (droits) d'un utilisateur
        $sql = "UPDATE {$this->table} SET droits = :role WHERE {$this->primaryKey} = :id";
        $stmt = $this->db()->prepare($sql);
        $stmt->bindValue(':role', $role, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
