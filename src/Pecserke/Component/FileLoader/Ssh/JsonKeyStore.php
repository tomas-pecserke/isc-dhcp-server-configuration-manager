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

class JsonKeyStore extends FileKeyStore {
    /**
     * @param \SplFileInfo|string $file
     */
    public function __construct($file) {
        if (!($file instanceof \SplFileInfo)) {
            $file = new \SplFileInfo($file);
        }
        parent::__construct($file);
    }

    protected function load(\SplFileInfo $file, KeyStoreInterface $cache) {
        $handle = $file->openFile();
        $content = $handle->fread($handle->getSize());
        $json = json_decode($content);

        foreach ($json as $host => $key) {
            if (!is_string($host)) {
                throw new \UnexpectedValueException('host is not string');
            }
            $rsa = new RSA();
            if (!$rsa->loadKey($key)) {
                throw new \UnexpectedValueException('not valid private key');
            }
            $cache->set($host, $rsa);
        }
    }

    protected function save(\SplFileInfo $file, KeyStoreInterface $cache) {
        $hosts = $cache->getHosts();

        $json = [];
        foreach ($hosts as $host) {
            $json[$host] = $cache->get($host)->getPrivateKey();
        }

        $handle = $file->openFile('w');
        $handle->fwrite(json_encode($json));
        $handle->fflush();
    }
}
