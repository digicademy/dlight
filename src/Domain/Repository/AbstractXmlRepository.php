<?php
namespace Digicademy\DLight\Domain\Repository;

/*********************************************************************************************
 * Copyright notice
 *
 * DLight - Domain Driven Design Microframework
 *
 * @copyright 2018-2019 Torsten Schrade <Torsten.Schrade@adwmainz.de>
 * @copyright 2018-2019 Academy of Sciences and Literature | Mainz
 * @license   https://raw.githubusercontent.com/digicademy/dlight/master/LICENSE (MIT License)
 *
 *********************************************************************************************/

use Psr\Container\ContainerInterface;
use Digicademy\DLight\Service\XmlService;

abstract class AbstractXmlRepository implements RepositoryInterface
{

    use RepositoryTrait;

    protected $container;

    protected $httpBackend;

    protected $objectFactory;

    protected $objectStorageFactory;

    protected $domainObject;

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
        $this->httpBackend = $this->container->get('HttpBackend');
        $this->objectFactory = $this->container->get('ObjectFactory');
        $this->objectStorageFactory = $this->container->get('ObjectStorageFactory');
        $this->domainObject = $this->setDomainObject();
    }

    /**
     * @param string $collection
     * @param string $identifier
     *
     * @return mixed
     */
    public function findByIdentifier($collection, $identifier)
    {
        $data = $this->httpBackend->readByIdentifier($collection, $identifier);
        $result = $this->objectFactory->build($this->domainObject, 'XmlDataMapper', $data);

        return $result;
    }

    /**
     * @param string $collection
     * @param string $query
     *
     * @return mixed
     * @throws \Exception
     */
    public function findAll($collection, $query)
    {
        $data = $this->httpBackend->readAll($collection);

        $xml = XmlService::load($data, $this->container->get('settings')['xslt']['namespaces']);
        $xpathQueryResult = $xml->xpath($query);

        $data = [];
        foreach ($xpathQueryResult as $item) {
            $data[] = $item->asXML();
        }

        $result = $this->objectStorageFactory->buildAll($this->domainObject, 'XmlDataMapper', $data);

        return $result;
    }

}
