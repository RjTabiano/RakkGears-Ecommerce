/**
 * Message Manager
 * Handles message creation, storage, and display
 */
export class MessageManager {
    constructor(sessionManager, maxMessageHistory = 100) {
        this.sessionManager = sessionManager;
        this.messageHistory = [];
        this.maxMessageHistory = maxMessageHistory;
    }

    /**
     * Add a message to the chat
     */
    addMessage(type, content) {
        const messagesContainer = document.getElementById('rakk-chat-messages');
        if (!messagesContainer) return;

        const messageDiv = this.createMessageElement(type, content);
        messagesContainer.appendChild(messageDiv);
        
        this.scrollToBottom();
        this.saveMessage(type, content);
    }

    /**
     * Create message element
     */
    createMessageElement(type, content) {
        const messageDiv = document.createElement('div');
        const timestamp = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        
        messageDiv.style.cssText = `
            margin-bottom: 16px;
            display: flex;
            flex-direction: column;
            animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            ${type === 'user' ? 'align-items: flex-end;' : 'align-items: flex-start;'}
        `;

        const messageContent = this.createMessageContent(type, content);
        const timeDiv = this.createTimeElement(type, timestamp);

        messageDiv.appendChild(messageContent);
        messageDiv.appendChild(timeDiv);

        return messageDiv;
    }

    /**
     * Create message content element
     */
    createMessageContent(type, content) {
        const messageContent = document.createElement('div');
        messageContent.style.cssText = `
            padding: 12px 16px;
            border-radius: 20px;
            max-width: 80%;
            line-height: 1.5;
            word-wrap: break-word;
            position: relative;
            ${type === 'user'
                ? `background: linear-gradient(135deg, #FA5252 0%, #e63e3e 100%); 
                   color: white; 
                   border-bottom-right-radius: 6px;
                   box-shadow: 0 2px 8px rgba(250,82,82,0.3);`
                : `background: white; 
                   color: #333; 
                   border: 1px solid #e0e0e0;
                   border-bottom-left-radius: 6px;
                   box-shadow: 0 2px 8px rgba(0,0,0,0.08);`}
        `;

        messageContent.textContent = content;

        // Add typing animation for bot messages
        if (type === 'bot') {
            messageContent.style.opacity = '0';
            messageContent.style.transform = 'translateY(10px)';
            
            requestAnimationFrame(() => {
                messageContent.style.transition = 'all 0.3s ease';
                messageContent.style.opacity = '1';
                messageContent.style.transform = 'translateY(0)';
            });
        }

        return messageContent;
    }

    /**
     * Create time element
     */
    createTimeElement(type, timestamp) {
        const timeDiv = document.createElement('div');
        timeDiv.style.cssText = `
            font-size: 11px;
            color: #999;
            margin: 4px 8px 0;
            ${type === 'user' ? 'text-align: right;' : 'text-align: left;'}
        `;
        timeDiv.textContent = timestamp;
        return timeDiv;
    }

    /**
     * Add products display
     */
    addProducts(products) {
        console.log('MessageManager.addProducts called with:', products);
        
        const messagesContainer = document.getElementById('rakk-chat-messages');
        
        if (!products || products.length === 0 || !messagesContainer) {
            console.log('MessageManager.addProducts: No products or messages container not found');
            return;
        }
        
        console.log('Creating product display for', products.length, 'products');
        
        const headerDiv = this.createProductHeader(products.length);
        const productsContainer = this.createProductsGrid(products);

        messagesContainer.appendChild(headerDiv);
        messagesContainer.appendChild(productsContainer);
        this.scrollToBottom();
    }

    /**
     * Create product header
     */
    createProductHeader(productCount) {
        const headerDiv = document.createElement('div');
        headerDiv.style.cssText = `
            margin-bottom: 12px;
            padding: 8px 12px;
            background: linear-gradient(135deg, #FA5252 0%, #ff6b6b 100%);
            color: white;
            border-radius: 12px;
            font-weight: 600;
            text-align: center;
            font-size: 14px;
        `;
        headerDiv.textContent = `🛍️ Found ${productCount} product${productCount > 1 ? 's' : ''} for you:`;
        return headerDiv;
    }

    /**
     * Create products grid
     */
    createProductsGrid(products) {
        const productsContainer = document.createElement('div');
        productsContainer.className = 'rakk-products-grid';
        productsContainer.style.cssText = `
            margin: 12px 0;
            animation: fadeIn 0.5s ease;
        `;

        products.forEach((product, index) => {
            const productCard = this.createProductCard(product, index);
            productsContainer.appendChild(productCard);
        });

        return productsContainer;
    }

    /**
     * Create individual product card
     */
    createProductCard(product, index) {
        console.log('Creating product card for:', product);
        
        const productCard = document.createElement('div');
        productCard.className = 'rakk-product-card';
        productCard.style.animationDelay = `${index * 0.1}s`;

        productCard.innerHTML = `
            <img 
                src="${this.escapeHtml(product.image)}" 
                alt="${this.escapeHtml(product.name)}" 
                class="rakk-product-image"
                onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjVmNWY1Ii8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPk5vIEltYWdlPC90ZXh0Pjwvc3ZnPg=='"
            >
            <h4 class="rakk-product-name">${this.escapeHtml(product.name)}</h4>
            <p class="rakk-product-description">${this.escapeHtml(product.description || 'No description available')}</p>
            <div class="rakk-product-price">₱${parseFloat(product.price).toFixed(2)}</div>
            <a href="${this.escapeHtml(product.link)}" target="_blank" class="rakk-product-button">
                View Product →
            </a>
        `;

        return productCard;
    }

    /**
     * Add welcome message
     */
    addWelcomeMessage(sessionId) {
        const messagesContainer = document.getElementById('rakk-chat-messages');
        if (!messagesContainer) return;

        const welcomeMessage = document.createElement('div');
        welcomeMessage.style.cssText = `
            background: white;
            padding: 16px;
            border-radius: 16px;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-left: 4px solid #FA5252;
        `;
        welcomeMessage.innerHTML = `
            <div style="font-weight: 600; color: #2c3e50; margin-bottom: 8px;">👋 Welcome to RakkGears!</div>
            <div style="color: #666; font-size: 14px; line-height: 1.4;">
                I'm here to help you find the perfect gear. Ask me about products, specifications, or anything else!
            </div>
        `;
        messagesContainer.appendChild(welcomeMessage);
    }

    /**
     * Save message to history
     */
    saveMessage(type, content) {
        try {
            const messageData = { 
                type, 
                content, 
                timestamp: new Date().toISOString(),
                session_id: this.sessionManager.getSessionId()
            };

            // Add to local history
            this.messageHistory.push(messageData);

            // Save to localStorage
            let history = JSON.parse(localStorage.getItem('chatHistory') || "[]");
            history.push(messageData);
            
            // Limit history size
            if (history.length > this.maxMessageHistory) {
                history = history.slice(-this.maxMessageHistory);
                this.messageHistory = this.messageHistory.slice(-this.maxMessageHistory);
            }
            
            localStorage.setItem('chatHistory', JSON.stringify(history));
        } catch (error) {
            console.warn('Could not save chat history:', error);
        }
    }

    /**
     * Load chat history
     */
    async loadHistory() {
        try {
            const history = JSON.parse(localStorage.getItem('chatHistory') || "[]");
            const sessionId = this.sessionManager.getSessionId();
            
            // Load recent messages for current session
            const recentHistory = history.slice(-20);
            const sessionHistory = recentHistory.filter(msg => 
                !msg.session_id || msg.session_id === sessionId
            );

            if (sessionHistory.length === 0) {
                this.addWelcomeMessage(sessionId);
            } else {
                sessionHistory.forEach(msg => {
                    this.addMessageWithoutSave(msg.type, msg.content);
                    this.messageHistory.push(msg);
                });
            }
        } catch (error) {
            console.warn('Could not load chat history:', error);
            this.addWelcomeMessage(this.sessionManager.getSessionId());
        }
    }

    /**
     * Add message without saving (for loading history)
     */
    addMessageWithoutSave(type, content) {
        const messagesContainer = document.getElementById('rakk-chat-messages');
        if (!messagesContainer) return;

        const messageDiv = document.createElement('div');
        messageDiv.style.cssText = `
            margin-bottom: 16px;
            display: flex;
            flex-direction: column;
            ${type === 'user' ? 'align-items: flex-end;' : 'align-items: flex-start;'}
        `;

        const messageContent = document.createElement('div');
        messageContent.style.cssText = `
            padding: 12px 16px;
            border-radius: 20px;
            max-width: 80%;
            line-height: 1.5;
            word-wrap: break-word;
            ${type === 'user'
                ? `background: linear-gradient(135deg, #FA5252 0%, #e63e3e 100%); 
                   color: white; 
                   border-bottom-right-radius: 6px;
                   box-shadow: 0 2px 8px rgba(250,82,82,0.3);`
                : `background: white; 
                   color: #333; 
                   border: 1px solid #e0e0e0;
                   border-bottom-left-radius: 6px;
                   box-shadow: 0 2px 8px rgba(0,0,0,0.08);`}
        `;

        messageContent.textContent = content;
        messageDiv.appendChild(messageContent);
        messagesContainer.appendChild(messageDiv);
    }

    /**
     * Clear all messages
     */
    clearMessages() {
        this.messageHistory = [];
    }

    /**
     * Get message history
     */
    getMessageHistory() {
        return this.messageHistory;
    }

    /**
     * Scroll to bottom
     */
    scrollToBottom() {
        const messagesContainer = document.getElementById('rakk-chat-messages');
        if (messagesContainer) {
            requestAnimationFrame(() => {
                messagesContainer.scrollTo({ 
                    top: messagesContainer.scrollHeight, 
                    behavior: 'smooth' 
                });
            });
        }
    }

    /**
     * Escape HTML to prevent XSS
     */
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}
