import React, { useState } from 'react';

export default function TestEmailSender({ template }) {
  const [recipient, setRecipient] = useState('');
  const [status, setStatus] = useState('');

  const isValidEmail = (email) => /\S+@\S+\.\S+/.test(email);

  const sendTestEmail = async () => {
    if (!isValidEmail(recipient)) {
      setStatus('Please enter a valid email address.');
      return;
    }

    setStatus('Sending...');
    try {
      const response = await fetch('/wp-json/reel/v1/send-test-email', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          recipient,
          templateId: template.id,
          subject: template.subject || '',
        }),
      });

      const result = await response.json();
      if (response.ok) {
        setStatus('Email sent successfully!');
      } else {
        setStatus(`Error: ${result.message || 'Unknown error'}`);
      }
    } catch (err) {
      setStatus('Failed to send email.');
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
      {status && <p style={{ marginTop: 10 }}>{status}</p>}
    </div>
  );
}
