# Module Structure Guide

This guide explains the different module types in our framework and when to use each structure.

## Module Types Overview

Our framework supports three main types of modules:

1. **Parent Modules** - Container modules that can hold other modules
2. **Child Modules** - Modules that must be placed within a parent module
3. **Dynamic Modules** - Modules that fetch and display dynamic content

## Common Structure

All module types share a common base structure:

```php
namespace MEE\Modules\ModuleName;

use ET\Builder\Framework\DependencyManagement\Interfaces\DependencyInterface;
use ET\Builder\Packages\ModuleLibrary\ModuleRegistration;

class ModuleName implements DependencyInterface {
    use ModuleNameTrait\RenderCallbackTrait;
    
    public function load() {
        $module_json_folder_path = MEDITA_ADDONS_MODULES_JSON_PATH . 'module-name/';
        add_action(
            'init',
            function() use ( $module_json_folder_path ) {
                ModuleRegistration::register_module(
                    $module_json_folder_path,
                    [
                        'render_callback' => [ ModuleName::class, 'render_callback' ],
                    ]
                );
            }
        );
    }
}
```

## When to Use Each Type

### Parent Module

Use a parent module when:
- You need to create a container that will hold child modules
- You want to apply common styles or functionality to a group of child modules
- You need to establish a parent-child relationship for complex layouts

### Child Module

Use a child module when:
- Your module must be placed inside a specific parent module
- The module depends on the parent context for proper functioning
- You want to create specialized components for a parent container

### Dynamic Module

Use a dynamic module when:
- You need to fetch content from the database or external APIs
- The module content changes based on user interaction, server state, or other dynamic factors
- You need to process data before display

## Traits Implementation

Each module type uses a specific trait for rendering:

### Static Module Trait

The static module trait is used for modules with fixed content that doesn't change dynamically:

```php
namespace MEE\Modules\StaticModule\StaticModuleTrait;

trait RenderCallbackTrait {
    // Static rendering implementation
}
```

### Dynamic Module Trait

The dynamic module trait includes additional methods for fetching and processing dynamic content:

```php
namespace MEE\Modules\DynamicModule\DynamicModuleTrait;

trait RenderCallbackTrait {
    // Dynamic content processing and rendering implementation
}
```

## Implementation Steps

1. **Define your module type** - Determine if your module should be a parent, child, or dynamic module
2. **Create the main module class** - Use the appropriate structure based on your module type
3. **Implement the render callback trait** - Create a trait with rendering logic specific to your module type
4. **Register your module** - Use the `load()` method to register your module with the framework

## Code Structure Guidelines

1. Always keep the namespace consistent with your module name
2. Use the appropriate trait based on your module's rendering needs
3. Maintain the standard method signatures for compatibility with the framework
4. Place module JSON configuration in the appropriate directory

## Example Use Cases

- **Slider (Parent)** with Slide Items (Child)
- **Tabs Container (Parent)** with Tab Items (Child)
- **Post Grid (Dynamic)** that fetches and displays posts
- **User Profile (Dynamic)** that displays user-specific information

## When to Modify Code Structure

You generally should maintain the common structure shown above, but may need to modify:

1. When adding custom REST API endpoints for dynamic data
2. When implementing custom front-end JavaScript interactions
3. When adding new dependencies or integrations
4. When extending module functionality with custom hooks or filters

Remember that traits provide a way to share code between modules, so consider creating shared traits for common functionality across modules.



# RenderCallbackTrait Implementation Guide

This guide explains how to implement the `RenderCallbackTrait` for different module types.

## Understanding RenderCallbackTrait

The `RenderCallbackTrait` contains the rendering logic for your module. Each module type has its own implementation based on its rendering requirements:

- **Static modules** - Simple rendering with fixed content
- **Dynamic modules** - Content generated from database queries or API calls
- **Parent modules** - Container rendering with slots for child modules
- **Child modules** - Components that work within parent contexts

## Implementation by Module Type

### Static Module RenderCallbackTrait

```php
namespace MEE\Modules\StaticModule\StaticModuleTrait;

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

use ET\Builder\Packages\Module\Module;
use ET\Builder\Framework\Utility\HTMLUtility;

trait RenderCallbackTrait {
    /**
     * Module render callback.
     *
     * @since ??
     *
     * @param array    $attrs    Module attributes.
     * @param string   $content  Module content.
     * @param WP_Block $block    Block instance.
     *
     * @return string
     */
    public static function render_callback($attrs, $content, $block) {
        // Basic static rendering
        $module = new Module($attrs, $content, $block);
        
        // Get attributes
        $title = $module->get_attribute('title', '');
        $text = $module->get_attribute('text', '');
        
        // Build HTML
        $html = '<div class="static-module">';
        $html .= HTMLUtility::tag('h2', [], $title);
        $html .= HTMLUtility::tag('div', ['class' => 'content'], $text);
        $html .= '</div>';
        
        return $html;
    }
}
```

### Dynamic Module RenderCallbackTrait

```php
namespace MEE\Modules\DynamicModule\DynamicModuleTrait;

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

use ET\Builder\Packages\Module\Module;
use ET\Builder\Framework\Utility\HTMLUtility;

trait RenderCallbackTrait {
    /**
     * Module render callback.
     *
     * @since ??
     *
     * @param array    $attrs    Module attributes.
     * @param string   $content  Module content.
     * @param WP_Block $block    Block instance.
     *
     * @return string
     */
    public static function render_callback($attrs, $content, $block) {
        // Create module instance
        $module = new Module($attrs, $content, $block);
        
        // Get attributes
        $post_type = $module->get_attribute('post_type', 'post');
        $posts_per_page = $module->get_attribute('posts_per_page', 5);
        
        // Fetch dynamic data
        $posts = get_posts([
            'post_type' => $post_type,
            'posts_per_page' => $posts_per_page,
        ]);
        
        // Build HTML
        $html = '<div class="dynamic-module">';
        
        foreach ($posts as $post) {
            $html .= '<div class="post-item">';
            $html .= HTMLUtility::tag('h3', [], $post->post_title);
            $html .= HTMLUtility::tag('div', ['class' => 'excerpt'], get_the_excerpt($post->ID));
            $html .= '</div>';
        }
        
        $html .= '</div>';
        
        return $html;
    }
}
```

### Parent Module RenderCallbackTrait

```php
namespace MEE\Modules\ParentModule\ParentModuleTrait;

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

use ET\Builder\Packages\Module\Module;
use ET\Builder\Framework\Utility\HTMLUtility;
use ET\Builder\FrontEnd\BlockParser\BlockParserStore;

trait RenderCallbackTrait {
    /**
     * Module render callback.
     *
     * @since ??
     *
     * @param array    $attrs    Module attributes.
     * @param string   $content  Module content.
     * @param WP_Block $block    Block instance.
     *
     * @return string
     */
    public static function render_callback($attrs, $content, $block) {
        // Create module instance
        $module = new Module($attrs, $content, $block);
        
        // Get attributes
        $container_class = $module->get_attribute('container_class', '');
        
        // Parse inner blocks (child modules)
        $inner_blocks = BlockParserStore::get_inner_blocks($block);
        $inner_content = '';
        
        // Render all child blocks
        foreach ($inner_blocks as $inner_block) {
            $inner_content .= render_block($inner_block);
        }
        
        // Build HTML with wrapper for child modules
        $html = HTMLUtility::tag(
            'div',
            ['class' => 'parent-module ' . $container_class],
            $inner_content
        );
        
        return $html;
    }
}
```

### Child Module RenderCallbackTrait

```php
namespace MEE\Modules\ChildModule\ChildModuleTrait;

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

use ET\Builder\Packages\Module\Module;
use ET\Builder\Framework\Utility\HTMLUtility;

trait RenderCallbackTrait {
    /**
     * Module render callback.
     *
     * @since ??
     *
     * @param array    $attrs    Module attributes.
     * @param string   $content  Module content.
     * @param WP_Block $block    Block instance.
     *
     * @return string
     */
    public static function render_callback($attrs, $content, $block) {
        // Create module instance
        $module = new Module($attrs, $content, $block);
        
        // Get attributes
        $title = $module->get_attribute('title', '');
        $content_text = $module->get_attribute('content', '');
        
        // Build HTML for child module (will be used within parent)
        $html = '<div class="child-module-item">';
        $html .= HTMLUtility::tag('h4', [], $title);
        $html .= HTMLUtility::tag('div', ['class' => 'content'], $content_text);
        $html .= '</div>';
        
        return $html;
    }
}
```

## When to Use Each Implementation

1. **Use Static Module Trait** when:
   - Your module displays fixed content
   - Content is primarily derived from module attributes
   - No database queries or external API calls are needed

2. **Use Dynamic Module Trait** when:
   - Content comes from WordPress database (posts, users, etc.)
   - Module needs to fetch data from external APIs
   - Content changes based on user, session, or other runtime factors

3. **Use Parent Module Trait** when:
   - Module serves as a container for other modules
   - You need to process and wrap inner blocks
   - Layout requires a specific parent-child relationship

4. **Use Child Module Trait** when:
   - Module is designed to work within a specific parent
   - Module represents a component of a larger structure
   - Content is specific to a parent context

## Common Modifications

You may need to modify the trait implementation in these scenarios:

1. **Advanced Filtering** - When you need to apply complex filters to dynamic data
2. **Custom Output Formats** - When standard HTML isn't sufficient (e.g., for JSON or other formats)
3. **Integration with Third-party APIs** - When you need to pull data from external sources
4. **Caching Implementation** - When you need to cache results for performance
5. **Custom Error Handling** - When you need specific error handling for edge cases

Remember to keep the method signature consistent across all implementations to ensure compatibility with the ModuleRegistration system.