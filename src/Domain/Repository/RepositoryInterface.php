<?php
namespace Digicademy\DLight\Domain\Repository;

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

interface RepositoryInterface
{

    /**
     * @param $objectType
     * @param $collection
     * @param $identifier
     *
     * @return mixed
     */
    public function findByIdentifier($objectType, $collection, $identifier);

    /**
     * @param string $objectType
     * @param string $collection
     * @param string $query
     *
     * @return mixed
     * @throws \Exception
     */
    public function findAll($objectType, $collection, $query);

}
