import { useState, useEffect, useRef } from '@wordpress/element';
import {
  SelectControl,
  Button,
  Notice,
  TextControl,
} from '@wordpress/components';
import 'react-quill/dist/quill.snow.css';
import {
  fetchTemplates,
  fetchTemplateBySlug,
  saveTemplate,
  deleteTemplate,
  importTemplate,
} from '../utils/api';
import { generateSlug } from '../utils/common.js'; 
import VariableList from './VariableList';
import Menu from './Menu';
import QuillEditor from './QuillEditor';
import TestEmailSender from './TestEmail.js';

export default function Editor() {
  const [templates, setTemplates] = useState([]);
  const [selectedTemplateId, setSelectedTemplateId] = useState(null);
  const [content, setContent] = useState('');
  const [subject, setSubject] = useState('');
  const [isSaving, setIsSaving] = useState(false);
  const [notice, setNotice] = useState(null);
  const [selectedActions, setSelectedActions] = useState({});
  const [title, setTitle] = useState('');
  const [slug, setSlug] = useState('');
  const quillRef = useRef(null);

  const wordpressActions = [
    { key: 'publish_post', label: 'Post published' },
  ];

  const selectedTemplate = templates.find(t => t.id === selectedTemplateId);

  useEffect(() => {
    fetchTemplates()
      .then((data) => {
        setTemplates(data);

        if (data.length > 0) {
          setSelectedTemplateId(data[0].id);
        } else {
          setSelectedTemplateId('');
        }
      })
      .catch((err) => console.error('Error fetching templates:', err));
  }, []);

  useEffect(() => {
    if (selectedTemplateId == null) return;
    const selected = templates.find(t => t.id === selectedTemplateId);
    const slug = selected?.slug || 'default';
       

    fetchTemplateBySlug(slug)
      .then((template) => {
        setContent(template?.content || '');
        let title = template.title;
        let slug = template.slug;
        let subject = template.subject;

        if (template.slug === 'default') {
          title = `${title}-${templates.length + 1}`;
          slug = generateSlug(title);
        }
        setTitle(title);
        setSlug(slug);
        setSubject(subject);
      })
      .catch(() => {
        setContent('Failed to load template.');
      });
  }, [selectedTemplateId]);


  function onSave() {
    if (!selectedTemplate) return;

    setIsSaving(true);

    const payload = {
      title,
      slug,
      subject,
      content,
    };

    saveTemplate(selectedTemplate.id, payload)
      .then(() => {
        setNotice({ status: 'success', message: 'Template saved successfully!' });
      })
      .catch(() => {
        setNotice({ status: 'error', message: 'Failed to save template.' });
      })
      .finally(() => {
        setIsSaving(false);
        setTimeout(() => setNotice(null), 3000);
      });
  }

  function onDelete() {
    if (slug === 'default') return;
    
    if (confirm('Are you sure you want to delete this template?')) {
      deleteTemplate(selectedTemplateId)
        .then(() => {
          setTemplates(templates.filter(t => t.id !== selectedTemplateId));
          setSelectedTemplateId('');
          setNotice({ status: 'success', message: 'Template deleted successfully.' });
        })
        .catch(() => {
          setNotice({ status: 'error', message: 'Failed to delete template.' });
        }).finally(() => {
        setTimeout(() => setNotice(null), 3000);
      });
    }
  }

  function onImport(){
    importTemplate()
      .then(() => {
        setNotice({ status: 'success', message: 'Templates imported successfully!' });
        return fetchTemplates();
      })
      .then((data) => {
        setTemplates(data);
      })
      .catch(() => {
        setNotice({ status: 'error', message: 'Failed to import template.' });
      }).finally(() => {
        setTimeout(() => setNotice(null), 3000);
      });
  }

  function toggleAction(key) {
    setSelectedActions(prev => ({
      ...prev,
      [key]: !prev[key],
    }));
  }

  const onTitleChange = (newTitle) => {
    setTitle(newTitle);
    setSlug(generateSlug(newTitle));
  };

  return (
    <div className="reel-email-template-editor" style={{ display: 'flex', flexDirection: 'column', gap: '20px' }}>
      {notice && (
      <div style={{ marginBottom: '1rem' }}>
        <Notice
          status={notice.status}
        >
          {notice.message}
        </Notice>
      </div>
    )}

      <div style={{ display: 'flex', gap: '20px' }}>
        <div style={{ flex: 1 }}>      
          <div style={{ display: 'flex', flexDirection: 'row', gap: '20px' }}>
            <div style={{ width: '50%' }}>              
              <TextControl
                label="Title"
                value={title || ''}
                onChange={onTitleChange}
              />
              <TextControl
                label="Slug"
                value={slug || ''}
                onChange={() => {}}
                disabled
              />             
            </div>
            <div style={{ width: '50%' }}>
              <SelectControl
                label="Select Template"
                value={selectedTemplateId}
                options={[
                  { label: '-- Select a Template --', value: '', disabled: true },
                  ...templates.map((t) => ({ label: t.title, value: t.id }))
                ]}
                onChange={(val) => setSelectedTemplateId(val)}
              />
              <TextControl
                label="Subject"
                value={subject}
                onChange={(val) => setSubject(val)}
              />
            </div>
          </div>          
          <Menu onImport={onImport} onAddNew={() => {setSelectedTemplateId('')}}/>
          <QuillEditor
            initialContent={content}
            onChange={(value) => {
                setContent(value);
              }
            }
          />
          <div style={{ marginTop: '10px' }}>
            <div style={{ display: 'flex', gap: '10px' }}>
              <Button variant="primary" onClick={onSave} disabled={isSaving}>
                {isSaving ? 'Saving...' : 'Save Template'}
              </Button>

              <Button
                variant="primary"
                style={{
                  backgroundColor: '#dc3545',
                  borderColor: '#dc3545',
                  color: 'white',
                }}
                onClick={onDelete}
              >
                Delete Template
              </Button>
            </div>
          </div>
        </div>        
        <div style={{ width: '300px', borderLeft: '1px solid #ccc', paddingLeft: '15px' }}> 
          <VariableList
            onInsert={(variable) => {
              const quill = quillRef.current?.getEditor();
              if (quill) {
                const range = quill.getSelection();
                quill.insertText(range.index, `{{${variable}}}`, 'user');
              }
            }}
          />
        </div>
      </div>

      <TestEmailSender template={selectedTemplate} />
    </div>    
  );
}
