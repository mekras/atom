<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Element\Content;
use Mekras\Atom\Node;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Element has "atom:content" child element.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.1.3
 */
trait HasContent
{
    use NodeInterfaceTrait;

    /**
     * Return content.
     *
     * @return Content|null
     *
     * @since 1.0
     */
    public function getContent()
    {
        return $this->getCachedProperty(
            'content',
            function () {
                // No REQUIRED — no exception.
                $element = $this->query('atom:content', Node::SINGLE);

                /** @var Element $this */
                return $element ? $this->getExtensions()->parseElement($this, $element) : null;
            }
        );
    }

    /**
     * Add content.
     *
     * For "text" and "html" $type values $content should be a string.
     *
     * For "xhtml" and all XML-based $type values $content should be an instance of
     * @{link DOMElement}.
     *
     * In all other cases $content should be a binary string and it will be base64 encoded.
     *
     * When $type is "xhtml" child nodes of $content will be moved to "xhtml:div" container.
     *
     * @param string|\DOMElement $content
     * @param string             $type
     *
     * @return Content
     *
     * @throws \InvalidArgumentException If $content type does not match given $type.
     *
     * @since 1.0
     */
    public function addContent($content, $type = 'text')
    {
        /** @var Content $element */
        $element = $this->addChild('atom:content', 'content');
        $element->setContent($content, $type);

        return $element;
    }
}
