<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Element\Entry;
use Mekras\Atom\Element\Feed;
use Mekras\Atom\Extension\ElementExtension;

/**
 * Atom elements "extension".
 *
 * @since 1.0
 */
class AtomElements implements ElementExtension
{
    /**
     * Create Atom node from XML DOM element.
     *
     * @param Extensions       $extensions Extension registry.
     * @param \DOMElement|Node $source     DOM element or parent Atom node.
     *
     * @return Element|null
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function parseElement(Extensions $extensions, $source)
    {
        if (Atom::NS !== $source->namespaceURI) {
            return null;
        }

        switch ($source->localName) {
            case 'entry':
                return new Entry($extensions, $source);
                break;
            case 'feed':
                return new Feed($extensions, $source);
                break;
        }

        return null;
    }

    /**
     * Create new Atom node.
     *
     * @param Extensions $extensions Extension registry.
     * @param Node       $parent     Parent node.
     * @param string     $name       Element name.
     *
     * @return Element|null
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function createElement(Extensions $extensions, Node $parent, $name)
    {
        switch ($name) {
            case 'entry':
                return new Entry($extensions, $parent);
                break;
            case 'feed':
                return new Feed($extensions, $parent);
                break;
        }

        return null;
    }
}
