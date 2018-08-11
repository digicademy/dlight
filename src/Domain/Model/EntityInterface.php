<?php
namespace Digicademy\DLight\Domain\Model;

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

interface EntityInterface
{

    public function getIdentifier();

    public function setIdentifier($identifier);

}
