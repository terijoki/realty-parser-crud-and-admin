<?php

namespace RltBundle\Controller;

use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use RltBundle\Entity\Group;
use RltBundle\Repository\GroupRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GroupController.
 */
final class GroupController extends AbstractController
{
    protected const REPOSITORY = GroupRepository::NAME;

    /**
     * Gets a Groups list.
     *
     * @FOSRest\Get("/groups")
     *
     * @QueryParam(name="set", map=true, strict=true, nullable=true, default="getGroup")
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
     * Gets a single Group.
     *
     * @QueryParam(name="set", map=true, strict=true, nullable=true, default="getShortGroup")
     *
     * @FOSRest\Get("/groups/{group}", requirements={"group" = "\d+"})
     *
     * @param ParamFetcherInterface $paramFetcher
     * @param Group                 $group
     *
     * @return Group|View
     * @ApiDoc(
     *     description="Returns a single Group",
     *     section="RltBundle",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when user is not found"
     *     }
     * )
     */
    public function getAction(ParamFetcherInterface $paramFetcher, Group $group)
    {
        return new View($this->getRepository()->find($group->getId()), Response::HTTP_OK);
    }
}
