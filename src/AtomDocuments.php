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
use Mekras\Atom\Extension\DocumentExtension;

/**
 * Atom documents "extension".
 *
 * @since 1.0
 */
class AtomDocuments implements DocumentExtension
{
    /**
     * Create Atom document from XML DOM document.
     *
     * @param Extensions   $extensions Extension registry.
     * @param \DOMDocument $document   Source document.
     *
     * @return Document|null
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function parseDocument(Extensions $extensions, \DOMDocument $document)
    {
        if (Atom::NS !== $document->documentElement->namespaceURI) {
            return null;
        }

        switch ($document->documentElement->localName) {
            case 'entry':
                return new EntryDocument($extensions, $document);
                break;
            case 'feed':
                return new FeedDocument($extensions, $document);
                break;
        }

        return null;
    }

    /**
     * Create new Atom document.
     *
     * @param Extensions $extensions Extension registry.
     * @param string     $name       Element name.
     *
     * @return Document|null
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function createDocument(Extensions $extensions, $name)
    {
        switch ($name) {
            case 'entry':
                return new EntryDocument($extensions);
                break;
            case 'feed':
                return new FeedDocument($extensions);
                break;
        }

        return null;
    }
}
