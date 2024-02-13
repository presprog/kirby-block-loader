# Block Loader

> ⚡ Your block *blueprints* and *snippets* **in one place** 

```php
// Have everything nicely grouped together. Let our plugin do the heavy lifting.
📂 site
    📂 blocks
        📂 call-to-action
            📄 call-to-action.yml   // Block blueprint
            📄 call-to-action.php   // Block snippet
```

You store blueprints and snippets for your custom blocks in different locations by default: Blueprints go to `site/blueprints/blocks` and snippets go to `site/snippets/blocks`. How about having all files that form a new block in one folder and let this plugin take care of loading and registering everything?

## How to use

Say you would like to add a custom `call to action` block. At least a blueprint and a snippet are required. Rather than placing them in separate folders, we use this plugin to have them nicely grouped together:

1. create a folder `site/blocks`. This is where all your custom blocks go. This can be configured with a custom root `blocks` in your `index.php`.
2. Create a folder `call-to-action` inside `site/blocks`. This is where your blueprint and snippet(s) go.
3. Add a file `call-to-action.yml` and set up your blueprint
4. Add a file `call-to-action.php` and render your block as you would like in any other snippet.

The plugin will scan the folder and register both the blueprint and snippet as `blocks/call-to-action`:

```php
// […]
    'blueprints' => [
        'blocks/call-to-action' => 'site/blocks/call-to-action/call-to-action.yml',
    ], 
    'snippets' => [
        'blocks/call-to-action' => 'site/blocks/call-to-action/call-to-action.php',
    ],
// […]
```

## Installation

**Composer**

```
composer require {{ your-name }}/block-loader
```

**Download**

Download and copy this repository to `/site/plugins/block-loader`.

**Git submodule**

```
git submodule add https://github.com/presprog/block-loader.git site/plugins/block-loader
```

## TODO

* [ ] Load block preview from block sub folder, too.

## License

MIT

## Alternatives

[microman/components](https://getkirby.com/plugins/microman/components) tries to solve this problem, too and introduces the new concept of components. This is a more versatile approach, as components can be anything. Our plugin only works for blocks. 

----

Made with ♥️ and ☕ by Present Progressive

<img src="/logo.svg?raw=true" width="200" height="43">
