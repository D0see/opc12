<?php

namespace App\Controller;

use App\Dto\User\Input\UserCreationInputDTO;
use App\Dto\User\Input\UserModificationInputDTO;
use App\Entity\User;
use App\Service\UserService;
use ErrorHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
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

    #[IsGranted('ROLE_ADMIN', message: 'route only accessible to admins')]
    #[Route(path: '/{user}', name: 'user_modify', methods: ['PUT'])]
    public function modfifyUser(
        Request $request,
        User $user
    ): JsonResponse
    {
        $userModificationInput = $this->serializer->deserialize($request->getContent(), UserModificationInputDTO::class, 'json');

        $errors = $this->validator->validate($userModificationInput);

        if (count($errors) > 0) {
            throw new HttpException(
                statusCode: Response::HTTP_BAD_REQUEST, 
                message: ErrorHelper::spreadContraintViolationsMessages($errors)
            );
        }

        $this->userService->modifyUser(
            username: $userModificationInput->getUsername(),
            password: $userModificationInput->getPassword(),
            code: $userModificationInput->getPostalCode(),
            user: $user
        );
        
        return new JsonResponse(status: Response::HTTP_OK);
    }

    #[IsGranted('ROLE_ADMIN', message: 'route only accessible to admins')]
    #[Route(path: '/{user}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(
        User $user
    ): JsonResponse
    {

        $this->userService->deleteUser($user);
        
        return new JsonResponse(status: Response::HTTP_OK);
    }
}
