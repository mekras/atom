<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Extension;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Extensions;
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
     * @param Extensions  $extensions Extension registry.
     * @param \DOMElement $element    DOM element.
     *
     * @return Element|null
     *
     * @since 1.0
     */
    public function parseElement(Extensions $extensions, $element);

    /**
     * Create new Atom node.
     *
     * @param Extensions $extensions Extension registry.
     * @param Node       $parent     Parent node.
     * @param string     $name       Element name.
     *
     * @return Element|null
     *
     * @since 1.0
     */
    public function createElement(Extensions $extensions, Node $parent, $name);
}
