<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Construct;

use Mekras\Atom\Exception\MalformedNodeException;
use Mekras\Atom\Node;
use Mekras\Atom\NodeInterfaceTrait;
use Mekras\Atom\Util\Xhtml;

/**
 * Atom Text Construct.
 *
 * @since 1.0
 * @link  https://tools.ietf.org/html/rfc4287#section-3.1
 */
trait Text
{
    use NodeInterfaceTrait;

    /**
     * Represent text as a string.
     *
     * @return string
     *
     * @since 1.0
     */
    public function __toString()
    {
        return $this->getContent();
    }

    /**
     * Return text content.
     *
     * @return string
     *
     * @since 1.0
     */
    public function getContent()
    {
        return $this->getCachedProperty(
            'content',
            function () {
                return $this->parseContent();
            }
        );
    }

    /**
     * Set new text.
     *
     * @param string $text Text.
     * @param string $type Content type: "text", "html", or "xhtml"
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function setContent($text, $type = 'text')
    {
        $this->setType($type);
        $this->getDomElement()->nodeValue = $text;
        $this->setCachedProperty('content', $this->parseContent());
    }

    /**
     * Return text type.
     *
     * @return string "text", "html", or "xhtml"
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function getType()
    {
        return $this->getCachedProperty(
            'type',
            function () {
                return $this->getAttribute('atom:type') ?: 'text';
            }
        );
    }

    /**
     * Return text type.
     *
     * @param string $type "text", "html", or "xhtml"
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function setType($type)
    {
        $this->setAttribute('atom:type', $type);
        $this->setCachedProperty('type', $type);

        return $this;
    }

    /**
     * Return string value.
     *
     * @return string
     */
    private function parseContent()
    {
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
}
