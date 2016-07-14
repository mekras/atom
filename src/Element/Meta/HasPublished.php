<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Element\Published;
use Mekras\Atom\Node;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Element has "atom:published" child element.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.9
 */
trait HasPublished
{
    use NodeInterfaceTrait;

    /**
     * Return date published.
     *
     * @return Published
     *
     * @throws \Mekras\Atom\Exception\MalformedNodeException If there is no required element.
     *
     * @since 1.0
     */
    public function getPublished()
    {
        return $this->getCachedProperty(
            'published',
            function () {
                $element = $this->query('atom:published', Node::SINGLE | Node::REQUIRED);

                /** @var Element $this */
                return $this->getExtensions()->parseElement($this, $element);
            }
        );
    }

    /**
     * Add date published.
     *
     * @param \DateTimeInterface $time
     *
     * @return Published
     *
     * @since 1.0
     */
    public function addPublished(\DateTimeInterface $time)
    {
        /** @var Published $element */
        $element = $this->addChild('atom:published', 'published');
        $element->setDate($time);

        return $element;
    }
}
