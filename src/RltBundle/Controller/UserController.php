<?php

namespace RltBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Psr\Log\LoggerInterface;
use RltBundle\Entity\Group;
use RltBundle\Entity\User;
use RltBundle\Manager\UserManager;
use RltBundle\Repository\UserRepository;
use RltBundle\Serializer\ErrorsNormalizer;
use RltBundle\Serializer\UserNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserController.
 */
final class UserController extends AbstractController
{
    protected const REPOSITORY = UserRepository::NAME;

    /**
     * @var ConstraintViolationListInterface
     */
    protected $errors;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var UserManager
     */
    private $manager;

    /**

     * UserController constructor.
     *
     * @param EntityManagerInterface $em
     * @param ValidatorInterface     $validator
     * @param LoggerInterface        $logger
     * @param UserManager            $manager
     * @param ValidatorInterface     $validator
     */
    public function __construct(EntityManagerInterface $em,
                                LoggerInterface $logger,
                                UserManager $manager,
                                ValidatorInterface $validator) {
        $this->em = $em;
        $this->logger = $logger;
        $this->manager = $manager;
        $this->validator = $validator;
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
     * @param User $user
     *
     * @return Response|User
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
    public function getAction(User $user)
    {
        $serializer = new Serializer([new UserNormalizer()], [new JsonEncoder()]);

        $data = $serializer->serialize($user, JsonEncoder::FORMAT);

        return new Response($data, Response::HTTP_OK);
    }

    /**
     * Creates a new User.
     *
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @FOSRest\Post("/users")
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
     * @return Response|View
     */
    public function createAction(Request $request)
    {
        $data = $request->request->all();
        $user = $this->createDenormalizedUser($data);

        $user->setPlainPassword($data['password']);
        $user->setEnabled(true);

        $this->em->persist($user);
        $log = [
            'user_id' => $user->getId(),
            'request' => \json_encode($data),
            'category' => 'user-post',
        ];

        try {
            $this->em->flush();
            $this->logger->info('User created', $log);

            return new View($user, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), $log);

            return new View($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param array $data
     * @return User
     * @throws ORMException
     */
    private function createDenormalizedUser(array $data): User
    {
        $serializer = new Serializer([(new ObjectNormalizer())->setIgnoredAttributes(['groups'])], [new JsonEncoder()]);

        /** @var User $rawUser */
        $user = $serializer->deserialize(\json_encode($data), User::class, JsonEncoder::FORMAT);

        $errors = $this->validator->validate($user);

        if (\count($errors) > 0) {
            $serializer = new Serializer([new ErrorsNormalizer()], [new JsonEncoder()]);
            $data = $serializer->serialize($errors, JsonEncoder::FORMAT);

            return new Response($data, Response::HTTP_BAD_REQUEST);
        }

        if (!empty($data['groups'])) {
            /* @var Group $group */
            foreach ($data['groups'] as $groupId) {
                try {
                    $group = $this->em->getReference(Group::class, $groupId);
                    if (null !== $group) {
                        $user->addGroup($group);
                    }
                } catch (ORMException $e) {
                }
            }
        } else {
            $defaultGroup = $this->em->getReference(Group::class, Group::DEFAULT_GROUP);
            $user->addGroup($defaultGroup);
        }

        return $user;
    }

    /**
     * Updates User info.
     *
     * @ApiDoc(
     *     section="ApiBundle",
     *     description="Updates User info",
     *     requirements={
     *         {
     *             "name" = "user",
     *             "dataType" = "integer",
     *             "description" = "User id"
     *         }
     *     },
     *     statusCodes={
     *         204 = "Returned when successful",
     *         400 = "Returned when bad request param",
     *         404 = "Returned when User is not found"
     *     },
     * )
     *
     * @FOSRest\Patch("/users/{user}", requirements={"user" = "\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param User $user
     *
     * @return Response|View
     * @throws ORMException
     */
    public function updateAction(Request $request, User $user)
    {
        $rawUser = $request->request->all();
        $userFromRequest = $this->createDenormalizedUser($rawUser);

        $serializer = new Serializer([new UserNormalizer()], [new JsonEncoder()]);

        //$normalized = $serializer->serialize($user, JsonEncoder::FORMAT);

        $createdUser = $this->manager->updateEntity($userFromRequest, $user);

        if (\count($this->getErrors()) > 0) {
            $serializer = new Serializer([new ErrorsNormalizer()], [new JsonEncoder()]);
            $data = $serializer->serialize($this->getErrors(), JsonEncoder::FORMAT);

            return new Response($data, Response::HTTP_BAD_REQUEST);
        }
    }
}
