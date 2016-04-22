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

class ArrayKeyStore implements KeyStoreInterface {
    /**
     * @var RSA[]
     */
    protected $keys = [];

    public function getHosts() {
        return array_keys($this->keys);
    }

    public function has($host) {
        $host = strtolower($host);

        return isset($this->keys[$host]);
    }

    public function get($host) {
        $host = strtolower($host);
        if (!isset($this->keys[$host])) {
            throw new \OutOfRangeException($host);
        }

        return $this->keys[$host];
    }

    public function set($host, RSA $rsa) {
        $host = strtolower($host);
        $this->keys[$host] = $rsa;
    }

    public function remove($host) {
        $host = strtolower($host);
        unset($this->keys[$host]);
    }

    public function clear() {
        unset($this->keys);
        $this->keys = [];
    }
}
