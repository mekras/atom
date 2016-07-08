# Parsing documents

[DocumentFactory](src/DocumentFactory.php) class is responsible for parsing documents. There are two
methods:

- `parseDocument` — takes an instance of the [DOMDocument](http://php.net/domdocument) as argument
and return one of the [Document](src/Document/Document.php) subclasses;
- `parseXML` — takes string with XML as argument then uses `parseDocument`.

```php
use Mekras\Atom\DocumentFactory;
use Mekras\Atom\Document\EntryDocument;
use Mekras\Atom\Document\FeedDocument;
use Mekras\Atom\Exception\AtomException;

$factory = new DocumentFactory;

$xml = file_get_contents('http://example.com/atom');
try {
    $document = $factory->parseXML($xml);
} catch (AtomException $e) {
    die($e->getMessage());
}

if ($document instanceof FeedDocument) {
    $feed = $document->getFeed();
    //...
} elseif ($document instanceof EntryDocument) {
    $entry = $document->getEntry();
    //...
}

```
