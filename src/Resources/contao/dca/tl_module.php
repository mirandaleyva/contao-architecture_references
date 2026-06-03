<?php

declare(strict_types=1);

/**
 * Frontend module palettes
 */
$GLOBALS["TL_DCA"]["tl_module"]["palettes"]["architecture_references_list"] =
  "{title_legend},name,headline,type;" .
  "{config_legend},imgSize,reference_limit,reference_offset;" .
  "{redirect_legend},jumpTo;" .
  "{template_legend:hide},customTpl;" .
  "{protected_legend:hide},protected;" .
  "{expert_legend:hide},guests,cssID,space";

$GLOBALS["TL_DCA"]["tl_module"]["palettes"]["architecture_reference_reader"] =
  "{title_legend},name,headline,type;" .
  "{config_legend},imgSize;" .
  "{template_legend:hide},customTpl;" .
  "{protected_legend:hide},protected;" .
  "{expert_legend:hide},guests,cssID,space";

/**
 * Frontend module fields
 */
$GLOBALS["TL_DCA"]["tl_module"]["fields"]["reference_limit"] = [
  "label" => &$GLOBALS["TL_LANG"]["tl_module"]["reference_limit"],
  "exclude" => true,
  "inputType" => "text",
  "eval" => [
    "rgxp" => "natural",
    "mandatory" => false,
    "tl_class" => "w50",
    "maxlength" => 10,
  ],
  "sql" => "int(10) unsigned NOT NULL default 0",
];

$GLOBALS["TL_DCA"]["tl_module"]["fields"]["reference_offset"] = [
  "label" => &$GLOBALS["TL_LANG"]["tl_module"]["reference_offset"],
  "exclude" => true,
  "inputType" => "text",
  "eval" => [
    "rgxp" => "natural",
    "mandatory" => false,
    "tl_class" => "w50",
    "maxlength" => 10,
  ],
  "sql" => "int(10) unsigned NOT NULL default 0",
];
