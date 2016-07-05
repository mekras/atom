<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Atom;
use Mekras\Atom\Node;

/**
 * Support for "atom:link[rel=self]".
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.2
 */
trait SelfLink
{
    use Base;

    /**
     * Return IRI in that identifies a resource equivalent to the containing element.
     *
     * @return string|null IRI
     *
     * @throws \Mekras\Atom\Exception\MalformedNodeException
     *
     * @since 1.0
     */
    public function getSelfLink()
    {
        return $this->getCachedProperty(
            'selfLink',
            function () {
                $element = $this->query('atom:link[@rel="self"]', Node::SINGLE);

                return $element ? trim($element->getAttribute('href')) : null;
            }
        );
    }

    /**
     * Set permanent, universally unique identifier for an entry or feed.
     *
     * @param string $value IRI
     *
     * @since 1.0
     */
    public function setSelfLink($value)
    {
        $element = $this->query('atom:link[@rel="self"]', Node::SINGLE);
        if (null === $element) {
            $element = $this->getDomElement()->ownerDocument->createElementNS(Atom::NS, 'link');
            $this->getDomElement()->appendChild($element);
            $element->setAttribute('rel', 'self');
        }
        $element->setAttribute('href', $value);
        $this->setCachedProperty('selfLink', $value);
    }
}
