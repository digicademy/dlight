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

interface BackendInterface
{

    // public function createByIdentifier($collection, $identifier);
    // public function createAll($collection, $resources);

    /**
     * @param string $collection
     * @param string $identifier
     *
     * @return string
     * @throws
     */
    public function readByIdentifier($collection, $identifier);

    /**
     * @param string $collection
     *
     * @return string
     * @throws
     */
    public function readAll($collection);

    // public function updateByIdentifier($collection, $identifier);
    // public function updateAll($collection, $resources);

    // public function deleteByIdentifier($collection, $identifier);
    // public function deleteAll($collection, $resources);
}
