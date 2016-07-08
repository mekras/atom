<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Exception\MalformedNodeException;
use Mekras\ClassHelpers\Traits\GettersCacheTrait;

/**
 * Abstract Atom Node.
 *
 * @since 1.0
 */
abstract class Node
{
    use GettersCacheTrait;

    /**
     * Return only one element.
     */
    const SINGLE = 0x01;

    /**
     * At least one element should exists.
     */
    const REQUIRED = 0x02;

    /**
     * Parent node.
     *
     * @var Node|null
     */
    private $parent;

    /**
     * DOM Element.
     *
     * @var \DOMElement
     */
    private $element;

    /**
     * XPath object
     *
     * @var \DOMXPath
     */
    private $xpath = null;

    /**
     * Create node.
     *
     * @param \DOMElement $element DOM element.
     * @param  Node|null  $parent  Parent node.
     *
     * @since 1.0
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(\DOMElement $element, Node $parent = null)
    {
        if ($this->ns() !== $element->namespaceURI) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Unexpected NS "%s", expecting "%s"',
                    $element->namespaceURI,
                    $this->ns()
                )
            );
        }
        $this->element = $element;
        $this->parent = $parent;
    }

    /**
     * Return child DOM element by name.
     *
     * @param string $xpath XPath expression.
     * @param int    $flags Flags, see class constants.
     *
     * @return \DOMNodeList|\DOMElement|null
     *
     * @throws \Mekras\Atom\Exception\MalformedNodeException
     *
     * @since 1.0
     */
    public function query($xpath, $flags = 0)
    {
        $nodes = $this->getXPath()->query($xpath, $this->getDomElement());
        if (0 === $nodes->length && $flags & self::REQUIRED) {
            throw new MalformedNodeException(sprintf('Required node(s) (%s) missing', $xpath));
        }

        if ($flags & self::SINGLE) {
            if ($nodes->length > 1) {
                throw new MalformedNodeException(
                    sprintf(
                        '%s must not contain more than one %s node',
                        $this->getDomElement()->localName,
                        $xpath
                    )
                );
            } elseif ($nodes->length === 0) {
                return null;
            }

            return $nodes->item(0);
        }

        return $nodes;
    }

    /**
     * Return DOM Element.
     *
     * @return \DOMElement
     *
     * @since 1.0
     */
    public function getDomElement()
    {
        return $this->element;
    }

    /**
     * Return parent node.
     *
     * @return Node
     *
     * @since 1.0
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Return node main namespace.
     *
     * @return string
     *
     * @since 1.0
     */
    public function ns()
    {
        return Atom::NS;
    }

    /**
     * Return extensions.
     *
     * @return Extensions
     *
     * @since 1.0
     */
    abstract public function getExtensions();

    /**
     * Add new child element
     *
     * @param $name
     * @param $cacheId
     *
     * @return Element|null
     *
     * @since 1.0
     */
    protected function addChild($name, $cacheId)
    {
        $child = $this->getExtensions()->createElement($this, $name);
        $this->dropCachedProperty($cacheId);

        return $child;
    }

    /**
     * Get the XPath query object
     *
     * @return \DOMXPath
     *
     * @since 1.0
     */
    protected function getXPath()
    {
        if (!$this->xpath) {
            $this->xpath = new \DOMXPath($this->getDomElement()->ownerDocument);
            $namespaces = $this->getExtensions()->getNamespaces();
            foreach ($namespaces as $prefix => $namespace) {
                $this->xpath->registerNamespace($prefix, $namespace);
            }
        }

        return $this->xpath;
    }
}
