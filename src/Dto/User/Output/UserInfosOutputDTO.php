<?php

namespace App\Dto\User\Output;

class UserInfosOutputDTO {
    public function __construct(
        public readonly float $login,
        public readonly string $postalCode
    ){}
}