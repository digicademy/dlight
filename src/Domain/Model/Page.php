<?php
namespace Digicademy\DLight\Domain\Model;

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

class Page extends AbstractEntity
{

    /**
     * @xpath //tei:publicationStmt/tei:idno
     * @var string $identifier
     */
    protected $identifier;

    /**
     * @xpath //tei:titleStmt/tei:title
     * @var string $title
     * @process UppercaseProcessor
     */
    protected $title;

    /**
     * @xpath //tei:body/tei:div
     * @transform html.xsl
     * @var mixed $content
     */
    protected $content;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     *
     * @throws \Exception
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

}
