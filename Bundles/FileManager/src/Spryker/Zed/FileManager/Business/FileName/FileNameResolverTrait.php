<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\FileManager\Business\FileName;

use Generated\Shared\Transfer\FileInfoTransfer;
use Spryker\Shared\FileManager\FileManagerConstants;

trait FileNameResolverTrait
{
    /**
     * @param \Generated\Shared\Transfer\FileInfoTransfer $fileInfoTransfer
     * @param int|null $idFileDirectory
     *
     * @return string
     */
    protected function buildFilename(FileInfoTransfer $fileInfoTransfer, ?int $idFileDirectory = null)
    {
        $fileName = sprintf(
            '%u%s%s.%s',
            $fileInfoTransfer->getFkFile(),
            FileManagerConstants::FILE_NAME_VERSION_DELIMITER,
            $fileInfoTransfer->getVersionName(),
            $fileInfoTransfer->getExtension()
        );

        if ($fileInfoTransfer->getFkFile() && $idFileDirectory) {
            $fileName = $idFileDirectory . DIRECTORY_SEPARATOR . $fileName;
        }

        return $fileName;
    }
}
