import { AI_CHAT_API_URL } from "../connection.js";

const STORAGE_MESSAGES_KEY = "mimouna_ai_chat_history";

const widget = document.querySelector(".ai-chat-widget");

if (widget) {
    const apiUrl = widget.getAttribute("data-api-url") || AI_CHAT_API_URL;
    const welcomeText = widget.getAttribute("data-welcome") || "";
    const errorText = widget.getAttribute("data-error") || "المساعد الذكي معطل حاليا، يرجى المحاولة لاحقا.";

    const fabBtn = widget.querySelector(".ai-chat-fab");
    const chatWindow = widget.querySelector(".ai-chat-window");
    const closeBtn = widget.querySelector(".ai-chat-close-btn");
    const resetBtn = widget.querySelector(".ai-chat-reset-btn");
    const messagesContainer = widget.querySelector(".ai-chat-messages");
    const suggestionsContainer = widget.querySelector(".ai-chat-suggestions");
    const suggestionsToggle = widget.querySelector(".ai-chat-suggestions-toggle");
    const suggestionChips = widget.querySelectorAll(".ai-chat-suggestion-chip");
    const chatForm = widget.querySelector(".ai-chat-form");
    const chatInput = widget.querySelector(".ai-chat-input");
    const sendBtn = widget.querySelector(".ai-chat-send-btn");

    let isSending = false;

    function getSavedHistory() {
        try {
            return JSON.parse(localStorage.getItem(STORAGE_MESSAGES_KEY) || "[]");
        } catch {
            return [];
        }
    }

    function saveHistory(history) {
        try {
            localStorage.setItem(STORAGE_MESSAGES_KEY, JSON.stringify(history.slice(-30)));
        } catch {
            // ignore storage quota errors
        }
    }

    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function appendMessageElement(role, text, isError = false) {
        const msgEl = document.createElement("div");
        msgEl.className = `ai-chat-msg ${role}` + (isError ? " error" : "");

        const avatarEl = document.createElement("div");
        avatarEl.className = "ai-chat-msg-avatar";
        avatarEl.innerHTML = role === "bot"
            ? '<i class="fa-solid fa-robot"></i>'
            : '<i class="fa-solid fa-user"></i>';

        const bubbleEl = document.createElement("div");
        bubbleEl.className = "ai-chat-msg-bubble";
        bubbleEl.textContent = text;

        msgEl.appendChild(avatarEl);
        msgEl.appendChild(bubbleEl);
        messagesContainer.appendChild(msgEl);
        scrollToBottom();
        return msgEl;
    }

    function showTypingIndicator() {
        const msgEl = document.createElement("div");
        msgEl.className = "ai-chat-msg bot ai-chat-typing-row";
        msgEl.innerHTML = `
            <div class="ai-chat-msg-avatar"><i class="fa-solid fa-robot"></i></div>
            <div class="ai-chat-msg-bubble">
                <div class="ai-chat-typing">
                    <span></span><span></span><span></span>
                </div>
            </div>
        `;
        messagesContainer.appendChild(msgEl);
        scrollToBottom();
        return msgEl;
    }

    function renderInitialMessages() {
        messagesContainer.innerHTML = "";
        const history = getSavedHistory();

        if (history.length === 0) {
            appendMessageElement("bot", welcomeText);
        } else {
            history.forEach((item) => {
                appendMessageElement(item.role, item.text, Boolean(item.isError));
            });
        }
    }

    async function sendPrompt(promptText) {
        const trimmed = (promptText || "").trim();
        if (!trimmed || isSending) return;

        isSending = true;
        sendBtn.disabled = true;
        chatInput.value = "";

        const history = getSavedHistory();
        if (history.length === 0 && welcomeText) {
            history.push({ role: "bot", text: welcomeText });
        }

        appendMessageElement("user", trimmed);
        history.push({ role: "user", text: trimmed });
        saveHistory(history);

        const typingEl = showTypingIndicator();

        try {
            const response = await fetch(apiUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                },
                body: JSON.stringify({
                    prompt: trimmed,
                }),
            });

            const data = await response.json();
            typingEl.remove();

            if (response.ok && data && data.success) {
                const reply = data.response || "";
                appendMessageElement("bot", reply);
                history.push({ role: "bot", text: reply });
                saveHistory(history);
            } else {
                const errReason = (data && data.detail) ? data.detail : `HTTP status ${response.status}`;
                console.log("AI Assistant Error:", errReason);
                appendMessageElement("bot", errorText, true);
            }
        } catch (err) {
            typingEl.remove();
            console.log("AI Assistant Error:", err);
            appendMessageElement("bot", errorText, true);
        } finally {
            isSending = false;
            sendBtn.disabled = false;
            chatInput.focus();
        }
    }

    function toggleChatWindow(forceOpen = null) {
        const shouldOpen = forceOpen !== null ? forceOpen : !widget.classList.contains("open");
        widget.classList.toggle("open", shouldOpen);
        chatWindow.setAttribute("aria-hidden", shouldOpen ? "false" : "true");
        if (shouldOpen) {
            scrollToBottom();
            setTimeout(() => chatInput.focus(), 150);
        }
    }

    fabBtn.addEventListener("click", () => toggleChatWindow());
    closeBtn.addEventListener("click", () => toggleChatWindow(false));

    if (suggestionsToggle && suggestionsContainer) {
        suggestionsToggle.addEventListener("click", () => {
            suggestionsContainer.classList.toggle("collapsed");
        });
    }

    suggestionChips.forEach((chip) => {
        chip.addEventListener("click", () => {
            const promptText = chip.getAttribute("data-prompt");
            if (promptText) {
                sendPrompt(promptText);
            }
        });
    });

    chatForm.addEventListener("submit", (e) => {
        e.preventDefault();
        sendPrompt(chatInput.value);
    });

    resetBtn.addEventListener("click", () => {
        if (isSending) return;

        localStorage.removeItem(STORAGE_MESSAGES_KEY);
        renderInitialMessages();
    });

    renderInitialMessages();
}
