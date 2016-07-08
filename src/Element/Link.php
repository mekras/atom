<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element;

use Mekras\Atom\Exception\MalformedNodeException;

/**
 * "atom:link" element
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7
 */
class Link extends Element
{
    /**
     * Return link IRI.
     *
     * @return string
     *
     * @since 1.1
     */
    public function __toString()
    {
        try {
            return $this->getUri();
        } catch (MalformedNodeException $e) {
            return '(empty link)';
        }
    }

    /**
     * Return link IRI.
     *
     * @return string
     *
     * @throws \Mekras\Atom\Exception\MalformedNodeException
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.1
     */
    public function getUri()
    {
        return $this->getCachedProperty(
            'href',
            function () {
                if (!$this->getDomElement()->hasAttribute('href')) {
                    throw new MalformedNodeException('There is no attribute "href"');
                }

                return $this->getDomElement()->getAttribute('href');
            }
        );
    }

    /**
     * Set link IRI.
     *
     * @param string $uri
     *
     * @return $this
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.1
     */
    public function setUri($uri)
    {
        $this->getDomElement()->setAttribute('href', $uri);
        $this->setCachedProperty('href', $uri);

        return $this;
    }

    /**
     * Return link relation type.
     *
     * @return string
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.2
     */
    public function getRelation()
    {
        return $this->getCachedProperty(
            'rel',
            function () {
                return $this->getDomElement()->getAttribute('rel') ?: 'alternate';
            }
        );
    }

    /**
     * Set link relation type.
     *
     * @param string $type
     *
     * @return $this
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.2
     */
    public function setRelation($type)
    {
        $this->getDomElement()->setAttribute('rel', $type);
        $this->setCachedProperty('rel', $type);

        return $this;
    }

    /**
     * Return target media type.
     *
     * @return string|null
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.3
     */
    public function getType()
    {
        return $this->getCachedProperty(
            'type',
            function () {
                return $this->getDomElement()->getAttribute('type') ?: null;
            }
        );
    }

    /**
     * Set target media type.
     *
     * @param string $type
     *
     * @return $this
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.3
     */
    public function setType($type)
    {
        $this->getDomElement()->setAttribute('type', $type);
        $this->setCachedProperty('type', $type);

        return $this;
    }

    /**
     * Return resource language.
     *
     * @return string|null
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.4
     */
    public function getLanguage()
    {
        return $this->getCachedProperty(
            'hreflang',
            function () {
                return $this->getDomElement()->getAttribute('hreflang') ?: null;
            }
        );
    }

    /**
     * Set resource language.
     *
     * @param string $language
     *
     * @return $this
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.4
     */
    public function setLanguage($language)
    {
        $this->getDomElement()->setAttribute('hreflang', $language);
        $this->setCachedProperty('hreflang', $language);

        return $this;
    }

    /**
     * Return human-readable information about the link.
     *
     * @return string|null
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.5
     */
    public function getTitle()
    {
        return $this->getCachedProperty(
            'title',
            function () {
                return $this->getDomElement()->getAttribute('title') ?: null;
            }
        );
    }

    /**
     * Set human-readable information about the link.
     *
     * @param string $title
     *
     * @return $this
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.5
     */
    public function setTitle($title)
    {
        $this->getDomElement()->setAttribute('title', $title);
        $this->setCachedProperty('title', $title);

        return $this;
    }

    /**
     * Return length of the linked content in octets.
     *
     * @return int|null
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.6
     */
    public function getLength()
    {
        return $this->getCachedProperty(
            'length',
            function () {
                return ((int) $this->getDomElement()->getAttribute('length')) ?: null;
            }
        );
    }

    /**
     * Set length of the linked content in octets.
     *
     * @param int $length
     *
     * @return $this
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.6
     */
    public function setLength($length)
    {
        $this->getDomElement()->setAttribute('length', $length);
        $this->setCachedProperty('length', $length);

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
        return 'link';
    }
}
