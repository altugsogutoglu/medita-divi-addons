<?php

/**
 * CartModule::render_callback()
 *
 * @package MEE\Modules\CartModule
 * @since ??
 */

namespace MEE\Modules\CartModule\CartModuleTrait;

if (! defined('ABSPATH')) {
    die('Direct access forbidden.');
}

// phpcs:disable ET.Sniffs.ValidVariableName.UsedPropertyNotSnakeCase -- WP use snakeCase in \WP_Block_Parser_Block

use ET\Builder\Packages\Module\Module;
use ET\Builder\Framework\Utility\HTMLUtility;
use ET\Builder\FrontEnd\BlockParser\BlockParserStore;
use ET\Builder\Packages\Module\Options\Element\ElementComponents;
use MEE\Modules\CartModule\CartModule;

trait RenderCallbackTrait
{
    /**
     * Cart module render callback which outputs server side rendered HTML on the Front-End.
     *
     * @since ??
     * @param array          $attrs    Block attributes that were saved by VB.
     * @param string         $content  Block content.
     * @param WP_Block       $block    Parsed block object that being rendered.
     * @param ModuleElements $elements ModuleElements instance.
     *
     * @return string HTML rendered of Cart module.
     */
    public static function render_callback($attrs, $content, $block, $elements)
    {
        // Cart icon SVG
        $cart_icon = '<svg class="medita_cart_module__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>';

        // Cart count
        // Cart count
        $cart_count = function_exists('WC') && WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
        $count_element = HTMLUtility::render([
            'tag' => 'span',
            'attributes' => [
                'class' => 'medita_cart_module__count',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => (string)$cart_count, // Cast to string here
        ]);
        // Cart link
        $cart_link = HTMLUtility::render([
            'tag' => 'a',
            'attributes' => [
                'href' => function_exists('wc_get_cart_url') ? esc_url(wc_get_cart_url()) : '#',
                'class' => 'medita_cart_module__link',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => $cart_icon . $count_element,
        ]);

        // Inner content
        $inner_content = HTMLUtility::render([
            'tag' => 'div',
            'attributes' => [
                'class' => 'medita_cart_module__inner',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => $cart_link,
        ]);

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
            'classnamesFunction' => [CartModule::class, 'module_classnames'],
            'stylesComponent' => [CartModule::class, 'module_styles'],
            'scriptDataComponent' => [CartModule::class, 'module_script_data'],
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
                $inner_content,
            ],
        ]);
    }
}
