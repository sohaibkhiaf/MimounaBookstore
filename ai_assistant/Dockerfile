# ==============================================================================
# Mimouna Bookstore AI Assistant - Dockerfile (Ubuntu 24.04 LTS)
# Relies on local Ollama running on the host machine (http://host.docker.internal:11434)
# ==============================================================================
FROM ubuntu:24.04

LABEL maintainer="Mimouna Bookstore"
LABEL description="Ubuntu 24.04 container for FastAPI & OpenAI Agents SDK AI Assistant"

# Prevent interactive prompts and configure environment variables
ENV DEBIAN_FRONTEND=noninteractive \
    TZ=UTC \
    PYTHONDONTWRITEBYTECODE=1 \
    PYTHONUNBUFFERED=1 \
    PIP_NO_CACHE_DIR=1 \
    VIRTUAL_ENV=/opt/venv \
    PATH="/opt/venv/bin:$PATH" \
    HOST=0.0.0.0 \
    PORT=8642

# 1. Install system dependencies, Python 3, and venv
RUN apt-get update && apt-get install -y --no-install-recommends \
    ca-certificates \
    curl \
    python3 \
    python3-pip \
    python3-venv \
    python3-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 2. Setup Python virtual environment
RUN python3 -m venv "$VIRTUAL_ENV" \
    && pip install --upgrade pip setuptools wheel

# 3. Set application working directory and install Python dependencies
WORKDIR /app
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt

# 4. Copy application files
COPY . .

# Expose port for FastAPI AI Assistant
EXPOSE 8642

# Standard Docker CMD to start the FastAPI server via main.py entrypoint
CMD ["python", "main.py"]
