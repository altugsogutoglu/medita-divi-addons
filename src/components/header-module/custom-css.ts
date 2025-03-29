// WordPress dependencies.
import { __ } from '@wordpress/i18n';
import metadata from './module.json';

const customCssFields = metadata.customCssFields as Record<
  'container' | 'logo' | 'navigation' | 'megaMenu' | 'actionButtons' | 
  'primaryButton' | 'profileLink' | 'cartLink' | 'mobileToggle' | 'mobileMenu',
  { subName: string, selector?: string, selectorSuffix: string, label: string }
>;

// Add translatable labels with your text domain
customCssFields.container.label = __('Header Container', 'medita-divi-addons');
customCssFields.logo.label = __('Logo', 'medita-divi-addons');
customCssFields.navigation.label = __('Navigation Menu', 'medita-divi-addons');
customCssFields.megaMenu.label = __('Mega Menu', 'medita-divi-addons');
customCssFields.actionButtons.label = __('Action Buttons Container', 'medita-divi-addons');
customCssFields.primaryButton.label = __('Primary Button', 'medita-divi-addons');
customCssFields.profileLink.label = __('Profile Link', 'medita-divi-addons');
customCssFields.cartLink.label = __('Cart Link', 'medita-divi-addons');
customCssFields.mobileToggle.label = __('Mobile Toggle', 'medita-divi-addons');
customCssFields.mobileMenu.label = __('Mobile Menu', 'medita-divi-addons');

export const cssFields = { ...customCssFields };