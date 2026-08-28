<?php

namespace App\Service;

use App\Entity\Tip;
use App\Repository\MonthRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use ErrorHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TipService {
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator,
        private readonly MonthRepository $monthRepository
    ){}

    public function createTip(
        string $content,
        array $monthsNums,
    ): Tip {

        $months = $this->monthRepository->findBy(['num' => $monthsNums]);
        if (count($months) < 1) {
            throw new HttpException(statusCode: Response::HTTP_INTERNAL_SERVER_ERROR, message: 'a tip must have at least one month');
        }

        $tip = (new Tip())
        ->setContent($content)
        ->setMonths(new ArrayCollection($months));

        $errors = $this->validator->validate($tip);

        if (count($errors) > 0) {
            throw new HttpException(
                statusCode: Response::HTTP_INTERNAL_SERVER_ERROR, 
                message: ErrorHelper::spreadContraintViolationsMessages($errors)
            );
        }

        $this->entityManager->persist($tip);

        $this->entityManager->flush();
        
        return $tip;
    }
}