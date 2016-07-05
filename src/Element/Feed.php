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
    use MEta\Categories;
    use Meta\Id;
    use Meta\SelfLink;
    use Meta\Title;
    use Meta\Updated;

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
     * Add new entry to feed.
     *
     * @return Entry
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function addEntry()
    {
        return new Entry($this);
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
