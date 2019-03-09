<?php

namespace App\Usermanagement\Controller\Rest;

use App\Domain\Model\Group\Group;
use App\Application\Service\GroupService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class GroupController extends AbstractFOSRestController
{
    /**
     * @var
     */
    private $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    /**
     * Add Group
     * @Rest\Post("/group")
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request) : JsonResponse
    {

        $result = '';
        if ($request->request->has('groupname')) {
            $group = new Group();
            $group->setGroupname($request->get('groupname'));
            $group->setStatus(1);
            $result = $this->groupService->saveGroup($group);
        } else {
            throw new \InvalidArgumentException('Bad request required parameters not found.');
        }

        if($result != '') {
            return new JsonResponse("Group created", Response::HTTP_OK);
        } else {
            return new JsonResponse("Group not created", Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * @Rest\Delete("/group")
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function delete(Request $request) : JsonResponse
    {

        $result = '';
        if ($request->request->has('groupid')) {
            $result = $this->groupService->deleteGroup($request->get('groupid'));
        } else {
            throw new \InvalidArgumentException('Bad request required parameters not found.');
        }

        if($result != '') {
            return new JsonResponse("Group deleted", Response::HTTP_OK);
        } else {
            return new JsonResponse("Group not deleted", Response::HTTP_BAD_REQUEST);
        }
    }

    

}