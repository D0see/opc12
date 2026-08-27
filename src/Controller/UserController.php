<?php

namespace App\Controller;

use App\Dto\User\Input\UserCreationInputDTO;
use App\Entity\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/user')]
final class UserController extends AbstractController
{

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly UserService $userService
    ){}
    #[Route(name: 'user_create', methods: ['POST'])]
    public function create(
        Request $request
    ): JsonResponse
    {
        $userCreationInputDTO = $this->serializer->deserialize($request->getContent(), UserCreationInputDTO::class, 'json');

        $this->userService->createUser(
            userName: $userCreationInputDTO->getUsername(),
            password: $userCreationInputDTO->getPassword(),
            code: $userCreationInputDTO->getPostalCode()
        );
        
        return new JsonResponse();
    }
}
