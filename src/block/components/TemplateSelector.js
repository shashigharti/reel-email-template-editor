import React from 'react';
import { TemplateNames } from './Templates';

const TemplateSelector = ({ selectedKey, onTemplateSelect }) => {
  return (
    <select
      value={selectedKey}
      onChange={(e) => onTemplateSelect(e.target.value)}
      style={{ padding: '8px', fontSize: '16px', marginBottom: '10px' }}
    >
      {Object.keys(TemplateNames).map((key) => (
        <option key={key} value={key}>
          {TemplateNames[key]}
        </option>
      ))}
    </select>
  );
};

export default TemplateSelector;
