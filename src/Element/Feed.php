<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element;

/**
 * Atom Feed.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.1.1
 */
class Feed extends Element
{
    use Meta\Author;
    use Meta\Id;
    use Meta\Title;
    use Meta\Updated;

    /**
     * Return the preferred URI for retrieving Atom Feed Documents representing this Atom feed.
     *
     * @return string
     *
     * @throws \Mekras\Atom\Exception\MalformedNodeException
     *
     * @since 1.0
     * @link  https://tools.ietf.org/html/rfc4287#section-4.1.1
     */
    public function getSelfLink()
    {
        return $this->getCachedProperty(
            'selfLink',
            function () {
                $element = $this->query('atom:link[@rel="self"]', self::SINGLE | self::REQUIRED);

                return trim($element->getAttribute('href'));
            }
        );
    }

    /**
     * Return feed entries.
     *
     * @return Entry[]
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function getEntries()
    {
        return $this->getCachedProperty(
            'entries',
            function () {
                $result = [];
                /** @var \DOMNodeList $items */
                $items = $this->query('atom:entry');
                foreach ($items as $item) {
                    $result[] = new Entry($item);
                }

                return $result;
            }
        );
    }

    /**
     * Return node name.
     *
     * @return string
     *
     * @since 1.0
     */
    protected function getNodeName()
    {
        return 'feed';
    }
}
