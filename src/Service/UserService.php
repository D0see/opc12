<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use ErrorHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class UserService {
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator,
        private readonly PostalCodeService $postalCodeService,
        private readonly UserRepository $userRepository,
    ){}

    /**
     * @param string $username
     * @param string $password clear password
     * @param string $code the postalCode code
     * @return User
     */
    public function createUser(
        string $username,
        string $password,
        string $code
    ): User {

        $userSharingUsername = $this->userRepository->findOneBy(['login' => $username]);

        if ($userSharingUsername !== null) {
            throw new HttpException(statusCode: Response::HTTP_CONFLICT, message: "this username is already taken");
        }

        $postalCode = $this->postalCodeService->findOrCreatePostalCode($code);

        $user = (new User())
        ->setLogin($username)
        ->setPostalCode($postalCode);

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            throw new HttpException(
                statusCode: Response::HTTP_INTERNAL_SERVER_ERROR, 
                message: ErrorHelper::spreadContraintViolationsMessages($errors)
            );
        }

        $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));

        $this->entityManager->persist($user);

        $this->entityManager->flush();
        
        return $user;
    }
}