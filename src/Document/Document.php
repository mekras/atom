<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Document;

use Mekras\Atom\Atom;
use Mekras\Atom\Extensions;
use Mekras\ClassHelpers\Traits\GettersCacheTrait;

/**
 * Abstract Atom Document.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-2
 */
abstract class Document
{
    use GettersCacheTrait;

    /**
     * Extensions.
     *
     * @var Extensions
     */
    private $extensions;

    /**
     * DOM document.
     *
     * @var \DOMDocument
     */
    private $document;

    /**
     * Create document.
     *
     * @param Extensions        $extensions Extension registry.
     * @param \DOMDocument|null $document   Source document.
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function __construct(Extensions $extensions, \DOMDocument $document = null)
    {
        $this->extensions = $extensions;

        if (null === $document) {
            $document = new \DOMDocument('1.0', 'utf-8');
            $element = $document->createElementNS($this->ns(), $this->getRootNodeName());
            $document->appendChild($element);
        } elseif ($this->getRootNodeName() !== $document->documentElement->localName) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Unexpected node "%s", expecting "%s"',
                    $document->documentElement->localName,
                    $this->getRootNodeName()
                )
            );
        }

        $this->document = $document;
    }

    /**
     * Return document XML.
     *
     * @return string
     *
     * @since 1.0
     */
    public function __toString()
    {
        return $this->getDomDocument()->saveXML();
    }

    /**
     * Return DOM Document.
     *
     * @return \DOMDocument
     *
     * @since 1.0
     */
    public function getDomDocument()
    {
        return $this->document;
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
        return Atom::NS;
    }

    /**
     * Child classes should return root node name here.
     *
     * @return string
     *
     * @since 1.0
     */
    abstract protected function getRootNodeName();

    /**
     * Return extensions.
     *
     * @return Extensions
     *
     * @since 1.0
     */
    protected function getExtensions()
    {
        return $this->extensions;
    }
}
