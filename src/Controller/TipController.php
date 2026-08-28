<?php

namespace App\Controller;

use ErrorHelper;
use App\Dto\Tip\Input\TipCreationInputDTO;
use App\Repository\MonthRepository;
use App\Repository\TipRepository;
use App\Service\TipService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('api/tip')]
final class TipController extends AbstractController
{

    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly SerializerInterface $serializer,
        private readonly TipService $tipService,
        private readonly TipRepository $tipRepository,
        private readonly MonthRepository $monthRepository
    ){}

    #[Route(name: 'tip_create', methods: ['POST'])]
    public function create(
        Request $request
    ): JsonResponse
    {
        $tipCreationInputDTO = $this->serializer->deserialize($request->getContent(), TipCreationInputDTO::class, 'json');

        $errors = $this->validator->validate($tipCreationInputDTO);

        if (count($errors) > 0) {
            throw new HttpException(
                statusCode: Response::HTTP_BAD_REQUEST, 
                message: ErrorHelper::spreadContraintViolationsMessages($errors)
            );
        }

        $this->tipService->createTip(
            content: $tipCreationInputDTO->getContent(),
            monthsNums: $tipCreationInputDTO->getMonthsNums()
        );
        
        return new JsonResponse(status: Response::HTTP_CREATED);
    }

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
