import { ChatWidget } from './chat/ChatWidget.js';

document.addEventListener('DOMContentLoaded', function() {
    const chatConfig = {
        baseURL: 'https://rakk-rag-chatbot-gte6d4dhhphrcff2.southeastasia-01.azurewebsites.net',
        timeout: 30000,
        sessionTimeout: 30 * 60 * 1000, 
        welcomeMessage: "Hello! I'm your RAKK assistant. How can I help you find the perfect gaming gear today?"
    };

    const rakkChat = new ChatWidget(chatConfig);
    rakkChat.init();

    window.rakkChat = rakkChat;
});

// Export for module usage
export { ChatWidget };
