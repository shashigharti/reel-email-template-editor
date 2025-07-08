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
    <div className="ceditor">
      <div className="ceditor__tabs">
        {['editor'].map((tab) => (
          <button
            key={tab}
            onClick={() => setActiveTab(tab)}
            className={`ceditor__tab ${activeTab === tab ? 'ceditor__tab--active' : ''}`}
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
              'sourceEditing',
            ],
            table: {
              contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells'],
            },
          }}
        />
      ) : (
        <textarea
          className="ceditor__textarea"
          value={content}
          onChange={handleHtmlChange}
        />
      )}
    </div>
  );
});

export default CEditor;
