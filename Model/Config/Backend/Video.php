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
 * @category    Mageplaza
 * @package     Mageplaza_BetterMaintenance
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

/**
 * System config image field backend model
 */
namespace Mageplaza\BetterMaintenance\Model\Config\Backend;

use Magento\Config\Model\Config\Backend\File;

/**
 * Class Video
 * @package Mageplaza\BetterMaintenance\Model\Config\Backend
 */
class Video extends File
{
    /**
     * Getter for allowed extensions of uploaded files
     *
     * @return string[]
     */
    protected function _getAllowedExtensions()
    {
        return ['mp4'];
    }
}