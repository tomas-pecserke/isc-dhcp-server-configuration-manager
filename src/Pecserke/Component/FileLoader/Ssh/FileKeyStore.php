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

abstract class FileKeyStore implements KeyStoreInterface {
    /**
     * @var KeyStoreInterface
     */
    private $cache;

    /**
     * @var \SplFileInfo
     */
    private $file;

    /**
     * @var int
     */
    private $cacheTime = 0;

    public function __construct(\SplFileInfo $file) {
        $this->file = $file;
        $this->cache = new ArrayKeyStore();
    }

    public function getHosts() {
        $this->ensureFresh();

        return $this->cache->getHosts();
    }

    public function has($host) {
        $this->ensureFresh();

        return $this->cache->has($host);
    }

    public function get($host) {
        $this->ensureFresh();

        return $this->cache->get($host);
    }

    public function remove($host) {
        $this->ensureFresh();
        $this->cache->remove($host);
        $this->save($this->file, $this->cache);
    }

    public function clear() {
        $this->cache->clear();
        $this->save($this->file, $this->cache);
    }

    public function set($host, RSA $rsa) {
        $this->ensureFresh();
        $this->cache->set($host, $rsa);
        $this->save($this->file, $this->cache);
    }

    private function ensureFresh() {
        if (!$this->exists($this->file)) {
            $this->file->openFile('w')->fflush();
            $this->save($this->file, $this->cache);
            return;
        }
        if ($this->file->getMTime() <= $this->cacheTime) {
            return;
        }
        $this->cache->clear();
        $this->cacheTime = time();
        $this->load($this->file, $this->cache);
    }

    private function exists(\SplFileInfo $file) {
        return $file->isFile() || $file->isDir() || $file->isLink();
    }

    protected abstract function load(\SplFileInfo $file, KeyStoreInterface $cache);

    protected abstract function save(\SplFileInfo $file, KeyStoreInterface $cache);
}
