<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Construct;

use Mekras\Atom\Exception\MalformedNodeException;
use Mekras\Atom\Node;

/**
 * Atom Person Construct.
 *
 * @since 1.0
 * @link  https://tools.ietf.org/html/rfc4287#section-3.2
 */
class Person extends Node
{
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
     * Return author name.
     *
     * @return string
     *
     * @throws \Mekras\Atom\Exception\MalformedNodeException
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
}
