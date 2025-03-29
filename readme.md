# Divi Custom Extension Development Guide

This comprehensive guide covers best practices, code structure, and implementation details for developing custom Divi extensions with modules.

## Project Structure

```
your-extension/
├── modules/                         # PHP module classes
│   ├── Modules.php                  # Main modules loader
│   ├── module-name/                 # Individual module folder
│   │   ├── ModuleName.php           # Main module class
│   │   └── ModuleNameTrait/         # Module traits
│   │       ├── RenderCallbackTrait.php     # Frontend rendering
│   │       ├── ModuleClassnamesTrait.php   # CSS class handling
│   │       ├── ModuleStylesTrait.php       # Styling logic
│   │       ├── ModuleScriptDataTrait.php   # JS data handling
│   │       └── CustomCssTrait.php          # Custom CSS fields
│   └── modules-json/                # JSON configuration files
│       └── module-name/             # Module JSON folder
│           └── module.json          # Module configuration
├── src/                             # React components
│   ├── components/                  # Module components
│   │   └── module-name/             # Individual module component
│   │       ├── custom-css.ts        # Custom CSS fields
│   │       ├── edit.tsx             # Visual Builder edit component
│   │       ├── index.ts             # Module registration
│   │       ├── module-classnames.ts # CSS class generation
│   │       ├── module-script-data.tsx # Script data handling
│   │       ├── module.json          # Module configuration
│   │       ├── module.scss          # Module styles
│   │       ├── placeholder-content.ts # Default content
│   │       ├── styles.tsx           # Style components
│   │       └── types.tsx            # TypeScript interfaces
│   ├── icons/                       # Module icons
│   │   └── module-name/             # Individual module icon
│   │       └── index.tsx            # Icon component
│   ├── index.ts                     # Main entry point
│   ├── module-icons.ts              # Icon registration
│   └── types.ts                     # Global type definitions
├── scripts/                         # Compiled JavaScript
│   └── bundle.js                    # Compiled bundle
├── styles/                          # Compiled CSS
│   ├── bundle.css                   # Frontend styles
│   └── vb-bundle.css                # Visual Builder styles
└── your-plugin.php                  # Main plugin file
```

## Module Development Workflow

### 1. Define Module PHP Class

Create a PHP class for your module that implements the `DependencyInterface`:

```php
namespace MEE\Modules\YourModule;

use ET\Builder\Framework\DependencyManagement\Interfaces\DependencyInterface;
use ET\Builder\Packages\ModuleLibrary\ModuleRegistration;

class YourModule implements DependencyInterface {
    use YourModuleTrait\RenderCallbackTrait;
    use YourModuleTrait\ModuleClassnamesTrait;
    use YourModuleTrait\ModuleStylesTrait;
    use YourModuleTrait\ModuleScriptDataTrait;
    
    public function load() {
        $module_json_folder_path = MEDITA_ADDONS_MODULES_JSON_PATH . 'your-module/';
        add_action(
            'init',
            function() use ($module_json_folder_path) {
                ModuleRegistration::register_module(
                    $module_json_folder_path,
                    [
                        'render_callback' => [YourModule::class, 'render_callback'],
                    ]
                );
            }
        );
    }
}
```

### 2. Implement RenderCallbackTrait

The `RenderCallbackTrait` handles the frontend rendering of your module:

```php
namespace MEE\Modules\YourModule\YourModuleTrait;

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

use ET\Builder\Packages\Module\Module;
use ET\Builder\Framework\Utility\HTMLUtility;
use ET\Builder\FrontEnd\BlockParser\BlockParserStore;
use ET\Builder\Packages\Module\Options\Element\ElementComponents;
use MEE\Modules\YourModule\YourModule;

trait RenderCallbackTrait {
    public static function render_callback($attrs, $content, $block, $elements) {
        // Build your HTML here
        $html = HTMLUtility::render([
            'tag' => 'div',
            'attributes' => [
                'class' => 'your_module__inner',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => 'Your module content',
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
            'classnamesFunction' => [YourModule::class, 'module_classnames'],
            'stylesComponent' => [YourModule::class, 'module_styles'],
            'scriptDataComponent' => [YourModule::class, 'module_script_data'],
            'parentAttrs' => $parent_attrs,
            'parentId' => $parent->id ?? '',
            'parentName' => $parent->blockName ?? '',
            'children' => [
                ElementComponents::component([
                    'attrs' => $attrs['module']['decoration'] ?? [],
                    'id' => $block->parsed_block['id'],
                    'orderIndex' => $block->parsed_block['orderIndex'],
                    'storeInstance' => $block->parsed_block['storeInstance'],
                ]),
                $html,
            ],
        ]);
    }
}
```

### 3. Implement ModuleStylesTrait

The `ModuleStylesTrait` handles styling for your module:

```php
namespace MEE\Modules\YourModule\YourModuleTrait;

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

use ET\Builder\FrontEnd\Module\Style;
use ET\Builder\Packages\Module\Options\Text\TextStyle;
use ET\Builder\Packages\Module\Options\Css\CssStyle;
use MEE\Modules\YourModule\YourModule;

trait ModuleStylesTrait {
    use CustomCssTrait;
    
    public static function module_styles($args) {
        $attrs = $args['attrs'] ?? [];
        $elements = $args['elements'];
        $settings = $args['settings'] ?? [];
        
        Style::add([
            'id' => $args['id'],
            'name' => $args['name'],
            'orderIndex' => $args['orderIndex'],
            'storeInstance' => $args['storeInstance'],
            'styles' => [
                // Module styling
                $elements->style([
                    'attrName' => 'module',
                    'styleProps' => [
                        'disabledOn' => [
                            'disabledModuleVisibility' => $settings['disabledModuleVisibility'] ?? null,
                        ],
                        'advancedStyles' => [
                            [
                                'componentName' => "divi/text",
                                'props' => [
                                    'selector' => "{$args['orderClass']} .your_module__inner",
                                    'attr' => $attrs['module']['advanced']['text'] ?? [],
                                ]
                            ]
                        ]
                    ],
                ]),
                
                // Custom CSS
                CssStyle::style([
                    'selector' => $args['orderClass'],
                    'attr' => $attrs['css'] ?? [],
                    'cssFields' => YourModule::custom_css(),
                ])
            ],
        ]);
    }
}
```

### 4. Implement ModuleScriptDataTrait

The `ModuleScriptDataTrait` handles JavaScript data for your module:

```php
namespace MEE\Modules\YourModule\YourModuleTrait;

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

use ET\Builder\Packages\Module\Layout\Components\MultiView\MultiViewScriptData;
use ET\Builder\Packages\Module\Options\Element\ElementScriptData;

trait ModuleScriptDataTrait {
    public static function module_script_data($args) {
        // Get basic module variables
        $id = $args['id'] ?? '';
        $name = $args['name'] ?? '';
        $selector = $args['selector'] ?? '';
        $attrs = $args['attrs'] ?? [];
        $store_instance = $args['storeInstance'] ?? null;
        
        // Module decoration attributes
        $module_decoration_attrs = $attrs['module']['decoration'] ?? [];
        
        // Basic module behavior
        ElementScriptData::set([
            'id' => $id,
            'selector' => $selector,
            'attrs' => array_merge(
                $module_decoration_attrs,
                [
                    'link' => $attrs['module']['advanced']['link'] ?? [],
                ]
            ),
            'storeInstance' => $store_instance,
        ]);
        
        // Dynamic content
        MultiViewScriptData::set([
            'id' => $id,
            'name' => $name,
            'hoverSelector' => $selector,
            
            // Dynamic content
            'setContent' => [
                [
                    'selector' => "{$selector} .your_module__content",
                    'data' => [
                        'desktop' => [
                            'value' => 'Dynamic content value',
                        ],
                    ],
                ],
            ],
            
            // Dynamic attributes
            'setAttrs' => [
                [
                    'selector' => "{$selector} .your_module__link",
                    'data' => [
                        'href' => [
                            'desktop' => [
                                'value' => '#',
                            ],
                        ],
                    ],
                    'tag' => 'a',
                ],
            ],
        ]);
    }
}
```

### 5. Implement ModuleClassnamesTrait

The `ModuleClassnamesTrait` handles CSS classnames for your module:

```php
namespace MEE\Modules\YourModule\YourModuleTrait;

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

use ET\Builder\Packages\Module\Options\Text\TextClassnames;

trait ModuleClassnamesTrait {
    public static function module_classnames($args) {
        $classnames_instance = $args['classnamesInstance'];
        $attrs = $args['attrs'];
        
        // Add text options classnames
        $text_options_classnames = TextClassnames::text_options_classnames($attrs['module']['advanced']['text'] ?? []);
        
        if ($text_options_classnames) {
            $classnames_instance->add($text_options_classnames, true);
        }
    }
}
```

### 6. Implement CustomCssTrait

The `CustomCssTrait` defines custom CSS fields for your module:

```php
namespace MEE\Modules\YourModule\YourModuleTrait;

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

trait CustomCssTrait {
    public static function custom_css() {
        return \WP_Block_Type_Registry::get_instance()->get_registered('your-namespace/your-module')->customCssFields;
    }
}
```

### 7. Create module.json

Create a module.json file with your module configuration:

```json
{
  "name": "your-namespace/your-module",
  "title": "Your Module",
  "titles": "Your Modules",
  "moduleIcon": "your-namespace/module-your",
  "moduleClassName": "your_module",
  "moduleOrderClassName": "your_module",
  "category": "module",
  "attributes": {
    "module": {
      "type": "object",
      "selector": "{{selector}}",
      "default": {
        "meta": {
          "adminLabel": {
            "desktop": {
              "value": "Your Module"
            }
          }
        }
      },
      "settings": {
        "meta": {
          "adminLabel": {}
        },
        "advanced": {
          "link": {},
          "text": {},
          "htmlAttributes": {}
        },
        "decoration": {
          "background": {},
          "sizing": {},
          "spacing": {},
          "border": {},
          "boxShadow": {},
          "filters": {},
          "transform": {},
          "animation": {},
          "overflow": {},
          "disabledOn": {},
          "transition": {},
          "position": {},
          "zIndex": {},
          "scroll": {},
          "sticky": {}
        }
      }
    },
    "yourField": {
      "type": "object",
      "selector": "{{selector}} .your_module__field",
      "default": {
        "value": {
          "desktop": {
            "value": "Default value"
          }
        }
      },
      "settings": {
        "innerContent": {
          "groupType": "group-items",
          "items": {
            "value": {
              "groupSlug": "contentSettings",
              "priority": 10,
              "render": true,
              "attrName": "yourField.value",
              "label": "Your Field Label",
              "description": "Description of your field",
              "features": {
                "sticky": false,
                "dynamicContent": false
              },
              "component": {
                "name": "divi/text",
                "type": "field",
                "props": {
                  "defaultValue": "Default value"
                }
              }
            }
          }
        }
      }
    }
  },
  "customCssFields": {
    "container": {
      "subName": "container",
      "selectorSuffix": " .your_module__inner"
    },
    "content": {
      "subName": "content",
      "selectorSuffix": " .your_module__content"
    }
  },
  "settings": {
    "content": "auto",
    "design": "auto",
    "advanced": "auto",
    "groups": {
      "contentSettings": {
        "panel": "content",
        "priority": 10,
        "groupName": "contentSettings",
        "multiElements": true,
        "component": {
          "name": "divi/composite",
          "props": {
            "groupLabel": "Content Settings"
          }
        }
      }
    }
  }
}
```

### 8. Create React Component Files

#### a. types.tsx

```typescript
import { ModuleEditProps } from '@divi/module-library';
import {
  FormatBreakpointStateAttr,
  InternalAttrs,
  type Element,
  type Module,
} from '@divi/types';

export interface YourModuleCssAttr extends Module.Css.AttributeValue {
  container?: string;
  content?: string;
}

export type YourModuleCssGroupAttr = FormatBreakpointStateAttr<YourModuleCssAttr>;

export interface StringValue {
  value: string;
}

export interface YourModuleAttrs extends InternalAttrs {
  // CSS options
  css?: YourModuleCssGroupAttr;
  
  // Module
  module?: {
    meta?: Element.Meta.Attributes;
    advanced?: {
      link?: Element.Advanced.Link.Attributes;
      htmlAttributes?: Element.Advanced.IdClasses.Attributes;
      text?: Element.Advanced.Text.Attributes;
    };
    decoration?: Element.Decoration.PickedAttributes<
      'animation' |
      'background' |
      'border' |
      'boxShadow' |
      'disabledOn' |
      'filters' |
      'overflow' |
      'position' |
      'scroll' |
      'sizing' |
      'spacing' |
      'sticky' |
      'transform' |
      'transition' |
      'zIndex'
    >;
  };
  
  // Your custom fields
  yourField?: {
    value?: StringValue;
  };
}

export type YourModuleEditProps = ModuleEditProps<YourModuleAttrs>;
```

#### b. custom-css.ts

```typescript
import { __ } from '@wordpress/i18n';
import metadata from './module.json';

const customCssFields = metadata.customCssFields as Record<
  'container' | 'content',
  { subName: string, selector?: string, selectorSuffix: string, label: string }
>;

// Add translatable labels
customCssFields.container.label = __('Container', 'your-text-domain');
customCssFields.content.label = __('Content', 'your-text-domain');

export const cssFields = { ...customCssFields };
```

#### c. module-classnames.ts

```typescript
import { ModuleClassnamesParams, textOptionsClassnames } from '@divi/module';
import { YourModuleAttrs } from './types';

export const moduleClassnames = ({
  classnamesInstance,
  attrs,
}: ModuleClassnamesParams<YourModuleAttrs>): void => {
  // Text Options
  const textOptionsClasses = textOptionsClassnames(attrs?.module?.advanced?.text);
  
  if (textOptionsClasses) {
    classnamesInstance.add(textOptionsClasses, true);
  }
};
```

#### d. module-script-data.tsx

```typescript
import React, {
  Fragment,
  ReactElement,
} from 'react';
import {
  ModuleScriptDataProps,
} from '@divi/module';
import { YourModuleAttrs } from './types';

export const ModuleScriptData = ({
  elements,
}: ModuleScriptDataProps<YourModuleAttrs>): ReactElement => (
  <Fragment>
    {elements.scriptData({
      attrName: 'module',
    })}
  </Fragment>
);
```

#### e. placeholder-content.ts

```typescript
import { placeholderContent as placeholder } from '@divi/module-utils';
import { YourModuleAttrs } from './types';

export const placeholderContent: YourModuleAttrs = {
  module: {
    meta: {
      adminLabel: {
        desktop: {
          value: 'Your Module',
        },
      }
    }
  },
  yourField: {
    value: {
      value: 'Default field value'
    }
  }
};
```

#### f. styles.tsx

```typescript
import React, { ReactElement } from 'react';
import {
  StyleContainer,
  StylesProps,
  CssStyle,
  TextStyle,
} from '@divi/module';
import { YourModuleAttrs } from './types';
import { cssFields } from './custom-css';

export const ModuleStyles = ({
  attrs,
  elements,
  settings,
  orderClass,
  mode,
  state,
  noStyleTag,
}: StylesProps<YourModuleAttrs>): ReactElement => {
  const textSelector = `${orderClass} .your_module__inner`;
  
  return (
    <StyleContainer mode={mode} state={state} noStyleTag={noStyleTag}>
      {/* Module */}
      {elements.style({
        attrName: 'module',
        styleProps: {
          disabledOn: {
            disabledModuleVisibility: settings?.disabledModuleVisibility,
          },
          advancedStyles: [
            {
              componentName: "divi/text",
              props: {
                selector: textSelector,
                attr: attrs?.module?.advanced?.text,
              }
            }
          ]
        },
      })}
      
      {/* Your field styles */}
      {elements.style({
        attrName: 'yourField',
      })}
      
      {/* Custom CSS */}
      <CssStyle
        selector={orderClass}
        attr={attrs.css}
        cssFields={cssFields}
      />
    </StyleContainer>
  );
};
```

#### g. edit.tsx

```typescript
import React, { ReactElement } from 'react';
import { ModuleContainer } from '@divi/module';
import { YourModuleAttrs, YourModuleEditProps } from './types';
import { ModuleStyles } from './styles';
import { moduleClassnames } from './module-classnames';
import { ModuleScriptData } from './module-script-data';

export const YourModuleEdit = (props: YourModuleEditProps): ReactElement => {
  const {
    attrs,
    elements,
    id,
    name,
  } = props;
  
  const fieldValue = attrs?.yourField?.value?.value || 'Default value';
  
  return (
    <ModuleContainer
      attrs={attrs}
      elements={elements}
      id={id}
      name={name}
      stylesComponent={ModuleStyles}
      classnamesFunction={moduleClassnames}
      scriptDataComponent={ModuleScriptData}
    >
      {elements.styleComponents({
        attrName: 'module',
      })}
      <div className="your_module__inner">
        <div className="your_module__content">
          {fieldValue}
        </div>
      </div>
    </ModuleContainer>
  );
};
```

#### h. index.ts

```typescript
import {
  type Metadata,
  type ModuleLibrary,
} from '@divi/types';
import metadata from './module.json';
import { YourModuleEdit } from './edit';
import { YourModuleAttrs } from './types';
import { placeholderContent } from './placeholder-content';
import './style.scss';
import './module.scss';

export const yourModule: ModuleLibrary.Module.RegisterDefinition<YourModuleAttrs> = {
  metadata: metadata as Metadata.Values<YourModuleAttrs>,
  placeholderContent,
  renderers: {
    edit: YourModuleEdit,
  },
};
```

#### i. module.scss

```scss
// Module styles for both frontend and Visual Builder
.your_module {
  &__inner {
    padding: 20px;
    background-color: #f7f7f7;
  }
  
  &__content {
    font-size: 16px;
    line-height: 1.5;
  }
}
```

### 9. Create Module Icon

#### icons/module-your/index.tsx

```typescript
import React, { ReactElement } from 'react';

// Icon data
export const name = 'your-namespace/module-your'; // Matches moduleIcon in module.json
export const viewBox = '0 0 24 24';
export const component = (): ReactElement => (
  <path d="M3 3h18v18H3V3zm16 16V5H5v14h14z" />
);
```

### 10. Register Module and Icon

#### module-icons.ts

```typescript
import { addFilter } from '@wordpress/hooks';
import { moduleYour } from './icons/module-your';

addFilter('divi.iconLibrary.icon.map', 'your-namespace', (icons) => {
  return {
    ...icons,
    [moduleYour.name]: moduleYour,
  };
});
```

#### index.ts (main)

```typescript
import { omit } from 'lodash';
import { addAction } from '@wordpress/hooks';
import { registerModule } from '@divi/module-library';
import { yourModule } from './components/your-module';
import './module-icons';

// Register modules
addAction('divi.moduleLibrary.registerModuleLibraryStore.after', 'your-namespace', () => {
  registerModule(yourModule.metadata, omit(yourModule, 'metadata'));
});
```

#### types.ts (main)

```typescript
import {
  ModuleFlatObjectNamed,
  ModuleFlatObjects,
  type EditPost
} from '@divi/types';

export type ModuleFlatObjectItems = (
  ModuleFlatObjectNamed<'your-namespace/your-module'>
);

export type YourNamespaceModuleFlatObjects = ModuleFlatObjects<ModuleFlatObjectItems>;
export type YourNamespaceMutableEditPostStoreState = EditPost.Store.State<YourNamespaceModuleFlatObjects>;
export type YourNamespaceEditPostStoreState = EditPost.Store.ImmutableState<YourNamespaceModuleFlatObjects>;
```

## Common Module Attribute Types

### Text Field

```json
"textField": {
  "type": "object",
  "default": {
    "value": {
      "desktop": {
        "value": "Default text"
      }
    }
  },
  "settings": {
    "innerContent": {
      "groupType": "group-items",
      "items": {
        "value": {
          "groupSlug": "contentSettings",
          "priority": 10,
          "render": true,
          "attrName": "textField.value",
          "label": "Text Field",
          "description": "Enter text here",
          "component": {
            "name": "divi/text",
            "type": "field",
            "props": {
              "defaultValue": "Default text"
            }
          }
        }
      }
    }
  }
}
```

### Rich Text Field

```json
"richTextField": {
  "type": "object",
  "default": {
    "value": {
      "desktop": {
        "value": "<p>Default rich text</p>"
      }
    }
  },
  "settings": {
    "innerContent": {
      "groupType": "group-items",
      "items": {
        "value": {
          "groupSlug": "contentSettings",
          "priority": 10,
          "render": true,
          "attrName": "richTextField.value",
          "label": "Rich Text Field",
          "description": "Enter formatted text here",
          "component": {
            "name": "divi/richtext",
            "type": "field",
            "props": {
              "defaultValue": "<p>Default rich text</p>"
            }
          }
        }
      }
    }
  }
}
```

### Select Field

```json
"selectField": {
  "type": "object",
  "default": {
    "value": {
      "desktop": {
        "value": "option1"
      }
    }
  },
  "settings": {
    "innerContent": {
      "groupType": "group-items",
      "items": {
        "value": {
          "groupSlug": "contentSettings",
          "priority": 10,
          "render": true,
          "attrName": "selectField.value",
          "label": "Select Field",
          "description": "Choose an option",
          "component": {
            "name": "divi/select",
            "type": "field",
            "props": {
              "defaultValue": "option1",
              "options": [
                { "value": "option1", "label": "Option 1" },
                { "value": "option2", "label": "Option 2" },
                { "value": "option3", "label": "Option 3" }
              ]
            }
          }
        }
      }
    }
  }
}
```

### Toggle Field

```json
"toggleField": {
  "type": "object",
  "default": {
    "value": {
      "desktop": {
        "value": true
      }
    }
  },
  "settings": {
    "innerContent": {
      "groupType": "group-items",
      "items": {
        "value": {
          "groupSlug": "contentSettings",
          "priority": 10,
          "render": true,
          "attrName": "toggleField.value",
          "label": "Toggle Field",
          "description": "Toggle this option",
          "component": {
            "name": "divi/toggle",
            "type": "field",
            "props": {
              "defaultValue": true
            }
          }
        }
      }
    }
  }
}
```

### Upload Field

```json
"uploadField": {
  "type": "object",
  "default": {
    "value": {
      "desktop": {
        "value": ""
      }
    }
  },
  "settings": {
    "innerContent": {
      "groupType": "group-items",
      "items": {
        "value": {
          "groupSlug": "contentSettings",
          "priority": 10,
          "render": true,
          "attrName": "uploadField.value",
          "label": "Upload Field",
          "description": "Upload a file",
          "component": {
            "name": "divi/upload",
            "type": "field",
            "props": {
              "defaultValue": ""
            }
          }
        }
      }
    }
  }
}
```

## Best Practices

### 1. Namespace Consistency

Always use the same namespace for all your module files:
- PHP namespace (e.g., `MEE\Modules\YourModule`)
- Module name in module.json (e.g., `medita/your-module`)
- Module icon name (e.g., `medita/module-your`)
- Hook namespace in JS files (e.g., `'medita'`)

### 2. Field Structure

Always follow this structure for field definitions:
- Include default values
- Use the innerContent pattern
- Add attrName properties to connect fields to attributes
- Include groupSlug properties to organize fields
- Use defaultValue props in components

### 3. CSS Naming Conventions

Use consistent class naming:
- Module class prefix (e.g., `medita_your_module`)
- BEM-style element naming (e.g., `medita_your_module__element`)
- BEM-style modifier naming (e.g., `medita_your_module__element--modifier`)

### 4. Module Registration

Register modules in the correct order:
- Import modules at the top of the file
- Register icons first
- Register modules after icons
- Add module types to types.ts

### 5. Error Handling

Add proper error handling in your PHP code:
- Check for null values with null coalescing operator (`??`)
- Handle missing parent contexts
- Validate dynamic data before rendering

### 6. Performance Considerations

Optimize for performance:
- Minimize database queries
- Use caching for expensive operations
- Enqueue scripts and styles only when needed
- Use conditional loading based on module presence

## Troubleshooting

### Field Values Not Saving

If field values don't save or appear:

1. **Check Field Structure**: Ensure your field has the proper structure with innerContent
2. **Verify attrName**: Make sure attrName matches the attribute path correctly
3. **Check defaultValue**: Ensure defaultValue is provided for the field
4. **Inspect Frontend HTML**: Check if attributes are being properly rendered in HTML

### Styling Issues

If your module styling doesn't work:

1. **Check Selectors**: Ensure CSS selectors match the HTML structure
2. **Verify Style Functions**: Make sure module_styles is correctly implemented
3. **Inspect CSS Output**: Use browser developer tools to see what CSS is actually generated
4. **Check Custom CSS Fields**: Ensure custom CSS fields are properly defined

## Advanced Techniques

### 1. Dynamic Data Loading

To load dynamic data from WordPress:

```php
// In RenderCallbackTrait
public static function render_callback($attrs, $content, $block, $elements) {
    // Get module attributes
    $module = new Module($attrs, $content, $block);
    $post_type = $module->get_attribute('post_type', 'post');
    $posts_per_page = $module->get_attribute('posts_per_page', 5);
    
    // Fetch data
    $posts = get_posts([
        'post_type' => $post_type,
        'posts_per_page' => $posts_per_page,
    ]);
    
    // Build HTML for posts
    $posts_html = '';
    foreach ($posts as $post) {
        $posts_html .= HTMLUtility::render([
            'tag' => 'div',
            'attributes' => [
                'class' => 'your_module__post',
            ],
            'childrenSanitizer' => 'et_core_esc_previously',
            'children' => HTMLUtility::tag('h3', [], $post->post_title) . 
                          HTMLUtility::tag('div', ['class' => 'excerpt'], get_the_excerpt($post->ID)),
        ]);
    }
    
    // Main module HTML
    $html = HTMLUtility::render([
        'tag' => 'div',
        'attributes' => [
            'class' => 'your_module__inner',
        ],
        'childrenSanitizer' => 'et_core_esc_previously',
        'children' => $posts_html,
    ]);
    
    // Return rendered module
    return Module::render([
        // Module rendering parameters...
        'children' => [
            ElementComponents::component([
                'attrs' => $attrs['module']['decoration'] ?? [],
                'id' => $block->parsed_block['id'],
                'orderIndex' => $block->parsed_block['orderIndex'],
                'storeInstance' => $block->parsed_block['storeInstance'],
            ]),
            $html,
        ],
    ]);
}
```

### 2. Conditional Content

To show content conditionally based on settings:

```tsx
// In edit.tsx
export const YourModuleEdit = (props: YourModuleEditProps): ReactElement => {
  const {
    attrs,
    elements,
    id,
    name,
  } = props;
  
  const showFeature = attrs?.toggleField?.value?.value || false;
  
  return (
    <ModuleContainer
      attrs={attrs}
      elements={elements}
      id={id}
      name={name}
      stylesComponent={ModuleStyles}
      classnamesFunction={moduleClassnames}
      scriptDataComponent={ModuleScriptData}
    >
      {elements.styleComponents({
        attrName: 'module',
      })}
      <div className="your_module__inner">
        {/* Always show this content */}
        <div className="your_module__content">
          Main content
        </div>
        
        {/* Conditionally show this content */}
        {showFeature && (
          <div className="your_module__feature">
            Optional feature content
          </div>
        )}
      </div>
    </ModuleContainer>
  );
};
```

### 3. Custom REST API Endpoints

To add custom REST API endpoints for dynamic data:

```php
// In your module class
public function load() {
    $module_json_folder_path = MEDITA_ADDONS_MODULES_JSON_PATH . 'your-module/';
    
    add_action(
        'init',
        function() use ($module_json_folder_path) {
            ModuleRegistration::register_module(
                $module_json_folder_path,
                [
                    'render_callback' => [YourModule::class, 'render_callback'],
                ]
            );
        }
    );
    
    // Register REST API endpoint
    add_action('rest_api_init', function() {
        register_rest_route('your-module/v1', '/data', [
            'methods' => 'GET',
            'callback' => [YourModule::class, 'get_data'],
            'permission_callback' => function() {
                return current_user_can('edit_posts');
            }
        ]);
    });
}

// REST API endpoint callback
public static function get_data($request) {
    $param = $request->get_param('param') ?? '';
    
    // Process data
    $data = [
        'items' => [/* your data */],
        'param' => $param
    ];
    
    return rest_ensure_response($data);
}
```

### 4. Advanced Mega Menu with AJAX Loading

For more complex features like a mega menu with AJAX loading:

```php
// In RenderCallbackTrait
public static function render_callback($attrs, $content, $block, $elements) {
    // Generate HTML structure
    $menu_html = self::generate_menu_html($attrs);
    
    // Add JavaScript for AJAX loading
    $script = "
        document.addEventListener('DOMContentLoaded', function() {
            const megaMenuTriggers = document.querySelectorAll('.mega-menu-trigger');
            
            megaMenuTriggers.forEach(trigger => {
                trigger.addEventListener('mouseenter', function() {
                    const menuId = this.dataset.menuId;
                    const megaMenu = this.querySelector('.mega-menu');
                    
                    if (!megaMenu.dataset.loaded) {
                        fetch('/wp-json/your-module/v1/menu-items?menu_id=' + menuId)
                            .then(response => response.json())
                            .then(data => {
                                // Populate mega menu with data
                                let menuHtml = '';
                                data.items.forEach(item => {
                                    menuHtml += `<div class='mega-menu-item'>${item.title}</div>`;
                                });
                                megaMenu.innerHTML = menuHtml;
                                megaMenu.dataset.loaded = 'true';
                            });
                    }
                });
            });
        });
    ";
    
    $script_tag = HTMLUtility::render([
        'tag' => 'script',
        'childrenSanitizer' => 'et_core_esc_previously',
        'children' => $script,
    ]);
    
    // Return rendered module
    return Module::render([
        // Module rendering parameters...
        'children' => [
            ElementComponents::component([
                'attrs' => $attrs['module']['decoration'] ?? [],
                'id' => $block->parsed_block['id'],
                'orderIndex' => $block->parsed_block['orderIndex'],
                'storeInstance' => $block->parsed_block['storeInstance'],
            ]),
            $menu_html,
            $script_tag,
        ],
    ]);
}
```

## Working with Different Module Types

### 1. Parent Module

For a parent module that can contain child modules:

```php
// In RenderCallbackTrait
public static function render_callback($attrs, $content, $block, $elements) {
    // Parse inner blocks (child modules)
    $inner_blocks = BlockParserStore::get_inner_blocks($block);
    $inner_content = '';
    
    // Render all child blocks
    foreach ($inner_blocks as $inner_block) {
        $inner_content .= render_block($inner_block);
    }
    
    // Container HTML
    $container_html = HTMLUtility::render([
        'tag' => 'div',
        'attributes' => [
            'class' => 'your_parent_module__container',
        ],
        'childrenSanitizer' => 'et_core_esc_previously',
        'children' => $inner_content,
    ]);
    
    // Return rendered module
    return Module::render([
        // Module rendering parameters...
        'children' => [
            ElementComponents::component([
                'attrs' => $attrs['module']['decoration'] ?? [],
                'id' => $block->parsed_block['id'],
                'orderIndex' => $block->parsed_block['orderIndex'],
                'storeInstance' => $block->parsed_block['storeInstance'],
            ]),
            $container_html,
        ],
    ]);
}
```

### 2. Child Module

For a child module that must be used inside a parent:

```php
// In module.json
{
  "name": "your-namespace/your-child-module",
  "title": "Your Child Module",
  "titles": "Your Child Modules",
  "moduleIcon": "your-namespace/module-your-child",
  "moduleClassName": "your_child_module",
  "moduleOrderClassName": "your_child_module",
  "category": "module",
  "allowedParentModules": ["your-namespace/your-parent-module"],
  // Other module properties...
}
```

The child module's RenderCallbackTrait would access the parent context:

```php
// In Child RenderCallbackTrait
public static function render_callback($attrs, $content, $block, $elements) {
    // Get parent module
    $parent = BlockParserStore::get_parent($block->parsed_block['id'], $block->parsed_block['storeInstance']);
    $parent_attrs = $parent->attrs ?? [];
    
    // Use parent attributes if needed
    $parent_setting = $parent_attrs['some_setting'] ?? 'default';
    
    // Child module HTML
    $html = HTMLUtility::render([
        'tag' => 'div',
        'attributes' => [
            'class' => 'your_child_module__content',
            'data-parent-setting' => $parent_setting,
        ],
        'childrenSanitizer' => 'et_core_esc_previously',
        'children' => 'Child content',
    ]);
    
    // Return rendered module
    return Module::render([
        // Module rendering parameters...
        'parentAttrs' => $parent_attrs,
        'parentId' => $parent->id ?? '',
        'parentName' => $parent->blockName ?? '',
        'children' => [
            ElementComponents::component([
                'attrs' => $attrs['module']['decoration'] ?? [],
                'id' => $block->parsed_block['id'],
                'orderIndex' => $block->parsed_block['orderIndex'],
                'storeInstance' => $block->parsed_block['storeInstance'],
            ]),
            $html,
        ],
    ]);
}
```

## Integration with Third-Party Services

### WooCommerce Integration

To integrate with WooCommerce:

```php
// In RenderCallbackTrait
public static function render_callback($attrs, $content, $block, $elements) {
    // Check if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        return '<div class="wc-error">WooCommerce is not active.</div>';
    }
    
    // Get product data
    $product_id = $attrs['product_id'] ?? 0;
    $product = wc_get_product($product_id);
    
    if (!$product) {
        return '<div class="wc-error">Product not found.</div>';
    }
    
    // Build product HTML
    $product_html = HTMLUtility::render([
        'tag' => 'div',
        'attributes' => [
            'class' => 'your_module__product',
        ],
        'childrenSanitizer' => 'et_core_esc_previously',
        'children' => 
            HTMLUtility::tag('h3', [], $product->get_name()) .
            HTMLUtility::tag('div', ['class' => 'price'], $product->get_price_html()) .
            HTMLUtility::tag('div', ['class' => 'description'], $product->get_short_description()) .
            '<a href="' . esc_url($product->add_to_cart_url()) . '" class="button">Add to Cart</a>',
    ]);
    
    // Return rendered module
    return Module::render([
        // Module rendering parameters...
        'children' => [
            ElementComponents::component([
                'attrs' => $attrs['module']['decoration'] ?? [],
                'id' => $block->parsed_block['id'],
                'orderIndex' => $block->parsed_block['orderIndex'],
                'storeInstance' => $block->parsed_block['storeInstance'],
            ]),
            $product_html,
        ],
    ]);
}
```

### Integration with Custom Post Types

For custom post type integration:

```php
// Register custom post type
function register_custom_post_type() {
    register_post_type('your_cpt', [
        'labels' => [
            'name' => 'Your CPT',
            'singular_name' => 'Your CPT',
        ],
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'register_custom_post_type');

// In RenderCallbackTrait
public static function render_callback($attrs, $content, $block, $elements) {
    // Get custom post type items
    $args = [
        'post_type' => 'your_cpt',
        'posts_per_page' => $attrs['posts_per_page'] ?? 5,
    ];
    
    $query = new \WP_Query($args);
    $items_html = '';
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            
            $items_html .= HTMLUtility::render([
                'tag' => 'div',
                'attributes' => [
                    'class' => 'your_module__cpt-item',
                ],
                'childrenSanitizer' => 'et_core_esc_previously',
                'children' => 
                    HTMLUtility::tag('h3', [], get_the_title()) .
                    HTMLUtility::tag('div', ['class' => 'excerpt'], get_the_excerpt()) .
                    '<a href="' . esc_url(get_permalink()) . '" class="read-more">Read More</a>',
            ]);
        }
        
        wp_reset_postdata();
    } else {
        $items_html = '<p>No items found.</p>';
    }
    
    // Return rendered module
    return Module::render([
        // Module rendering parameters...
        'children' => [
            ElementComponents::component([
                'attrs' => $attrs['module']['decoration'] ?? [],
                'id' => $block->parsed_block['id'],
                'orderIndex' => $block->parsed_block['orderIndex'],
                'storeInstance' => $block->parsed_block['storeInstance'],
            ]),
            HTMLUtility::render([
                'tag' => 'div',
                'attributes' => [
                    'class' => 'your_module__cpt-container',
                ],
                'childrenSanitizer' => 'et_core_esc_previously',
                'children' => $items_html,
            ]),
        ],
    ]);
}
```

## Performance Optimization

### 1. Caching

Implement caching for expensive operations:

```php
public static function render_callback($attrs, $content, $block, $elements) {
    // Generate a cache key based on attributes
    $cache_key = 'your_module_' . md5(serialize($attrs));
    
    // Try to get cached HTML
    $cached_html = get_transient($cache_key);
    
    if ($cached_html !== false) {
        // Return cached HTML
        return $cached_html;
    }
    
    // Generate HTML if not cached
    $html = ''; // Your HTML generation logic
    
    // Cache the HTML for 1 hour
    set_transient($cache_key, $html, HOUR_IN_SECONDS);
    
    return $html;
}
```

### 2. Selective Enqueuing

Only load scripts and styles when your module is present:

```php
// In your main plugin file
function check_for_module_on_page() {
    if (is_singular()) {
        $post = get_post();
        
        // Check if post content contains your module
        if ($post && has_block('your-namespace/your-module', $post->post_content)) {
            // Enqueue only when module is used
            wp_enqueue_script('your-module-script', plugin_dir_url(__FILE__) . 'js/your-module.js', [], '1.0.0', true);
            wp_enqueue_style('your-module-style', plugin_dir_url(__FILE__) . 'css/your-module.css', [], '1.0.0');
        }
    }
}
add_action('wp_enqueue_scripts', 'check_for_module_on_page');
```

## Localization

### 1. Text Domain Setup

Set up your text domain in the main plugin file:

```php
function load_textdomain() {
    load_plugin_textdomain('your-text-domain', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'load_textdomain');
```

### 2. Translatable Strings

Use translation functions in PHP:

```php
$label = __('Your Label', 'your-text-domain');
$formatted = sprintf(__('Hello, %s', 'your-text-domain'), $name);
```

Use translation functions in JavaScript:

```typescript
import { __ } from '@wordpress/i18n';

const label = __('Your Label', 'your-text-domain');
```

### 3. Translation Files

Generate POT file using WP-CLI:

```bash
wp i18n make-pot . languages/your-text-domain.pot --domain=your-text-domain
```

## Deployment and Distribution

### 1. Build Process

Set up a build process for your extension:

1. Install dependencies:
```bash
npm install
```

2. Build for development:
```bash
npm run dev
```

3. Build for production:
```bash
npm run build
```

### 2. Version Control

Structure your version control properly:

```
.gitignore
├── node_modules/
├── scripts/bundle.js
└── styles/bundle.css
```

### 3. Documentation

Include thorough documentation:

1. README.md with installation and usage instructions
2. Inline code documentation
3. Example configurations
4. Troubleshooting guide

## Security Best Practices

### 1. Input Validation

Always validate user input:

```php
// Sanitize text inputs
$text = sanitize_text_field($attrs['text'] ?? '');

// Validate numeric inputs
$number = absint($attrs['number'] ?? 0);

// Validate URLs
$url = esc_url_raw($attrs['url'] ?? '');

// Validate HTML content
$html = wp_kses_post($attrs['html'] ?? '');
```

### 2. Output Escaping

Always escape output:

```php
// Escape HTML attributes
echo 'class="' . esc_attr($class) . '"';

// Escape URLs
echo 'href="' . esc_url($url) . '"';

// Escape HTML content
echo wp_kses_post($content);
```

### 3. Capability Checks

Check user capabilities before executing privileged actions:

```php
if (!current_user_can('edit_posts')) {
    return new \WP_Error('forbidden', __('You do not have permission to access this resource.', 'your-text-domain'), ['status' => 403]);
}
```

## Testing

### 1. Manual Testing

Checklist for manual testing:

- Test in both Visual Builder and frontend
- Test with different content configurations
- Test responsive behavior (desktop, tablet, phone)
- Test with different themes
- Test with other plugins activated
- Test with different WordPress versions

### 2. Automated Testing

Set up PHPUnit for testing PHP code:

```php
class YourModuleTest extends \WP_UnitTestCase {
    public function test_render_callback() {
        // Set up test data
        $attrs = [/* test attributes */];
        $content = '';
        $block = $this->createMock('\WP_Block');
        $elements = $this->createMock('\ET\Builder\Packages\Module\Layout\Components\ModuleElements\ModuleElements');
        
        // Call the method
        $html = \MEE\Modules\YourModule\YourModuleTrait\RenderCallbackTrait::render_callback($attrs, $content, $block, $elements);
        
        // Assert the result
        $this->assertStringContainsString('your_module__inner', $html);
    }
}
```

Set up Jest for testing JavaScript code:

```javascript
// In your Jest test file
import { YourModuleEdit } from '../src/components/your-module/edit';

describe('YourModuleEdit', () => {
    it('renders correctly', () => {
        const props = {
            // Test props
        };
        
        const wrapper = shallow(<YourModuleEdit {...props} />);
        expect(wrapper.find('.your_module__inner').exists()).toBe(true);
    });
});
```

## Conclusion

Building custom Divi extension modules requires understanding both the PHP backend and React frontend components of the Divi framework. By following this guide, you can create powerful, customizable modules that integrate seamlessly with the Divi Builder.

Remember to:
- Maintain consistent naming and structure
- Follow best practices for security and performance
- Test thoroughly before deployment
- Document your code and module usage

With these principles in mind, you can create professional-quality Divi extensions that enhance the capabilities of the Divi Builder and provide value to your users.