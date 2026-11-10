import json
from typing import Any

import httpx
from agents import function_tool

from .config import settings


def _compact_json(data: Any) -> str:
    """Serialize data into compact UTF-8 JSON without unnecessary whitespace."""
    return json.dumps(data, ensure_ascii=False, separators=(",", ":"))


def _truncate_text(text: Any, max_len: int = 220) -> str:
    """Truncate long text fields to keep tool payloads concise inside the LLM context window."""
    cleaned = " ".join(str(text or "").split())
    if len(cleaned) <= max_len:
        return cleaned
    return cleaned[: max_len - 1].rstrip() + "…"


def _compact_book(book: dict[str, Any], include_description: bool = True, desc_limit: int = 200) -> dict[str, Any]:
    """Extract only AI-relevant book fields, omitting URLs and redundant flags to save tokens."""
    genre_obj = book.get("genre")
    genre_name = None
    if isinstance(genre_obj, dict):
        genre_name = genre_obj.get("ar_name") or genre_obj.get("fr_name") or genre_obj.get("en_name")

    item: dict[str, Any] = {
        "id": book.get("id"),
        "title": book.get("title"),
        "author": book.get("author"),
        "price": book.get("price"),
        "discount": book.get("discount"),
        "effective_price": book.get("effective_price"),
        "available": bool(book.get("available", True)),
        "bestseller": bool(book.get("bestseller", False)),
    }
    if genre_name:
        item["genre"] = genre_name
    if include_description and book.get("description"):
        item["description"] = _truncate_text(book.get("description"), max_len=desc_limit)
    return item


async def _fetch_from_bookstore_api(endpoint: str, params: dict[str, Any] | None = None) -> dict[str, Any]:
    """Perform an async GET request to the Laravel Bookstore API."""
    base_url = settings.bookstore_api_base_url.rstrip("/")
    url = f"{base_url}/{endpoint.lstrip('/')}"

    async with httpx.AsyncClient(timeout=settings.bookstore_api_timeout, follow_redirects=True) as client:
        response = await client.get(url, params=params, headers={"Accept": "application/json"})
        response.raise_for_status()
        return response.json()


@function_tool
async def get_all_books(search_query: str | None = None) -> str:
    """
    Fetch the list of all books from the Mimouna Bookstore API (/api/books).
    Returns each book's id, title, author, description, original price, discount price,
    effective_price, availability (in stock or not), bestseller flag, and genre name.

    Args:
        search_query: Optional keyword (book title or author name) to filter results.
                      Pass None or empty string to retrieve all books in the store.
    """
    try:
        payload = await _fetch_from_bookstore_api("/books")
        books: list[dict[str, Any]] = payload.get("data", [])

        is_filtered = False
        if search_query and search_query.strip():
            q = search_query.strip().lower()
            filtered = [
                b for b in books
                if q in str(b.get("title", "")).lower()
                or q in str(b.get("author", "")).lower()
                or q in str(b.get("description", "")).lower()
            ]
            if filtered:
                books = filtered
                is_filtered = True

        desc_limit = 350 if is_filtered else 160
        compact_books = [_compact_book(b, include_description=True, desc_limit=desc_limit) for b in books]

        return _compact_json({"count": len(compact_books), "books": compact_books})
    except Exception as exc:  # noqa: BLE001
        return _compact_json({"error": f"Failed to fetch books from Bookstore API: {exc}"})


@function_tool
async def get_delivery_regions(region_query: str | None = None) -> str:
    """
    Fetch the list of delivery regions (Wilayas) from the Mimouna Bookstore API (/api/regions).
    Returns each region's id (wilaya code), Arabic name (ar_name), French name (fr_name),
    delivery availability (enabled), stop_desk (office delivery price in DA),
    and a_domicile (home delivery price in DA).

    Args:
        region_query: Optional wilaya name (in Arabic or French) or wilaya ID/number to filter by.
                      Pass None or empty string to retrieve all delivery regions.
    """
    try:
        payload = await _fetch_from_bookstore_api("/regions")
        regions: list[dict[str, Any]] = payload.get("data", [])

        if region_query and region_query.strip():
            q = region_query.strip().lower()
            filtered = [
                r for r in regions
                if q == str(r.get("id", "")).lower()
                or q in str(r.get("ar_name", "")).lower()
                or q in str(r.get("fr_name", "")).lower()
            ]
            if filtered:
                regions = filtered

        compact_regions = [
            {
                "id": r.get("id"),
                "ar_name": r.get("ar_name"),
                "fr_name": r.get("fr_name"),
                "enabled": bool(r.get("enabled", False)),
                "stop_desk": r.get("stop_desk"),
                "a_domicile": r.get("a_domicile"),
            }
            for r in regions
        ]

        return _compact_json({"count": len(compact_regions), "regions": compact_regions})
    except Exception as exc:  # noqa: BLE001
        return _compact_json({"error": f"Failed to fetch delivery regions from Bookstore API: {exc}"})


@function_tool
async def get_genres_with_books() -> str:
    """
    Fetch all book categories/genres along with the books belonging to each genre
    from the Mimouna Bookstore API (/api/genres).
    Returns each genre's id, ar_name, fr_name, en_name, books_count, and the list of books under it.
    """
    try:
        payload = await _fetch_from_bookstore_api("/genres")
        genres: list[dict[str, Any]] = payload.get("data", [])
        compact_genres = [
            {
                "id": g.get("id"),
                "ar_name": g.get("ar_name"),
                "fr_name": g.get("fr_name"),
                "en_name": g.get("en_name"),
                "books_count": g.get("books_count", len(g.get("books", []))),
                "books": [
                    _compact_book(b, include_description=False)
                    for b in g.get("books", [])
                ],
            }
            for g in genres
        ]
        return _compact_json({"count": len(compact_genres), "genres": compact_genres})
    except Exception as exc:  # noqa: BLE001
        return _compact_json({"error": f"Failed to fetch genres from Bookstore API: {exc}"})


@function_tool
async def get_book_top_reviews(book_id: int) -> str:
    """
    Fetch up to the top 10 published reader reviews (sorted by upvotes descending) for a specific book
    by its book_id from the Mimouna Bookstore API (/api/books/{book_id}/reviews).
    Returns an empty list [] if the book has no reviews.

    Args:
        book_id: The numeric ID of the book whose reviews should be retrieved.
    """
    try:
        payload = await _fetch_from_bookstore_api(f"/books/{int(book_id)}/reviews")
        reviews: list[dict[str, Any]] = payload.get("data", [])
        compact_reviews = [
            {
                "id": rev.get("id"),
                "user_name": rev.get("user_name"),
                "review": _truncate_text(rev.get("review", ""), max_len=300),
                "upvotes_count": rev.get("upvotes_count", 0),
            }
            for rev in reviews
        ]
        return _compact_json(
            {
                "book_id": int(book_id),
                "count": len(compact_reviews),
                "reviews": compact_reviews,
            }
        )
    except Exception as exc:  # noqa: BLE001
        return _compact_json(
            {
                "book_id": int(book_id),
                "count": 0,
                "reviews": [],
                "error": f"Failed to fetch reviews for book {book_id}: {exc}",
            }
        )
