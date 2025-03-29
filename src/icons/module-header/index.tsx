import React, { ReactElement } from 'react';

// Icon data.
export const name = 'medita/module-header'; // Unique name matching module.json
export const viewBox = '0 0 24 24'; // Adjusted for a header icon
export const component = (): ReactElement => (
  <>
    {/* Simple header icon - horizontal bars */}
    <path d="M3 6h18M3 12h18M3 18h18" strokeWidth="2" strokeLinecap="round" />
  </>
);