<?php

namespace BoergenerWebdesign\BwRegistration\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Core\ApplicationContext;
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class Controller extends ActionController {
    protected ModuleTemplateFactory $moduleTemplateFactory;

    /**
     * @param ModuleTemplateFactory $moduleTemplateFactory
     */
    public function __construct(ModuleTemplateFactory $moduleTemplateFactory) {
        $this -> moduleTemplateFactory = $moduleTemplateFactory;
    }

    /**
     * @param string|null $html
     * @return ResponseInterface
     */
    public function htmlResponse(string $html = null): ResponseInterface {
        if(ApplicationType::fromRequest($this -> request)->isBackend()) {
            $moduleTemplate = GeneralUtility::makeInstance(ModuleTemplateFactory::class) -> create($this->request);
            $moduleTemplate->setContent($this->view->render());
            return parent::htmlResponse($moduleTemplate->renderContent());
        }
        return parent::htmlResponse($html);
    }
}