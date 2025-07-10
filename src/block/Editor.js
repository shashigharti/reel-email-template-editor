import { useState, useEffect, useRef } from '@wordpress/element';
import {
  SelectControl,
  Button,
  Notice,
  TextControl,
} from '@wordpress/components';

import {
  fetchHooks,
  fetchTemplates,
  fetchTemplateBySlug,
  saveTemplate,
  deleteTemplate,
  importTemplate,
} from '../utils/api';
import { generateSlug } from '../utils/common.js'; 
import VariableList from './VariableList';
import Menu from './Menu';
import CEditor from './CEditor.js';
import TestEmailSender from './TestEmailSender.js';
import HookList from './HookList.js';
import UserTypeList from './UserTypeList.js';
import HelpText from './components/HelpText.js';

export default function Editor() {
  const [templates, setTemplates] = useState([]);
  const [hooks, setHooks] = useState([]);
  const [selectedTemplateId, setSelectedTemplateId] = useState(null);
  const [content, setContent] = useState('');
  const [subject, setSubject] = useState('');
  const [hookID, setHookID] = useState(null);
  const [description, setDescription] = useState('');
  const [isSaving, setIsSaving] = useState(false);
  const [notice, setNotice] = useState(null);
  const [title, setTitle] = useState('');
  const [slug, setSlug] = useState('');
  const editorInstanceRef = useRef(null);
  const [selectedUserTypeID, setSelectedUserTypeID] = useState(null);

  const selectedTemplate = templates.find(t => t.id === selectedTemplateId);

  useEffect(() => {
    console.log('Fetching templates...');
    fetchTemplates()
      .then((data) => {
        setTemplates(data);
        if (data.length > 0) {
          setSelectedTemplateId(data[0].id);
        }
      })
      .catch((err) => console.error('Error fetching templates:', err));
    
    console.log('Fetching hooks...');
    fetchHooks()
      .then((data) => { 
        if (data.length > 0) {
          setHooks(data);
        }
      })
      .catch((err) => console.error('Error fetching hooks:', err));
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
        let hook_id = template.hook_id;
        let description = template.description;
        let user_type = template.user_type;

        if (template.slug === 'default') {
          title = `${title}-${templates.length + 1}`;
          slug = generateSlug(title);
        }
        setTitle(title);
        setSlug(slug);
        setSubject(subject);        
        setDescription(description);
        setSelectedUserTypeID(user_type);

        setHookID(hook_id);
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
      description,
      hook_id: hookID,
      user_type: selectedUserTypeID,
    };
    console.log(payload);

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

  function onImport() {
    const confirmed = window.confirm(
      'Importing templates will overwrite existing ones with matching slugs. Do you want to continue?'
    );

    if (!confirmed) return;

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
      })
      .finally(() => {
        setTimeout(() => setNotice(null), 3000);
      });
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
              <HelpText
              info="A good name for the email template for internal use only."
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
              <HelpText
              info="Select an email template to edit."
              /> 
            </div>
          </div>
          <div>
             <TextControl
                label="Subject"
                value={subject}
                onChange={(val) => setSubject(val)}
              />
              <HelpText
              info="Add subject for the email. You can also use the variable here ${user_name}."
              />
          </div>
          <div style={{ marginTop: '10px' }}>
            <TextControl 
              value={description} 
              onChange={(val)=>setDescription(val)}
              label="Description"
            />
            <HelpText
              info="Add a short description for the email template. This information is for internal reference only and won't appear in the final email."
            />
          </div>   
          <Menu onImport={onImport} onAddNew={() => {setSelectedTemplateId('')}}/>
          <CEditor
            ref={editorInstanceRef}
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
          <div style={{ marginTop: '10px' }}>
            <TestEmailSender template={selectedTemplate} setNotice={setNotice} templateSlug={slug} />
            <HelpText info="Send a test email using the currently selected template. Please note that the data used 
            is dummy data for testing purposes, not real placeholder values." />
          </div>          
        </div>        
        <div style={{ width: '300px', borderLeft: '1px solid #ccc', paddingLeft: '15px' }}> 
          <VariableList
            onInsert={(variable) => {
              if (editorInstanceRef.current?.insertVariable) {
                editorInstanceRef.current.insertVariable(`{{${variable}}}`);
              }
            }}
          />
          <HookList onAttach={(hID)=>setHookID(hID)} selectedHookID={hookID} hooks={hooks}  />
          <UserTypeList onSelect={(userTypeID)=>setSelectedUserTypeID(userTypeID)} selectedUserTypeID={selectedUserTypeID}/>
        </div>
      </div>
    </div>    
  );
}
