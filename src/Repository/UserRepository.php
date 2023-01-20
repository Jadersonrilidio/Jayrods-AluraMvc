<?php

namespace Jayrods\AluraMvc\Repository;

use Jayrods\AluraMvc\Repository\Repository;
use Jayrods\AluraMvc\Entity\User;
use PDO;

class UserRepository implements Repository
{
    /**
     * @var PDO
     */
    private PDO $pdo;

    /**
     * 
     * @param  PDO  $pdo
     * 
     * @return void
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * 
     * @param  User  $user
     * 
     * @return User
     */
    public function add(User $user): User
    {
        $query = "INSERT INTO users (email, password) VALUES (:email, :password);";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':url', $user->email(), PDO::PARAM_STR);
        $stmt->bindValue(':title', $user->password(), PDO::PARAM_STR);

        $stmt->execute();

        $id = $this->pdo->lastInsertId();

        $user->identify(intval($id));

        return $user;
    }

    /**
     * @param  int  $id
     * 
     * @return bool
     */
    public function remove(int $id): bool
    {
        $query = "DELETE FROM users WHERE id = :id;";

        $id = filter_var($id, FILTER_VALIDATE_INT);

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * 
     * @param  User  $user
     * 
     * @return User
     */
    public function update(User $user): User
    {
        $query = "UPDATE users SET email = :email, password = :password WHERE id = :id;";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':url', $user->email(), PDO::PARAM_STR);
        $stmt->bindValue(':title', $user->password(), PDO::PARAM_STR);
        $stmt->bindValue(':id', $user->id(), PDO::PARAM_INT);

        $stmt->execute();

        return $user;
    }

    /**
     * 
     * @param  int  $id
     * @param  string  $password
     * 
     * @return bool
     */
    public function passwordRehash(int $id, string $password): bool
    {
        $query = "UPDATE users SET password = :password WHERE id = :id;";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':password', password_hash($password, PASSWORD_ARGON2ID), PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * 
     * @return User[]
     */
    public function all(): array
    {
        $query = "SELECT * FROM users;";

        $users = array_map(function ($userData) {
            return new User(
                $userData['id'],
                $userData['email'],
                $userData['password']
            );
        }, $this->pdo
            ->query($query)
            ->fetchAll(PDO::FETCH_ASSOC));

        return $users;
    }

    /**
     * @param  int  $id
     * 
     * @return User[]
     */
    public function find(int $id): User
    {
        $query = "SELECT * FROM users WHERE id = :id;";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);
        $stmt->execute();

        return $this->hydrateUser($stmt)[0];
    }

    /**
     * @param  string  $email
     * 
     * @return User
     */
    public function findByEmail(string $email): ?User
    {
        $query = "SELECT * FROM users WHERE email = :email;";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $this->hydrateUser($stmt)[0] ?? null;
    }

    /**
     * 
     */
    public function hydrateUser($stmt)
    {
        $userCollection = array();

        while ($userData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $userCollection[] = new User(
                $userData['id'],
                $userData['email'],
                $userData['password']
            );
        }

        return $userCollection;
    }
}
