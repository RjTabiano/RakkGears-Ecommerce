/**
 * RAKK Gears AI Chat Widget - Modular Architecture
 * Main integration file that initializes the chat widget
 * This replaces the monolithic chat-widget.js file
 */
import { ChatWidget } from './chat/ChatWidget.js';

// Initialize chat widget when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Configuration for the chat widget
    const chatConfig = {
        baseURL: 'http://127.0.0.1:8000',
        timeout: 30000,
        sessionTimeout: 30 * 60 * 1000, // 30 minutes
        welcomeMessage: "Hello! I'm your RAKK assistant. How can I help you find the perfect gaming gear today?"
    };

    // Initialize the chat widget
    const rakkChat = new ChatWidget(chatConfig);
    rakkChat.init();

    // Make it globally accessible for debugging (optional)
    window.rakkChat = rakkChat;
});

// Export for module usage
export { ChatWidget };
