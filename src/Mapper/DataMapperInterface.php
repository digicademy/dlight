<?php
namespace Digicademy\DLight\Mapper;

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

interface DataMapperInterface
{

    /**
     * @param string $className
     * @param mixed  $data
     */
    public function map($className, $data);
}
