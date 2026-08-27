<?php

namespace App\Controller;

use App\Repository\MonthRepository;
use App\Repository\TipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/tip')]
final class TipController extends AbstractController
{

    public function __construct(
        private readonly TipRepository $tipRepository,
        private readonly MonthRepository $monthRepository
    ){}

    #[Route(path: '/{monthNum}', methods: ['GET'], name: 'get_tip_per_month')]
    public function getTipsByMonthNum(
        int $monthNum
    ): JsonResponse
    {   
        $month = $this->monthRepository->findOneBy(['num' => $monthNum]);

        $tips = $this->tipRepository->findBy(
            [
                'months' => $month
            ]
        );

        return new JsonResponse();
    }

    #[Route(path: '/', methods: ['GET'], name: 'get_tips_for_current_month')]
    public function getTipsForCurrentMonth(

    ): JsonResponse
    {   
        $month = $this->monthRepository->findOneBy(
            [
                'num' => (int) (new \DateTime('now'))->format('m')
            ]
        );

        $tips = $this->tipRepository->findBy(
            [
                'months' => $month
            ]
        );

        return new JsonResponse();
    }
}
