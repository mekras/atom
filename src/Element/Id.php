<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element;

/**
 * "atom:id" element
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.6
 */
class Id extends Element
{
    /**
     * Return IRI.
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
     * Return IRI.
     *
     * @return string
     *
     * @since 1.0
     */
    public function getContent()
    {
        return trim($this->getDomElement()->textContent);
    }

    /**
     * Set new IRI.
     *
     * @param string $content IRI.
     *
     * @since 1.0
     */
    public function setContent($content)
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
        return 'id';
    }
}
