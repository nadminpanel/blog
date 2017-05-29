# NAdminPanel\Blog

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

N Admin Panel's blog package, which includes:
- category
- author
- post
- advertisement
- page
- menu
- tag


## Install on Laravel 5.4

1) Run in your terminal:

``` bash
$ composer require nadminpanel/blog
```

2) Add the service providers in config/app.php:
``` php
NAdminPanel\Blog\BlogServiceProvider::class,
```

3) Then run a few commands in the terminal:
``` bash
$ php artisan vendor:publish
$ php artisan migrate
```

## Credits

- [Pyae Hein][link-author]
- [All Contributors][link-contributors]

## License

Admin Panel is free for non-commercial use.

[ico-version]: https://img.shields.io/packagist/v/nadminpanel/blog.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/nadminpanel/blog.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/nadminpanel/blog
[link-downloads]: https://packagist.org/packages/nadminpanel/blog
[link-author]: https://github.com/pyaehein
[link-contributors]: ../../contributors