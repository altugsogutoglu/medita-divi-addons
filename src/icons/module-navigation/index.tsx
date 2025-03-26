import React, { ReactElement } from 'react';

// Icon data.
export const name      = 'example/module-navigation';
export const viewBox   = '0 0 24 24';
export const component = (): ReactElement => (
  <>
    <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
    <path d="M4 6h16v4H4z" />
    <path d="M6 14h8v2H6z" />
    <path d="M6 18h5v-1H6z" />
  </>
);