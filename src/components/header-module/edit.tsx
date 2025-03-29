// External Dependencies.
import React, { ReactElement } from 'react';
import classnames from 'classnames';
// Divi Dependencies.
import { ModuleContainer } from '@divi/module';
// Local Dependencies.
import { HeaderModuleEditProps } from './types';
import { ModuleStyles } from './styles';
import { moduleClassnames } from './module-classnames';
import { ModuleScriptData } from './module-script-data';

/**
 * Header Module edit component of visual builder.
 *
 * @since 1.0.0
 *
 * @param {HeaderModuleEditProps} props React component props.
 *
 * @returns {ReactElement}
 */
export const HeaderModuleEdit = (props: HeaderModuleEditProps): ReactElement => {
  const {
    attrs,
    elements,
    id,
    name,
  } = props;

  // Get logo attributes
  const logoId = attrs?.logo?.image_id ?? '';
  const logoUrl = logoId ? `https://via.placeholder.com/200x80` : `https://via.placeholder.com/200x80`;
  
  // Get button attributes
  const showCta = attrs?.buttons?.show?.value ?? true;
  const ctaText = attrs?.buttons?.primary?.text?.value ?? 'Get Started';
  const ctaUrl = attrs?.buttons?.primary?.url?.value ?? '#';
  
  // Get menu attributes
  const menuLocation = attrs?.menu?.location?.value ?? 'primary-menu';
  
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
      <div className="header_inner">
        {/* Logo */}
        <div className="header_logo">
          <a href="#" className="header_logo_link">
            <img src={logoUrl} alt="Site Logo" className="header_logo_img" />
          </a>
        </div>
        
        {/* Navigation Menu */}
        <nav className="header_navigation header_desktop_nav">
          <ul className="header_menu">
            <li className="menu-item"><a href="#">Home</a></li>
            <li className="menu-item menu-item-has-children">
              <a href="#">Products</a>
              <div className="mega-menu">
                <div className="mega-menu-column">
                  <h4 className="column-title">Category 1</h4>
                  <ul>
                    <li><a href="#">Product 1.1</a></li>
                    <li><a href="#">Product 1.2</a></li>
                    <li><a href="#">Product 1.3</a></li>
                  </ul>
                </div>
                <div className="mega-menu-column">
                  <h4 className="column-title">Category 2</h4>
                  <ul>
                    <li><a href="#">Product 2.1</a></li>
                    <li><a href="#">Product 2.2</a></li>
                    <li><a href="#">Product 2.3</a></li>
                  </ul>
                </div>
              </div>
            </li>
            <li className="menu-item"><a href="#">About</a></li>
            <li className="menu-item"><a href="#">Contact</a></li>
          </ul>
        </nav>
        
        {/* Action Buttons */}
        <div className="header_actions">
          {/* CTA Button */}
          {showCta && (
            <a href={ctaUrl} className="header_button header_primary_button">
              {ctaText}
            </a>
          )}
          
          {/* Profile Link */}
          <a href="#" className="header_profile_link">
            <svg className="header_profile_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span className="header_user_text">Log In</span>
          </a>
          
          {/* Cart Link */}
          <a href="#" className="header_cart_link">
            <svg className="header_cart_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
              <circle cx="9" cy="21" r="1"></circle>
              <circle cx="20" cy="21" r="1"></circle>
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <span className="header_cart_count">0</span>
          </a>
        </div>
        
        {/* Mobile Toggle */}
        <button className="header_mobile_toggle" aria-expanded="false" aria-label="Toggle navigation menu">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
      
      {/* Mobile Menu (hidden by default) */}
      <nav className="header_mobile_menu">
        <ul className="header_mobile_menu_list">
          <li className="menu-item"><a href="#">Home</a></li>
          <li className="menu-item menu-item-has-children">
            <a href="#">Products <span className="submenu-toggle"></span></a>
            <ul className="sub-menu">
              <li><a href="#">Category 1</a></li>
              <li><a href="#">Category 2</a></li>
            </ul>
          </li>
          <li className="menu-item"><a href="#">About</a></li>
          <li className="menu-item"><a href="#">Contact</a></li>
        </ul>
      </nav>
    </ModuleContainer>
  );
};