<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Element\Subtitle;
use Mekras\Atom\Node;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Element has a title.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.12
 */
trait HasSubtitle
{
    use NodeInterfaceTrait;

    /**
     * Return title.
     *
     * @return Subtitle|null
     *
     * @since 1.0
     */
    public function getSubtitle()
    {
        return $this->getCachedProperty(
            'subtitle',
            function () {
                // No REQUIRED — no exception.
                $element = $this->query('atom:subtitle', Node::SINGLE);

                /** @var Element $this */
                return $element ? $this->getExtensions()->parseElement($this, $element) : null;
            }
        );
    }

    /**
     * Add subtitle.
     *
     * @param string $value
     * @param string $type
     *
     * @return Subtitle
     *
     * @since 1.0
     */
    public function addSubtitle($value, $type = 'text')
    {
        /** @var Subtitle $element */
        $element = $this->addChild('atom:subtitle', 'subtitle');
        $element->setContent($value, $type);

        return $element;
    }
}
