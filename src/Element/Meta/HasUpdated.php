<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Node;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Element has an "updated" node.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.15
 */
trait HasUpdated
{
    use NodeInterfaceTrait;

    /**
     * Return the most recent instant in time when an entry or feed was modified
     *
     * @return \DateTime
     *
     * @throws \Mekras\Atom\Exception\MalformedNodeException
     *
     * @since 1.0
     */
    public function getUpdated()
    {
        return $this->getCachedProperty(
            'updated',
            function () {
                return new \DateTimeImmutable(
                    trim(
                        $this->query('atom:updated', Node::SINGLE | Node::REQUIRED)->nodeValue
                    )
                );
            }
        );
    }
}