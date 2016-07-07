<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Extension;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Node;

/**
 * Element extension interface.
 *
 * @since 1.0
 */
interface ElementExtension extends Extension
{
    /**
     * Create Atom node from XML DOM element.
     *
     * @param Node        $parent  Parent node.
     * @param \DOMElement $element DOM element.
     *
     * @return Element|null
     *
     * @since 1.0
     */
    public function parseElement(Node $parent, \DOMElement $element);

    /**
     * Create new Atom node.
     *
     * @param Node   $parent Parent node.
     * @param string $name   Element name.
     *
     * @return Element|null
     *
     * @since 1.0
     */
    public function createElement(Node $parent, $name);
}
