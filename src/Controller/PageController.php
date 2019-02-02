<?php
namespace Digicademy\DLight\Controller;

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
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PageController
{

    protected $container;

    protected $pageRepository;

    protected $view;

    /**
     * PageController constructor.
     *
     * @param ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->pageRepository = $this->container->get('PageRepository');
        $this->view = $this->container->get('view');
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param          $args
     *
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function indexAction(Request $request, Response $response, $args)
    {
        $settings = [
            'basePath' => $request->getUri()->getBasePath(),
            'path' => $request->getUri()->getPath(),
            'frameworkPath' => $this->container->settings['frameworkPath']
        ];

        return $this->view->render($response, 'index.html', ['settings' => $settings]);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param          $args
     *
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function testAction(Request $request, Response $response, $args)
    {
        $page = $this->pageRepository->findByIdentifier('data/', 'test.xml');

        $settings = [
            'basePath' => $request->getUri()->getBasePath(),
            'path' => $request->getUri()->getPath(),
            'frameworkPath' => $this->container->settings['frameworkPath']
        ];

        return $this->view->render($response, 'test.html', ['page' => $page, 'settings' => $settings]);
    }

}
