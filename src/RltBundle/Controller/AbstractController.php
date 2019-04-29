<?php

namespace RltBundle\Controller;

use Doctrine\Common\Persistence\ObjectRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

/**
 * Class AbstractController.
 */
abstract class AbstractController extends FOSRestController implements ClassResourceInterface
{
    protected const REPOSITORY = 'RltBundle:EntityName';

    /**
     * @return ObjectRepository
     */
    protected function getRepository(): ObjectRepository
    {
        return $this->getDoctrine()->getRepository(static::REPOSITORY);
    }
}
