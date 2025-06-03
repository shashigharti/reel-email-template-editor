import { Button } from '@wordpress/components';

const defaultVariables = [
  { key: 'username', label: 'Username', description: 'The name of the user.' },
  { key: 'email', label: 'Email Address', description: 'The user\'s email address.' },
  { key: 'product_price', label: 'Product Price', description: 'The price of the product.' },
  { key: 'product_type', label: 'Product Type', description: 'The type or category of the product.' },
  { key: 'seller_name', label: 'Seller Name', description: 'The name of the product seller.' },
  { key: 'seller_location', label: 'Seller Location', description: 'The location of the product seller.' },
];

export default function VariableList({ onInsert, variables = defaultVariables }) {
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
