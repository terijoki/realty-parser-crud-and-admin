<?php

namespace RltBundle\Controller;

use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use RltBundle\Entity\Group;
use RltBundle\Repository\GroupRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GroupController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Gets a Groups list.
     *
     * @FOSRest\Get("/groups")
     *
     * @QueryParam(name="set", map=true, strict=true, nullable=true, default="default")
     *
     * @ApiDoc(
     *     resource=true,
     *     section="RltBundle",
     *     description="Gets a Groups list",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         400 = "Returned when bad request"
     *     }
     * )
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return JsonResponse|View
     */
    public function getListAction(ParamFetcherInterface $paramFetcher)
    {
        return new View($this->getRepository()->findAll(), Response::HTTP_OK);
    }

    /**
     * @return GroupRepository
     */
    protected function getRepository(): GroupRepository
    {
        return $this->getDoctrine()->getRepository(Group::class);
    }
}
