# [Atom Syndication Format](https://tools.ietf.org/html/rfc4287) support library

[![Latest Stable Version](https://poser.pugx.org/mekras/atom/v/stable.png)](https://packagist.org/packages/mekras/atom)
[![License](https://poser.pugx.org/mekras/atom/license.png)](https://packagist.org/packages/mekras/atom)
[![Build Status](https://travis-ci.org/mekras/atom.svg?branch=master)](https://travis-ci.org/mekras/atom)
[![Coverage Status](https://coveralls.io/repos/mekras/atom/badge.svg?branch=master&service=github)](https://coveralls.io/github/mekras/atom?branch=master)

## Purpose

This library is designed to work with the [Atom](https://tools.ietf.org/html/rfc4287) documents in
an object-oriented style. It does not contain the functionality to download or display documents.

## Documentation

- [Parsing documents](docs/02-parsing_documents.md)
- [Creating documents](docs/03-creating_documents.md)
- [Extending (custom elements)](docs/06-extending.md)
- [Atom reader example](docs/example.php)

## Example

```php
use Mekras\Atom\Document\FeedDocument;
use Mekras\Atom\DocumentFactory;
use Mekras\Atom\Exception\AtomException;

$xml = file_get_contents('http://example.com/atom');

$factory = new DocumentFactory();

try {
    $document = $factory->parseXML($xml);
} catch (AtomException $e) {
    die($e->getMessage());
}

if ($document instanceof FeedDocument) {
    $feed = $document->getFeed();
    echo 'Feed: ', $feed->getTitle(), PHP_EOL;
    echo 'Updated: ', $feed->getUpdated()->format('d.m.Y H:i:s'), PHP_EOL;
    foreach ($feed->getAuthors() as $author) {
        echo 'Author: ', $author->getName(), PHP_EOL;
    }
    foreach ($feed->getEntries() as $entry) {
        echo PHP_EOL;
        echo '  Entry: ', $entry->getTitle(), PHP_EOL;
        if ($entry->getSelfLink()) {
            echo '  URL: ', $entry->getSelfLink(), PHP_EOL;
        } else {
            echo PHP_EOL, (string) $entry->getContent(), PHP_EOL;
        }
    }
}
```