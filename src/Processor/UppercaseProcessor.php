<?php
namespace Digicademy\DLight\Processor;

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

class UppercaseProcessor implements ProcessorInterface
{

    /**
     * @param array $value
     *
     * @return array
     */
    public function process($value)
    {
        $processedValue = array();
        foreach ($value as $valueToProcess) {
            $processedValue[] = (string)strtoupper($valueToProcess);
        }

        return $processedValue;
    }
}
