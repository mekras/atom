<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Document;

use Mekras\Atom\Node;

/**
 * Abstract Atom Document.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-2
 */
abstract class Document extends Node
{
    /**
     * DOM document.
     *
     * @var \DOMDocument
     */
    private $document;

    /**
     * Create document.
     *
     * @param \DOMDocument|null $document
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function __construct(\DOMDocument $document = null)
    {
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
        parent::__construct($document->documentElement);
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
     * Child classes should return root node name here.
     *
     * @return string
     *
     * @since 1.0
     */
    abstract protected function getRootNodeName();
}
