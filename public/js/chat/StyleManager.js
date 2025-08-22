/**
 * Style Manager
 * Handles all CSS injection and styling for the chat widget
 */
export class StyleManager {
    constructor() {
        this.styleElement = null;
    }

    /**
     * Inject all chat widget styles
     */
    injectStyles() {
        if (this.styleElement) return; // Prevent duplicate injection

        this.styleElement = document.createElement('style');
        this.styleElement.id = 'rakk-chat-styles';
        this.styleElement.textContent = this.getCSSStyles();
        document.head.appendChild(this.styleElement);
    }

    /**
     * Remove injected styles
     */
    removeStyles() {
        if (this.styleElement) {
            this.styleElement.remove();
            this.styleElement = null;
        }
    }

    /**
     * Get all CSS styles for the chat widget
     */
    getCSSStyles() {
        return `
            /* Chat Widget Base Styles */
            #rakk-chat-widget {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 10000;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            }

            /* Chat Button */
            #rakk-chat-button {
                width: 60px;
                height: 60px;
                background: linear-gradient(135deg, #FA5252, #E03131);
                border: none;
                border-radius: 50%;
                cursor: pointer;
                box-shadow: 0 4px 20px rgba(250, 82, 82, 0.4);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 24px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
            }

            #rakk-chat-button:hover {
                transform: translateY(-2px) scale(1.05);
                box-shadow: 0 8px 30px rgba(250, 82, 82, 0.6);
                background: linear-gradient(135deg, #E03131, #C92A2A);
            }

            #rakk-chat-button.active {
                transform: scale(0.95);
                box-shadow: 0 2px 10px rgba(250, 82, 82, 0.4);
            }

            /* Chat Window */
            #rakk-chat-window {
                position: absolute;
                bottom: 80px;
                right: 0;
                width: 350px;
                height: 500px;
                background: white;
                border-radius: 16px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
                display: none;
                flex-direction: column;
                overflow: hidden;
                border: 1px solid rgba(0, 0, 0, 0.08);
                transform: translateY(20px);
                opacity: 0;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            #rakk-chat-window.open {
                display: flex;
                transform: translateY(0);
                opacity: 1;
            }

            /* Chat Header */
            #rakk-chat-header {
                background: linear-gradient(135deg, #FA5252, #E03131);
                color: white;
                padding: 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-radius: 16px 16px 0 0;
            }

            #rakk-chat-header h3 {
                margin: 0;
                font-size: 18px;
                font-weight: 600;
            }

            #rakk-chat-close {
                background: none;
                border: none;
                color: white;
                font-size: 24px;
                cursor: pointer;
                padding: 0;
                width: 30px;
                height: 30px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s ease;
            }

            #rakk-chat-close:hover {
                background: rgba(255, 255, 255, 0.2);
                transform: scale(1.1);
            }

            /* Chat Messages */
            #rakk-chat-messages {
                flex: 1;
                padding: 20px;
                overflow-y: auto;
                background: #f8f9fa;
                max-height: 350px;
                scrollbar-width: thin;
                scrollbar-color: #cbd5e0 transparent;
            }

            #rakk-chat-messages::-webkit-scrollbar {
                width: 6px;
            }

            #rakk-chat-messages::-webkit-scrollbar-track {
                background: transparent;
            }

            #rakk-chat-messages::-webkit-scrollbar-thumb {
                background: #cbd5e0;
                border-radius: 3px;
            }

            #rakk-chat-messages::-webkit-scrollbar-thumb:hover {
                background: #a0aec0;
            }

            /* Message Styles */
            .rakk-message {
                margin-bottom: 16px;
                animation: messageSlideIn 0.3s ease-out;
            }

            @keyframes messageSlideIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .rakk-message.user {
                text-align: right;
            }

            .rakk-message.bot {
                text-align: left;
            }

            .rakk-message-content {
                display: inline-block;
                padding: 12px 16px;
                border-radius: 18px;
                max-width: 80%;
                word-wrap: break-word;
                line-height: 1.5;
                font-size: 14px;
            }

            .rakk-message.user .rakk-message-content {
                background: linear-gradient(135deg, #FA5252, #E03131);
                color: white;
                border-bottom-right-radius: 6px;
            }

            .rakk-message.bot .rakk-message-content {
                background: white;
                color: #333;
                border: 1px solid #e0e0e0;
                border-bottom-left-radius: 6px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            }

            /* Typing Indicator */
            .rakk-typing-indicator {
                display: flex;
                align-items: center;
                padding: 12px 16px;
                max-width: 60px;
                margin-bottom: 16px;
            }

            .rakk-typing-dots {
                display: flex;
                gap: 4px;
            }

            .rakk-typing-dot {
                width: 6px;
                height: 6px;
                background: #999;
                border-radius: 50%;
                animation: typingBounce 1.4s infinite ease-in-out;
            }

            .rakk-typing-dot:nth-child(1) {
                animation-delay: -0.32s;
            }

            .rakk-typing-dot:nth-child(2) {
                animation-delay: -0.16s;
            }

            @keyframes typingBounce {
                0%, 80%, 100% {
                    transform: scale(0.8);
                    opacity: 0.5;
                }
                40% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            /* Product Grid */
            .rakk-products-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
                gap: 12px;
                margin-top: 12px;
            }

            .rakk-product-card {
                background: white;
                border: 1px solid #e0e0e0;
                border-radius: 12px;
                padding: 12px;
                text-align: center;
                transition: all 0.2s ease;
                cursor: pointer;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            }

            .rakk-product-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
                border-color: #FA5252;
            }

            .rakk-product-image {
                width: 100%;
                height: 80px;
                object-fit: cover;
                border-radius: 8px;
                margin-bottom: 8px;
            }

            .rakk-product-name {
                font-size: 12px;
                font-weight: 600;
                color: #333;
                margin-bottom: 4px;
                line-height: 1.3;
            }

            .rakk-product-price {
                font-size: 14px;
                color: #FA5252;
                font-weight: 700;
            }

            /* Chat Input */
            #rakk-chat-input-container {
                padding: 20px;
                background: white;
                border-top: 1px solid #e0e0e0;
                display: flex;
                gap: 12px;
                align-items: flex-end;
            }

            #rakk-chat-input {
                flex: 1;
                border: 1px solid #e0e0e0;
                border-radius: 20px;
                padding: 12px 16px;
                font-size: 14px;
                resize: none;
                outline: none;
                transition: all 0.2s ease;
                min-height: 40px;
                max-height: 120px;
                line-height: 1.4;
                font-family: inherit;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            #rakk-chat-input::-webkit-scrollbar {
                display: none;
            }

            #rakk-chat-input:focus {
                border-color: #FA5252;
                box-shadow: 0 0 0 3px rgba(250, 82, 82, 0.1);
            }

            #rakk-send-button {
                background: linear-gradient(135deg, #FA5252, #E03131);
                border: none;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 16px;
                transition: all 0.2s ease;
                flex-shrink: 0;
                position: relative;
                overflow: hidden;
            }

            #rakk-send-button:hover:not(:disabled) {
                transform: scale(1.05);
                box-shadow: 0 4px 12px rgba(250, 82, 82, 0.4);
            }

            #rakk-send-button:active {
                transform: scale(0.95);
            }

            #rakk-send-button:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }

            /* Welcome Message */
            .rakk-welcome-message {
                text-align: center;
                padding: 20px;
                color: #666;
                font-style: italic;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                #rakk-chat-widget {
                    bottom: 10px;
                    right: 10px;
                }

                #rakk-chat-window {
                    width: calc(100vw - 20px);
                    max-width: 350px;
                    height: 450px;
                    bottom: 80px;
                    right: 0;
                }

                #rakk-chat-header {
                    padding: 16px;
                }

                #rakk-chat-messages {
                    padding: 16px;
                    max-height: 280px;
                }

                #rakk-chat-input-container {
                    padding: 16px;
                }

                .rakk-products-grid {
                    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                    gap: 10px;
                }

                .rakk-product-card {
                    padding: 10px;
                }

                .rakk-product-image {
                    height: 70px;
                }

                .rakk-product-name {
                    font-size: 11px;
                }

                .rakk-product-price {
                    font-size: 13px;
                }
            }

            @media (max-width: 480px) {
                #rakk-chat-window {
                    width: calc(100vw - 10px);
                    height: 400px;
                    bottom: 70px;
                    right: 5px;
                }

                #rakk-chat-button {
                    width: 50px;
                    height: 50px;
                    font-size: 20px;
                }

                .rakk-products-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            /* Animation Utilities */
            .rakk-fade-in {
                animation: fadeIn 0.3s ease-out;
            }

            .rakk-scale-in {
                animation: scaleIn 0.2s ease-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            @keyframes scaleIn {
                from {
                    transform: scale(0.8);
                    opacity: 0;
                }
                to {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            /* Loading Spinner */
            .rakk-loading-spinner {
                width: 20px;
                height: 20px;
                border: 2px solid #f3f3f3;
                border-top: 2px solid #FA5252;
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin: 0 auto;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            /* Error Message */
            .rakk-error-message {
                background: #fee;
                color: #c53030;
                border: 1px solid #fed7d7;
                border-radius: 8px;
                padding: 12px;
                margin: 8px 0;
                font-size: 13px;
            }

            /* Success Message */
            .rakk-success-message {
                background: #f0fff4;
                color: #38a169;
                border: 1px solid #c6f6d5;
                border-radius: 8px;
                padding: 12px;
                margin: 8px 0;
                font-size: 13px;
            }
        `;
    }
}
