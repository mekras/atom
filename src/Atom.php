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
use Mekras\Atom\Extension\DocumentType;

/**
 * XML to Atom Document converter.
 *
 * @since 1.0
 *
 * @api
 * @link  https://tools.ietf.org/html/rfc4287
 */
class Atom
{
    /**
     * Additional document types.
     *
     * @var DocumentType[]
     */
    private $extensions = [];

    /**
     * Atom constructor.
     */
    public function __construct()
    {
        // NOP
    }

    /**
     * Create Atom document from XML document.
     *
     * @param \DOMDocument $document
     *
     * @return Document
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function createDocument(\DOMDocument $document)
    {
        switch ($document->documentElement->localName) {
            case 'feed':
                return new FeedDocument($document);
            case 'entry':
                return new EntryDocument($document);
        }

        foreach ($this->extensions as $extension) {
            $doc = $extension->createDocument($document);
            if ($doc) {
                return $doc;
            }
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
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML($xml);

        return $this->createDocument($doc);
    }

    /**
     * Register new document type extension
     *
     * @param DocumentType $extension
     *
     * @since 1.0
     */
    public function registerDocumentType(DocumentType $extension)
    {
        $this->extensions[] = $extension;
    }
}
