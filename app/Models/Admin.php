<?php

final class Admin extends Model
{
    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM admins WHERE username = :username LIMIT 1');
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(string $username, string $password): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO admins (username, password_hash, created_at) VALUES (:username, :hash, NOW())'
        );
        $stmt->execute([
            'username' => $username,
            'hash' => password_hash($password, PASSWORD_DEFAULT),
        ]);
        return (int) $this->db->lastInsertId();
    }
}
