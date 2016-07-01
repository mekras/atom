<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element;

use Mekras\Atom\Exception\MalformedNodeException;
use Mekras\Atom\Node;
use Mekras\Atom\Util\Xhtml;

/**
 * Atom Content.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.1.3
 */
class Content extends Element
{
    /**
     * Represent text as a string.
     *
     * @return string
     *
     * @since 1.0
     */
    public function __toString()
    {
        /** @var string $string */
        $string = $this->getCachedProperty(
            'value',
            function () {
                $type = $this->getType();
                if ('text' === $type || 'html' === $type) {
                    return $this->getDomElement()->textContent;
                } elseif ('xhtml' === $type) {
                    /** @var \DOMElement $xhtml */
                    try {
                        $xhtml = $this->query('xhtml:div', Node::SINGLE | Node::REQUIRED);
                    } catch (MalformedNodeException $e) {
                        return '';
                    }

                    return Xhtml::extract($xhtml);
                } elseif (preg_match('~^([\w-]+)/((xml.*)|(.+\+xml))$~', $type)) {
                    /** @var \DOMElement $xml */
                    try {
                        $xml = $this->query('*', Node::SINGLE | Node::REQUIRED);
                    } catch (MalformedNodeException $e) {
                        return '';
                    }

                    return $this->getDomElement()->ownerDocument->saveXML($xml);
                } elseif (stripos($type, 'text/') === 0) {
                    return $this->getDomElement()->textContent;
                }

                return base64_decode($this->getDomElement()->textContent);
            }
        );

        return $string;
    }

    /**
     * Return content type.
     *
     * @return string "text", "html", "xhtml" or MIME type.
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.1.3.1
     */
    public function getType()
    {
        return $this->getCachedProperty(
            'type',
            function () {
                return $this->getDomElement()->getAttribute('type') ?: 'text';
            }
        );
    }

    /**
     * Return content IRI.
     *
     * @return string|null
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.1.3.2
     */
    public function getSrc()
    {
        return $this->getCachedProperty(
            'src',
            function () {
                return $this->getDomElement()->getAttribute('src') ?: null;
            }
        );
    }

    /*
     atomInlineTextContent =
      element atom:content {
         atomCommonAttributes,
         attribute type { "text" | "html" }?,
         (text)*
      }

   atomInlineXHTMLContent =
      element atom:content {
         atomCommonAttributes,
         attribute type { "xhtml" },
         xhtmlDiv
      }

   atomInlineOtherContent =
      element atom:content {
         atomCommonAttributes,
         attribute type { atomMediaType }?,
         (text|anyElement)*
      }

   atomOutOfLineContent =
      element atom:content {
         atomCommonAttributes,
         attribute type { atomMediaType }?,
         attribute src { atomUri },
         empty
      }

   atomContent = atomInlineTextContent
    | atomInlineXHTMLContent
    | atomInlineOtherContent
    | atomOutOfLineContent
     */

    /**
     * Return node name here.
     *
     * @return string
     *
     * @since 1.0
     */
    protected function getNodeName()
    {
        return 'content';
    }
}
