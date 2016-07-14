<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Element\Summary;
use Mekras\Atom\Node;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Element has a title.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.12
 */
trait HasSummary
{
    use NodeInterfaceTrait;

    /**
     * Return title.
     *
     * @return Summary|null
     *
     * @since 1.0
     */
    public function getSummary()
    {
        return $this->getCachedProperty(
            'summary',
            function () {
                // No REQUIRED — no exception.
                $element = $this->query('atom:summary', Node::SINGLE);

                /** @var Element $this */
                return $element ? $this->getExtensions()->parseElement($this, $element) : null;
            }
        );
    }

    /**
     * Add summary.
     *
     * @param string $value
     * @param string $type
     *
     * @return Summary
     *
     * @since 1.0
     */
    public function addSummary($value, $type = 'text')
    {
        /** @var Summary $element */
        $element = $this->addChild('atom:summary', 'summary');
        $element->setContent($value, $type);

        return $element;
    }
}
