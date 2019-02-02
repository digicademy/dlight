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

trait RepositoryTrait
{

    /**
     * Gets the domain object for this repository.
     * Class name is derived from FQN of this repository.
     *
     * @return string
     */
     private function setDomainObject() {
        $className = str_replace('Repository', 'Model', get_class($this));
        $domainObject = strrev(preg_replace(strrev('/Model/'), '', strrev($className),1));
        return $domainObject;
     }

}
