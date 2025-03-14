<?php

/**
 * CardModule::render_callback()
 *
 * @package MEE\Modules\CardModule
 * @since ??
 */

namespace MEE\Modules\CardModule\CardModuleTrait;

if (! defined('ABSPATH')) {
    die('Direct access forbidden.');
}

// phpcs:disable ET.Sniffs.ValidVariableName.UsedPropertyNotSnakeCase -- WP use snakeCase in \WP_Block_Parser_Block

use ET\Builder\Packages\Module\Module;
use ET\Builder\Framework\Utility\HTMLUtility;
use ET\Builder\FrontEnd\BlockParser\BlockParserStore;
use ET\Builder\Packages\Module\Options\Element\ElementComponents;
use MEE\Modules\CardModule\CardModule;

trait RenderCallbackTrait
{

    /**
     * Card module render callback which outputs server side rendered HTML on the Front-End.
     *
     * @since ??
     * @param array          $attrs    Block attributes that were saved by VB.
     * @param string         $content  Block content.
     * @param WP_Block       $block    Parsed block object that being rendered.
     * @param ModuleElements $elements ModuleElements instance.
     *
     * @return string HTML rendered of Card module.
     */
    public static function render_callback($attrs, $content, $block, $elements)
    {
        // Image.
        $image_src = $attrs['image']['innerContent']['desktop']['value']['src'] ?? '';
        $image_alt = $attrs['image']['innerContent']['desktop']['value']['alt'] ?? '';
        $image     = HTMLUtility::render(
            [
                'tag'                  => 'img',
                'attributes'           => [
                    'src' => $image_src,
                    'alt' => $image_alt,
                ],
                'attributesSanitizers' => [
                    'src' => function ($value) {
                        $protocols = array_merge(wp_allowed_protocols(), ['data']); // Need to add `data` protocol for default image.
                        return esc_url($value, $protocols);
                    },
                ],
            ]
        );

        // Image container.
        $image_container = HTMLUtility::render(
            [
                'tag'               => 'div',
                'attributes'        => [
                    'class' => 'example_card_module__image',
                ],
                'childrenSanitizer' => 'et_core_esc_previously',
                'children'          => $image,
            ]
        );

        // Title.
        $title = $elements->render(
            [
                'attrName' => 'title',
            ]
        );

        // Content.
        $content = $elements->render(
            [
                'attrName' => 'content',
            ]
        );

        // Content container.
        $content_container = HTMLUtility::render(
            [
                'tag'               => 'div',
                'attributes'        => [
                    'class' => 'example_card_module__content-container',
                ],
                'childrenSanitizer' => 'et_core_esc_previously',
                'children'          => $title . $content,
            ]
        );

        // Create the inner content
        $inner_content = HTMLUtility::render([
            'tag'               => 'div',
            'attributes'        => [
                'class' => 'example_card_module__inner',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children'          => $image_container . $content_container,
        ]);


        // Check if link exists and create a linked wrapper if it does
        $final_content = $inner_content;
        if (
            isset($attrs['link']) &&
            isset($attrs['link']['innerContent']) &&
            isset($attrs['link']['innerContent']['desktop']) &&
            isset($attrs['link']['innerContent']['desktop']['value']) &&
            !empty($attrs['link']['innerContent']['desktop']['value'])
        ) {

            $link_url = $attrs['link']['innerContent']['desktop']['value'];
            $final_content = HTMLUtility::render([
                'tag'               => 'a',
                'attributes'        => [
                    'class' => 'example_card_module__link',
                    'href' => esc_url($link_url),
                ],
                'childrenSanitizer' => 'et_core_esc_previously',
                'children'          => $inner_content,
            ]);
        }

        $parent       = BlockParserStore::get_parent($block->parsed_block['id'], $block->parsed_block['storeInstance']);
        $parent_attrs = $parent->attrs ?? [];

        return Module::render(
            [
                // FE only.
                'orderIndex'          => $block->parsed_block['orderIndex'],
                'storeInstance'       => $block->parsed_block['storeInstance'],

                // VB equivalent.
                'attrs'               => $attrs,
                'elements'            => $elements,
                'id'                  => $block->parsed_block['id'],
                'name'                => $block->block_type->name,
                'moduleCategory'      => $block->block_type->category,
                'classnamesFunction'  => [CardModule::class, 'module_classnames'],
                'stylesComponent'     => [CardModule::class, 'module_styles'],
                'scriptDataComponent' => [CardModule::class, 'module_script_data'],
                'parentAttrs'         => $parent_attrs,
                'parentId'            => $parent->id ?? '',
                'parentName'          => $parent->blockName ?? '',
                'children'            => [
                    ElementComponents::component(
                        [
                            'attrs'         => $attrs['module']['decoration'] ?? [],
                            'id'            => $block->parsed_block['id'],

                            // FE only.
                            'orderIndex'    => $block->parsed_block['orderIndex'],
                            'storeInstance' => $block->parsed_block['storeInstance'],
                        ]
                    ),
                    HTMLUtility::render(
                        [
                            'tag'               => 'div',
                            'attributes'        => [
                                'class' => 'example_card_module__inner',
                            ],
                            'childrenSanitizer' => 'et_core_esc_previously',
                            'children'          => $image_container . $content_container,
                        ]
                    ),
                ],
            ]
        );
    }
}
