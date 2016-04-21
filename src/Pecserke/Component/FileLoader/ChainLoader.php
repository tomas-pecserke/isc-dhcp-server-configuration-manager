<?php
/*
 * This file is part of the isc-dhcp-server-configuration-manager package.
 *
 * (c) Tomas Pecserke <tomas@pecserke.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pecserke\Component\FileLoader;

class ChainLoader extends Loader {
    /**
     * @var Loader[]
     */
    private $loaders = [];

    public function supports($uri) {
        foreach ($this->loaders as $loader) {
            if ($loader->supports($uri)) {
                return true;
            }
        }

        return false;
    }

    public function load($uri) {
        foreach ($this->loaders as $loader) {
            if ($loader->supports($uri)) {
                return $loader->load($uri);
            }
        }

        throw new UnsupportedUriException($uri);
    }

    public function registerLoader(Loader $loader) {
        if (!in_array($loader, $this->loaders)) {
            $this->loaders[] = $loader;
        }
    }
}
