<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Construct;

use Mekras\Atom\Exception\MalformedNodeException;
use Mekras\Atom\Node;
use Mekras\Atom\Util\Xhtml;

/**
 * Atom Text Construct.
 *
 * @since 1.0
 * @link  https://tools.ietf.org/html/rfc4287#section-3.1
 */
class Text extends Node
{
    /**
     * Represent text as a string.
     *
     * @return string
     *
     * @since 1.0
     */
    public function __toString()
    {
        /** @var string $string */
        $string = $this->getCachedProperty(
            'value',
            function () {
                if ($this->getType() === 'xhtml') {
                    try {
                        /** @var \DOMElement $xhtml */
                        $xhtml = $this->query('xhtml:div', Node::SINGLE | Node::REQUIRED);
                    } catch (MalformedNodeException $e) {
                        return '';
                    }

                    return Xhtml::extract($xhtml);
                }

                return $this->getDomElement()->textContent;
            }
        );

        return $string;
    }

    /**
     * Return text type.
     *
     * @return string "text", "html", or "xhtml"
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-3.1.1
     */
    public function getType()
    {
        return $this->getCachedProperty(
            'type',
            function () {
                return $this->getDomElement()->getAttribute('type') ?: 'text';
            }
        );
    }

    /**
     * Set new value
     *
     * @param string $text
     * @param string $type
     *
     * @since 1.0
     */
    public function setValue($text, $type = 'text')
    {
        $this->getDomElement()->setAttribute('type', $type);
        $this->getDomElement()->nodeValue = $text;
    }
}
