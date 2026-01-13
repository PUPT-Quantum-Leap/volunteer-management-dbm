import React, { useState, useEffect, useRef } from 'react';
import { createRoot } from 'react-dom/client';
import {
  MessageCircle,
  Send,
  X,
  Settings,
  Volume2,
  Trash2,
  Zap,
  Mic,
  ArrowUp,
  Bot
} from 'lucide-react';

function AdminChatbot({ userName }) {
  const [isOpen, setIsOpen] = useState(false);
  const [messages, setMessages] = useState([]);
  const [inputMessage, setInputMessage] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  const messagesEndRef = useRef(null);
  const inputRef = useRef(null);

  const scrollToBottom = () => {
    messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' });
  };

  useEffect(() => {
    scrollToBottom();
  }, [messages, isOpen]);

  useEffect(() => {
    if (isOpen && inputRef.current) {
      inputRef.current.focus();
    }
  }, [isOpen]);

  useEffect(() => {
    const handleToggle = () => setIsOpen(prev => !prev);
    window.addEventListener('toggle-admin-chat', handleToggle);
    return () => window.removeEventListener('toggle-admin-chat', handleToggle);
  }, []);

  const sendMessage = async (e) => {
    e.preventDefault();

    if (!inputMessage.trim() || isLoading) return;

    const userMessage = {
      id: Date.now(),
      text: inputMessage,
      sender: 'user',
      timestamp: new Date()
    };

    setMessages(prev => [...prev, userMessage]);
    setInputMessage('');
    setIsLoading(true);

    try {
      const response = await fetch('/admin/chatbot', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ message: inputMessage })
      });

      const data = await response.json();

      if (data.success) {
        const botMessage = {
          id: Date.now() + 1,
          text: data.response,
          sender: 'bot',
          timestamp: new Date()
        };
        setMessages(prev => [...prev, botMessage]);
      } else {
        throw new Error(data.message || 'Failed to get response');
      }
    } catch (error) {
      console.error('Chat error:', error);
      const errorMessage = {
        id: Date.now() + 1,
        text: 'Sorry, I encountered an error. Please try again.',
        sender: 'bot',
        timestamp: new Date(),
        isError: true
      };
      setMessages(prev => [...prev, errorMessage]);
    } finally {
      setIsLoading(false);
    }
  };

  const clearChat = () => {
    setMessages([]);
  };

  return (
    <>
      {/* Sidebar Overlay */}
      {isOpen && (
        <div
          className="fixed inset-0 bg-transparent z-40"
          onClick={() => setIsOpen(false)}
        />
      )}

      {/* Sidebar Panel */}
      <div
        className={`fixed top-[110px] right-0 h-[calc(100vh-110px)] w-[400px] bg-white/95 backdrop-blur-xl shadow-[-10px_0_30px_rgba(0,0,0,0.1)] z-50 flex flex-col transform transition-transform duration-300 ease-in-out border-l border-blue-500/10 ${isOpen ? 'translate-x-0' : 'translate-x-full'
          }`}
        onClick={(e) => e.stopPropagation()}
      >
        {/* Header */}
        <div className="h-20 px-6 bg-gradient-to-r from-blue-600 to-blue-500 flex items-center justify-between shadow-lg flex-shrink-0">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/20 shadow-inner">
              <Bot className="w-6 h-6 text-white" />
            </div>
            <div>
              <h3 className="font-bold text-white text-lg leading-tight">Gotcha</h3>
              <p className="text-blue-100 text-xs font-medium opacity-90">Always here to help</p>
            </div>
          </div>
          <div className="flex items-center gap-1 text-white/90">
            <button className="p-2 hover:bg-white/20 rounded-lg transition-all duration-200 hover:scale-105" title="Settings">
              <Settings className="w-4 h-4" />
            </button>
            <button className="p-2 hover:bg-white/20 rounded-lg transition-all duration-200 hover:scale-105" title="Mute">
              <Volume2 className="w-4 h-4" />
            </button>
            <button
              onClick={clearChat}
              className="p-2 hover:bg-white/20 rounded-lg transition-all duration-200 hover:scale-105"
              title="Clear Chat"
            >
              <Trash2 className="w-4 h-4" />
            </button>
            <button
              onClick={() => setIsOpen(false)}
              className="p-2 hover:bg-white/20 rounded-lg transition-all duration-200 hover:scale-105 ml-1"
              aria-label="Close chat"
            >
              <X className="w-5 h-5" />
            </button>
          </div>
        </div>

        {/* Content Area */}
        <div className="flex-1 overflow-y-auto bg-gradient-to-b from-slate-50 to-white relative">

          {/* Welcome Screen / Empty State */}
          {messages.length === 0 && (
            <div className="absolute inset-0 flex flex-col items-center justify-center p-8 text-center animate-fade-in">
              <div className="w-24 h-24 mb-6 rounded-3xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20 transform hover:scale-105 transition-transform duration-300">
                <Bot className="w-12 h-12 text-white" />
              </div>
              <h2 className="text-2xl font-bold text-slate-800 mb-2">
                Hi, <span className="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-400">{userName || 'there'}</span>
              </h2>
              <h3 className="text-lg font-medium text-slate-600 mb-6">
                How can I assist you today?
              </h3>

              <div className="grid grid-cols-2 gap-3 w-full max-w-[320px]">
                <button
                  onClick={() => setInputMessage("Show me recent volunteers")}
                  className="p-4 bg-white border border-slate-100 rounded-xl shadow-sm hover:shadow-md hover:border-blue-200 transition-all text-xs text-left group"
                >
                  <span className="block mb-1 text-blue-500 group-hover:scale-110 transition-transform origin-left">
                    <Zap className="w-4 h-4" />
                  </span>
                  <span className="text-slate-600 font-medium">Recent Volunteers</span>
                </button>
                <button
                  onClick={() => setInputMessage("Generate monthly report")}
                  className="p-4 bg-white border border-slate-100 rounded-xl shadow-sm hover:shadow-md hover:border-blue-200 transition-all text-xs text-left group"
                >
                  <span className="block mb-1 text-purple-500 group-hover:scale-110 transition-transform origin-left">
                    <MessageCircle className="w-4 h-4" />
                  </span>
                  <span className="text-slate-600 font-medium">Monthly Report</span>
                </button>
              </div>
            </div>
          )}

          {/* Messages */}
          <div className="p-4 space-y-6 pt-6">
            {messages.map((message) => (
              <div
                key={message.id}
                className={`flex gap-3 ${message.sender === 'user' ? 'justify-end' : 'justify-start'}`}
              >
                {message.sender === 'bot' && (
                  <div className="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex-shrink-0 flex items-center justify-center mt-1 shadow-md shadow-blue-500/20">
                    <Bot className="w-4 h-4 text-white" />
                  </div>
                )}

                <div
                  className={`max-w-[85%] rounded-2xl px-5 py-3 shadow-sm ${message.sender === 'user'
                    ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-tr-sm shadow-blue-500/20'
                    : message.isError
                      ? 'bg-red-50 text-red-800 border border-red-100 rounded-tl-sm'
                      : 'bg-white border border-slate-100 text-slate-700 rounded-tl-sm shadow-md'
                    }`}
                >
                  <p className="text-sm leading-relaxed whitespace-pre-wrap font-medium">{message.text}</p>
                  <p className={`text-[10px] mt-1.5 opacity-70 ${message.sender === 'user' ? 'text-blue-100' : 'text-slate-400'}`}>
                    {new Date(message.timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                  </p>
                </div>
              </div>
            ))}

            {isLoading && (
              <div className="flex gap-3 justify-start">
                <div className="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex-shrink-0 flex items-center justify-center mt-1 shadow-md shadow-blue-500/20">
                  <Bot className="w-4 h-4 text-white" />
                </div>
                <div className="bg-white border border-slate-100 rounded-2xl rounded-tl-sm px-5 py-4 shadow-md flex items-center gap-1.5">
                  <div className="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style={{ animationDelay: '0ms' }} />
                  <div className="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style={{ animationDelay: '150ms' }} />
                  <div className="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style={{ animationDelay: '300ms' }} />
                </div>
              </div>
            )}
            <div ref={messagesEndRef} />
          </div>
        </div>

        {/* Input Area */}
        <div className="p-5 bg-white border-t border-slate-100 flex-shrink-0">
          <form
            onSubmit={sendMessage}
            className="flex items-center gap-2 p-2 bg-slate-50 border border-slate-200 rounded-[2rem] shadow-sm hover:border-blue-300 transition-all duration-300 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/10 focus-within:bg-white"
          >
            <div className="flex items-center gap-1 pl-2">
              <button
                type="button"
                className="p-2 text-slate-400 hover:text-blue-500 hover:bg-blue-50 rounded-full transition-colors"
              >
                <Zap className="w-5 h-5" />
              </button>
            </div>

            <input
              ref={inputRef}
              type="text"
              value={inputMessage}
              onChange={(e) => setInputMessage(e.target.value)}
              placeholder="Type your message..."
              disabled={isLoading}
              className="flex-1 bg-transparent border-none focus:ring-0 text-slate-700 placeholder-slate-400 px-2 py-2 text-sm font-medium"
            />

            <div className="flex items-center gap-1 pr-1">
              {!inputMessage.trim() ? (
                <button
                  type="button"
                  className="p-2 text-slate-400 hover:text-blue-500 hover:bg-blue-50 rounded-full transition-colors"
                >
                  <Mic className="w-5 h-5" />
                </button>
              ) : (
                <button
                  type="submit"
                  disabled={isLoading}
                  className="p-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-full hover:shadow-lg shadow-blue-500/30 transition-all duration-200 disabled:opacity-50 hover:scale-105 transform"
                >
                  <ArrowUp className="w-5 h-5" />
                </button>
              )}
            </div>
          </form>
          <p className="text-center text-[10px] text-slate-400 mt-3">
            AI can minimize mistakes, but check important info.
          </p>
        </div>
      </div>
    </>
  );
}

// Mount the component
const rootElement = document.getElementById('admin-chatbot-root');
if (rootElement) {
  const userName = rootElement.getAttribute('data-user-name');
  const root = createRoot(rootElement);
  root.render(<AdminChatbot userName={userName} />);
}

export default AdminChatbot;
