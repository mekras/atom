<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom;

use Mekras\Atom\Document\Document;
use Mekras\Atom\Document\EntryDocument;
use Mekras\Atom\Document\FeedDocument;

/**
 * Atom Document factory.
 *
 * @since 1.0
 *
 * @api
 */
class DocumentFactory
{
    /**
     * Extensions.
     *
     * @var Extensions
     */
    private $extensions;

    /**
     * Create new factory
     */
    public function __construct()
    {
        $this->extensions = new Extensions();
    }

    /**
     * Create Atom document from XML DOM document.
     *
     * @param \DOMDocument $document
     *
     * @return Document
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function parseDocument(\DOMDocument $document)
    {
        $doc = $this->extensions->parseDocument($document);
        if ($doc) {
            return $doc;
        }

        switch ($document->documentElement->localName) {
            case 'feed':
                return new FeedDocument($document);
            case 'entry':
                return new EntryDocument($document);
        }

        throw new \InvalidArgumentException(
            sprintf('Unexpected root element "%s"', $document->documentElement->localName)
        );
    }

    /**
     * Parse XML and return Atom Document.
     *
     * @param string $xml
     *
     * @return Document
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function parseXML($xml)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($xml);

        return $this->parseDocument($doc);
    }

    /**
     * Return extension registry.
     *
     * @return Extensions
     *
     * @since 1.0
     */
    public function getExtensions()
    {
        return $this->extensions;
    }
}
