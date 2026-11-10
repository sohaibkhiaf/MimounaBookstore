import sys
from pathlib import Path

ROOT_DIR = Path(__file__).resolve().parent
if str(ROOT_DIR) not in sys.path:
    sys.path.insert(0, str(ROOT_DIR))

import uvicorn

from app.api import app
from app.config import settings

__all__ = ["app", "main"]


def main() -> None:
    """Entry point to start the FastAPI AI Assistant server using Uvicorn."""
    uvicorn.run(
        app,
        host=settings.host,
        port=settings.port,
        reload=False,
    )


if __name__ == "__main__":
    main()
