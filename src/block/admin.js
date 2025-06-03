import domReady from '@wordpress/dom-ready';
import { createRoot } from '@wordpress/element';
import Editor from './Editor'; 

domReady(() => {
    const container = document.getElementById('reel-email-template-editor-root');
    if (container) {
        const root = createRoot(container);
        root.render(<Editor />);
    }
});
