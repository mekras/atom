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
 * Support for "app:author".
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
                    $result[] = new Person($node);
                }

                return $result;
            }
        );
    }

    /**
     * Add new entry or feed author.
     *
     * @param string      $name
     * @param string|null $email
     * @param string|null $uri
     *
     * @since 1.0
     */
    public function addAuthor($name, $email = null, $uri = null)
    {
        $document = $this->getDomElement()->ownerDocument;
        $author = $document->createElementNS(Atom::NS, 'author');
        $this->getDomElement()->appendChild($author);

        $element = $document->createElementNS(Atom::NS, 'name', $name);
        $author->appendChild($element);

        if ($email) {
            $element = $document->createElementNS(Atom::NS, 'email', $email);
            $author->appendChild($element);
        }

        if ($uri) {
            $element = $document->createElementNS(Atom::NS, 'uri', $uri);
            $author->appendChild($element);
        }
    }
}
