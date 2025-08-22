/**
 * Main ChatWidget Class
 * Orchestrates all chat functionality and manages dependencies
 */
import { SessionManager } from './SessionManager.js';
import { UIManager } from './UIManager.js';
import { MessageManager } from './MessageManager.js';
import { APIClient } from './APIClient.js';
import { EventManager } from './EventManager.js';
import { StyleManager } from './StyleManager.js';

export class ChatWidget {
    constructor(config = {}) {
        this.config = {
            baseURL: 'http://127.0.0.1:8000',
            namespace: 'prod-v1',
            k: 5,
            maxMessageHistory: 100,
            requestTimeout: 30000,
            ...config
        };

        this.isOpen = false;
        this.isTyping = false;
        
        // Initialize managers
        this.sessionManager = new SessionManager();
        this.styleManager = new StyleManager();
        this.uiManager = new UIManager(this.config);
        this.messageManager = new MessageManager(this.sessionManager, this.config.maxMessageHistory);
        this.apiClient = new APIClient(this.config);
        this.eventManager = new EventManager(this);
        
        // Don't auto-init in constructor - let the caller decide when to init
    }

    /**
     * Initialize the chat widget
     */
    async init() {
        try {
            // Apply styles first
            this.styleManager.injectStyles();
            
            // Create UI
            this.uiManager.createWidget();
            
            // Load chat history
            await this.messageManager.loadHistory();
            
            // Setup event listeners
            this.eventManager.attachEventListeners();
            
            // Initialize session management
            this.sessionManager.setupSessionManagement(this);
            
            console.log('ChatWidget initialized successfully');
        } catch (error) {
            console.error('Failed to initialize ChatWidget:', error);
            throw error;
        }
    }

    /**
     * Toggle chat window visibility
     */
    toggleChat() {
        this.isOpen = !this.isOpen;
        this.uiManager.toggleChatWindow(this.isOpen);
        
        if (this.isOpen) {
            this.uiManager.focusInput();
        }
    }

    /**
     * Send a message
     */
    async sendMessage() {
        const messageInput = document.getElementById('rakk-chat-input');
        if (!messageInput) return;

        const message = messageInput.value.trim();
        if (!message || this.isTyping) return;

        this.isTyping = true;
        this.uiManager.setInputState(false);
        
        messageInput.value = '';
        messageInput.style.height = 'auto';
        this.messageManager.addMessage('user', message);

        const typingId = this.uiManager.addTypingIndicator();

        try {
            const sessionId = this.sessionManager.getSessionId();
            const response = await this.apiClient.sendMessage(message, sessionId);
            this.uiManager.removeTypingIndicator(typingId);
            
            this.messageManager.addMessage('bot', response.answer);
            
            // Show products if any
            if (response.products && response.products.length > 0) {
                setTimeout(() => {
                    this.messageManager.addProducts(response.products);
                }, 500);
            }

        } catch (error) {
            console.error('Chat Error:', error);
            this.uiManager.removeTypingIndicator(typingId);
            
            const errorMessage = this.getErrorMessage(error);
            this.messageManager.addMessage('bot', errorMessage);
        } finally {
            this.isTyping = false;
            this.uiManager.setInputState(true); // Re-enable input
        }
    }

    /**
     * Get appropriate error message based on error type
     */
    getErrorMessage(error) {
        if (error.name === 'AbortError') {
            return '❌ Request timed out. Please try again.';
        } else if (!navigator.onLine) {
            return '❌ Please check your internet connection.';
        } else {
            return '❌ Sorry, something went wrong. Please try again later.';
        }
    }

    /**
     * End the current session
     */
    async endSession() {
        try {
            await this.sessionManager.endSession();
            this.messageManager.clearMessages();
            this.uiManager.clearMessages();
            this.messageManager.addWelcomeMessage(this.sessionManager.getSessionId());
        } catch (error) {
            console.error('Error ending session:', error);
        }
    }

    /**
     * Get current session ID
     */
    getSessionId() {
        return this.sessionManager.getSessionId();
    }

    /**
     * Save session history
     */
    async saveHistory() {
        return this.sessionManager.saveHistory();
    }

    /**
     * Check if chat is open
     */
    getChatState() {
        return this.isOpen;
    }
}
