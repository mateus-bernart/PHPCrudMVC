<?php

declare(strict_types=1);

namespace Alura\Mvc\Entity;

class User
{
    public readonly int $id;
    public readonly string $email;
    public readonly string $password;

    public function __construct(
        int $id,
        string $email,
        string $password
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
