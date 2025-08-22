/**
 * Event Manager
 * Handles all event listeners and user interactions
 */
export class EventManager {
    constructor(chatWidget) {
        this.chatWidget = chatWidget;
    }

    /**
     * Attach all event listeners
     */
    attachEventListeners() {
        this.attachChatToggleListeners();
        this.attachMessageSendListeners();
        this.attachInputListeners();
        this.attachKeyboardListeners();
        this.attachClickOutsideListener();
        this.attachRippleEffects();
    }

    /**
     * Attach chat toggle listeners
     */
    attachChatToggleListeners() {
        const chatButton = document.getElementById('rakk-chat-button');
        const closeButton = document.getElementById('rakk-chat-close');

        if (chatButton) {
            chatButton.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.chatWidget.toggleChat();
            });
        }

        if (closeButton) {
            closeButton.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.chatWidget.toggleChat();
            });
        }
    }

    /**
     * Attach message send listeners
     */
    attachMessageSendListeners() {
        const sendButton = document.getElementById('rakk-send-button');

        if (sendButton) {
            sendButton.addEventListener('click', (e) => {
                e.preventDefault();
                this.chatWidget.sendMessage();
            });
        }
    }

    /**
     * Attach input listeners
     */
    attachInputListeners() {
        const messageInput = document.getElementById('rakk-chat-input');
        const sendButton = document.getElementById('rakk-send-button');

        if (!messageInput || !sendButton) return;

        // Auto-resize textarea
        messageInput.addEventListener('input', () => {
            this.handleTextareaResize(messageInput);
            this.handleInputValidation(messageInput, sendButton);
        });

        // Focus/blur effects
        messageInput.addEventListener('focus', () => {
            messageInput.style.borderColor = '#FA5252';
            messageInput.style.boxShadow = '0 0 0 3px rgba(250,82,82,0.1)';
        });

        messageInput.addEventListener('blur', () => {
            messageInput.style.borderColor = '#e0e0e0';
            messageInput.style.boxShadow = 'none';
        });

        // Initialize button state
        sendButton.style.opacity = '0.5';
        sendButton.disabled = true;
    }

    /**
     * Handle textarea auto-resize
     */
    handleTextareaResize(messageInput) {
        messageInput.style.height = 'auto';
        const newHeight = Math.min(messageInput.scrollHeight, 120);
        messageInput.style.height = newHeight + 'px';
        
        // Show scrollbar only when content exceeds max height
        if (messageInput.scrollHeight > 120) {
            messageInput.style.overflowY = 'auto';
            messageInput.style.scrollbarWidth = 'thin';
        } else {
            messageInput.style.overflowY = 'hidden';
            messageInput.style.scrollbarWidth = 'none';
        }
    }

    /**
     * Handle input validation
     */
    handleInputValidation(messageInput, sendButton) {
        const value = messageInput.value.trim();
        sendButton.style.opacity = value ? '1' : '0.5';
        sendButton.disabled = !value;
    }

    /**
     * Attach keyboard listeners
     */
    attachKeyboardListeners() {
        const messageInput = document.getElementById('rakk-chat-input');

        if (messageInput) {
            // Enter key handling
            messageInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    this.chatWidget.sendMessage();
                }
            });

            // Prevent form submission
            messageInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                }
            });
        }

        // Global keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            // Escape to close chat
            if (e.key === 'Escape' && this.chatWidget.isOpen) {
                this.chatWidget.toggleChat();
            }
        });
    }

    /**
     * Attach click outside listener
     */
    attachClickOutsideListener() {
        // Use a timeout to prevent immediate closing on button click
        let clickOutsideEnabled = false;
        
        // Enable click outside detection after a short delay
        setTimeout(() => {
            clickOutsideEnabled = true;
        }, 100);
        
        document.addEventListener('click', (e) => {
            if (!clickOutsideEnabled) return;
            
            const chatWindow = document.getElementById('rakk-chat-window');
            const chatButton = document.getElementById('rakk-chat-button');
            
            if (this.chatWidget.isOpen && 
                chatWindow && chatButton &&
                !chatWindow.contains(e.target) && 
                !chatButton.contains(e.target)) {
                
                // Reset the flag temporarily to prevent immediate re-closing
                clickOutsideEnabled = false;
                this.chatWidget.toggleChat();
                
                // Re-enable after animation
                setTimeout(() => {
                    clickOutsideEnabled = true;
                }, 300);
            }
        });
    }

    /**
     * Attach ripple effects
     */
    attachRippleEffects() {
        const chatButton = document.getElementById('rakk-chat-button');
        const sendButton = document.getElementById('rakk-send-button');

        if (chatButton) {
            chatButton.addEventListener('mousedown', this.createRipple);
        }

        if (sendButton) {
            sendButton.addEventListener('mousedown', this.createRipple);
        }
    }

    /**
     * Create ripple effect
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
