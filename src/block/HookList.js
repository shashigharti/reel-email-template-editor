import { useState } from 'react';

export default function HookList({ onAttach, selectedHookID, hooks = []}) {
  const handleAttach = (id) => {
    if (id) {
      onAttach(id);
      setSelectedID(id)
    }
  };

  return (
    <div style={{ marginTop: '30px' }}>
      <h3 style={{ marginBottom: '12px', fontSize: '16px' }}>Select Action</h3>
      <div
        style={{
          maxHeight: '220px',
          overflowY: 'auto',
          border: '1px solid #ddd',
          padding: '10px',
          borderRadius: '6px',
          backgroundColor: '#fff',
          marginBottom: '10px',
        }}
      >
        {hooks.map((hook) => (
          <label
            key={hooks.id}
            style={{
              display: 'block',
              padding: '8px',
              marginBottom: '6px',
              backgroundColor: selectedHookID === hook.id ? '#e0f7fa' : '#f9f9f9',
              border: '1px solid #ccc',
              borderRadius: '4px',
              cursor: 'pointer',
            }}
          >
            <input
              type="radio"
              name="action"
              value={hook.id}
              checked={selectedHookID === hook.id}
              onChange={(e) => handleAttach(e.target.value)}
              style={{ marginRight: '8px' }}
            />
            <strong>{hook.name}</strong>
          </label>
        ))}
      </div>
    </div>
  );
}
