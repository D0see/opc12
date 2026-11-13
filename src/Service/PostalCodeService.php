<?php

namespace App\Service;

use App\Entity\PostalCode;
use App\Repository\PostalCodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use ErrorHelper;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostalCodeService {
    public function __construct(
        private readonly PostalCodeRepository $postalCodeRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator
    ){}

    public function findOrCreatePostalCode(
        string $code
    ): PostalCode {

        $postalCode = $this->postalCodeRepository->findOneBy(['code' => $code]);
        if ($postalCode === null) {
            return $this->createPostalCode($code);
        }

        return $postalCode;
    }

    private function createPostalCode(string $code): PostalCode 
    {

        $newPostalCode = (new PostalCode())->setCode($code);

        $errors = $this->validator->validate($newPostalCode);

        if ($errors->count() > 0) {
            throw new BadRequestHttpException(ErrorHelper::spreadContraintViolationsMessages($errors));
        }

        $this->entityManager->persist($newPostalCode);

        $this->entityManager->flush();

        return $newPostalCode;
    }
}