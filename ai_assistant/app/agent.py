from agents import (
    Agent,
    ModelSettings,
    OpenAIChatCompletionsModel,
    RunConfig,
    Runner,
    set_tracing_disabled,
)
from openai import AsyncOpenAI

from .config import settings
from .tools import (
    get_all_books,
    get_book_top_reviews,
    get_delivery_regions,
    get_genres_with_books,
)

# Disable OpenAI cloud tracing since we run locally on Ollama
set_tracing_disabled(True)

# Configure AsyncOpenAI client pointing to local Ollama server
ollama_openai_client = AsyncOpenAI(
    base_url=settings.ollama_base_url,
    api_key=settings.ollama_api_key,
)

# Wrap Ollama model (qwen3:4b-instruct) using OpenAIChatCompletionsModel
ollama_model = OpenAIChatCompletionsModel(
    model=settings.ollama_model,
    openai_client=ollama_openai_client,
)

# Configure Ollama context window (num_ctx) so tool results never hit the 4096 default limit
ollama_model_settings = ModelSettings(
    extra_body={"options": {"num_ctx": settings.ollama_num_ctx}},
)

SYSTEM_INSTRUCTIONS = """أنت المساعد الذكي الرسمي لمتجر الكتب الإلكتروني "مكتبة ميمونة" (Mimouna Bookstore).
مهمتك هي مساعدة المستخدمين والإجابة عن استفساراتهم بدقة ووضوح باللغة التي يتحدثون بها (العربية، الفرنسية، أو الإنجليزية) بالاعتماد حصرياً على بيانات المتجر الحقيقية عبر الأدوات (Tools) المتاحة لك:

1. `get_all_books`: لجلب قائمة الكتب مع معرف الكتاب (id)، العنوان، اسم الكاتب، الوصف، السعر الأصلي، التخفيض، السعر الفعلي (effective_price)، والتوفر. مرّر `search_query` عند السؤال عن كتاب أو كاتب محدد.
2. `get_delivery_regions`: لجلب ولايات ومناطق التوصيل مع المعرف، الاسم بالعربية والفرنسية، إمكانية التوصيل (enabled)، وسعر التوصيل للمكتب (stop_desk) وللمنزل (a_domicile) بالدينار الجزائري (دج / DA). مرّر `region_query` عند السؤال عن ولاية معينة.
3. `get_genres_with_books`: لجلب قائمة التصنيفات (الفئات) مع الكتب المندرجة تحت كل تصنيف.
4. `get_book_top_reviews`: لجلب أفضل 10 مراجعات لكتاب معين (مرتبة حسب عدد الـ upvotes) عن طريق تمرير معرف الكتاب `book_id`. إذا لم تكن للكتاب مراجعات ستُرجع الأداة قائمة فارغة `[]`.

قواعد مهمة:
- استدعِ الأداة المناسبة دائماً قبل الإجابة عن أي سؤال يتعلق بالكتب، الأسعار، التخفيضات، التصنيفات، المراجعات، أو التوصيل.
- إذا سأل المستخدم عن مراجعات كتاب بالاسم، استخدم أولاً `get_all_books(search_query=...)` لمعرفة معرف الكتاب (`id`)، ثم استدعِ `get_book_top_reviews(book_id=...)`.
- لا تخترع كتباً أو أسعاراً غير موجودة في البيانات المسترجعة من الأدوات.
- اجعل إجاباتك منظمة، ودودة، ومباشرة.
"""

bookstore_agent = Agent(
    name="MimounaBookstoreAssistant",
    instructions=SYSTEM_INSTRUCTIONS,
    model=ollama_model,
    model_settings=ollama_model_settings,
    tools=[
        get_all_books,
        get_delivery_regions,
        get_genres_with_books,
        get_book_top_reviews,
    ],
)


async def run_agent_chat(prompt: str) -> str:
    """
    Execute a stateless agent turn for the given prompt and return the textual answer.
    """
    run_config = RunConfig(
        model_settings=ollama_model_settings,
    )

    result = await Runner.run(
        starting_agent=bookstore_agent,
        input=prompt,
        max_turns=settings.agent_max_turns,
        run_config=run_config,
    )

    return str(result.final_output) if result.final_output is not None else ""
