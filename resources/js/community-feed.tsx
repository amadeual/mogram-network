import React from 'react';
import { createRoot } from 'react-dom/client';
import { PromptInputBox } from './components/ui/ai-prompt-box';

document.addEventListener('DOMContentLoaded', () => {
    const rootElement = document.getElementById('community-prompt-root');
    if (rootElement) {
        const communitySlug = rootElement.getAttribute('data-community-slug');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const handleSend = async (message: string, files?: File[]) => {
            console.log('Sending message to community:', communitySlug, message, files);
            
            const formData = new FormData();
            formData.append('content', message);
            if (files && files.length > 0) {
                formData.append('media', files[0]);
            }
            if (csrfToken) {
                formData.append('_token', csrfToken);
            }

            try {
                const response = await fetch(`/communities/${communitySlug}/posts`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    window.location.reload();
                } else {
                    const data = await response.json();
                    alert(data.message || 'Erro ao publicar');
                }
            } catch (error) {
                console.error('Error sending post:', error);
                alert('Ocorreu um erro ao enviar sua publicação.');
            }
        };

        const root = createRoot(rootElement);
        root.render(
            <div className="w-full">
                <PromptInputBox onSend={handleSend} />
            </div>
        );
    }
});
