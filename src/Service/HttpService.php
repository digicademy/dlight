<?php
namespace Digicademy\DLight\Service;

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

use GuzzleHttp\Client as HttpClient;
use Psr\Container\ContainerInterface;

class HttpService implements ApiInterface
{

    protected $container;

    protected $baseUri;

    /**
     * HttpService constructor
     *
     * @param ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->baseUri = $this->container->get('settings')['httpServiceBaseUri'];
    }

    /**
     * @param string $identifier
     * @param string $collection
     *
     * @return string
     * @throws
     */
    public function fetchResourceByIdentifier($identifier, $collection)
    {
        $httpClient = new HttpClient(['base_uri' => $this->baseUri . $collection . '/']);
        $response = (string)$httpClient->request('GET', $identifier)->getBody();

        return $response;
    }

    /**
     * @param string $collection
     *
     * @return string
     * @throws
     */
    public function fetchAllResources($collection)
    {
        $httpClient = new HttpClient(['base_uri' => $this->baseUri]);
        $response = (string)$httpClient->request('GET', $collection . '/')->getBody();

        return $response;
    }

}
