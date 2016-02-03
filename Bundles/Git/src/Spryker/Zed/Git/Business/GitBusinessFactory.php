<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Git\Business;

use Spryker\Zed\Git\Communication\Console\GitFlowFinishConsole;
use Spryker\Zed\Git\Communication\Console\GitFlowUpdateConsole;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Spryker\Zed\Git\GitConfig getConfig()
 */
class GitBusinessFactory extends AbstractBusinessFactory
{

    /**
     * @return \Symfony\Component\Console\Command\Command[]
     */
    public function getConsoleCommands()
    {
        return [
            $this->createGitFlowUpdateConsole(),
            $this->createGitFlowFinishConsole(),
        ];
    }

    /**
     * @return \Spryker\Zed\Git\Communication\Console\GitFlowUpdateConsole
     */
    protected function createGitFlowUpdateConsole()
    {
        return new GitFlowUpdateConsole();
    }

    /**
     * @return \Spryker\Zed\Git\Communication\Console\GitFlowUpdateConsole
     */
    protected function createGitFlowFinishConsole()
    {
        return new GitFlowFinishConsole();
    }

}
