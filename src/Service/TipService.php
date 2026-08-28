<?php

namespace App\Service;

use App\Entity\Tip;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TipService {
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator
    ){}

    public function createTip(
        string $content,
        array $monthsNums,
    ): Tip {

        $tip = (new Tip())
        ->setContent($content);

        $errors = $this->validator->validate($tip);

        if (count($errors) > 0) {
            throw new HttpException(statusCode: Response::HTTP_INTERNAL_SERVER_ERROR, message: json_encode($errors));
        }

        $this->entityManager->persist($tip);

        $this->entityManager->flush();
        
        return $tip;
    }
}