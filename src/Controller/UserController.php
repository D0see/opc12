<?php

namespace App\Controller;

use App\Dto\User\Input\UserCreationInputDTO;
use App\Service\UserService;
use ErrorHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('api/user')]
final class UserController extends AbstractController
{

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
        private readonly UserService $userService,
    ){}
    
    #[Route(path: '/create', name: 'user_create', methods: ['POST'])]
    public function create(
        Request $request
    ): JsonResponse
    {
        $userCreationInputDTO = $this->serializer->deserialize($request->getContent(), UserCreationInputDTO::class, 'json');

        $errors = $this->validator->validate($userCreationInputDTO);

        if (count($errors) > 0) {
            throw new HttpException(
                statusCode: Response::HTTP_BAD_REQUEST, 
                message: ErrorHelper::spreadContraintViolationsMessages($errors)
            );
        }

        $this->userService->createUser(
            username: $userCreationInputDTO->getUsername(),
            password: $userCreationInputDTO->getPassword(),
            code: $userCreationInputDTO->getPostalCode()
        );
        
        return new JsonResponse(status: Response::HTTP_CREATED);
    }
}
