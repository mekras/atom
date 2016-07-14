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
     * @throws \InvalidArgumentException If $element has invalid namespace.
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
     * @throws \Mekras\Atom\Exception\MalformedNodeException If REQUIRED flag set but nothing found.
     *
     * @since 1.0
     */
    public function query($xpath, $flags = 0)
    {
        $nodes = $this->getXPath()->query($xpath, $this->getDomElement());
        if (0 === $nodes->length && $flags & self::REQUIRED) {
            throw new MalformedNodeException(sprintf('Required node (%s) not found', $xpath));
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
     * Get attribute value.
     *
     * Important! This method uses document independent prefixes registered via @{link
     * Extension\NamespaceExtension}. This library registers only "atom:" prefix, but this list
     * can be expanded by extensions.
     *
     * @param string $attrName Attribute name (e. g. "type", "atom:foo").
     *
     * @return string|null
     *
     * @throws \InvalidArgumentException If $attrName contains unregistered prefix.
     *
     * @since 1.0
     */
    public function getAttribute($attrName)
    {
        $element = $this->getDomElement();
        if (strpos($attrName, ':') === false) {
            return $element->hasAttribute($attrName) ? $element->getAttribute($attrName) : null;
        } else {
            list($prefix, $name) = explode(':', $attrName);
            $namespace = $this->getNamespace($prefix);

            return $element->hasAttributeNS($namespace, $name)
                ? $element->getAttributeNS($namespace, $name)
                : null;
        }
    }

    /**
     * Set attribute value.
     *
     * Important! This method uses document independent prefixes registered via @{link
     * Extension\NamespaceExtension}. This library registers only "atom:" prefix, but this list
     * can be expanded by extensions.
     *
     * @param string      $attrName Attribute name (e. g. "type", "atom:foo").
     * @param string|null $value    New value or null to remove attribute.
     *
     * @throws \InvalidArgumentException If $attrName contains unregistered prefix.
     *
     * @since 1.0
     */
    public function setAttribute($attrName, $value)
    {
        $element = $this->getDomElement();
        if (strpos($attrName, ':') === false) {
            if (null === $value) {
                $element->removeAttribute($attrName);
            } else {
                $element->setAttribute($attrName, $value);
            }
        } else {
            list($prefix, $name) = explode(':', $attrName);
            $namespace = $this->getNamespace($prefix);
            if (null === $value) {
                $element->removeAttributeNS($namespace, $name);
            } else {
                $element->setAttributeNS($namespace, $name, $value);
            }
        }
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

    /**
     * Return namespace by registered prefix.
     *
     * @param string $prefix
     *
     * @return string
     *
     * @throws \InvalidArgumentException If the given prefix is not registered.
     */
    private function getNamespace($prefix)
    {
        $namespaces = $this->getExtensions()->getNamespaces();
        if (!array_key_exists($prefix, $namespaces)) {
            throw new \InvalidArgumentException(sprintf('Unknown NS prefix "%s"', $prefix));
        }

        return $namespaces[$prefix];
    }
}
