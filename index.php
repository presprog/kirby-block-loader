<?php declare(strict_types=1);

use Kirby\Cms\App;

App::plugin('presprog/block-loader', [
    'hooks' => [
        'system.loadPlugins:after' => function () {
            $base  = kirby()->root('blocks') ?? kirby()->root('site') . DIRECTORY_SEPARATOR . 'blocks';
            $types = \Kirby\Filesystem\Dir::read($base);

            $blueprints = [];
            $snippets   = [];

            foreach ($types as $type) {
                $typePath = $base . DIRECTORY_SEPARATOR . $type;
                $iterator = new DirectoryIterator($typePath);

                // Register blueprint, namespaced with `blocks`
                $blueprints['blocks/' . $type] = $typePath . DIRECTORY_SEPARATOR . $type . '.yml';

                /** @var DirectoryIterator $file */
                foreach ($iterator as $file) {
                    if ($file->isDot() || $file->getExtension() !== 'php') {
                        continue;
                    }

                    // Register all PHP files, namespaced with `blocks`
                    $snippets['blocks/' . $file->getBasename('.php')] = $typePath . DIRECTORY_SEPARATOR . $file->getFilename();
                }
            }

            kirby()->extend([
                'blueprints' => $blueprints,
                'snippets' => $snippets,
            ], kirby()->plugin('presprog/block-loader'));
        },
    ],
]);
