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

use phpseclib\Crypt\RSA;

class SshKeyStore {
    /**
     * @var RSA[]
     */
    protected $keys = [];

    public function __construct() {
        $rsa = new RSA();
        $rsa->loadKey(file_get_contents('/home/nh/id_rsa'));
        $this->set('ns1.office.maind.sk', $rsa); // FIXME
    }

    /**
     * @param string $host
     * @return bool
     */
    public function has($host) {
        $host = strtolower($host);
        return isset($this->keys[$host]);
    }

    /**
     * @param string $host
     * @return RSA
     */
    public function get($host) {
        $host = strtolower($host);
        if (!isset($this->keys[$host])) {
            throw new \OutOfRangeException($host);
        }

        return $this->keys[$host];
    }

    /**
     * @param string $host
     * @param RSA $rsa
     */
    public function set($host, RSA $rsa) {
        $this->keys[$host] = $rsa;
    }
}
