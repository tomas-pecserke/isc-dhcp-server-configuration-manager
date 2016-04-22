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

class ChainKeyStoreInterface implements KeyStoreInterface {
    /**
     * @var KeyStoreInterface[]
     */
    private $keyStores = [];

    public function getHosts() {
        $hosts = [];
        foreach ($this->keyStores as $keyStore) {
            $hosts = array_merge($hosts, $keyStore->getHosts());
        }

        return $hosts;
    }

    public function has($host) {
        foreach ($this->keyStores as $keyStore) {
            if ($keyStore->has($host)) {
                return true;
            }
        }

        return false;
    }

    public function get($host) {
        foreach ($this->keyStores as $keyStore) {
            if ($keyStore->has($host)) {
                return $keyStore->get($host);
            }
        }

        throw new \OutOfRangeException($host);
    }

    public function set($host, RSA $rsa) {
        throw new \BadMethodCallException('operation not supported');
    }

    public function remove($host) {
        throw new \BadMethodCallException('operation not supported');
    }

    public function clear() {
        throw new \BadMethodCallException('operation not supported');
    }

    public function registerKeyStore(KeyStoreInterface $keyStore) {
        if (!in_array($keyStore, $this->keyStores)) {
            $this->keyStores[] = $keyStore;
        }
    }
}
