<?php

namespace Jayrods\AluraMvc\Repository;

use PDO;
use Jayrods\AluraMvc\Repository\{VideoRepository, UserRepository};

class RepositoryFactory
{
    /**
     * 
     */
    private PDO $pdo;

    /**
     * 
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * 
     */
    public function create(string $case)
    {
        switch ($case) {
            case 'Video':
                return new VideoRepository($this->pdo);
            case 'User':
                return new UserRepository($this->pdo);
            default:
                return;
        }
    }
}
