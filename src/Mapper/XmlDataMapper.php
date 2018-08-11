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

use phpDocumentor\Reflection\DocBlockFactory;
use Psr\Container\ContainerInterface;
use Digicademy\DLight\Service\XmlService;

class XmlDataMapper implements DataMapperInterface
{

    protected $container;

    protected $object;

    protected $reflector;

    protected $docBlockFactory;

    protected $docBlock;

    protected $data;

    protected $value;

    /**
     * XmlDataMapper constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param $className
     * @param $data
     *
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function map($className, $data)
    {
        $this->setData($data);
        $this->setObject($className);
        $this->setReflector();
        $this->setDocBlockFactory();

        foreach ($this->reflector->getProperties() as $property) {
            $this->getDocBlock($property->name);
            $this->getValue();
            $this->processValue();
            $this->castValue();
            $this->transformValue();
            $this->setValue($property->name);
        }

        return $this->object;
    }

    /**
     * @param $data
     *
     * @throws \Exception
     */
    private function setData($data)
    {
        $this->data = XmlService::load($data, $this->container->get('settings')['xslt']['namespaces']);
    }

    /**
     * @param $className
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function setObject($className)
    {
        $object = 'Digicademy\\DLight\\Domain\\Model\\' . $className;
        $this->object = new $object;
    }

    /**
     * @throws
     */
    private function setReflector()
    {
        $this->reflector = new \ReflectionClass($this->object);
    }

    /**
     * @void
     */
    private function setDocBlockFactory()
    {
        $this->docBlockFactory = DocBlockFactory::createInstance();
    }

    /**
     * @param $propertyName
     */
    private function getDocBlock($propertyName)
    {
        $this->docBlock = $this->docBlockFactory->create(
            $this->reflector->getProperty($propertyName)->getDocComment()
        );
    }

    /**
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function getValue()
    {
        $type = (string)$this->docBlock->getTagsByName('var')[0]->getType();

        if ($type == '\SplObjectStorage') {
            $this->getPrimitive();
            $className = (string)$this->docBlock->getTagsByName('var')[0]->getDescription();
            $this->getObjectStorage($className);
        } elseif ($type{0} == '\\') {
            $this->getObject($type);
        } else {
            $this->getPrimitive();
        }
    }

    /**
     * @void
     */
    private function getPrimitive()
    {
        $result = '';
        $xpathTag = $this->docBlock->getTagsByName('xpath')[0];
        if ($xpathTag) {
            $expressions = explode('|', (string)$xpathTag->getDescription());
            foreach ($expressions as $expression) {
                $expression = trim($expression);
                if (!$result) {
                    $result = $this->data->xpath($expression);
                }
            }
        }

        $this->value = $result;
    }

    /**
     * @param $className
     *
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function getObject($className)
    {
        $result = '';
        if (class_exists($className)) {
            $xmlDataMapper = clone($this);
            $result = $xmlDataMapper->map(substr($className, strrpos($className, '\\') + 1), $this->data->asXml());
        }
        $this->value = $result;
    }

    /**
     * @param $className
     *
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function getObjectStorage($className)
    {
        $objectStorage = new \SplObjectStorage;
        if (class_exists($className)) {
            $xmlDataMapper = clone($this);
            foreach ($this->value as $item) {
                $result = $xmlDataMapper->map(substr($className, strrpos($className, '\\') + 1), $item->asXml());
                $objectStorage->attach($result, $result->getIdentifier());
            }
        }
        $this->value = $objectStorage;
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function processValue()
    {
        if ($this->docBlock->getTagsByName('process')) {
            $processTag = $this->docBlock->getTagsByName('process')[0];
        } else {
            $processTag = '';
        }
        if ($processTag) {
            $processorList = explode(',', (string)$processTag->getDescription());
            foreach ($processorList as $processorItem) {
                $parameters = [$this->value];
                if (stripos($processorItem, '[')) {
                    $processorName = trim(substr($processorItem, 0, stripos($processorItem, '[')));
                    $processorArguments = str_replace('[', '',
                        trim(substr($processorItem, stripos($processorItem, '['))));
                    $processorArguments = str_replace(']', '', $processorArguments);
                    $processorArgumentKeyValues = explode(',', $processorArguments);
                    foreach ($processorArgumentKeyValues as $item) {
                        $keyValue = explode('=', $item);
                        $parameters[] = trim($keyValue[1]);
                    }
                } else {
                    $processorName = trim($processorItem);
                }
                $processor = $this->container->get($processorName);
                $value = call_user_func_array(array($processor, 'process'), $parameters);
                $this->value = $value;
            }
        }
    }

    /**
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function transformValue()
    {
        if ($this->docBlock->hasTag('transform')) {
            $transformations = explode(',', (string)$this->docBlock->getTagsByName('transform')[0]->getDescription());
            if ($transformations) {
                $styleSheets = array();
                if ($this->container->get('settings')['xslt']['stylesheetDir']) {
                    $stylesheetDir = $this->container->get('settings')['xslt']['stylesheetDir'];
                } else {
                    $stylesheetDir = __DIR__ . '/../../files/xsl/';
                }
                foreach ($transformations as $transformation) {
                    $styleSheets[] = $stylesheetDir . trim($transformation);
                }
                $result = XmlService::transform($this->value, $styleSheets);
                $result = str_replace('<transformation_root>', '', $result);
                $result = str_replace('</transformation_root>', '', $result);
                $this->value = $result;
            }
        }
    }

    /**
     * @void
     */
    private function setValue($propertyName)
    {
        if ($this->value) {
            $setterName = 'set' . ucfirst($propertyName);
            $this->object->$setterName($this->value);
        }
    }

    /**
     * @void
     */
    private function castValue()
    {
        $type = (string)$this->docBlock->getTagsByName('var')[0]->getType();

        switch ($type) {
            case 'boolean':
            case 'bool':
                $this->value = count($this->value);
                settype($this->value, $type);
                break;
            case 'integer':
            case 'int':
                settype($this->value, $type);
                break;
            case 'float':
                settype($this->value, $type);
                break;
            case 'array':
                settype($this->value, $type);
                break;
            case 'object':
                settype($this->value, $type);
                break;
            case 'null':
                $this->value = null;
                break;
            case 'mixed':
                $value = '';
                foreach ($this->value as $element) {
                    $value .= $element->asXml();
                }
                $this->value = '<transformation_root>' . $value . '</transformation_root>';
                break;
            case 'string':
                if (is_array($this->value)) {
                    $value = '';
                    foreach ($this->value as $element) {
                        $value .= (string)$element;
                    }
                    $this->value = $value;
                }
                settype($this->value, $type);
                break;
            default:
                break;
        }
    }
}
