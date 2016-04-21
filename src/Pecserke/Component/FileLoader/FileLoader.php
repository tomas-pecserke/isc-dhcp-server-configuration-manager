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

class FileLoader extends Loader {
    public function supports($uri) {
        return $this->getScheme($uri) === 'file';
    }

    public function load($uri) {
        if (!$this->supports($uri)) {
            throw new UnsupportedUriException($uri);
        }

        $path = substr($uri, 7);
        $content = file_get_contents($path);
        if ($content === false) {
            throw new LoaderException(sprintf("can't read file '%s'", $path));
        }

        return $content;
    }
}
