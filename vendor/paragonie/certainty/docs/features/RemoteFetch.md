# RemoteFetch

This downloads the latest CA certificates from our Github repository and caches them locally.

## Basic Usage

Using the `RemoteFetch` class is rather straightforward.

```php
<?php
use ParagonIE\Certainty\RemoteFetch;

$fetcher = new RemoteFetch();
$latestCACertBundle = $fetcher->getLatestBundle();

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_CAINFO, $latestCACertBundle->getFilePath());
```

### Changing the Path or URL

By default, Certainty's `RemoteFetch` feature pulls from Github and uses the most recent CA-Cert
bundled with the source code to ensure Github is actually Github.

You can change the URL or local save directory either by passing string arguments to the constructor,
like so:

```php
<?php
use ParagonIE\Certainty\RemoteFetch;

// Custom local path and remote URL:
$fetcher = new RemoteFetch(
    '/var/www/common/certs',
    'https://raw.githubusercontent.com/your-organization/certainty-fork/master/data/'
);
```

### Changing the Time Between Remote Fetches

By default, RemoteFetch will check for new certificates at most once per day. To change this
timeout, you have two options: Pass a `DateInterval` to the constructor, or change it after the
object has been created.


```php
<?php
use ParagonIE\Certainty\RemoteFetch;

// Cleaner.
$fetcher = (new RemoteFetch())
    ->setCacheTimeout(new \DateInterval('PT06H'));

// Alternatively, the constructor approach:
$fetcher = new RemoteFetch(
    '',   // use the default save path
    RemoteFetch::DEFAULT_URL,
    null, // automatically selects/configures Guzzle
    new \DateInterval('PT06H') // 6 hours
);
```

## Symlinks

Being able to fetch the most recent CA-Cert bundle's file path at runtime is the preferred usage
for Certainty, but some will prefer to create a symlink at a predictable location so they can use
that path in their code.

Certainty supports this usage.

```php
<?php
use ParagonIE\Certainty\RemoteFetch;

$latest = (new RemoteFetch())->getLatestBundle();

$latest->createSymlink('/path/to/cacert.pem', true);
```

The second argument, `true`, tells Certainty to remove the existing symlink if it already exists.
