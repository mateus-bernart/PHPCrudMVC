<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\UserRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    private \PDO $pdo;
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $dbPath = __DIR__ . '/../../banco.sqlite';
        $this->pdo = new \PDO("sqlite:$dbPath");
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        $user = $this->userRepository->find($email);

        if ($user === null) {
            $this->addErrorMessage('Usuário ou senha inválidos');
            return new Response(302, ['Location' => '/login']);
        }

        if (!password_verify($password, $user->getPassword())) {
            $this->addErrorMessage('Usuário ou senha inválidos');
            return new Response(302, ['Location' => '/login']);
        }

        if (password_needs_rehash($user->getPassword(), PASSWORD_ARGON2ID)) {
            $statement = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
            $statement->bindValue(1, password_hash($password, PASSWORD_ARGON2ID));
            $statement->bindValue(2, $user->getId());
            $statement->execute();
        }

        $_SESSION['logado'] = true;
        return new Response(302, ['Location' => '/']);
    } 
}
