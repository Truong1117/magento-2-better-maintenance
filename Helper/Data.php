<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category  Mageplaza
 * @package   Mageplaza_BetterMaintenance
 * @copyright Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license   https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\BetterMaintenance\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mageplaza\Core\Helper\AbstractData;

class Data extends AbstractData
{
    const CONFIG_MODULE_PATH = 'mpbettermaintenance';
    const MAINTENANCE_ROUTE  = 'mpmaintenance';
    const COMINGSOON_ROUTE   = 'mpcomingsoon';

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param ObjectManagerInterface $objectManager
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context, $objectManager, $storeManager);
    }

    public function getConfigGeneral($code = '', $storeId = null)
    {
        $code = ($code !== '') ? '/' . $code : '';

        return $this->getConfigValue(static::CONFIG_MODULE_PATH . '/general' . $code, $storeId);
    }

    public function getFooterSetting($code, $storeId = null)
    {
        return $this->getModuleConfig('display_setting/footer_block/' . $code, $storeId);
    }

    public function getClockSetting($code, $storeId = null)
    {
        return $this->getModuleConfig('display_setting/clock_setting/' . $code, $storeId);
    }

    public function getSubscribeSetting($code, $storeId = null)
    {
        return $this->getModuleConfig('display_setting/subscribe_setting/' . $code, $storeId);
    }

    public function getSocialSetting($code, $storeId = null)
    {
        return $this->getModuleConfig('display_setting/social_contact/' . $code, $storeId);
    }

    public function getMaintenanceSetting($code, $storeId = null)
    {
        return $this->getModuleConfig('maintenance_setting/' . $code, $storeId);
    }

    public function getComingSoonSetting($code, $storeId = null)
    {
        return $this->getModuleConfig('comingsoon_setting/' . $code, $storeId);
    }

    public function getMaintenanceRoute()
    {
        $maintenanceRoute = $this->getMaintenanceSetting('maintenance_route');

        return isset($maintenanceRoute) ? $maintenanceRoute : self::MAINTENANCE_ROUTE;
    }

    public function getComingSoonRoute()
    {
        $comingSoonRoute = $this->getComingSoonSetting('comingsoon_route');

        return isset($comingSoonRoute) ? $comingSoonRoute : self::COMINGSOON_ROUTE;
    }
    /**
     * Check Ip
     *
     * @param $ip
     * @param $range
     * @return bool
     */
    public function checkIp($ip, $range)
    {
        if (strpos($range, '*') !== false) {
            $low = $high = $range;
            if (strpos($range, '-') !== false) {
                list($low, $high) = explode('-', $range, 2);
            }
            $low   = str_replace('*', '0', $low);
            $high  = str_replace('*', '255', $high);
            $range = $low . '-' . $high;
        }
        if (strpos($range, '-') !== false) {
            list($low, $high) = explode('-', $range, 2);

            return $this->ipCompare($ip, $low, 1) && $this->ipcompare($ip, $high, -1);
        }

        return $this->ipCompare($ip, $range);
    }

    /**
     * @param $ip1
     * @param $ip2
     * @param int $op
     * @return bool
     */
    private function ipCompare($ip1, $ip2, $op = 0)
    {
        $ip1Arr = explode('.', $ip1);
        $ip2Arr = explode('.', $ip2);

        for ($i = 0; $i < 4; $i++) {
            if ($ip1Arr[$i] < $ip2Arr[$i]) {
                return ($op == -1);
            }
            if ($ip1Arr[$i] > $ip2Arr[$i]) {
                return ($op == 1);
            }
        }

        return ($op == 0);
    }
}
