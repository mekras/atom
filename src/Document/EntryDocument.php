<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Document;

use Mekras\Atom\Element\Entry;

/**
 * Atom Entry Document.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-2
 */
class EntryDocument extends Document
{
    /**
     * Return entry.
     *
     * @return Entry
     *
     * @since 1.0
     */
    public function getEntry()
    {
        return $this->getCachedProperty(
            'entry',
            function () {
                return $this->getExtensions()
                    ->parseElement($this, $this->getDomDocument()->documentElement);
            }
        );
    }

    /**
     * Return root node name.
     *
     * @return string
     *
     * @since 1.0
     */
    protected function getRootNodeName()
    {
        return 'entry';
    }
}
