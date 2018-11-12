<?php

namespace RltBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use RltBundle\Entity\User;
use RltBundle\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController.
 */
final class UserController extends AbstractController
{
    protected const REPOSITORY = UserRepository::NAME;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * UserController constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Gets a Users list.
     *
     * @FOSRest\Get("/users")
     *
     * @QueryParam(name="set", map=true, strict=true, nullable=true, default="getUser")
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
     * Gets a single User.
     *
     * @FOSRest\Get("/users/{user}", requirements={"user" = "\d+"})
     *
     * @param ParamFetcherInterface $paramFetcher
     * @param User                  $user
     *
     * @return User|View
     * @ApiDoc(
     *     output="RltBundle\Entity\User",
     *     description="Returns a single User",
     *     section="RltBundle",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when user is not found"
     *     }
     * )
     */
    public function getAction(ParamFetcherInterface $paramFetcher, User $user)
    {
        return new View($this->getRepository()->find($user->getId()), Response::HTTP_OK);
    }

    /**
     * Creates a new User.
     *
     * @ApiDoc(
     *     section="RltBundle",
     *     description="Creates a new User",
     *     statusCodes={
     *         201 = "Returned when successful",
     *         400 = "Returned when bad request param"
     *     }
     * )
     *
     * @param Request $request
     *
     * @throws \Doctrine\ORM\ORMException
     *
     * @return View
     */
    public function createAction(Request $request)
    {
        //creates user from request here and validate them

//        $this->em->persist($user);
//        $this->em->flush();

//        return new View($user, Response::HTTP_CREATED);
    }
}
