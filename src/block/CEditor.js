import React, {
  useState,
  useEffect,
  useRef,
  forwardRef,
  useImperativeHandle,
} from 'react';
import { CKEditor } from '@ckeditor/ckeditor5-react';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

const CEditor = forwardRef(({ initialContent = '', onChange }, ref) => {
  const [content, setContent] = useState(initialContent);
  const [activeTab, setActiveTab] = useState('editor');
  const editorRef = useRef(null);

  useEffect(() => {
    setContent(initialContent);
  }, [initialContent]);

  useImperativeHandle(ref, () => ({
    insertVariable: (variable) => {
      const editor = editorRef.current;
      if (editor) {
        const viewFragment = editor.data.processor.toView(variable);
        const modelFragment = editor.data.toModel(viewFragment);
        editor.model.insertContent(modelFragment);
      }
    },
  }));

  const handleEditorReady = (editor) => {
    editorRef.current = editor;
  };

  const handleEditorChange = (event, editor) => {
    const data = editor.getData();
    setContent(data);
    onChange?.(data);
  };

  const handleHtmlChange = (e) => {
    const value = e.target.value;
    setContent(value);
    onChange?.(value);
  };

  return (
    <div>
      <div style={{ borderBottom: '1px solid #ccc', marginBottom: 10 }}>
        {['editor'].map((tab) => (
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
            Editor
          </button>
        ))}
      </div>

      {activeTab === 'editor' ? (
        <CKEditor
          editor={ClassicEditor}
          data={content}
          onReady={handleEditorReady}
          onChange={handleEditorChange}
          config={{
            toolbar: [
              'heading', '|',
              'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
              'insertTable', 'imageUpload', 'undo', 'redo', '|',
              'sourceEditing'
            ],
            table: {
              contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
            }
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
            marginBottom: '20px',
          }}
        />
      )}
    </div>
  );
});

export default CEditor;
