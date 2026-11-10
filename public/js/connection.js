// Connection URLs are loaded from the Laravel .env file (APP_URL, AI_ASSISTANT_URL).
// They are injected into <meta> tags by the Blade layouts (layouts/app & layouts/app-admin).

function readMeta(name) {
    const meta = document.querySelector(`meta[name="${name}"]`);
    const value = meta ? meta.getAttribute("content") : "";
    return value ? value.trim() : "";
}

function withTrailingSlash(url) {
    return url.endsWith("/") ? url : `${url}/`;
}

function withoutTrailingSlash(url) {
    return url.replace(/\/+$/, "");
}

// Laravel application base URL (from APP_URL), falls back to the current origin
export const URL = withTrailingSlash(readMeta("app-url") || window.location.origin);

// AI Assistant service base URL (from AI_ASSISTANT_URL)
export const AI_ASSISTANT_URL = withoutTrailingSlash(readMeta("ai-assistant-url"));
export const AI_CHAT_API_URL = `${AI_ASSISTANT_URL}/api/chat`;
