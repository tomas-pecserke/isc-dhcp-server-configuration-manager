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

use Pecserke\Component\FileLoader\Ssh\KeyStoreInterface;
use phpseclib\Net\SCP;
use phpseclib\Net\SSH2;

class ScpLoader extends Loader {
    /**
     * @var KeyStoreInterface
     */
    private $keyStore;

    public function __construct(KeyStoreInterface $keyStore) {
        $this->keyStore = $keyStore;
    }

    public function supports($uri) {
        return $this->getScheme($uri) === 'scp';
    }

    public function load($uri) {
        $matches = [];
        if (preg_match('/^scp:\\/\\/([^@]+)@([^:\\/]+)(:(\\d+))?(\\/.*)$/', $uri, $matches) === false) {
            throw new UnsupportedUriException($uri);
        }
        $user = $matches[1];
        $host = $matches[2];
        $port = (int) $matches[4] ?: 22;
        $path = $matches[5];
        unset($matches);

        $ssh = new SSH2($host, $port);
        if (!$this->keyStore->has($host)) {
            throw new LoaderException(sprintf("no SSH key for host '%s'", $host));
        }
        if (!$ssh->login($user, $this->keyStore->get($host))) {
            throw new LoaderException('SSH authentication failed');
        }
        $scp = new SCP($ssh);
        $content = $scp->get($path);
        if ($content === false) {
            throw new LoaderException(sprintf("can't read file '%s'", $path));
        }

        return $content;
    }
}
