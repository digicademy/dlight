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

interface ApiInterface
{
    /**
     * @param string $identifier
     * @param string $collection
     *
     * @return string
     * @throws
     */
    public function fetchResourceByIdentifier($identifier, $collection);

    /**
     * @param string $collection
     *
     * @return string
     * @throws
     */
    public function fetchAllResources($collection);
}
