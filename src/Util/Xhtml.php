<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Util;

use Mekras\Atom\Atom;

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

    /**
     * Import HTML from $source to $target node.
     *
     * @param \DOMElement $source
     * @param \DOMElement $target
     *
     * @since 1.0
     */
    public static function import(\DOMElement $source, \DOMElement $target)
    {
        /* Prepare container */
        $container = $target->ownerDocument->createElement('xhtml:div');
        $container->setAttributeNS(Atom::XMLNS, 'xmlns:xhtml', Atom::XHTML);
        $target->appendChild($container);

        /* Prefix all source tags with "xhtml:" */
        $xmlFrom = $source->ownerDocument->saveXML($source);
        $xmlTo = '';
        $xhtmlNsSet = false;
        $parser = xml_parser_create('UTF-8');
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_set_element_handler(
            $parser,
            function ($parser, $name, array $attrs) use ($xmlFrom, &$xmlTo, &$xhtmlNsSet) {
                $selfClosing = '/>' === substr($xmlFrom, xml_get_current_byte_index($parser), 2);
                $xmlTo .= '<xhtml:' . $name;
                if (false === $xhtmlNsSet) {
                    $attrs['xmlns:xhtml'] = Atom::XHTML;
                    $xhtmlNsSet = true;
                }
                foreach ($attrs as $attr => $value) {
                    $xmlTo .= sprintf(
                        ' %s="%s"',
                        $attr,
                        htmlspecialchars($value, ENT_COMPAT | ENT_XML1)
                    );
                }
                $xmlTo .= $selfClosing ? '/>' : '>';
            },
            function ($parser, $name) use ($xmlFrom, &$xmlTo) {
                $selfClosing = '/>' ===
                    substr($xmlFrom, xml_get_current_byte_index($parser) - 2, 2);
                if ($selfClosing) {
                    return;
                }
                $xmlTo .= '</xhtml:' . $name . '>';
            }
        );
        xml_set_default_handler(
            $parser,
            function ($parser, $data) use (&$xmlTo) {
                $xmlTo .= $data;
            }
        );
        xml_parse($parser, $xmlFrom, true);
        xml_parser_free($parser);

        /* Import prefixed XML into container */
        $tmpDoc = new \DOMDocument('1.0', 'utf-8');
        $tmpDoc->loadXML($xmlTo);
        foreach ($tmpDoc->documentElement->childNodes as $node) {
            $container->appendChild($container->ownerDocument->importNode($node, true));
        }
    }
}
