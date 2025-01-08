<?php

namespace App\Models;

use PDO;

class User
{
  private PDO $db;

  public int $id = -1;
  public string $email;
  public string $name;
  public string $password;
  public string $phone;
  public string $role;

  public function __construct(PDO $pdo)
  {
    $this->db = $pdo;
  }

  public function findContact(int $id): ?Contact
  {
    $contact = new Contact($this->db);
    $contact = $contact->find($id);
    if (isset($contact)) {
      return $contact;
    }
    return null;
  }

  public function contacts(): array
  {
    $contact = new Contact($this->db);
    return $contact->contactsForAll($this);
  }

  public function where(string $column, string $value): User
  {
    $statement = $this->db->prepare("SELECT * FROM users WHERE $column = :value");
    $statement->execute(['value' => $value]);
    $row = $statement->fetch();
    if ($row) {
      $this->fillFromDbRow($row);
    }
    return $this;
  }

  public function save(): bool
  {
    $result = false;

    if ($this->id >= 0) {
      $statement = $this->db->prepare(
        'UPDATE users SET email = :email, name = :name, password = :password, phone = :phone, updated_at = NOW() WHERE id = :id'
      );
      $result = $statement->execute([
        'id' => $this->id,
        'email' => $this->email,
        'name' => $this->name,
        'password' => $this->password,
        'phone' => $this->phone 
      ]);
    } else {
      $statement = $this->db->prepare(
        'INSERT INTO users (email, name, password, created_at, updated_at, phone)
          VALUES (:email, :name, :password, NOW(), NOW(), :phone)'
      );
      $result = $statement->execute([
        'email' => $this->email,
        'name' => $this->name,
        'password' => $this->password,
        'phone' => $this->phone
      ]);
      if ($result) {
        $this->id = $this->db->lastInsertId();
      }
    }

    return $result;
  }

  public function fill(array $data): User
  {
    $this->email = $data['email'];
    $this->name = $data['name'];
    $this->password = password_hash($data['password'], PASSWORD_DEFAULT);
    $this->phone = password_hash($data['phone'], PASSWORD_DEFAULT);
    return $this;
  }

  private function fillFromDbRow(array $row)
  {
    $this->id = $row['id'];
    $this->email = $row['email'];
    $this->name = $row['name'];
    $this->password = $row['password'];
    $this->phone = $row['phone'];
    $this->role = $row['role'];
  }

  private function isEmailInUse(string $email): bool
  {
    $statement = $this->db->prepare('SELECT count(*) FROM users WHERE email = :email');
    $statement->execute(['email' => $email]);
    return $statement->fetchColumn() > 0;
  }

  public function validate(array $data): array
  {
    $errors = [];

    if (!$data['email']) {
      $errors['email'] = 'Invalid email.';
    } elseif ($this->isEmailInUse($data['email'])) {
      $errors['email'] = 'Email already in use.';
    }

    if (strlen($data['password']) < 6) {
      $errors['password'] = 'Password must be at least 6 characters.';
    } elseif ($data['password'] != $data['password_confirmation']) {
      $errors['password'] = 'Password confirmation does not match.';
    }

    $validPhone = preg_match('/^(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b$/', $data['phone'] ?? '');
    if (!$validPhone) {
        $errors['phone'] = 'Invalid phone number.';
    }
    return $errors;
  }
}
