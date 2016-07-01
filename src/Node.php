<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom;

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
     *
     * @since 1.0
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($element)
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
    protected function query($xpath, $flags = 0)
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
            $this->xpath->registerNamespace('atom', Atom::NS);
            $this->xpath->registerNamespace('xhtml', Atom::XHTML);
        }

        return $this->xpath;
    }
}
