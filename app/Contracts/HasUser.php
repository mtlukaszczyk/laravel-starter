<?php declare(strict_types=1);

namespace App\Contracts;

use App\Models\User;

interface HasUser
{
    public function getUser(): User|null;
}
