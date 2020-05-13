<?php

namespace RltBundle\Controller;

use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use RltBundle\Entity\Bank;
use RltBundle\Repository\BankRepository;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BankController.
 */
final class BankController extends AbstractController
{
    protected const REPOSITORY = BankRepository::NAME;

    /**
     * Gets a Bank list.
     *
     * @FOSRest\Get("/banks")
     *
     * @FOSRest\View(serializerGroups={"getShortBank"})
     * @QueryParam(name="set", map=true, strict=true, nullable=true, default="getShortBank")
     *
     * @ApiDoc(
     *     resource=true,
     *     section="RltBundle",
     *     description="Gets a banks list",
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
     * Gets a single Bank.
     *
     * @QueryParam(name="set", map=true, strict=true, nullable=true, default="getShortBank")
     *
     * @FOSRest\Get("/banks/{bank}", requirements={"bank" = "\d+"})
     *
     * @param ParamFetcherInterface $paramFetcher
     * @param Bank                  $bank
     *
     * @return Bank|View
     * @ApiDoc(
     *     description="Returns a single Bank",
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
