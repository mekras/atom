<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element;

use Mekras\Atom\Exception\MalformedNodeException;
use Mekras\Atom\Node;

/**
 * Abstract Atom Element.
 *
 * @since 1.0
 */
abstract class Element extends Node
{
    /**
     * Return only one element.
     */
    const SINGLE = 0x01;

    /**
     * At least one element should exists.
     */
    const REQUIRED = 0x02;

    /**
     * Create node.
     *
     * @param \DOMElement|Node $source DOM element or parent Atom node.
     *
     * @since 1.0
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($source)
    {
        if ($source instanceof Node) {
            $owner = $source->getDomElement();
            $element = $owner->ownerDocument->createElementNS($this->ns(), $this->getNodeName());
            $owner->appendChild($element);
            parent::__construct($element);
        } elseif ($source instanceof \DOMElement) {
            if ($this->getNodeName() !== $source->localName) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Unexpected element "%s", expecting "%s"',
                        $source->localName,
                        $this->getNodeName()
                    )
                );
            }
            parent::__construct($source);
        } else {
            throw new \InvalidArgumentException(
                sprintf(
                    '1st argument of %s should be an instance of DOMElement or %s',
                    __METHOD__,
                    Node::class
                )
            );
        }
    }

    /**
     * Child classes should return node name here.
     *
     * @return string
     *
     * @since 1.0
     */
    abstract protected function getNodeName();

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
}
