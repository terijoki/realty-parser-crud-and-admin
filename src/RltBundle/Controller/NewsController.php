<?php

namespace RltBundle\Controller;

use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use RltBundle\Entity\Bank;
use RltBundle\Repository\NewsRepository;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NewsController.
 */
final class NewsController extends AbstractController
{
    protected const REPOSITORY = NewsRepository::NAME;

    /**
     * Gets a Banks list.
     *
     * @FOSRest\Get("/news")
     *
     * @FOSRest\View(serializerGroups={"getShortNews"})
     * @QueryParam(name="set", map=true, strict=true, nullable=true, default="getShortNews")
     *
     * @ApiDoc(
     *     resource=true,
     *     section="RltBundle",
     *     description="Gets a news list",
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
     * Gets a single News.
     *
     * @QueryParam(name="set", map=true, strict=true, nullable=true, default="getShortNews")
     *
     * @FOSRest\Get("/news/{news}", requirements={"news" = "\d+"})
     *
     * @param ParamFetcherInterface $paramFetcher
     * @param Bank                  $bank
     *
     * @return Bank|View
     * @ApiDoc(
     *     description="Returns a single news",
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
