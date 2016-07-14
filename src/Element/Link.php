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
        } catch (\Exception $e) {
            return '(empty link)';
        }
    }

    /**
     * Return link IRI.
     *
     * @return string
     *
     * @throws \Mekras\Atom\Exception\MalformedNodeException If there is no required attribute.
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.1
     */
    public function getUri()
    {
        // No NS prefix — no exception.
        $value = $this->getAttribute('href');
        if (null === $value) {
            throw new MalformedNodeException('There is no required attribute "href"');
        }

        return $value;
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
        // No NS prefix — no exception.
        $this->setAttribute('href', $uri);

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
        // No NS prefix — no exception.
        return $this->getAttribute('rel') ?: 'alternate';
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
        // No NS prefix — no exception.
        $this->setAttribute('rel', $type);

        if ('self' === $type) {
            $this->setType('application/atom+xml');
        }

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
        // No NS prefix — no exception.
        return $this->getAttribute('type');
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
        // No NS prefix — no exception.
        $this->setAttribute('type', $type);

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
        // No NS prefix — no exception.
        return $this->getAttribute('hreflang');
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
        // No NS prefix — no exception.
        $this->setAttribute('hreflang', $language);

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
        // No NS prefix — no exception.
        return $this->getAttribute('title');
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
        // No NS prefix — no exception.
        $this->setAttribute('title', $title);

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
        // No NS prefix — no exception.
        return ((int) $this->getAttribute('length')) ?: null;
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
        // No NS prefix — no exception.
        $this->setAttribute('length', $length);

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
