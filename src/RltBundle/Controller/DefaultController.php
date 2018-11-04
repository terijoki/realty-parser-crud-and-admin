<?php

namespace RltBundle\Controller;

use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DefaultController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @FOSRest\Get("/")
     *
     * @ApiDoc(
     *     resource=true,
     *     statusCodes={
     *         200 = "Returned when successful",
     *         400 = "Returned when bad request param"
     *     }
     * )
     *
     * @QueryParam(name="set", map=true, nullable=true, default="getAdvertiser", description="Which set of fields group will be returned?")
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return ParamFetcherInterface
     */
    public function cgetAction(ParamFetcherInterface $paramFetcher)
    {
        return $paramFetcher;
    }
}
