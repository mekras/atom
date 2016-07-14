<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element;

/**
 * "atom:generator" element
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.4
 */
class Generator extends Element
{
    /**
     * Return human readable name for the generating agent.
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
     * Return human readable name for the generating agent.
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
     * Set new human readable name for the generating agent.
     *
     * @param string $content Generating agent name.
     *
     * @since 1.0
     */
    public function setContent($content)
    {
        $this->getDomElement()->nodeValue = $content;
    }

    /**
     * Return generating agent IRI.
     *
     * @return string|null
     *
     * @since 1.0
     */
    public function getUri()
    {
        // No NS prefix — no exception.
        return $this->getAttribute('uri');
    }

    /**
     * Set generating agent IRI.
     *
     * @param string $iri
     *
     * @return $this
     *
     * @since 1.0
     */
    public function setUri($iri)
    {
        // No NS prefix — no exception.
        $this->setAttribute('uri', $iri);

        return $this;
    }

    /**
     * Return agent version.
     *
     * @return string|null
     *
     * @since 1.0
     */
    public function getVersion()
    {
        // No NS prefix — no exception.
        return $this->getAttribute('version');
    }

    /**
     * Set agent version.
     *
     * @param string $version
     *
     * @return $this
     *
     * @since 1.0
     */
    public function setVersion($version)
    {
        // No NS prefix — no exception.
        $this->setAttribute('version', $version);

        return $this;
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
        return 'generator';
    }
}
