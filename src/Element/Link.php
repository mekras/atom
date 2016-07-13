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
     * @throws \InvalidArgumentException
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
                $value = $this->getAttribute('href');
                if (null === $value) {
                    throw new MalformedNodeException('There is no attribute "href"');
                }

                return $value;
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
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.1
     */
    public function setUri($uri)
    {
        $this->setAttribute('href', $uri);
        $this->setCachedProperty('href', $uri);

        return $this;
    }

    /**
     * Return link relation type.
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.2
     */
    public function getRelation()
    {
        return $this->getCachedProperty(
            'rel',
            function () {
                return $this->getAttribute('rel') ?: 'alternate';
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
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.2
     */
    public function setRelation($type)
    {
        $this->setAttribute('rel', $type);
        $this->setCachedProperty('rel', $type);

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
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.3
     */
    public function getType()
    {
        return $this->getCachedProperty(
            'type',
            function () {
                return $this->getAttribute('type');
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
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.3
     */
    public function setType($type)
    {
        $this->setAttribute('type', $type);
        $this->setCachedProperty('type', $type);

        return $this;
    }

    /**
     * Return resource language.
     *
     * @return string|null
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.4
     */
    public function getLanguage()
    {
        return $this->getCachedProperty(
            'hreflang',
            function () {
                return $this->getAttribute('hreflang');
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
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.4
     */
    public function setLanguage($language)
    {
        $this->setAttribute('hreflang', $language);
        $this->setCachedProperty('hreflang', $language);

        return $this;
    }

    /**
     * Return human-readable information about the link.
     *
     * @return string|null
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.5
     */
    public function getTitle()
    {
        return $this->getCachedProperty(
            'title',
            function () {
                return $this->getAttribute('title');
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
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.5
     */
    public function setTitle($title)
    {
        $this->setAttribute('title', $title);
        $this->setCachedProperty('title', $title);

        return $this;
    }

    /**
     * Return length of the linked content in octets.
     *
     * @return int|null
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.6
     */
    public function getLength()
    {
        return $this->getCachedProperty(
            'length',
            function () {
                return ((int) $this->getAttribute('length')) ?: null;
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
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7.6
     */
    public function setLength($length)
    {
        $this->setAttribute('length', $length);
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
