import React, { useState, useEffect } from 'react';
import ReactQuill from 'react-quill';
import 'react-quill/dist/quill.snow.css';

export default function QuillEditor({ initialContent = '', onChange }) {
  const [content, setContent] = useState(initialContent);
  const [activeTab, setActiveTab] = useState('editor');

  const handleEditorChange = (value) => {
    setContent(value);
    onChange?.(value);
  };

  const handleHtmlChange = (e) => {
    const value = e.target.value;
    setContent(value);
    onChange?.(value);
  };
  
  useEffect(() => {
    setContent(initialContent);
  }, [initialContent]);

  return (
    <div>
      <div style={{ borderBottom: '1px solid #ccc', marginBottom: 10 }}>
        {['editor', 'html'].map((tab) => (
          <button
            key={tab}
            onClick={() => setActiveTab(tab)}
            style={{
              padding: '10px 20px',
              marginRight: '2px',
              background: activeTab === tab ? '#fff' : '#f1f1f1',
              color: '#000',
              border: '1px solid #ccc',
              borderBottom: activeTab === tab ? 'none' : '1px solid #ccc',
              borderTopLeftRadius: '5px',
              borderTopRightRadius: '5px',
              cursor: 'pointer',
              fontWeight: activeTab === tab ? 'bold' : 'normal',
              position: 'relative',
              top: activeTab === tab ? '1px' : '0',
            }}
          >
            {tab === 'editor' ? 'Editor' : 'HTML'}
          </button>
        ))}
      </div>

      {activeTab === 'editor' ? (
        <ReactQuill
          theme="snow"
          value={content}
          onChange={handleEditorChange}
          placeholder="Enter template content here..."
          style={{
            minHeight: '300px',
            background: '#fff',
            borderRadius: '4px',
            border: '1px solid #ccc',
            marginBottom: '50px',
          }}
        />
      ) : (
        <textarea
          value={content}
          onChange={handleHtmlChange}
          style={{
            width: '100%',
            minHeight: '300px',
            borderRadius: '4px',
            border: '1px solid #ccc',
            fontFamily: 'monospace',
            fontSize: '14px',
            padding: '10px',
          }}
        />
      )}
    </div>
  );
}
