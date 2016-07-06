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
     * @param \DOMElement $element    Source element.
     *
     * @return Element|null
     *
     * @since 1.0
     */
    public function parseElement(Extensions $extensions, \DOMElement $element);
}
