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
 * Extension interface.
 *
 * @since 1.0
 */
interface Extension
{
    /**
     * Create Atom document from XML DOM document.
     *
     * @param \DOMDocument $document
     *
     * @return Document|null
     *
     * @since 1.0
     */
    public function parseDocument(\DOMDocument $document);
}
