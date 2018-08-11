<?php
namespace Digicademy\DLight\Factory;

/*********************************************************************************************
 * Copyright notice
 *
 * DLight - Domain Driven Design Light
 *
 * @copyright 2018 Torsten Schrade <Torsten.Schrade@adwmainz.de>
 * @copyright 2018 Academy of Sciences and Literature | Mainz
 * @license   https://raw.githubusercontent.com/digicademy/dlight/master/LICENSE (MIT License)
 *
 *********************************************************************************************/

use Psr\Container\ContainerInterface;

class ObjectStorageFactory
{

    protected $container;

    /**
     * ObjectStorageFactory constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $className
     * @param string $mapper
     * @param array  $data
     *
     * @return mixed
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function buildAll($className, $mapper, $data)
    {

        $dataMapper = $this->container->get($mapper);
        $objectStorage = $this->container->get('ObjectStorage');

        foreach ($data as $key => $value) {
            $object = $dataMapper->map($className, $value);
            $objectStorage->attach($object, $object->getIdentifier());
        }

        return $objectStorage;
    }
}
