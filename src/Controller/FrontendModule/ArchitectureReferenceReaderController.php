<?php

namespace MirandaLeyva\ContaoArchitectureReferences\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\FilesModel;
use Contao\Input;
use Contao\ModuleModel;
use Contao\StringUtil;
use MirandaLeyva\ContaoArchitectureReferences\Model\ArchitectureReferencesModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[
  AsFrontendModule(
    category: "references",
    type: "architecture_reference_reader",
    template: "mod_architecture_reference",
  ),
]
class ArchitectureReferenceReaderController extends
  AbstractFrontendModuleController
{
  protected function getResponse(
    FragmentTemplate $template,
    ModuleModel $model,
    Request $request,
  ): Response {
    $project =
      Input::get("project") ?:
      Input::get("architecture_reference") ?:
      Input::get("auto_item");

    if (!$project) {
      return new Response("", Response::HTTP_NO_CONTENT);
    }

    if (is_numeric($project)) {
      $reference = ArchitectureReferencesModel::findOneBy(
        ["id=?", "published=?"],
        [(int) $project, "1"],
      );
    } else {
      $reference = ArchitectureReferencesModel::findOneBy(
        ["alias=?", "published=?"],
        [$project, "1"],
      );
    }

    if (null === $reference) {
      throw $this->createNotFoundException("Architecture reference not found.");
    }

    $previewImage = null;

    if ($reference->preview_image) {
      $file = FilesModel::findByUuid($reference->preview_image);

      if (null !== $file) {
        $previewImage = $file->path;
      }
    }

    $galleryImages = [];

    foreach (StringUtil::deserialize($reference->gallery, true) as $uuid) {
      $file = FilesModel::findByUuid($uuid);

      if (null !== $file) {
        $galleryImages[] = $file->path;
      }
    }

    $reference->previewImage = $previewImage;
    $reference->galleryImages = $galleryImages;

    $template->set("reference", $reference);
    $template->set("model", $model);

    return $template->getResponse();
  }
}
