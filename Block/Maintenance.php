<?php
namespace Mageplaza\BetterMaintenance\Block;

use Magento\Framework\View\Element\Template;
use Mageplaza\BetterMaintenance\Helper\Data as HelperData;
use Mageplaza\BetterMaintenance\Helper\Image as HelperImage;

class Maintenance extends Template
{
    const PAGE_TITLE       = 'Under Maintenance';
    const PAGE_DESCRIPTION = 'We\'re currentyly down for maintenace. Be right back!';
    const PROGRESS_VALUE   = 50;

    protected $_helperData;
    protected $_helperImage;

    public function __construct
    (
        HelperData $helperData,
        HelperImage $helperImage,
        Template\Context $context,
        array $data = []
    ) {
        $this->_helperData  = $helperData;
        $this->_helperImage = $helperImage;
        parent::__construct($context, $data);
    }

    public function getLogo($logo)
    {
        return $this->_helperImage->getMediaUrl($this->_helperImage->getMediaPath($logo,
            HelperImage::TEMPLATE_MEDIA_TYPE_LOGO
        ));
    }

    public function getImageUrl($image)
    {
        if (empty($image)) {
            return null;
        }

        return $this->_helperImage->getMediaUrl($this->_helperImage->getMediaPath($image,
            HelperImage::TEMPLATE_MEDIA_TYPE_IMAGE
        ));
    }

    public function getVideoUrl($video)
    {
        if (empty($video)) {
            return null;
        }

        return $this->_helperImage->getMediaUrl($this->_helperImage->getMediaPath($video,
            HelperImage::TEMPLATE_MEDIA_TYPE_VIDEO
        ));
    }

    public function getListMultipleImages($images) {
        $data = HelperData::jsonDecode($images);
        $list = [];

        foreach ($data as $key => $value) {
            $list[] = $value['file'];
        }

        return $list;
    }

    public function getMultipleImagesUrl($images)
    {
        $urls = [];
        $images = $this->getListMultipleImages($images);
        if (empty($images)) {
            return null;
        }

        foreach($images as $image) {
            $urls[] = $this->_helperImage->getMediaUrl($this->_helperImage->getMediaPath($image));
        }

        return $urls;
    }

    public function getPageTitle()
    {
        $title = $this->_helperData->getMaintenanceSetting('maintenance_title');

        return empty($title) ? self::PAGE_TITLE : $title;
    }

    public function getPageDescription()
    {
        $des = $this->_helperData->getMaintenanceSetting('maintenance_description');

        return empty($des) ? self::PAGE_DESCRIPTION : $des;
    }

    public function getProgressValue()
    {
        $value = $this->_helperData->getMaintenanceSetting('maintenance_progress_value');

        return empty($value) ? self::PROGRESS_VALUE : $value;
    }

    public function getProgressLabel()
    {
        $label = $this->_helperData->getMaintenanceSetting('maintenance_progress_label');

        return isset($label) ? $label : '';
    }

    public function getSocialLabel()
    {
        $label = $this->_helperData->getSocialSetting('social_label');

        return isset($label) ? $label : '';
    }

    public function getSocialList()
    {
        $list    = [
            'social_facebook',
            'social_twitter',
            'social_instagram',
            'social_google',
            'social_youtube',
            'social_pinterest'
        ];
        $url     = [];
        $imgPath = 'Mageplaza_BetterMaintenance::media/';
        foreach ($list as $value) {
            $url[] = [
                'link' => $this->_helperData->getSocialSetting($value),
                'img'  => $this->getViewFileUrl($imgPath . $value . '.png')
            ];
        }

        return $url;
    }

    public function getBlockCms()
    {
        $blockId = $this->_helperData->getFooterSetting('cms_block');
        if ($blockId === '0') {
            return null;
        }
        $block = $this->getLayout()->createBlock('Magento\Cms\Block\Block')
            ->setBlockId($blockId)
            ->toHtml();

        return $block;
    }
}