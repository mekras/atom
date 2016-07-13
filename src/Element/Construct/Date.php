<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Construct;

use Mekras\Atom\NodeInterfaceTrait;

/**
 * Atom Date Construct.
 *
 * @since 1.0
 * @link  https://tools.ietf.org/html/rfc4287#section-3.3
 */
trait Date
{
    use NodeInterfaceTrait;

    /**
     * Represent date as a string.
     *
     * @return string
     *
     * @since 1.0
     */
    public function __toString()
    {
        return $this->getDomElement()->nodeValue;
    }

    /**
     * Return date.
     *
     * @return \DateTimeInterface
     *
     * @since 1.0
     */
    public function getDate()
    {
        return $this->getCachedProperty(
            'content',
            function () {
                return new \DateTime($this->getDomElement()->nodeValue);
            }
        );
    }

    /**
     * Set new date.
     *
     * @param \DateTimeInterface $date Date and time.
     *
     * @since 1.0
     */
    public function setDate(\DateTimeInterface $date)
    {
        $this->getDomElement()->nodeValue = $date->format(\DateTime::RFC3339);
        $this->setCachedProperty('content', $date);
    }
}
