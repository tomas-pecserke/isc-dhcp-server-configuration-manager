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

abstract class Loader {
    /**
     * @param string $uri
     * @return bool
     * @throws UnsupportedUriException
     * @throws LoaderException
     */
    public abstract function supports($uri);

    /**
     * @param string $uri
     * @return string
     */
    public abstract function load($uri);

    /**
     * @param string $uri
     * @return string
     */
    protected function getScheme($uri) {
        $pos = strpos($uri, ':');
        if ($pos === false || $pos === 0) {
            throw new \InvalidArgumentException('uri');
        }

        return substr($uri, 0, $pos);
    }
}
