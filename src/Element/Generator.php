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
        return $this->getCachedProperty(
            'content',
            function () {
                return trim($this->getDomElement()->textContent);
            }
        );
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
        $this->setCachedProperty('content', $content);
    }

    /**
     * Return generating agent IRI.
     *
     * @return string|null
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function getUri()
    {
        return $this->getCachedProperty(
            'href',
            function () {
                return $this->getAttribute('atom:href');
            }
        );
    }

    /**
     * Set generating agent IRI.
     *
     * @param string $iri
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function setUri($iri)
    {
        $this->setAttribute('atom:href', $iri);
        $this->setCachedProperty('href', $iri);

        return $this;
    }

    /**
     * Return agent version.
     *
     * @return string|null
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function getVersion()
    {
        return $this->getCachedProperty(
            'version',
            function () {
                return $this->getAttribute('atom:version');
            }
        );
    }

    /**
     * Set agent version.
     *
     * @param string $version
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function setVersion($version)
    {
        $this->setAttribute('atom:version', $version);
        $this->setCachedProperty('version', $version);

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
