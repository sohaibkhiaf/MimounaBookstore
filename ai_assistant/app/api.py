from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware

from .agent import run_agent_chat
from .config import settings
from .schemas import (
    ChatRequest,
    ChatResponse,
    HealthResponse,
)

app = FastAPI(
    title="Mimouna Bookstore AI Assistant API",
    description=(
        "AI Agent microservice powered by OpenAI Agents SDK & local Ollama (qwen3:4b-instruct) "
        "with real-time tools connected to the Mimouna Bookstore API."
    ),
    version="1.0.0",
)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


@app.get("/health", response_model=HealthResponse, tags=["System"])
async def health_check() -> HealthResponse:
    """Check service health and active configuration."""
    return HealthResponse(
        status="ok",
        model=settings.ollama_model,
        ollama_base_url=settings.ollama_base_url,
        bookstore_api_base_url=settings.bookstore_api_base_url,
    )


@app.post("/api/chat", response_model=ChatResponse, tags=["AI Assistant"])
@app.post("/chat", response_model=ChatResponse, tags=["AI Assistant"])
async def chat_endpoint(payload: ChatRequest) -> ChatResponse:
    """Send a prompt to the AI Assistant and receive a grounded response."""
    try:
        reply_text = await run_agent_chat(prompt=payload.prompt)
        return ChatResponse(
            success=True,
            response=reply_text,
        )
    except Exception as exc:
        raise HTTPException(
            status_code=500,
            detail=f"AI Agent execution error: {exc}",
        ) from exc
