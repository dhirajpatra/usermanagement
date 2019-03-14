<?php

namespace App\Usermanagement\Controller\Rest;

use App\Domain\Model\Groupuser\Groupuser;
use App\Application\Service\GroupuserService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class GroupuserController extends AbstractFOSRestController
{
    /**
     * @var
     */
    private $groupuserService;

    public function __construct(GroupuserService $groupuserService)
    {
        $this->groupuserService = $groupuserService;
    }

    /**
     * Add Groupuser
     * @Rest\Post("/groupuser")
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request) : JsonResponse
    {
        $result = '';
        if ($request->request->has('userid') && $request->request->has('groupid')) {
            $groupuser = new Groupuser();
            $groupuser->setGroupid($request->get('groupid'));
            $groupuser->setUserid($request->get('userid'));

            $result = $this->groupuserService->saveGroupuser($request->get('userid'), $request->get('groupid'), $groupuser);
        } else {
            throw new \InvalidArgumentException('Bad request required parameters not found.');
        }


        if($result != '') {
            return new JsonResponse("Groupuser created", Response::HTTP_OK);
        } else {
            return new JsonResponse("Groupuser not created", Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * @Rest\Delete("/groupuser")
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function delete(Request $request) : JsonResponse
    {
        $result = '';
        if ($request->request->has('userid')) {
            //$result = $this->groupuserService->deleteGroupuserByGroup($request->get('groupid'));
            $result = $this->groupuserService->deleteGroupuserByUser($request->get('userid'));
        } else {
            throw new \InvalidArgumentException('Bad request required parameters not found.');
        }

        if($result != '') {
            return new JsonResponse("Groupuser deleted", Response::HTTP_OK);
        } else {
            return new JsonResponse("Groupuser not deleted", Response::HTTP_BAD_REQUEST);
        }
    }


}