<?php

namespace MirandaLeyva\ContaoArchitectureReferences\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\FilesModel;
use Contao\ModuleModel;
use Contao\PageModel;
use MirandaLeyva\ContaoArchitectureReferences\Model\ArchitectureReferencesModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[
  AsFrontendModule(
    category: "references",
    type: "architecture_references_list",
    template: "mod_architecture_references",
  ),
]
class ArchitectureReferencesListController extends
  AbstractFrontendModuleController
{
  protected function getResponse(
    FragmentTemplate $template,
    ModuleModel $model,
    Request $request,
  ): Response {
    $options = [
      "order" => "sorting ASC",
    ];

    $limit = (int) ($model->reference_limit ?? 0);
    $offset = (int) ($model->reference_offset ?? 0);

    if ($limit > 0) {
      $options["limit"] = $limit;
    }

    if ($offset > 0) {
      $options["offset"] = $offset;
    }

    $referenceModels = ArchitectureReferencesModel::findBy(
      ["published=?"],
      ["1"],
      $options,
    );

    $references = [];
    $jumpToPage = null;

    if ($model->jumpTo) {
      $jumpToPage = PageModel::findByPk($model->jumpTo);
    }

    if (null !== $referenceModels) {
      foreach ($referenceModels as $referenceModel) {
        $previewImage = null;

        if ($referenceModel->preview_image) {
          $file = FilesModel::findByUuid($referenceModel->preview_image);

          if (null !== $file) {
            $previewImage = $file->path;
          }
        }

        $url = null;

        if (null !== $jumpToPage) {
          $url =
            $jumpToPage->getFrontendUrl() .
            (str_contains($jumpToPage->getFrontendUrl(), "?") ? "&" : "?") .
            "project=" .
            (int) $referenceModel->id;
        }

        $references[] = [
          "id" => (int) $referenceModel->id,
          "title" => $referenceModel->title,
          "short_description" => $referenceModel->short_description,
          "alias" => $referenceModel->alias,
          "preview_image" => $previewImage,
          "url" => $url,

          // Optional fields for the old Superdraft hover layout
          "category" => $referenceModel->category ?? null,
          "status" => $referenceModel->status ?? null,
          "location" => $referenceModel->location ?? null,
          "completion" => $referenceModel->completion ?? null,
        ];
      }
    }

    $template->set("references", $references);
    $template->set("model", $model);

    return $template->getResponse();
  }
}
