<?php

namespace RltBundle\Controller;

use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use RltBundle\Entity\Bank;
use RltBundle\Repository\DeveloperRepository;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BuildingController.
 */
final class BuildingController extends AbstractController
{
    protected const REPOSITORY = DeveloperRepository::NAME;

    /**
     * Gets a Buildings list.
     *
     * @FOSRest\Get("/buildings")
     *
     * @FOSRest\View(serializerGroups={"getShortBuilding"})
     * @QueryParam(name="set", map=true, strict=true, nullable=true, default="getShortBuilding")
     *
     * @ApiDoc(
     *     resource=true,
     *     section="RltBundle",
     *     description="Gets a buidings list",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         400 = "Returned when bad request"
     *     }
     * )
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return array|View
     */
    public function getListAction(ParamFetcherInterface $paramFetcher)
    {
        return new View($this->getRepository()->findAll(), Response::HTTP_OK);
    }

    /**
     * Gets a single Building.
     *
     * @QueryParam(name="set", map=true, strict=true, nullable=true, default="getShortBuilding")
     *
     * @FOSRest\Get("/buildings/{building}", requirements={"building" = "\d+"})
     *
     * @param ParamFetcherInterface $paramFetcher
     * @param Bank                  $bank
     *
     * @return Bank|View
     * @ApiDoc(
     *     description="Returns a single building",
     *     section="RltBundle",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when user is not found"
     *     }
     * )
     */
    public function getAction(ParamFetcherInterface $paramFetcher, Bank $bank)
    {
        return new View($this->getRepository()->find($bank->getId()), Response::HTTP_OK);
    }
}
