<?php

namespace RltBundle\Controller;

use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use RltBundle\Entity\User;
use RltBundle\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;

class UserController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Gets a Users list.
     *
     * @FOSRest\Get("/users")
     *
     * @QueryParam(name="set", map=true, strict=true, nullable=true, default="default")
     *
     * @ApiDoc(
     *     resource=true,
     *     section="RltBundle",
     *     description="Gets a Users list",
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
     * @return UserRepository
     */
    protected function getRepository(): UserRepository
    {
        return $this->getDoctrine()->getRepository(User::class);
    }
}
