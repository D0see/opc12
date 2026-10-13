<?php

namespace App\Dto\User\Mapper;

use App\Dto\User\Output\UserInfosOutputDTO;
use App\Entity\User;

class UserMapper {
    
    public function userToInfosOutputDTO(User $user): UserInfosOutputDTO
    {
        return new UserInfosOutputDTO(
            login: $user->getUsername(),
            postalCode: $user->getPostalCode()->getCode()
        );
    }
}