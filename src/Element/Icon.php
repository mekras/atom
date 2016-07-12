<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element;

/**
 * "atom:icon" element
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.5
 */
class Icon extends Element
{
    /**
     * Return icon IRI.
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
     * Return icon IRI.
     *
     * @return string
     *
     * @since 1.0
     */
    public function getUri()
    {
        return $this->getCachedProperty(
            'content',
            function () {
                return trim($this->getDomElement()->textContent);
            }
        );
    }

    /**
     * Set new icon IRI.
     *
     * @param string $content IRI.
     *
     * @since 1.0
     */
    public function setUri($content)
    {
        $this->getDomElement()->nodeValue = $content;
        $this->setCachedProperty('content', $content);
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
        return 'icon';
    }
}