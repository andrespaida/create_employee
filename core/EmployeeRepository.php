<?php
require_once __DIR__ . '/DbConnection.php';

class EmployeeRepository {
    public static function create(array $data): bool {
        $pdo = DbConnection::get();

        $stmt = $pdo->prepare("
            INSERT INTO employee (name, email, phone, position, hire_date, salary, created_at)
            VALUES (:name, :email, :phone, :position, :hireDate, :salary, NOW())
        ");

        return $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':phone' => $data['phone'],
            ':position' => $data['position'],
            ':hireDate' => $data['hireDate'],
            ':salary' => $data['salary']
        ]);
    }
}