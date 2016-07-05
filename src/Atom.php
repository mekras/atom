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
     * Atom namespace.
     *
     * @since 1.0
     */
    const NS = 'http://www.w3.org/2005/Atom';

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
        foreach ($this->extensions as $extension) {
            $doc = $extension->createDocument($document);
            if ($doc) {
                return $doc;
            }
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
     * Register new document type extension
     *
     * New extensions are placed in top of the list.
     *
     * @param DocumentType $extension
     *
     * @since 1.0
     */
    public function registerDocumentType(DocumentType $extension)
    {
        array_unshift($this->extensions, $extension);
    }
}
