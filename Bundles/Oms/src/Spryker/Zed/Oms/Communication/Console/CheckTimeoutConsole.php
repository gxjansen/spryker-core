<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Oms\Communication\Console;

use Spryker\Zed\Console\Business\Model\Console;
use Spryker\Zed\Oms\Business\OmsFacade;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method OmsFacade getFacade()
 */
class CheckTimeoutConsole extends Console
{

    const COMMAND_NAME = 'oms:check-timeout';
    const COMMAND_DESCRIPTION = 'Check timeouts';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription(self::COMMAND_DESCRIPTION);

        parent::configure();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getFacade()->checkTimeouts();
    }

}
