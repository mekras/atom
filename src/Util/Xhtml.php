<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Util;

/**
 * XHTML tools.
 *
 * @since 1.0
 */
class Xhtml
{
    /**
     * Extract HTML from XHTML container.
     *
     * @param \DOMElement $element
     *
     * @return string
     *
     * @since 1.0
     */
    public static function extract(\DOMElement $element)
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $imported = $doc->importNode($element, true);
        $doc->appendChild($imported);

        $prefix = $doc->lookupPrefix('http://www.w3.org/1999/xhtml');
        if ('' !== $prefix) {
            $prefix .= ':';
        }
        $patterns = [
            '/<\?xml[^<]*>[^<]*<' . $prefix . 'div[^<]*/',
            '/<\/' . $prefix . 'div>\s*$/'
        ];
        $text = preg_replace($patterns, '', $doc->saveXML());
        if ('' !== $prefix) {
            $text = preg_replace('/(<[\/]?)' . $prefix . '([a-zA-Z]+)/', '$1$2', $text);
        }

        return $text;
    }
}
