class ChatWidget {
    constructor() {
        this.isOpen = false;
        this.createWidget();
        this.attachEventListeners();
        this.loadHistory();
    }

    addProducts(products) {
        const messagesContainer = document.getElementById('rakk-chat-messages');
    
        products.forEach(product => {
            const productDiv = document.createElement('div');
            productDiv.style.cssText = `
                margin-bottom: 12px;
                padding: 12px;
                border-radius: 12px;
                background: #fff;
                border: 1px solid #eee;
                box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                max-width: 80%;
                margin-right: auto;
            `;
    
            productDiv.innerHTML = `
                <img src="${product.image_path}" alt="${product.name}" style="max-width: 100%; border-radius: 8px; margin-bottom: 8px;">
                <h4 style="margin: 0 0 6px; font-size: 16px; font-weight: bold;">${product.name}</h4>
                <p style="margin: 0 0 6px; font-size: 14px; color: #555;">${product.description || ''}</p>
                <p style="margin: 0 0 10px; font-size: 14px; font-weight: bold;">$${product.price}</p>
                <a href="${product.link}" target="_blank" style="display: inline-block; padding: 6px 12px; background: #FA5252; color: white; border-radius: 6px; text-decoration: none; font-size: 14px;">View Product</a>
            `;
    
            messagesContainer.appendChild(productDiv);
        });
    
        messagesContainer.scrollTo({ top: messagesContainer.scrollHeight, behavior: 'smooth' });
    }

    createWidget() {
        const container = document.createElement('div');
        container.id = 'rakk-chat-widget';
        container.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            font-family: Arial, sans-serif;
        `;

        // Floating chat button
        const chatButton = document.createElement('button');
        chatButton.id = 'rakk-chat-button';
        chatButton.innerHTML = '💬';
        chatButton.style.cssText = `
            width: 60px; height: 60px;
            border-radius: 50%;
            background: #FA5252;
            border: none; color: white;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(250,82,82,0.3);
            transition: transform 0.2s ease;
        `;
        chatButton.onmouseover = () => chatButton.style.transform = 'scale(1.1)';
        chatButton.onmouseout = () => chatButton.style.transform = 'scale(1)';

        // Chat window
        const chatWindow = document.createElement('div');
        chatWindow.id = 'rakk-chat-window';
        chatWindow.style.cssText = `
            display: none;
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 350px;
            max-height: 70vh;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            display: flex; flex-direction: column;
            overflow: hidden;
        `;

        // Header
        const chatHeader = document.createElement('div');
        chatHeader.style.cssText = `
            padding: 15px;
            background: #FA5252;
            color: white;
            font-weight: bold;
            border-radius: 12px 12px 0 0;
            display: flex; justify-content: space-between; align-items: center;
        `;
        chatHeader.innerHTML = `
            <span>RakkGears Assistant</span>
            <button id="rakk-chat-close" style="background: none; border: none; color: white; cursor: pointer; font-size: 20px;">×</button>
        `;

        // Messages
        const chatMessages = document.createElement('div');
        chatMessages.id = 'rakk-chat-messages';
        chatMessages.style.cssText = `
            flex-grow: 1;
            padding: 15px;
            overflow-y: auto;
            background: #fdfdfd;
        `;

        // Input area
        const chatInput = document.createElement('div');
        chatInput.style.cssText = `
            padding: 12px;
            border-top: 1px solid #eee;
            display: flex; gap: 8px;
            background: #fff;
        `;

        const messageInput = document.createElement('input');
        messageInput.type = 'text';
        messageInput.id = 'rakk-chat-input';
        messageInput.placeholder = 'Type your message...';
        messageInput.style.cssText = `
            flex-grow: 1;
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 20px;
            outline: none;
            transition: border-color 0.2s ease;
        `;
        messageInput.onfocus = () => messageInput.style.borderColor = '#FA5252';

        const sendButton = document.createElement('button');
        sendButton.innerHTML = '➤';
        sendButton.style.cssText = `
            width: 40px; height: 40px;
            background: #FA5252;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            display: flex; align-items: center; justify-content: center;
            transition: background-color 0.2s ease;
        `;
        sendButton.onmouseover = () => sendButton.style.background = '#e63e3e';
        sendButton.onmouseout = () => sendButton.style.background = '#FA5252';

        // Assemble
        chatInput.appendChild(messageInput);
        chatInput.appendChild(sendButton);
        chatWindow.appendChild(chatHeader);
        chatWindow.appendChild(chatMessages);
        chatWindow.appendChild(chatInput);
        container.appendChild(chatButton);
        container.appendChild(chatWindow);
        document.body.appendChild(container);
    }

    attachEventListeners() {
        const chatButton = document.getElementById('rakk-chat-button');
        const chatWindow = document.getElementById('rakk-chat-window');
        const closeButton = document.getElementById('rakk-chat-close');
        const sendButton = chatWindow.querySelector('button:last-of-type');
        const messageInput = document.getElementById('rakk-chat-input');

        chatButton.addEventListener('click', () => this.toggleChat());
        closeButton.addEventListener('click', () => this.toggleChat());
        sendButton.addEventListener('click', () => this.sendMessage());
        messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') this.sendMessage();
        });
    }

    toggleChat() {
        const chatWindow = document.getElementById('rakk-chat-window');
        this.isOpen = !this.isOpen;
        chatWindow.style.display = this.isOpen ? 'flex' : 'none';
    }

    async sendMessage() {
        const messageInput = document.getElementById('rakk-chat-input');
        const message = messageInput.value.trim();
        if (!message) return;

        this.addMessage('user', message);
        messageInput.value = '';

        // Typing indicator
        const typingId = this.addTypingIndicator();

        try {
            const response = await fetch('http://127.0.0.1:8000/chat', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ question: message, namespace: "prod-v1", k: 5 })
            });

            const data = await response.json();
            this.removeTypingIndicator(typingId);

            if (data.error) throw new Error(data.error);
            this.addMessage('bot', data.answer);

            if (data.products && data.products.length > 0) {
                this.addProducts(data.products);
            }
        } catch (error) {
            console.error('Error:', error);
            this.removeTypingIndicator(typingId);
            this.addMessage('bot', '❌ Sorry, something went wrong. Please try again.');
        }
    }

    addMessage(type, content) {
        const messagesContainer = document.getElementById('rakk-chat-messages');
        const messageDiv = document.createElement('div');
        messageDiv.style.cssText = `
            margin-bottom: 12px;
            padding: 10px 14px;
            border-radius: 18px;
            max-width: 75%;
            line-height: 1.4;
            animation: fadeIn 0.3s ease;
            ${type === 'user'
                ? 'background: #FA5252; color: white; margin-left: auto; box-shadow: 0 2px 6px rgba(250,82,82,0.2);'
                : 'background: #f1f1f1; color: #333; margin-right: auto; box-shadow: 0 2px 6px rgba(0,0,0,0.05);'}
        `;
        messageDiv.textContent = content;

        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTo({ top: messagesContainer.scrollHeight, behavior: 'smooth' });

        // Save to localStorage
        this.saveHistory(type, content);
    }

    addTypingIndicator() {
        const messagesContainer = document.getElementById('rakk-chat-messages');
        const typingDiv = document.createElement('div');
        const id = `typing-${Date.now()}`;
        typingDiv.id = id;
        typingDiv.style.cssText = `
            margin: 8px 0;
            padding: 10px 14px;
            border-radius: 18px;
            background: #f1f1f1;
            color: #777;
            font-size: 14px;
            max-width: 50%;
            margin-right: auto;
        `;
        typingDiv.textContent = "Assistant is typing...";
        messagesContainer.appendChild(typingDiv);
        messagesContainer.scrollTo({ top: messagesContainer.scrollHeight, behavior: 'smooth' });
        return id;
    }

    removeTypingIndicator(id) {
        const el = document.getElementById(id);
        if (el) el.remove();
    }

    saveHistory(type, content) {
        let history = JSON.parse(localStorage.getItem('chatHistory') || "[]");
        history.push({ type, content });
        localStorage.setItem('chatHistory', JSON.stringify(history));
    }

    loadHistory() {
        const history = JSON.parse(localStorage.getItem('chatHistory') || "[]");
        history.forEach(msg => this.addMessage(msg.type, msg.content));
    }
}

document.addEventListener('DOMContentLoaded', () => new ChatWidget());
