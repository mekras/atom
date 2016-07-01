<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Extension;

use Mekras\Atom\Document\Document;

/**
 * New document type extension.
 *
 * @since 1.0
 */
interface DocumentType
{
    /**
     * Create Atom document from XML document.
     *
     * @param \DOMDocument $document
     *
     * @return Document|null
     *
     * @since 1.0
     */
    public function createDocument(\DOMDocument $document);
}
