<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/user')]
final class UserController extends AbstractController
{
    #[Route(name: 'user_create', methods: ['POST'])]
    public function create(): JsonResponse
    {
        return new JsonResponse();
    }
}
