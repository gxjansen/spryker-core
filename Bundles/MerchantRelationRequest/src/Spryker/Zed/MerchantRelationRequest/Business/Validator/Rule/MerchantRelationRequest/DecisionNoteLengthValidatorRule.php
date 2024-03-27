<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationRequest\Business\Validator\Rule\MerchantRelationRequest;

use ArrayObject;
use Generated\Shared\Transfer\ErrorCollectionTransfer;
use Generated\Shared\Transfer\MerchantRelationRequestTransfer;
use Spryker\Shared\MerchantRelationRequest\MerchantRelationRequestConfig as SharedMerchantRelationRequestConfig;
use Spryker\Zed\MerchantRelationRequest\Business\Validator\Util\ErrorAdderInterface;

class DecisionNoteLengthValidatorRule implements MerchantRelationValidatorRuleInterface
{
    /**
     * @var int
     */
    protected const DECISION_NOTE_MIN_LENGTH = 1;

    /**
     * @var int
     */
    protected const DECISION_NOTE_MAX_LENGTH = 5000;

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_PARAMETER_MIN = '%min%';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_PARAMETER_MAX = '%max%';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_DECISION_NOTE_WRONG_LENGTH = 'merchant_relation_request.validation.decision_note_wrong_length';

    /**
     * @var \Spryker\Zed\MerchantRelationRequest\Business\Validator\Util\ErrorAdderInterface
     */
    protected ErrorAdderInterface $errorAdder;

    /**
     * @param \Spryker\Zed\MerchantRelationRequest\Business\Validator\Util\ErrorAdderInterface $errorAdder
     */
    public function __construct(ErrorAdderInterface $errorAdder)
    {
        $this->errorAdder = $errorAdder;
    }

    /**
     * @param \ArrayObject<array-key, \Generated\Shared\Transfer\MerchantRelationRequestTransfer> $merchantRelationRequestTransfers
     *
     * @return \Generated\Shared\Transfer\ErrorCollectionTransfer
     */
    public function validate(ArrayObject $merchantRelationRequestTransfers): ErrorCollectionTransfer
    {
        $errorCollectionTransfer = new ErrorCollectionTransfer();
        foreach ($merchantRelationRequestTransfers as $entityIdentifier => $merchantRelationRequestTransfer) {
            if (!$this->isApplicable($merchantRelationRequestTransfer)) {
                continue;
            }

            if (!$this->isDecisionNoteLengthValid($merchantRelationRequestTransfer->getDecisionNoteOrFail())) {
                $this->errorAdder->addError(
                    $errorCollectionTransfer,
                    $entityIdentifier,
                    static::GLOSSARY_KEY_DECISION_NOTE_WRONG_LENGTH,
                    [
                        static::GLOSSARY_KEY_PARAMETER_MIN => static::DECISION_NOTE_MIN_LENGTH,
                        static::GLOSSARY_KEY_PARAMETER_MAX => static::DECISION_NOTE_MAX_LENGTH,
                    ],
                );
            }
        }

        return $errorCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantRelationRequestTransfer $merchantRelationRequestTransfer
     *
     * @return bool
     */
    protected function isApplicable(MerchantRelationRequestTransfer $merchantRelationRequestTransfer): bool
    {
        return $merchantRelationRequestTransfer->getDecisionNote() && in_array(
            $merchantRelationRequestTransfer->getStatusOrFail(),
            [
                SharedMerchantRelationRequestConfig::STATUS_REJECTED,
                SharedMerchantRelationRequestConfig::STATUS_APPROVED,
            ],
            true,
        );
    }

    /**
     * @param string $decisionNote
     *
     * @return bool
     */
    protected function isDecisionNoteLengthValid(string $decisionNote): bool
    {
        return mb_strlen($decisionNote) >= static::DECISION_NOTE_MIN_LENGTH
            && mb_strlen($decisionNote) <= static::DECISION_NOTE_MAX_LENGTH;
    }
}
