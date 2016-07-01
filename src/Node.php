<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom;

use Mekras\ClassHelpers\Traits\GettersCacheTrait;

/**
 * Abstract Atom Node.
 *
 * @since 1.0
 */
abstract class Node
{
    use GettersCacheTrait;

    /**
     * Atom namespace.
     *
     * @since 1.0
     */
    const ATOM = 'http://www.w3.org/2005/Atom';

    /**
     * XHTML namespace.
     *
     * @since 1.0
     */
    const XHTML = 'http://www.w3.org/1999/xhtml';

    /**
     * XML namespaces.
     *
     * @since 1.0
     */
    const XMLNS = 'http://www.w3.org/2000/xmlns/';

    /**
     * DOM Element.
     *
     * @var \DOMElement
     */
    private $element;

    /**
     * XPath object
     *
     * @var \DOMXPath
     */
    private $xpath = null;

    /**
     * Create node.
     *
     * @param \DOMElement $element DOM element.
     *
     * @since 1.0
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($element)
    {
        if ($this->ns() !== $element->namespaceURI) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Unexpected NS "%s", expecting "%s"',
                    $element->namespaceURI,
                    $this->ns()
                )
            );
        }
        $this->element = $element;
    }

    /**
     * Return DOM Element.
     *
     * @return \DOMElement
     *
     * @since 1.0
     */
    public function getDomElement()
    {
        return $this->element;
    }

    /**
     * Return node main namespace.
     *
     * @return string
     *
     * @since 1.0
     */
    public function ns()
    {
        return self::ATOM;
    }

    /**
     * Get the XPath query object
     *
     * @return \DOMXPath
     *
     * @since 1.0
     */
    protected function getXPath()
    {
        if (!$this->xpath) {
            $this->xpath = new \DOMXPath($this->getDomElement()->ownerDocument);
            $this->xpath->registerNamespace('atom', self::ATOM);
            $this->xpath->registerNamespace('xhtml', self::XHTML);
        }

        return $this->xpath;
    }
}
