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
    use Meta\HasAuthors;
    use Meta\HasCategories;
    use Meta\HasId;
    use Meta\HasSelfLink;
    use Meta\HasTitle;
    use Meta\HasUpdated;

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
                    $result[] = $this->getExtensions()->parseElement($this, $item);
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
        return $this->getExtensions()->createElement($this, 'atom:entry');
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
