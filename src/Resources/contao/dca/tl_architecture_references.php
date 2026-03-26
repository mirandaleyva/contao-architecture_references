<?php

use Contao\DC_Table;

/**
 * Table tl_architecture_references
 */
$GLOBALS['TL_DCA']['tl_architecture_references'] = [

    // Config
    'config' => [
        'dataContainer' => DC_Table::class,
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'alias' => 'index',
                'published' => 'index',
            ],
        ],
    ],

    // List
    'list' => [
        'sorting' => [
            'mode' => 1,
            'fields' => ['sorting'],
            'flag' => 1,
            'panelLayout' => 'sort,search,limit',
        ],
        'label' => [
            'fields' => ['title', 'location'],
            'format' => '%s <span style="color:#999;padding-left:3px">[%s]</span>',
        ],
        'global_operations' => [
            'all' => [
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'  => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="e"',
            ],
        ],
        'operations' => [
            'edit' => [
                'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.svg',
            ],
            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.svg',
            ],
            'delete' => [
                'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['delete'],
                'href'  => 'act=delete',
                'icon'  => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;"',
            ],
            'toggle' => [
                'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['toggle'],
                'href'  => 'act=toggle&field=published',
                'icon'  => 'visible.svg',
            ],
            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.svg',
            ],
        ],
    ],

    // Palettes
    'palettes' => [
        'default' =>
            '{general_legend},title,alias,category;' .
            '{content_legend},short_description,long_description;' .
            '{project_legend},completion,location,work,status;' .
            '{credits_legend},photographer,visualizer,photographer_link,visualizer_link;' .
            '{image_legend},preview_image,gallery;' .
            '{publish_legend},published',
    ],

    // Fields
    'fields' => [

        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment",
        ],

        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default 0",
        ],

        'sorting' => [
            'sql' => "int(10) unsigned NOT NULL default 0",
        ],

        'title' => [
            'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['title'],
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],

        'alias' => [
            'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['alias'],
            'inputType' => 'text',
            'eval' => ['rgxp' => 'alias', 'unique' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],

        'category' => [
            'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['category'],
            'inputType' => 'text',
            'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],

        'short_description' => [
            'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['short_description'],
            'inputType' => 'textarea',
            'eval' => ['mandatory' => true, 'tl_class' => 'clr'],
            'sql' => "text NULL",
        ],

        'long_description' => [
            'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['long_description'],
            'inputType' => 'textarea',
            'eval' => ['rte' => 'tinyMCE', 'tl_class' => 'clr'],
            'sql' => "text NULL",
        ],

        'completion' => [
            'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['completion'],
            'inputType' => 'text',
            'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],

        'location' => [
            'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['location'],
            'inputType' => 'text',
            'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],

        'work' => [
            'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['work'],
            'inputType' => 'text',
            'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],

        'status' => [
            'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['status'],
            'inputType' => 'text',
            'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],

        'photographer' => [
            'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['photographer'],
            'inputType' => 'text',
            'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],

        'visualizer' => [
            'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['visualizer'],
            'inputType' => 'text',
            'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],

        'photographer_link' => [
            'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['photographer_link'],
            'inputType' => 'text',
            'eval' => ['rgxp' => 'url', 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],

        'visualizer_link' => [
            'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['visualizer_link'],
            'inputType' => 'text',
            'eval' => ['rgxp' => 'url', 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],

        'preview_image' => [
            'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['preview_image'],
            'inputType' => 'fileTree',
            'eval' => [
                'files' => true,
                'fieldType' => 'radio',
                'extensions' => 'jpg,jpeg,png,webp',
                'filesOnly' => true,
            ],
            'sql' => "binary(16) NULL",
        ],

        'gallery' => [
            'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['gallery'],
            'inputType' => 'fileTree',
            'eval' => [
                'multiple' => true,
                'files' => true,
                'fieldType' => 'checkbox',
                'extensions' => 'jpg,jpeg,png,webp',
            ],
            'sql' => "blob NULL",
        ],

        'published' => [
            'label' => &$GLOBALS['TL_LANG']['tl_architecture_references']['published'],
            'inputType' => 'checkbox',
            'eval' => ['doNotCopy' => true, 'tl_class' => 'w50'],
            'sql' => "char(1) NOT NULL default '0'",
        ],
    ],
];