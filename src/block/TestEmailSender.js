import { useState } from '@wordpress/element';

export default function TestEmailSender({ setNotice, templateSlug = 'default' }) {
  const [recipient, setRecipient] = useState('');

  const isValidEmail = (email) =>
    /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

  const sendTestEmail = async () => {
    if (!isValidEmail(recipient)) {
      setNotice({ status: 'error', message: 'Please enter a valid email address.' });
      return;
    }

    setNotice({ status: 'info', message: 'Sending...' });
    try {
      const response = await fetch('/wp-json/reel/v1/email/send', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          recipient_email: recipient,
          template_slug: templateSlug,
        }),
      });

      const result = await response.json();
      if (response.ok) {
        setNotice({ status: 'success', message: 'Email sent successfully!' });
      } else {
        setNotice({ status: 'error', message: `Error: ${result.message || 'Unknown error'}` });
      }
    } catch (err) {
      setNotice({ status: 'error', message: 'Failed to send email.' });
    } finally {
      setTimeout(() => setNotice(null), 3000);
    }
  };

  return (
    <div style={{ marginTop: 20 }}>
      <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
        <input
          type="email"
          value={recipient}
          onChange={(e) => setRecipient(e.target.value)}
          style={{
            padding: 5,
            width: '300px',
            border: '1px solid #ccc',
            borderRadius: 4,
          }}
          placeholder="Recipient email"
        />
        <button
          onClick={sendTestEmail}
          style={{
            padding: '8px 16px',
            background: '#007bff',
            color: '#fff',
            border: 'none',
            borderRadius: 4,
            cursor: 'pointer',
          }}
          disabled={!recipient}
        >
          Send test email
        </button>
      </div>
    </div>
  );
}
