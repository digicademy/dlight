<?php
namespace Digicademy\DLight\Factory;

/*********************************************************************************************
 * Copyright notice
 *
 * DLight - Domain Driven Design Microframework
 *
 * @copyright 2018 Torsten Schrade <Torsten.Schrade@adwmainz.de>
 * @copyright 2018 Academy of Sciences and Literature | Mainz
 * @license   https://raw.githubusercontent.com/digicademy/dlight/master/LICENSE (MIT License)
 *
 *********************************************************************************************/


use Psr\Container\ContainerInterface;

class ObjectFactory
{

    protected $container;

    /**
     * ObjectFactory constructor.
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
     * @param mixed  $data
     *
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function build($className, $mapper, $data)
    {
        $dataMapper = $this->container->get($mapper);

        return $dataMapper->map($className, $data);
    }
}
