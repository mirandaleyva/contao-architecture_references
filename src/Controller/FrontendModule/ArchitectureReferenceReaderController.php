<?php

namespace MirandaLeyva\ContaoArchitectureReferences\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\Input;
use Contao\ModuleModel;
use MirandaLeyva\ContaoArchitectureReferences\Model\ArchitectureReferencesModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsFrontendModule(
    category: 'references',
    type: 'architecture_reference_reader',
    template: 'mod_architecture_reference'
)]
class ArchitectureReferenceReaderController extends AbstractFrontendModuleController
{
    protected function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response
    {
        $alias = Input::get('architecture_reference') ?: Input::get('auto_item');

        if (!$alias) {
            return new Response('', Response::HTTP_NO_CONTENT);
        }

        $reference = ArchitectureReferencesModel::findOneBy(
            ['alias=?', 'published=?'],
            [$alias, '1']
        );

        if (null === $reference) {
            throw $this->createNotFoundException('Architecture reference not found.');
        }

        $template->set('reference', $reference);
        $template->set('model', $model);

        return $template->getResponse();
    }
}