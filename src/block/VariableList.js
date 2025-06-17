import { useState, useEffect } from '@wordpress/element';
import { Button } from '@wordpress/components';
import { fetchVariables } from '../utils/api';

export default function VariableList({ onInsert }) {
  const [variables, setVariables] = useState([]);

  useEffect(() => {
    fetchVariables()
      .then((data) => {
        setVariables(data);
      })
      .catch((error) => {
        console.error('Failed to fetch variables:', error);
      });
  }, []);

  return (
    <div style={{ marginTop: '30px' }}>
      <h3 style={{ marginBottom: '10px' }}>Insert Variables</h3>
      <div
        style={{
          maxHeight: '220px', 
          overflowY: 'auto',
          border: '1px solid #ccc',
          padding: '10px',
          borderRadius: '4px',
          backgroundColor: '#fff',
        }}
      >
        {variables.map((v) => (
          <Button
            key={v.key}
            onClick={() => onInsert(v.key)}
            style={{
              textAlign: 'left',
              width: '100%',
              whiteSpace: 'normal',
              marginBottom: '6px',
            }}
          >
            <strong>{`{{${v.key}}}`}</strong> – {v.description}
          </Button>
        ))}
      </div>
    </div>
  );
}
