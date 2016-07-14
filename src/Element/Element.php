<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element;

use Mekras\Atom\Extensions;
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
     * @param  Node            $parent  Parent node.
     * @param \DOMElement|null $element DOM element.
     *
     * @since 1.0
     *
     * @throws \InvalidArgumentException If $element has invalid namespace.
     */
    public function __construct(Node $parent, \DOMElement $element = null)
    {
        if (null === $element) {
            $owner = $parent->getDomElement();
            $ns = $this->ns();
            $element = $owner->ownerDocument->createElementNS($ns, $this->getNodeName());
            $owner->appendChild($element);
        }
        parent::__construct($element, $parent);
    }

    /**
     * Return extensions.
     *
     * @return Extensions
     *
     * @since 1.0
     */
    public function getExtensions()
    {
        return $this->getParent()->getExtensions();
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
