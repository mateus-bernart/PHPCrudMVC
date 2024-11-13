<?php

declare(strict_types=1);

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\User;
use PDO;
use Alura\Mvc\Helper\FlashMessageTrait;
use Nyholm\Psr7\Response;

class UserRepository
{
    use FlashMessageTrait;
    public function __construct(private PDO $pdo) {}

    public function find(string $email)
    {
        $statement = $this->pdo->prepare('SELECT * FROM users WHERE email = ?;');
        $statement->bindValue(1, $email, \PDO::PARAM_STR);
        $statement->execute();

        $userData = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($userData === false) {
            return null;
        }

        return $this->hydrateUser($userData);
    }

    private function hydrateUser(array $userData): User
    {
        return new User(
            $userData['id'],
            $userData['email'],
            $userData['password']
        );
    }
}
