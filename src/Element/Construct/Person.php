<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Construct;

use Mekras\Atom\Exception\MalformedNodeException;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Atom Person Construct.
 *
 * @since 1.0
 * @link  https://tools.ietf.org/html/rfc4287#section-3.2
 */
trait Person
{
    use NodeInterfaceTrait;

    /**
     * Represent person as a string.
     *
     * @return string
     *
     * @since 1.0
     */
    public function __toString()
    {
        try {
            return $this->getName();
        } catch (MalformedNodeException $e) {
            return '';
        }
    }

    /**
     * Return person name.
     *
     * @return string
     *
     * @throws \Mekras\Atom\Exception\MalformedNodeException If there is no required element.
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-3.2.1
     */
    public function getName()
    {
        return $this->getCachedProperty(
            'name',
            function () {
                return trim($this->query('atom:name', self::SINGLE | self::REQUIRED)->textContent);
            }
        );
    }

    /**
     * Set person name.
     *
     * @param string $value
     *
     * @return $this
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-3.2.1
     */
    public function setName($value)
    {
        $element = $this->query('atom:name', self::SINGLE);
        if (null === $element) {
            $element = $this->getDomElement()->ownerDocument->createElementNS($this->ns(), 'name');
            $this->getDomElement()->appendChild($element);
        }
        $element->nodeValue = $value;
        $this->setCachedProperty('name', $value);

        return $this;
    }

    /**
     * Return IRI associated with the person.
     *
     * @return string|null
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-3.2.2
     */
    public function getUri()
    {
        return $this->getCachedProperty(
            'uri',
            function () {
                return trim($this->query('atom:uri', self::SINGLE)->textContent);
            }
        );
    }

    /**
     * Set IRI associated with the person.
     *
     * @param string $value IRI.
     *
     * @return $this
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-3.2.2
     */
    public function setUri($value)
    {
        $element = $this->query('atom:uri', self::SINGLE);
        if (null === $element) {
            $element = $this->getDomElement()->ownerDocument->createElementNS($this->ns(), 'uri');
            $this->getDomElement()->appendChild($element);
        }
        $element->nodeValue = $value;
        $this->setCachedProperty('uri', $value);

        return $this;
    }

    /**
     * Return e-mail address associated with the person.
     *
     * @return string|null
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-3.2.3
     */
    public function getEmail()
    {
        return $this->getCachedProperty(
            'email',
            function () {
                return trim($this->query('atom:email', self::SINGLE)->textContent);
            }
        );
    }

    /**
     * Set e-mail address associated with the person.
     *
     * @param string $value E-mail address.
     *
     * @return $this
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-3.2.2
     */
    public function setEmail($value)
    {
        $element = $this->query('atom:email', self::SINGLE);
        if (null === $element) {
            $element = $this->getDomElement()->ownerDocument->createElementNS($this->ns(), 'email');
            $this->getDomElement()->appendChild($element);
        }
        $element->nodeValue = $value;
        $this->setCachedProperty('email', $value);

        return $this;
    }
}
