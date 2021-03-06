<?php
namespace Fab\Media\View\Button;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Fab\Media\Module\MediaModule;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Imaging\Icon;
use Fab\Vidi\View\AbstractComponentView;
use Fab\Vidi\Domain\Model\Content;

/**
 * View which renders a "image-editor" button to be placed in the grid.
 */
class ImageEditorButton extends AbstractComponentView
{

    /**
     * Renders a "image-editor" button to be placed in the grid.
     *
     * @param Content $object
     * @return string
     */
    public function render(Content $object = NULL)
    {
        $button = '';
        if ($this->getModuleLoader()->hasPlugin('imageEditor')) {
            $button = $this->makeLinkButton()
                ->setHref($this->getImageEditorUri($object))
                ->setDataAttributes([
                    'uid' => $object->getUid(),
                    'toggle' => 'tooltip',
                ])
                ->setClasses('btn-imageEditor')
                ->setTitle($this->getLanguageService()->sL('LLL:EXT:media/Resources/Private/Language/locallang.xlf:edit_image'))
                ->setIcon($this->getIconFactory()->getIcon('extensions-media-image-edit', Icon::SIZE_SMALL))
                ->render();
        }
        return $button;
    }

    /**
     * @param Content $object
     * @return string
     */
    protected function getImageEditorUri(Content $object)
    {
        $urlParameters = array(
            MediaModule::getParameterPrefix() => array(
                'controller' => 'ImageEditor',
                'action' => 'show',
                'file' => $object->getUid(),
            ),
        );
        return BackendUtility::getModuleUrl(MediaModule::getSignature(), $urlParameters);
    }
}
