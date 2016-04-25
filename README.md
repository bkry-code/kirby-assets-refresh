# Kirby Assets Refresh

**Version 0.2**

*Require Kirby 2.2 - Does not fully work with 2.3 because of a Kirby bug*

The plugin is based on [this solution](https://forum.getkirby.com/t/refresh-js-and-css-only-when-logged-in/1448).

## In short

- It prevents the browser from caching css and js, when an asset is updated.
- You don't need to change your htaccess file.
- Supports the exact same arguments as `js()` and `css()` does.
- It's super simple. Just add `r`, like `jsr()` and `cssr()`.

## Install

Add `assets-refresh` into `/site/plugins/` folder.

## Usage

### Css

The only thing you need to do is to change `css` to `cssr`. Everything else is the same as before.

Read more about it on [getkirby.com/docs/cheatsheet/helpers/css](https://getkirby.com/docs/cheatsheet/helpers/css)

**Single file example:**

```php
echo cssr('assets/css/site.css');
```

### Js

The only thing you need to do is to change `js` to `jsr`. Everything else is the same as before.

Read more about it on [getkirby.com/docs/cheatsheet/helpers/js](https://getkirby.com/docs/cheatsheet/helpers/js)

**Single file example:**

```php
echo jsr('assets/js/site.js');
```