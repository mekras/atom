<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Element\Updated;
use Mekras\Atom\Node;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Element has "atom:updated" child element.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.15
 */
trait HasUpdated
{
    use NodeInterfaceTrait;

    /**
     * Return date updated.
     *
     * @return Updated
     *
     * @throws \Mekras\Atom\Exception\MalformedNodeException If there is no required element.
     *
     * @since 1.0
     */
    public function getUpdated()
    {
        return $this->getCachedProperty(
            'updated',
            function () {
                $element = $this->query('atom:updated', Node::SINGLE | Node::REQUIRED);

                /** @var Element $this */
                return $this->getExtensions()->parseElement($this, $element);
            }
        );
    }

    /**
     * Add date updated.
     *
     * @param \DateTimeInterface $time
     *
     * @return Updated
     *
     * @since 1.0
     */
    public function addUpdated(\DateTimeInterface $time)
    {
        /** @var Updated $element */
        $element = $this->addChild('atom:updated', 'updated');
        $element->setDate($time);

        return $element;
    }
}
