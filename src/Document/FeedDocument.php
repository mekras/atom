<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Document;

use Mekras\Atom\Element\Feed;

/**
 * Atom Feed Document.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-2
 */
class FeedDocument extends Document
{
    /**
     * Return feed.
     *
     * @return Feed
     *
     * @since 1.0
     */
    public function getFeed()
    {
        return $this->getCachedProperty(
            'feed',
            function () {
                return $this->getExtensions()
                    ->parseElement($this, $this->getDomDocument()->documentElement);
            }
        );
    }

    /**
     * Return root node name.
     *
     * @return string
     *
     * @since 1.0
     */
    protected function getRootNodeName()
    {
        return 'feed';
    }
}
