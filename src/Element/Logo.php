<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element;

/**
 * "atom:logo" element
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.8
 */
class Logo extends Element
{
    /**
     * Return logo IRI.
     *
     * @return string
     *
     * @since 1.0
     */
    public function __toString()
    {
        return $this->getUri();
    }

    /**
     * Return logo IRI.
     *
     * @return string
     *
     * @since 1.0
     */
    public function getUri()
    {
        return trim($this->getDomElement()->textContent);
    }

    /**
     * Set new logo IRI.
     *
     * @param string $content IRI.
     *
     * @since 1.0
     */
    public function setUri($content)
    {
        $this->getDomElement()->nodeValue = $content;
    }

    /**
     * Return node name.
     *
     * @return string
     *
     * @since 1.0
     */
    protected function getNodeName()
    {
        return 'logo';
    }
}
