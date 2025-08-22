export class APIClient {
    constructor(config) {
        this.baseURL = config.baseURL;
        this.timeout = config.requestTimeout;
        this.namespace = config.namespace;
        this.k = config.k;
    }

    /**
     * Send message to chat API
     */
    async sendMessage(message, sessionId) {
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), this.timeout);

        try {
            const response = await fetch(`${this.baseURL}/chat`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ 
                    question: message, 
                    session_id: sessionId,
                    namespace: this.namespace, 
                    k: this.k 
                }),
                signal: controller.signal
            });

            clearTimeout(timeoutId);

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }

            const data = await response.json();

            if (data.error) {
                throw new Error(data.error);
            }

            return data;

        } catch (error) {
            clearTimeout(timeoutId);
            throw error;
        }
    }

    /**
     * Delete session from backend
     */
    async deleteSession(sessionId, messageHistory) {
        if (!sessionId || messageHistory.length === 0) {
            console.log('No session or messages to delete');
            return;
        }

        try {
            const response = await fetch(`${this.baseURL}/chat/session/${sessionId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    session_id: sessionId,
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
}
