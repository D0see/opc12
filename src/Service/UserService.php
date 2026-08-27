<?php

namespace App\Service;

class UserService {
    public function __construct(
        private readonly PostalCodeService $postalCodeService,
    ){}

    /**
     * @param string $userName
     * @param string $password clear password
     * @param string $code the postalCode code
     * @return void
     */
    public function createUser(
        string $userName,
        string $password,
        string $code
    ) {
        $this->postalCodeService->findOrCreatePostalCode($code);

        if (strlen($password) < 7) {
            
        }

    }
}