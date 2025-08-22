/**
 * UI Manager
 * Handles all DOM manipulation and UI interactions
 */
export class UIManager {
    constructor(config) {
        this.config = config;
    }

    /**
     * Create the chat widget UI
     */
    createWidget() {
        // Prevent duplicate widgets
        if (document.getElementById('rakk-chat-widget')) return;

        const container = this.createContainer();
        const chatButton = this.createChatButton();
        const chatWindow = this.createChatWindow();

        container.appendChild(chatButton);
        container.appendChild(chatWindow);
        document.body.appendChild(container);
    }

    /**
     * Create main container
     */
    createContainer() {
        const container = document.createElement('div');
        container.id = 'rakk-chat-widget';
        container.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 10000;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        `;
        return container;
    }

    /**
     * Create chat button
     */
    createChatButton() {
        const chatButton = document.createElement('button');
        chatButton.id = 'rakk-chat-button';
        chatButton.innerHTML = `
            <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-3 12H7v-2h10v2zm0-3H7V9h10v2zm0-3H7V6h10v2z"/>
            </svg>
        `;
        chatButton.style.cssText = `
            width: 64px; 
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FA5252 0%, #e63e3e 100%);
            border: none; 
            color: white;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(250,82,82,0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        `;
        return chatButton;
    }

    /**
     * Create chat window
     */
    createChatWindow() {
        const chatWindow = document.createElement('div');
        chatWindow.id = 'rakk-chat-window';
        chatWindow.style.cssText = `
            display: none;
            position: fixed;
            bottom: 100px;
            right: 20px;
            width: 380px;
            max-width: calc(100vw - 40px);
            height: 500px;
            max-height: calc(100vh - 140px);
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            display: flex; 
            flex-direction: column;
            overflow: hidden;
            transform: scale(0.8) translateY(20px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        `;

        const header = this.createHeader();
        const messages = this.createMessagesContainer();
        const input = this.createInputArea();

        chatWindow.appendChild(header);
        chatWindow.appendChild(messages);
        chatWindow.appendChild(input);

        return chatWindow;
    }

    /**
     * Create header
     */
    createHeader() {
        const header = document.createElement('div');
        header.style.cssText = `
            padding: 20px;
            background: linear-gradient(135deg, #FA5252 0%, #e63e3e 100%);
            color: white;
            font-weight: 600;
            border-radius: 16px 16px 0 0;
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            box-shadow: 0 2px 10px rgba(250,82,82,0.2);
        `;

        header.innerHTML = `
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    🤖
                </div>
                <div>
                    <div style="font-size: 16px; font-weight: 600;">RakkGears Assistant</div>
                    <div style="font-size: 12px; opacity: 0.9;">Always here to help</div>
                </div>
            </div>
            <button id="rakk-chat-close" style="
                background: rgba(255,255,255,0.2); 
                border: none; 
                color: white; 
                cursor: pointer; 
                font-size: 20px;
                width: 32px;
                height: 32px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: background 0.2s ease;
            " onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">×</button>
        `;

        return header;
    }

    /**
     * Create messages container
     */
    createMessagesContainer() {
        const messages = document.createElement('div');
        messages.id = 'rakk-chat-messages';
        messages.style.cssText = `
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            background: #fafafa;
            scroll-behavior: smooth;
        `;

        // Add scrollbar styles
        const style = document.createElement('style');
        style.textContent = `
            #rakk-chat-messages::-webkit-scrollbar {
                width: 6px;
            }
            #rakk-chat-messages::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 3px;
            }
            #rakk-chat-messages::-webkit-scrollbar-thumb {
                background: #FA5252;
                border-radius: 3px;
            }
            #rakk-chat-messages::-webkit-scrollbar-thumb:hover {
                background: #e63e3e;
            }
        `;
        document.head.appendChild(style);

        return messages;
    }

    /**
     * Create input area
     */
    createInputArea() {
        const inputArea = document.createElement('div');
        inputArea.style.cssText = `
            padding: 20px;
            border-top: 1px solid #e0e0e0;
            display: flex; 
            gap: 12px;
            background: white;
            align-items: flex-end;
        `;

        const messageInput = this.createMessageInput();
        const sendButton = this.createSendButton();

        inputArea.appendChild(messageInput);
        inputArea.appendChild(sendButton);

        return inputArea;
    }

    /**
     * Create message input
     */
    createMessageInput() {
        const messageInput = document.createElement('textarea');
        messageInput.id = 'rakk-chat-input';
        messageInput.placeholder = 'Type your message...';
        messageInput.rows = 1;
        messageInput.style.cssText = `
            flex-grow: 1;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 24px;
            outline: none;
            transition: all 0.2s ease;
            font-family: inherit;
            font-size: 14px;
            resize: none;
            max-height: 120px;
            line-height: 1.4;
            overflow: hidden;
            scrollbar-width: none;
            -ms-overflow-style: none;
            box-sizing: border-box;
        `;

        // Hide scrollbar
        const style = document.createElement('style');
        style.textContent = `
            #rakk-chat-input::-webkit-scrollbar {
                display: none;
            }
        `;
        document.head.appendChild(style);

        return messageInput;
    }

    /**
     * Create send button
     */
    createSendButton() {
        const sendButton = document.createElement('button');
        sendButton.id = 'rakk-send-button';
        sendButton.innerHTML = `
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
            </svg>
        `;
        sendButton.style.cssText = `
            width: 48px; 
            height: 48px;
            background: linear-gradient(135deg, #FA5252 0%, #e63e3e 100%);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex; 
            align-items: center; 
            justify-content: center;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(250,82,82,0.3);
            flex-shrink: 0;
            opacity: 0.5;
        `;
        sendButton.disabled = true;

        return sendButton;
    }

    /**
     * Toggle chat window visibility
     */
    toggleChatWindow(isOpen) {
        const chatWindow = document.getElementById('rakk-chat-window');
        const chatButton = document.getElementById('rakk-chat-button');
        
        if (!chatWindow || !chatButton) return;
        
        if (isOpen) {
            chatWindow.style.display = 'flex';
            requestAnimationFrame(() => {
                chatWindow.style.transform = 'scale(1) translateY(0)';
                chatWindow.style.opacity = '1';
            });
            chatButton.style.transform = 'rotate(180deg)';
        } else {
            chatWindow.style.transform = 'scale(0.8) translateY(20px)';
            chatWindow.style.opacity = '0';
            chatButton.style.transform = 'rotate(0deg)';
            
            setTimeout(() => {
                chatWindow.style.display = 'none';
            }, 300);
        }
    }

    /**
     * Focus input field
     */
    focusInput() {
        setTimeout(() => {
            const messageInput = document.getElementById('rakk-chat-input');
            if (messageInput) messageInput.focus();
        }, 300);
    }

    /**
     * Set input state (enabled/disabled)
     */
    setInputState(enabled) {
        const messageInput = document.getElementById('rakk-chat-input');
        const sendButton = document.getElementById('rakk-send-button');
        
        if (messageInput) messageInput.disabled = !enabled;
        if (sendButton) sendButton.disabled = !enabled;
        
        if (enabled) {
            setTimeout(() => {
                if (messageInput) messageInput.focus();
            }, 100);
        }
    }

    /**
     * Add typing indicator
     */
    addTypingIndicator() {
        const messagesContainer = document.getElementById('rakk-chat-messages');
        if (!messagesContainer) return null;

        const typingDiv = document.createElement('div');
        const id = `typing-${Date.now()}`;
        typingDiv.id = id;
        typingDiv.style.cssText = `
            margin: 12px 0;
            display: flex;
            align-items: flex-start;
            animation: fadeIn 0.3s ease;
        `;

        const typingContent = document.createElement('div');
        typingContent.style.cssText = `
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 20px;
            border-bottom-left-radius: 6px;
            padding: 12px 16px;
            max-width: 60%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        `;

        typingContent.innerHTML = `
            <div style="display: flex; align-items: center; gap: 8px; color: #666;">
                <div class="rakk-typing-indicator">
                    <div class="rakk-typing-dot"></div>
                    <div class="rakk-typing-dot"></div>
                    <div class="rakk-typing-dot"></div>
                </div>
                <span style="font-size: 13px;">Assistant is typing...</span>
            </div>
        `;

        typingDiv.appendChild(typingContent);
        messagesContainer.appendChild(typingDiv);
        this.scrollToBottom();
        return id;
    }

    /**
     * Remove typing indicator
     */
    removeTypingIndicator(id) {
        if (!id) return;
        const element = document.getElementById(id);
        if (element) {
            element.style.animation = 'fadeIn 0.2s ease reverse';
            setTimeout(() => element.remove(), 200);
        }
    }

    /**
     * Scroll messages to bottom
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
     * Clear all messages from UI
     */
    clearMessages() {
        const messagesContainer = document.getElementById('rakk-chat-messages');
        if (messagesContainer) {
            messagesContainer.innerHTML = '';
        }
    }

    /**
     * Create ripple effect for buttons
     */
    createRipple(e) {
        const button = e.currentTarget;
        const rect = button.getBoundingClientRect();
        const ripple = document.createElement('span');
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;

        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            background: rgba(255,255,255,0.5);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            left: ${x}px;
            top: ${y}px;
            pointer-events: none;
        `;

        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        button.appendChild(ripple);
        setTimeout(() => {
            ripple.remove();
            style.remove();
        }, 600);
    }
}
