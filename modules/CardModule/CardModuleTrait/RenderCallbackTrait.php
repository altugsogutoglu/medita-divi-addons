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
        $link_url = $attrs['module']['advanced']['link']['desktop']['value']['url'] ?? '#';

        $image = HTMLUtility::render([
            'tag' => 'img',
            'attributes' => [
                'src' => $image_src,
                'alt' => $image_alt,
                'class' => 'example_card_module__image-element',
            ],
            'attributesSanitizers' => [
                'src' => function ($value) {
                    $protocols = array_merge(wp_allowed_protocols(), ['data']);
                    return esc_url($value, $protocols);
                },
            ],
        ]);

        // Gradient overlay
        $gradient_overlay = HTMLUtility::render([
            'tag' => 'div',
            'attributes' => [
                'class' => 'example_card_module__gradient-overlay',
            ],
        ]);

        // Title - now positioned inside the image container
        $title = $elements->render([
            'attrName' => 'title',
        ]);

        // Title container positioned at the bottom of the image
        $title_container = HTMLUtility::render([
            'tag' => 'div',
            'attributes' => [
                'class' => 'example_card_module__title-container',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => $title,
        ]);

        // Image container with overlay and title
        $image_container = HTMLUtility::render([
            'tag' => 'div',
            'attributes' => [
                'class' => 'example_card_module__image',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => $image . $gradient_overlay . $title_container,
        ]);

        // Content.
        $content = $elements->render([
            'attrName' => 'content',
        ]);

        // Arrow SVG for link
        $arrow_svg = '<svg class="example_card_module__arrow-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>';

        // Link text with arrow
        $link_text = HTMLUtility::render([
            'tag' => 'span',
            'attributes' => [
                'class' => 'example_card_module__link-text',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => 'Meer informatie' . $arrow_svg,
        ]);

        // Content container.
        $content_container = HTMLUtility::render([
            'tag' => 'div',
            'attributes' => [
                'class' => 'example_card_module__content-container',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => $content . $link_text,
        ]);

        // Inner content
        $inner_content = HTMLUtility::render([
            'tag' => 'div',
            'attributes' => [
                'class' => 'example_card_module__inner',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => $image_container . $content_container,
        ]);

        // Wrap everything in a link if URL exists
        $final_content = $inner_content;
        if (!empty($link_url)) {
            $final_content = HTMLUtility::render([
                'tag' => 'a',
                'attributes' => [
                    'href' => esc_url($link_url),
                    'class' => 'example_card_module__wrapper',
                ],
                'childrenSanitizer' => 'et_core_esc_previously',
                'children' => $inner_content,
            ]);
        }

        $parent = BlockParserStore::get_parent($block->parsed_block['id'], $block->parsed_block['storeInstance']);
        $parent_attrs = $parent->attrs ?? [];

        return Module::render([
            // FE only.
            'orderIndex' => $block->parsed_block['orderIndex'],
            'storeInstance' => $block->parsed_block['storeInstance'],

            // VB equivalent.
            'attrs' => $attrs,
            'elements' => $elements,
            'id' => $block->parsed_block['id'],
            'name' => $block->block_type->name,
            'moduleCategory' => $block->block_type->category,
            'classnamesFunction' => [CardModule::class, 'module_classnames'],
            'stylesComponent' => [CardModule::class, 'module_styles'],
            'scriptDataComponent' => [CardModule::class, 'module_script_data'],
            'parentAttrs' => $parent_attrs,
            'parentId' => $parent->id ?? '',
            'parentName' => $parent->blockName ?? '',
            'children' => [
                ElementComponents::component([
                    'attrs' => $attrs['module']['decoration'] ?? [],
                    'id' => $block->parsed_block['id'],

                    // FE only.
                    'orderIndex' => $block->parsed_block['orderIndex'],
                    'storeInstance' => $block->parsed_block['storeInstance'],
                ]),
                $final_content,
            ],
        ]);
    }
}
