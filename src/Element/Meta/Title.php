<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Atom;
use Mekras\Atom\Construct\Text;
use Mekras\Atom\Node;

/**
 * Support for "atom:title".
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.14
 */
trait Title
{
    use Base;

    /**
     * Return title.
     *
     * @return Text
     *
     * @throws \InvalidArgumentException
     * @throws \Mekras\Atom\Exception\MalformedNodeException
     *
     * @since 1.0
     */
    public function getTitle()
    {
        return $this->getCachedProperty(
            'title',
            function () {
                return new Text($this->query('atom:title', Node::SINGLE | Node::REQUIRED));
            }
        );
    }

    /**
     * Set title.
     *
     * @param Text|string $title
     *
     * @since 1.0
     *
     * @throws \InvalidArgumentException
     */
    public function setTitle($title)
    {
        $element = $this->query('atom:title', Node::SINGLE);
        if (null === $element) {
            $element = $this->getDomElement()->ownerDocument->createElementNS(Atom::NS, 'title');
            $this->getDomElement()->appendChild($element);
        }
        $text = new Text($element);
        $text->setValue($title);
        $this->setCachedProperty('title', $text);
    }
}
