<?php

namespace WapplerSystems\ZabbixClient\Operation;

/**
 * This file is part of the "zabbix_client" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use WapplerSystems\ZabbixClient\Exception\InvalidArgumentException;
use WapplerSystems\ZabbixClient\OperationResult;


/**
 * A Operation which returns the current TYPO3 version
 */
class CheckTYPO3Configuration implements IOperation, SingletonInterface
{
    /**
     * @param array $parameter None
     * @return OperationResult the current PHP version
     */
    public function execute($parameter = [])
    {

        if (!isset($parameter['configurationPath']) || !isset($parameter['expectedValue'])) {
            throw new InvalidArgumentException('no configurationPath and/or expectedValue set');
        }

        $pathSegments = GeneralUtility::trimExplode('.', $parameter['configurationPath']);
        $configuration = $GLOBALS['TYPO3_CONF_VARS'];
        foreach ($pathSegments as $pathSegment) {
            $configuration = $configuration[$pathSegment];
        }

        return new OperationResult(true, $configuration == $parameter['expectedValue']);
    }
}
