<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Atom;
use Mekras\Atom\Construct\Person;
use Mekras\Atom\Node;

/**
 * Support for "atom:author".
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.1
 */
trait Author
{
    use Base;

    /**
     * Return authors.
     *
     * @return Person[]
     *
     * @throws \InvalidArgumentException
     * @throws \Mekras\Atom\Exception\MalformedNodeException
     *
     * @since 1.0
     */
    public function getAuthors()
    {
        return $this->getCachedProperty(
            'authors',
            function () {
                $result = [];
                $nodes = $this->query('atom:author', Node::REQUIRED);
                foreach ($nodes as $node) {
                    $result[] = $this->getExtensions()->parseElement($node);
                }

                return $result;
            }
        );
    }

    /**
     * Add new entry or feed author.
     *
     * @param string $name
     *
     * @return Person
     *
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function addAuthor($name)
    {
        $document = $this->getDomElement()->ownerDocument;
        $element = $document->createElementNS(Atom::NS, 'author');
        $this->getDomElement()->appendChild($element);
        /** @var Person $person */
        $person = $this->getExtensions()->parseElement($element);
        $person->setName($name);

        return $person;
    }
}
