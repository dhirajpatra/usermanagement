<?php

namespace App\Usermanagement\Controller\Rest;

use App\Domain\Model\User\User;
use App\Application\Service\UserService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UserController extends AbstractFOSRestController
{
    /**
     * @var
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Add User
     * @Rest\Post("/user")
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request) : JsonResponse
    {
        
        $result = '';
        if ($request->request->has('username')) {
            $user = new User();
            $user->setUsername($request->get('username'));
            $user->setStatus(1);
            $result = $this->userService->saveUser($user);

        } else {
            throw new \InvalidArgumentException('Bad request required parameters not found.');
        }

        if($result != '') {
            return new JsonResponse("User created", Response::HTTP_OK);
        } else {
            return new JsonResponse("User not created", Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * @Rest\Delete("/user")
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function delete(Request $request) : JsonResponse
    {
        $result = '';
        if ($request->request->has('userid')) {
            $result = $this->userService->deleteUser($request->get('userid'));
        } else {
            throw new \InvalidArgumentException('Bad request required parameters not found.');
        }

        if($result != '') {
            return new JsonResponse("User deleted", Response::HTTP_OK);
        } else {
            return new JsonResponse("User not deleted", Response::HTTP_BAD_REQUEST);
        }
    }

   
}