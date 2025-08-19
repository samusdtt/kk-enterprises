<?php
declare(strict_types=1);

class User
{
    public static function findByUsername(string $username): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function findById(int $id): ?array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function updateProfile(int $id, array $data): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ?, address = ? WHERE id = ?');
        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['address'],
            $id,
        ]);
    }

    public static function changePassword(int $id, string $newPassword): bool
    {
        $pdo = Database::getConnection();
        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
        return $stmt->execute([$hash, $id]);
    }

    public static function setLoginHoursVisibility(int $staffId, bool $enabled): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('UPDATE users SET login_hours_enabled = ? WHERE id = ? AND role = "staff"');
        return $stmt->execute([$enabled ? 1 : 0, $staffId]);
    }

    public static function create(string $username, string $password, string $email, string $role, string $name = '', string $address = ''): int
    {
        $pdo = Database::getConnection();
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('INSERT INTO users (username, name, email, password, address, role) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$username, $name, $email, $hash, $address, $role]);
        return (int)$pdo->lastInsertId();
    }
}

