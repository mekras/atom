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
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function getContent()
    {
        return $this->getCachedProperty(
            'content',
            function () {
                $element = $this->query('atom:content', Node::SINGLE);

                /** @var Element $this */
                return $element ? $this->getExtensions()->parseElement($this, $element) : null;
            }
        );
    }

    /**
     * Add content.
     *
     * @param string $value
     * @param string $type
     *
     * @return Content
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function addContent($value, $type = 'text')
    {
        /** @var Content $element */
        $element = $this->addChild('atom:content', 'content');
        $element->setContent($value, $type);

        return $element;
    }
}
