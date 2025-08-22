/**
 * Session Manager
 * Handles session creation, persistence, and cleanup
 */
export class SessionManager {
    constructor() {
        this.sessionId = this.initializeSession();
    }

    /**
     * Initialize session - get existing or create new
     */
    initializeSession() {
        let sessionId = localStorage.getItem('chatSessionId');
        
        if (!sessionId) {
            sessionId = this.generateSessionId();
        }
        
        return sessionId;
    }

    /**
     * Generate a unique session ID
     */
    generateSessionId() {
        const timestamp = Date.now();
        const random = Math.random().toString(36).substring(2, 15);
        const sessionId = `chat_${timestamp}_${random}`;
        
        localStorage.setItem('chatSessionId', sessionId);
        console.log('Generated new session ID:', sessionId);
        
        return sessionId;
    }

    /**
     * Get current session ID
     */
    getSessionId() {
        return this.sessionId;
    }

    /**
     * Setup session management handlers
     */
    setupSessionManagement(chatWidget) {
        // Handle page unload/reload - save locally only
        window.addEventListener('beforeunload', () => {
            this.saveToLocal(chatWidget.messageManager.getMessageHistory());
        });

        // Handle visibility change - save locally only
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'hidden') {
                this.saveToLocal(chatWidget.messageManager.getMessageHistory());
            }
        });

        this.setupLogoutHandlers(chatWidget);
    }

    /**
     * Setup logout detection handlers
     */
    setupLogoutHandlers(chatWidget) {
        // Listen for custom logout events
        window.addEventListener('userLogout', () => {
            chatWidget.endSession();
        });

        // Listen for storage changes (logout in another tab)
        window.addEventListener('storage', (e) => {
            if (e.key === 'userLoggedOut' && e.newValue === 'true') {
                chatWidget.endSession();
            }
        });

        // Check auth status periodically (optional)
        const checkAuthStatus = () => {
            const token = localStorage.getItem('authToken') || sessionStorage.getItem('authToken');
            if (!token && this.sessionId) {
                console.log('Auth token not found. Call ChatWidgetAPI.endSession() to end session.');
            }
        };

        setInterval(checkAuthStatus, 30000);
    }

    /**
     * Save session data to localStorage only
     */
    saveToLocal(messageHistory) {
        try {
            if (this.sessionId && messageHistory.length > 0) {
                localStorage.setItem('chatSessionId', this.sessionId);
                localStorage.setItem('chatHistory', JSON.stringify(messageHistory));
                console.log('Session saved locally');
            }
        } catch (error) {
            console.error('Error saving session locally:', error);
        }
    }

    /**
     * Save session history (non-destructive)
     */
    async saveHistory() {
        // Currently just saves locally
        // You can extend this to save to backend without deleting
        try {
            const messageHistory = JSON.parse(localStorage.getItem('chatHistory') || '[]');
            this.saveToLocal(messageHistory);
            console.log('Session history saved (local only)');
        } catch (error) {
            console.error('Error saving session history:', error);
        }
    }

    /**
     * End session and delete from backend
     */
    async endSession() {
        if (!this.sessionId) return;

        console.log('Ending chat session:', this.sessionId);
        
        try {
            await this.deleteSessionFromBackend();
            this.clearLocalSession();
            console.log('Session ended successfully');
        } catch (error) {
            console.error('Error ending session:', error);
            throw error;
        }
    }

    /**
     * Delete session from backend
     */
    async deleteSessionFromBackend() {
        const messageHistory = JSON.parse(localStorage.getItem('chatHistory') || '[]');
        
        if (!this.sessionId || messageHistory.length === 0) {
            console.log('No session or messages to delete');
            return;
        }

        try {
            const response = await fetch(`http://127.0.0.1:8000/chat/session/${this.sessionId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    session_id: this.sessionId,
                    messages: messageHistory,
                    timestamp: new Date().toISOString()
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }

            console.log('Session deleted from backend successfully');
        } catch (error) {
            console.error('Error deleting session from backend:', error);
            throw error;
        }
    }

    /**
     * Clear local session data
     */
    clearLocalSession() {
        localStorage.removeItem('chatSessionId');
        localStorage.removeItem('chatHistory');
        this.sessionId = null;
    }
}
