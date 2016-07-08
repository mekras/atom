<?php
/**
 * Atom package example.
 *
 * @author    Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license   http://opensource.org/licenses/MIT MIT
 */
namespace Mekras\Atom\Example;

use Mekras\Atom\Document\EntryDocument;
use Mekras\Atom\Document\FeedDocument;
use Mekras\Atom\DocumentFactory;
use Mekras\Atom\Exception\AtomException;

require __DIR__ . '/../vendor/autoload.php';

if (PHP_SAPI !== 'cli') {
    die("This script should be executed from console!\n");
}

if (2 !== $argc) {
    die('Usage: php example.php <URL of Atom feed or entry>' . PHP_EOL);
}

$url = $argv[1];
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    die(sprintf('It seems that "%s" is not a valid URL', $url) . PHP_EOL);
}

@$xml = file_get_contents($url);
if (!$xml) {
    die(sprintf('Failed to read document from "%s"', $url) . PHP_EOL);
}

$factory = new DocumentFactory();

try {
    $document = $factory->parseXML($xml);
} catch (AtomException $e) {
    die($e->getMessage() . PHP_EOL);
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
} elseif ($document instanceof EntryDocument) {
    $entry = $document->getEntry();
    echo 'Entry: ', $entry->getTitle(), PHP_EOL;
    echo 'Updated: ', $entry->getUpdated()->format('d.m.Y H:i:s'), PHP_EOL;
    foreach ($entry->getAuthors() as $author) {
        echo 'Author: ', $author->getName(), PHP_EOL;
    }
    if ($entry->getContent()->getSrc()) {
        echo 'Content URL: ', $entry->getContent()->getSrc() , PHP_EOL;
    } else {
        echo PHP_EOL, (string) $entry->getContent(), PHP_EOL;
    }
}
