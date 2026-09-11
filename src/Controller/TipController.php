<?php

namespace App\Controller;

use ErrorHelper;
use App\Dto\Tip\Input\TipCreationInputDTO;
use App\Dto\Tip\Mapper\TipMapper;
use App\Entity\Tip;
use App\Repository\TipRepository;
use App\Service\TipService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
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
        private readonly TipMapper $tipMapper,
        private readonly Security $security
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

        $tip = $this->tipService->createTip(
            content: $tipCreationInputDTO->getContent(),
            monthsNums: $tipCreationInputDTO->getMonthsNums(),
            user: $this->security->getUser()
        );
        
        return new JsonResponse(
            data: $this->tipMapper->TipToOutputDTO($tip),
            status: Response::HTTP_CREATED
        );
    }

    #[Route(path: '/{monthNum}', methods: ['GET'], name: 'get_tip_per_month')]
    public function getTipsByMonthNum(
        int $monthNum
    ): JsonResponse
    {   
        $tips = $this->tipRepository->findByMonthNum($monthNum);

        return new JsonResponse(
            data: array_map(
                callback: fn(Tip $tip) => $this->tipMapper->TipToOutputDTO($tip),
                array: $tips
            )
        );
    }

    #[Route(path: '/', methods: ['GET'], name: 'get_tips_for_current_month')]
    public function getTipsForCurrentMonth(
    ): JsonResponse
    {   
        $tips = $this->tipRepository->findByMonthNum((int) (new \DateTime('now'))->format('m'));

        $data = array_map(
            callback: fn(Tip $tip) => $this->tipMapper->TipToOutputDTO($tip),
            array: $tips
        );

        return new JsonResponse(
            data: $data
        );
    }

    #[Route(path: '/{tip}', methods: ['DELETE'], name: 'delete_tip')]
    public function deleteTipById(
        Tip $tip
    ): JsonResponse
    {   

        $this->tipService->deleteTip($tip);
        
        return new JsonResponse(
            status: Response::HTTP_OK
        );
    }
}
