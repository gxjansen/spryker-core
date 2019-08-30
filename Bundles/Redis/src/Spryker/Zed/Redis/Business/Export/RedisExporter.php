<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Redis\Business\Export;

use Spryker\Zed\Redis\Business\Exception\RedisExportException;
use Spryker\Zed\Redis\RedisConfig;
use Symfony\Component\Process\Process;

class RedisExporter implements RedisExporterInterface
{
    /**
     * @var \Spryker\Zed\Redis\RedisConfig
     */
    protected $config;

    /**
     * @param \Spryker\Zed\Redis\RedisConfig $config
     */
    public function __construct(RedisConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $destination
     * @param int|null $redisPort
     *
     * @throws \Spryker\Zed\Redis\Business\Exception\RedisExportException
     *
     * @return bool
     */
    public function export(string $destination, ?int $redisPort = null): bool
    {
        if ($redisPort === null) {
            throw new RedisExportException('No port specified for Redis export.');
        }

        $command = $this->buildExportCliCommand($destination, $redisPort);
        $process = new Process(explode(' ', $command), APPLICATION_ROOT_DIR);
        $process->setTimeout($this->config->getProcessTimeout());
        $process->run();

        return $process->isSuccessful();
    }

    /**
     * @param string $destination
     * @param int|null $redisPort
     *
     * @return string
     */
    protected function buildExportCliCommand(string $destination, ?int $redisPort = null): string
    {
        return sprintf('redis-cli -p %s --rdb %s', $redisPort, $destination);
    }
}
