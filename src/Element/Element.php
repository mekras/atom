<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element;

use Mekras\Atom\Node;

/**
 * Abstract Atom Element.
 *
 * @since 1.0
 */
abstract class Element extends Node
{
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
                        'Unexpected element name "%s", expecting "%s"',
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
}
