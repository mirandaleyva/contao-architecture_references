<?php

namespace MirandaLeyva\ContaoArchitectureReferences\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\ModuleModel;
use Contao\PageModel;
use MirandaLeyva\ContaoArchitectureReferences\Model\ArchitectureReferencesModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsFrontendModule(
    category: 'references',
    type: 'architecture_references_list',
    template: 'mod_architecture_references'
)]
class ArchitectureReferencesListController extends AbstractFrontendModuleController
{
    protected function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response
    {
        $referenceModels = ArchitectureReferencesModel::findBy(
            ['published=?'],
            ['1'],
            [
                'order' => 'sorting ASC',
                'limit' => (int) $model->reference_limit,
                'offset' => (int) $model->reference_offset,
            ]
        );

        $references = [];
        $jumpToPage = null;

        if ($model->jumpTo) {
            $jumpToPage = PageModel::findByPk($model->jumpTo);
        }

        if (null !== $referenceModels) {
            foreach ($referenceModels as $referenceModel) {
                $references[] = [
                    'title' => $referenceModel->title,
                    'short_description' => $referenceModel->short_description,
                    'alias' => $referenceModel->alias,
                    'url' => (null !== $jumpToPage && $referenceModel->alias)
                        ? $jumpToPage->getFrontendUrl('/' . $referenceModel->alias)
                        : null,
                ];
            }
        }

        $template->set('references', $references);
        $template->set('model', $model);

        return $template->getResponse();
    }
}