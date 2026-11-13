<?php

namespace App\Service;

use App\Entity\Tip;
use App\Entity\User;
use App\Repository\MonthRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use ErrorHelper;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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
        User $user
    ): Tip {

        $months = $this->monthRepository->findBy(['num' => $monthsNums]);
        if ($monthsNums === [] || count($months) !== count(array_unique($monthsNums))) {
            throw new BadRequestHttpException('Select at least one valid month');
        }

        $tip = (new Tip())
        ->setContent($content)
        ->setMonths(new ArrayCollection($months))
        ->setUser($user);

        $errors = $this->validator->validate($tip);

        if (count($errors) > 0) {
            throw new BadRequestHttpException(ErrorHelper::spreadContraintViolationsMessages($errors));
        }

        $this->entityManager->persist($tip);

        $this->entityManager->flush();
        
        return $tip;
    }

    public function modifyTip(
        Tip $tip,
        ?string $content,
        ?array $monthsNums,
        User $user
    ): Tip {

        // if ($tip->getUser()->getId() !== $user->getId()) {
        //     throw new HttpException(statusCode: Response::HTTP_FORBIDDEN, message: 'a user cannot modify another users tip');
        // }

        if ($monthsNums !== null) {

            $months = $this->monthRepository->findBy(['num' => $monthsNums]);
            if ($monthsNums === [] || count($months) !== count(array_unique($monthsNums))) {
                throw new BadRequestHttpException('Select at least one valid month');
            }

            $tip->setMonths(new ArrayCollection($months));
        }


        if ($content !== null) {
            $tip->setContent($content);
        }
    
        $errors = $this->validator->validate($tip);

        if (count($errors) > 0) {
            throw new BadRequestHttpException(ErrorHelper::spreadContraintViolationsMessages($errors));
        }

        $this->entityManager->flush();
        
        return $tip;
    }

    public function deleteTip(Tip $tip) {
        
        $this->entityManager->remove($tip);

        $this->entityManager->flush();
    }
}