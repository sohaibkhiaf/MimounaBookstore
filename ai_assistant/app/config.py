from pathlib import Path

from pydantic_settings import BaseSettings, SettingsConfigDict

BASE_DIR = Path(__file__).resolve().parent.parent


class Settings(BaseSettings):
    """Application settings loaded from environment variables or .env file."""

    host: str = "127.0.0.1"
    port: int = 8642

    ollama_base_url: str = "http://localhost:11434/v1"
    ollama_api_key: str = "ollama"
    ollama_model: str = "qwen3:4b-instruct"
    ollama_num_ctx: int = 16384

    bookstore_api_base_url: str = "http://127.0.0.1:8000/api"
    bookstore_api_timeout: float = 15.0

    agent_max_turns: int = 10

    model_config = SettingsConfigDict(
        env_file=str(BASE_DIR / ".env"),
        env_file_encoding="utf-8",
        extra="ignore",
    )


settings = Settings()
