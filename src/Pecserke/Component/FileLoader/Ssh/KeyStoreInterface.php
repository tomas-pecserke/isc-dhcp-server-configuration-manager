<?php
/*
 * This file is part of the isc-dhcp-server-configuration-manager package.
 *
 * (c) Tomas Pecserke <tomas@pecserke.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pecserke\Component\FileLoader\Ssh;

use phpseclib\Crypt\RSA;

interface KeyStoreInterface {
    /**
     * @return string[]
     */
    public function getHosts();

    /**
     * @param string $host
     * @return bool
     */
    public function has($host);

    /**
     * @param string $host
     * @return RSA
     * @throws \OutOfRangeException
     */
    public function get($host);

    /**
     * @param string $host
     * @param RSA $rsa
     */
    public function set($host, RSA $rsa);

    /**
     * @param string $host
     */
    public function remove($host);

    public function clear();
}
