import React from 'react';

export function Logo({ width = 200, height = 44 }) {
  return (
    <img
      src="/hotpatch_logo.svg"
      alt="HotPatch Logo"
      width={width}
      height={height}
      style={{ objectFit: 'contain' }}
    />
  );
}
