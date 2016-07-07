<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom;

/**
 * Node interface for traits.
 *
 * @since 1.0
 */
trait NodeInterfaceTrait
{
    /**
     * Return DOM Element.
     *
     * @return \DOMElement
     *
     * @since 1.0
     */
    abstract public function getDomElement();

    /**
     * Return extensions.
     *
     * @return Extensions
     *
     * @since 1.0
     */
    abstract public function getExtensions();

    /**
     * Return cached value for $name or call $factory to get new value
     *
     * @param string   $name    cache entry key
     * @param \Closure $factory value factory function
     *
     * @return mixed
     *
     * @since 1.0
     */
    abstract protected function getCachedProperty($name, \Closure $factory);

    /**
     * Change cached value
     *
     * Useful for setters.
     *
     * @param string $name  cache entry key
     * @param mixed  $value new value
     *
     * @since 1.0
     */
    abstract protected function setCachedProperty($name, $value);

    /**
     * Return child DOM element by name.
     *
     * @param string $xpath XPath expression.
     * @param int    $flags Flags, see class constants.
     *
     * @return \DOMNodeList|\DOMElement|null
     *
     * @throws \Mekras\Atom\Exception\MalformedNodeException
     *
     * @since 1.0
     */
    abstract protected function query($xpath, $flags = 0);
}
