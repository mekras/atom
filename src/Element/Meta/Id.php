<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Node;

/**
 * Support for "app:id".
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.6
 */
trait Id
{
    use Base;

    /**
     * Return permanent, universally unique identifier for an entry or feed.
     *
     * @return string IRI
     *
     * @throws \Mekras\Atom\Exception\MalformedNodeException
     *
     * @since 1.0
     */
    public function getId()
    {
        return $this->getCachedProperty(
            'id',
            function () {
                return trim(
                    $this->query('atom:id', Node::SINGLE | Node::REQUIRED)->nodeValue
                );
            }
        );
    }
}
