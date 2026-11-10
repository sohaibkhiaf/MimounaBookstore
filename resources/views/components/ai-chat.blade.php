@php
    $locale = app()->getLocale();
    $aiBaseUrl = rtrim(config('services.ai_assistant.url', env('AI_ASSISTANT_URL', 'http://127.0.0.1:8642')), '/');

    $ui = match ($locale) {
        'ar' => [
            'title'       => 'مساعد مكتبة الميمونة الذكي',
            'subtitle'    => 'متصل الآن • اسألني عن الكتب والتوصيل',
            'welcome'     => 'أهلاً بك في مكتبة ميمونة! 📚 أنا مساعدك الذكي، يمكنني إجابتك حول الكتب المتوفرة، الأسعار والتخفيضات، التصنيفات، مراجعات القراء، وأسعار التوصيل لجميع الولايات. كيف يمكنني مساعدتك اليوم؟',
            'placeholder' => 'اكتب سؤالك هنا...',
            'send'        => 'إرسال',
            'reset'       => 'محادثة جديدة',
            'close'       => 'إغلاق',
            'thinking'    => 'جاري البحث والتحليل...',
            'error'       => 'المساعد الذكي معطل حاليا، يرجى المحاولة لاحقا.',
            'suggestions_label' => 'اقتراحات سريعة:',
            'suggestions' => [
                'ما هي الكتب المتوفرة في المتجر مع أسعارها؟',
                'ما هي الكتب التي عليها تخفيض حالياً؟',
                'ما هي التصنيفات المتوفرة والكتب في كل تصنيف؟',
                'ما هي أسعار التوصيل للمنزل والمكتب حسب الولايات؟',
                'ما هي أفضل مراجعات القراء لكتاب رسائل من القرآن؟',
            ],
        ],
        'fr' => [
            'title'       => 'Assistant IA Mimouna',
            'subtitle'    => 'En ligne • Livres, avis & livraison',
            'welcome'     => 'Bienvenue à la Librairie Mimouna ! 📚 Je suis votre assistant intelligent. Posez-moi vos questions sur nos livres, les prix et réductions, les catégories, les avis des lecteurs ou les tarifs de livraison par wilaya.',
            'placeholder' => 'Posez votre question ici...',
            'send'        => 'Envoyer',
            'reset'       => 'Nouvelle conversation',
            'close'       => 'Fermer',
            'thinking'    => 'Recherche en cours...',
            'error'       => 'L\'assistant intelligent est actuellement indisponible, veuillez réessayer plus tard.',
            'suggestions_label' => 'Suggestions rapides :',
            'suggestions' => [
                'Quels sont tous les livres disponibles et leurs prix ?',
                'Quels livres sont actuellement en promotion ?',
                'Quelles sont les catégories et leurs livres ?',
                'Quels sont les tarifs de livraison par wilaya ?',
                'Quels sont les meilleurs avis sur le livre رسائل من القرآن ?',
            ],
        ],
        default => [
            'title'       => 'Mimouna AI Assistant',
            'subtitle'    => 'Online • Ask about books, reviews & shipping',
            'welcome'     => 'Welcome to Mimouna Bookstore! 📚 I am your AI assistant. Ask me anything about our available books, prices & discounts, genres, top reader reviews, or delivery rates across regions.',
            'placeholder' => 'Type your question here...',
            'send'        => 'Send',
            'reset'       => 'New conversation',
            'close'       => 'Close',
            'thinking'    => 'Thinking & checking store data...',
            'error'       => 'The AI assistant is currently unavailable, please try again later.',
            'suggestions_label' => 'Quick suggestions:',
            'suggestions' => [
                'What books are available in the store and what are their prices?',
                'Which books currently have a discount?',
                'What are the book genres and the books under each genre?',
                'What are the home and desk delivery prices for each region?',
                'What are the top reviews for the book رسائل من القرآن?',
            ],
        ],
    };
@endphp

<div class="ai-chat-widget"
    data-api-url="{{ $aiBaseUrl }}/api/chat"
    data-welcome="{{ $ui['welcome'] }}"
    data-thinking="{{ $ui['thinking'] }}"
    data-error="{{ $ui['error'] }}">

    <!-- Floating Action Button -->
    <button type="button" class="ai-chat-fab" aria-label="{{ $ui['title'] }}" title="{{ $ui['title'] }}">
        <span class="ai-chat-fab-pulse"></span>
        <i class="fa-solid fa-robot ai-chat-fab-icon-open"></i>
        <i class="fa-solid fa-xmark ai-chat-fab-icon-close"></i>
    </button>

    <!-- Chat Window -->
    <div class="ai-chat-window" aria-hidden="true">

        <!-- Header -->
        <div class="ai-chat-header">
            <div class="ai-chat-header-info">
                <div class="ai-chat-avatar">
                    <i class="fa-solid fa-robot"></i>
                    <span class="ai-chat-status-dot"></span>
                </div>
                <div class="ai-chat-title-wrap">
                    <h4>{{ $ui['title'] }}</h4>
                    <p>{{ $ui['subtitle'] }}</p>
                </div>
            </div>

            <div class="ai-chat-header-actions">
                <button type="button" class="ai-chat-reset-btn" title="{{ $ui['reset'] }}">
                    <i class="fa-solid fa-rotate-right"></i>
                </button>
                <button type="button" class="ai-chat-close-btn" title="{{ $ui['close'] }}">
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
            </div>
        </div>

        <!-- Messages List -->
        <div class="ai-chat-messages"></div>

        <!-- Quick Suggestions -->
        <div class="ai-chat-suggestions">
            <div class="ai-chat-suggestions-header">
                <span><i class="fa-solid fa-wand-magic-sparkles"></i> {{ $ui['suggestions_label'] }}</span>
                <button type="button" class="ai-chat-suggestions-toggle" title="Toggle suggestions">
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
            </div>
            <div class="ai-chat-suggestions-list">
                @foreach ($ui['suggestions'] as $suggestion)
                    <button type="button" class="ai-chat-suggestion-chip" data-prompt="{{ $suggestion }}">
                        {{ $suggestion }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Input Area -->
        <form class="ai-chat-form" autocomplete="off">
            <input type="text" class="ai-chat-input" placeholder="{{ $ui['placeholder'] }}" maxlength="1000" required />
            <button type="submit" class="ai-chat-send-btn" title="{{ $ui['send'] }}">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>

    </div>

</div>
