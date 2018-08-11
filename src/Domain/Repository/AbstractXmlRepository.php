<?php
namespace Digicademy\DLight\Domain\Repository;

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
use Digicademy\DLight\Service\XmlService;

abstract class AbstractXmlRepository implements RepositoryInterface
{

    protected $container;

    protected $httpService;

    protected $objectFactory;

    protected $objectStorageFactory;

    /**
     * Repository constructor
     *
     * @param ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->httpService = $this->container->get('HttpService');
        $this->objectFactory = $this->container->get('ObjectFactory');
        $this->objectStorageFactory = $this->container->get('ObjectStorageFactory');
    }

    /**
     * @param string $objectType
     * @param string $collection
     * @param string $identifier
     *
     * @return mixed
     */
    public function findByIdentifier($objectType, $collection, $identifier)
    {
        $data = $this->httpService->fetchResourceByIdentifier($identifier, $collection);
        $result = $this->objectFactory->build($objectType, 'XmlDataMapper', $data);

        return $result;
    }

    /**
     * @param string $objectType
     * @param string $collection
     * @param string $query
     *
     * @return mixed
     * @throws \Exception
     */
    public function findAll($objectType, $collection, $query)
    {
        $data = $this->httpService->fetchAllResources($collection);

        $xml = XmlService::load($data, $this->container->get('settings')['xslt']['namespaces']);
        $xpathQueryResult = $xml->xpath($query);

        $data = '';
        foreach ($xpathQueryResult as $item) {
            $data[] = $item->asXML();
        }

        $result = $this->objectStorageFactory->buildAll($objectType, 'XmlDataMapper', $data);

        return $result;
    }

}
