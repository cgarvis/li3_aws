# [Lithium PHP](http://lithify.me) Plugin to enable Amazon Web Services support

## Requirements
- [Lithium PHP](https://github.com/UnionOfRAD/lithium)
- [li3_filesystem](https://github.com/mariuskubilius/li3_filesystem)
- Amazon S3 account

## Installation

> Please be aware that this plugin provides an adapter to [li3_filesystem][fs] and therefore will not work without it.

1. Clone/Download/submodule the plugin into your app's ``libraries`` directory.
2. Initialize the AWS library by entering into `libraries/li3_aws` and running `git submodule update --init`.
3. Tell your app to load the plugin by adding `Libraries::add('li3_aws')` to your app's `config/bootstrap/libraries.php`

## Usage

Add the `s3` adapter to your [li3_filesystem][fs]

~~~ php
<?php
FileSystem::config(array(
    's3' => array( 
        'adapter' => 'S3',
        'key' => '...',
        'secret' => '...'
    )
));
?>
~~~

## More to come

This is a fork of [this original project](https://github.com/cgarvis/li3_aws) which is outdated and no longer seems to work with the current version of [lithium]

Composer installation coming soon

[fs]: https://github.com/mariuskubilius/li3_filesystem "li3_filesystem"

[li3]: https://github.com/UnionOfRAD/lithium "Lithium PHP"


