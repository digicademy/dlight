<?php
namespace Digicademy\DLight\Persistence;

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

use GuzzleHttp\Client as HttpClient;
use Psr\Container\ContainerInterface;

class HttpBackend implements BackendInterface
{

    private $container;

    private $baseUri;

    private $options;

    /**
     * @param ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->baseUri = $this->container->get('settings')['connection']['baseUri'];
        $this->options = $this->container->get('settings')['connection']['options'];
    }

    /**
     * @param string $collection
     *
     * @return string
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function readAll($collection)
    {
        $this->options['base_uri'] = $this->baseUri;
        $httpClient = new HttpClient($this->options);

        $response = (string)$httpClient->request('GET', $collection)->getBody();

        return $response;
    }

    /**
     * @param string $collection
     * @param string $identifier
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function readByIdentifier($collection, $identifier)
    {
        $this->options['base_uri'] = $this->baseUri . $collection;
        $httpClient = new HttpClient($this->options);

        $response = (string)$httpClient->request('GET', $identifier)->getBody();

        return $response;
    }

}
