<?php
namespace MEE\Modules\HeaderModule\HeaderModuleTrait;

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

use ET\Builder\Packages\Module\Module;
use ET\Builder\Framework\Utility\HTMLUtility;
use ET\Builder\FrontEnd\BlockParser\BlockParserStore;
use ET\Builder\Packages\Module\Options\Element\ElementComponents;
use MEE\Modules\HeaderModule\HeaderModule;

trait RenderCallbackTrait
{
    public static function render_callback($attrs, $content, $block, $elements)
    {
        // Get site logo
        $logo_id = $attrs['logo']['image_id'] ?? get_theme_mod('custom_logo');
        $logo_url = '';
        $logo_alt = get_bloginfo('name');
        
        if ($logo_id) {
            $logo_data = wp_get_attachment_image_src($logo_id, 'full');
            if ($logo_data) {
                $logo_url = $logo_data[0];
            }
        }
        
        // Logo element
        $logo_img = HTMLUtility::render([
            'tag' => 'img',
            'attributes' => [
                'src' => $logo_url ? esc_url($logo_url) : 'https://via.placeholder.com/200x80',
                'alt' => esc_attr($logo_alt),
                'class' => 'header_logo_img',
            ],
        ]);
        
        $logo_link = HTMLUtility::render([
            'tag' => 'a',
            'attributes' => [
                'href' => esc_url(home_url('/')),
                'class' => 'header_logo_link',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => $logo_img,
        ]);
        
        $logo_container = HTMLUtility::render([
            'tag' => 'div',
            'attributes' => [
                'class' => 'header_logo',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => $logo_link,
        ]);
        
        // Navigation - Main Menu
        $menu_location = $attrs['menu']['location'] ?? 'primary-menu';
        $menu_html = '';
        
        if (has_nav_menu($menu_location)) {
            ob_start();
            wp_nav_menu([
                'theme_location' => $menu_location,
                'menu_class' => 'header_menu',
                'container' => 'nav',
                'container_class' => 'header_navigation header_desktop_nav',
                'depth' => 3, // Support for mega menu
                'walker' => new \Walker_Nav_Menu(), // Consider a custom walker for mega menu
            ]);
            $menu_html = ob_get_clean();
        } else {
            // Fallback menu
            $menu_html = HTMLUtility::render([
                'tag' => 'nav',
                'attributes' => [
                    'class' => 'header_navigation header_desktop_nav',
                ],
                'childrenSanitizer' => 'et_core_esc_previously',
                'children' => '
                    <ul class="header_menu">
                        <li class="menu-item"><a href="#">Home</a></li>
                        <li class="menu-item menu-item-has-children">
                            <a href="#">Products</a>
                            <div class="mega-menu">
                                <div class="mega-menu-column">
                                    <h4 class="column-title">Category 1</h4>
                                    <ul>
                                        <li><a href="#">Product 1.1</a></li>
                                        <li><a href="#">Product 1.2</a></li>
                                        <li><a href="#">Product 1.3</a></li>
                                    </ul>
                                </div>
                                <div class="mega-menu-column">
                                    <h4 class="column-title">Category 2</h4>
                                    <ul>
                                        <li><a href="#">Product 2.1</a></li>
                                        <li><a href="#">Product 2.2</a></li>
                                        <li><a href="#">Product 2.3</a></li>
                                    </ul>
                                </div>
                                <div class="mega-menu-column">
                                    <h4 class="column-title">Category 3</h4>
                                    <ul>
                                        <li><a href="#">Product 3.1</a></li>
                                        <li><a href="#">Product 3.2</a></li>
                                        <li><a href="#">Product 3.3</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="menu-item"><a href="#">About</a></li>
                        <li class="menu-item"><a href="#">Contact</a></li>
                    </ul>
                ',
            ]);
        }
        
        // CTA Buttons
        $show_cta = $attrs['buttons']['show'] ?? true;
        $cta_text = $attrs['buttons']['primary']['text'] ?? 'Get Started';
        $cta_url = $attrs['buttons']['primary']['url'] ?? '#';
        
        $cta_button = '';
        if ($show_cta) {
            $cta_button = HTMLUtility::render([
                'tag' => 'a',
                'attributes' => [
                    'href' => esc_url($cta_url),
                    'class' => 'header_button header_primary_button',
                ],
                'childrenSanitizer' => 'et_core_esc_previously',
                'children' => esc_html($cta_text),
            ]);
        }
        
        // User profile icon/link
        $profile_icon = '<svg class="header_profile_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>';
        
        $user_text = is_user_logged_in() ? wp_get_current_user()->display_name : 'Log In';
        $user_url = is_user_logged_in() ? get_edit_profile_url() : wp_login_url();
        
        $profile_link = HTMLUtility::render([
            'tag' => 'a',
            'attributes' => [
                'href' => esc_url($user_url),
                'class' => 'header_profile_link',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => $profile_icon . '<span class="header_user_text">' . esc_html($user_text) . '</span>',
        ]);
        
        // Cart icon/link
        $cart_icon = '<svg class="header_cart_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>';
        
        $cart_count = function_exists('WC') && WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
        $count_element = HTMLUtility::render([
            'tag' => 'span',
            'attributes' => [
                'class' => 'header_cart_count',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => (string)$cart_count,
        ]);
        
        $cart_link = HTMLUtility::render([
            'tag' => 'a',
            'attributes' => [
                'href' => function_exists('wc_get_cart_url') ? esc_url(wc_get_cart_url()) : '#',
                'class' => 'header_cart_link',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => $cart_icon . $count_element,
        ]);
        
        // Action buttons container (CTA, Profile, Cart)
        $action_buttons = HTMLUtility::render([
            'tag' => 'div',
            'attributes' => [
                'class' => 'header_actions',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => $cta_button . $profile_link . $cart_link,
        ]);
        
        // Mobile menu toggle
        $mobile_toggle = HTMLUtility::render([
            'tag' => 'button',
            'attributes' => [
                'class' => 'header_mobile_toggle',
                'aria-expanded' => 'false',
                'aria-label' => 'Toggle navigation menu',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => '<span></span><span></span><span></span>',
        ]);
        
        // Assemble the header inner content
        $inner_content = HTMLUtility::render([
            'tag' => 'div',
            'attributes' => [
                'class' => 'header_inner',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => $logo_container . $menu_html . $action_buttons . $mobile_toggle,
        ]);
        
        // Mobile navigation (hidden by default, shown with JS)
        $mobile_menu = '';
        if (has_nav_menu($menu_location)) {
            ob_start();
            wp_nav_menu([
                'theme_location' => $menu_location,
                'menu_class' => 'header_mobile_menu_list',
                'container' => 'nav',
                'container_class' => 'header_mobile_menu',
                'depth' => 2,
            ]);
            $mobile_menu = ob_get_clean();
        } else {
            $mobile_menu = HTMLUtility::render([
                'tag' => 'nav',
                'attributes' => [
                    'class' => 'header_mobile_menu',
                ],
                'childrenSanitizer' => 'et_core_esc_previously',
                'children' => '
                    <ul class="header_mobile_menu_list">
                        <li class="menu-item"><a href="#">Home</a></li>
                        <li class="menu-item menu-item-has-children">
                            <a href="#">Products</a>
                            <ul class="sub-menu">
                                <li><a href="#">Category 1</a></li>
                                <li><a href="#">Category 2</a></li>
                                <li><a href="#">Category 3</a></li>
                            </ul>
                        </li>
                        <li class="menu-item"><a href="#">About</a></li>
                        <li class="menu-item"><a href="#">Contact</a></li>
                    </ul>
                ',
            ]);
        }
        
        // Add mobile menu JavaScript
        $mobile_menu_script = HTMLUtility::render([
            'tag' => 'script',
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => "
                document.addEventListener('DOMContentLoaded', function() {
                    var toggle = document.querySelector('.header_mobile_toggle');
                    var mobileMenu = document.querySelector('.header_mobile_menu');
                    
                    if (toggle && mobileMenu) {
                        toggle.addEventListener('click', function() {
                            var expanded = toggle.getAttribute('aria-expanded') === 'true';
                            toggle.setAttribute('aria-expanded', !expanded);
                            toggle.classList.toggle('active');
                            mobileMenu.classList.toggle('active');
                            document.body.classList.toggle('mobile-menu-open');
                        });
                        
                        // Handle sub-menu toggles
                        var hasChildrenItems = document.querySelectorAll('.header_mobile_menu .menu-item-has-children > a');
                        hasChildrenItems.forEach(function(item) {
                            var submenuToggle = document.createElement('span');
                            submenuToggle.className = 'submenu-toggle';
                            item.appendChild(submenuToggle);
                            
                            submenuToggle.addEventListener('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                var parent = this.parentNode.parentNode;
                                parent.classList.toggle('submenu-open');
                            });
                        });
                    }
                });
            ",
        ]);
        
        // Get parent context if needed
        $parent = BlockParserStore::get_parent($block->parsed_block['id'], $block->parsed_block['storeInstance']);
        $parent_attrs = $parent->attrs ?? [];
        
        // Return the fully rendered header
        return Module::render([
            // FE only
            'orderIndex' => $block->parsed_block['orderIndex'],
            'storeInstance' => $block->parsed_block['storeInstance'],
            
            // VB equivalent
            'attrs' => $attrs,
            'elements' => $elements,
            'id' => $block->parsed_block['id'],
            'name' => $block->block_type->name,
            'moduleCategory' => $block->block_type->category,
            'classnamesFunction' => [HeaderModule::class, 'module_classnames'],
            'stylesComponent' => [HeaderModule::class, 'module_styles'],
            'scriptDataComponent' => [HeaderModule::class, 'module_script_data'],
            'parentAttrs' => $parent_attrs,
            'parentId' => $parent->id ?? '',
            'parentName' => $parent->blockName ?? '',
            'children' => [
                // Module decoration styles
                ElementComponents::component([
                    'attrs' => $attrs['module']['decoration'] ?? [],
                    'id' => $block->parsed_block['id'],
                    'orderIndex' => $block->parsed_block['orderIndex'],
                    'storeInstance' => $block->parsed_block['storeInstance'],
                ]),
                // Main header content
                $inner_content,
                // Mobile menu
                $mobile_menu,
                // Mobile menu script
                $mobile_menu_script,
            ],
        ]);
    }
}