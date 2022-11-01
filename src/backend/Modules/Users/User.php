<?php

declare(strict_types=1);

namespace Modules\User;

use Exception;

require "/xampp/htdocs/proftaak-WEB/vendor/autoload.php";

abstract class User
{
    protected ?int $id = null;
    protected ?string $email = null;

    public function getID(): int
    {
        if ($this->id === null) {
            throw new Exception("No account linked to User", 8);
        } else {
            return $this->id;
        }
    }

    public function getEmail(): string
    {
        if ($this->email === null) {
            throw new Exception("No account linked to User", 8);
        } else {
            return $this->email;
        }
    }
}
