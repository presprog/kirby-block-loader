<?php declare(strict_types=1);

use Kirby\Cms\App;

App::plugin('presprog/block-loader', [
    'hooks' => [
        'system.loadPlugins:after' => function () {
            $base  = kirby()->root('blocks') ?? kirby()->root('site') . DIRECTORY_SEPARATOR . 'blocks';
            $types = \Kirby\Filesystem\Dir::read($base);

            $classes    = [];
            $extensions = [
                'blockModels' => [],
                'blueprints' => [],
                'snippets' => [],
            ];

            foreach ($types as $type) {
                $typePath = $base . DIRECTORY_SEPARATOR . $type;
                $iterator = new DirectoryIterator($typePath);

                // Register blueprint, namespaced with `blocks`
                $extensions['blueprints']['blocks/' . $type] = $typePath . DIRECTORY_SEPARATOR . $type . '.yml';

                /** @var DirectoryIterator $file */
                foreach ($iterator as $file) {
                    if ($file->isDot() || $file->getExtension() !== 'php') {
                        continue;
                    }

                    if ($file->getBasename() === 'model.php') {
                        $class = Str::studly($type . 'Block');

                        // Register custom block model
                        $extensions['blockModels'][$type] = $class;
                        // Add path to class to load it later
                        $classes[$class]                  = $file->getPathname();
                    }

                    // Register all PHP files, namespaced with `blocks`
                    $extensions['snippets']['blocks/' . $file->getBasename('.php')] = $typePath . DIRECTORY_SEPARATOR . $file->getFilename();
                }
            }

            kirby()->extend($extensions, kirby()->plugin('presprog/block-loader'));
            load($classes);
        },
    ],
]);
