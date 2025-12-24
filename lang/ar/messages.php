<?php


return [

    'success_logged_in' => 'تم تسجيل الدخول بنجاح',
    'success_logged_out' => 'تم تسجيل الخروج بنجاح',

    'error_invalid_credentials' => 'لقد قمت بإدخال بيانات غير صالحة',

    'error_password_characters' => 'يجب أن تحتوي كلمة المرور على 8 حروف على الأقل',
    'error_password_confirmation' => 'حقل تأكيد كلمة المرور لا يتوافق مع حقل كلمة المرور',
    'error_email_characters' => 'حقل البريد الإلكتروني يجب أن لا يتجاوز 100 حرف',
    'error_fullname_characters' => 'لا يجب أن يتجاوز الإسم الكامل 50 حرف',
    'error_phone_characters' => 'رقم الهاتف يجب أن يحتوي 10 أرقام',
    'error_address_characters' => 'يجب أن لا يتجاوز حقل العنوان 255 حرف',
    'error_password_mandatory' => 'كلمة المرور الحالية ضرورية إذا كنت ترغب بتغيير كلمة المرور',

    'success_account_created' => 'تم إنشاء الحساب بنجاح',
    'error_unexpected' => 'حدث خطأ غير متوقع',

    'error_current_password' => 'كلمة المرور الحالية خاطئة',
    'success_account_info' => 'تم تغيير معلومات الحساب بنجاح',

    'success_book_added' => 'تم إضافة الكتاب بنجاح',
    'success_book_updated' => 'تم تعديل الكتاب بنجاح',
    'success_book_deleted' => 'تم حذف الكتاب `:book_title` بنجاح',

    'error_require_verification' => 'هذا الإجراء يتطلب التحقق من البريد الإلكتروني',
    'success_email_verified' => 'تم التحقق من البريد الإلكتروني بنجاح',
    'success_link_sent' => 'تم إرسال رابط التحقق!',

    'success_genre_added' => 'تم إضافة التصنيف بنجاح',
    'success_genre_updated' => 'تم تعديل التصنيف بنجاح',
    'error_default_genres' => 'لا يمكنك حذف التصنيفات الأساسية',
    'success_genre_deleted' => 'تم حذف التصنيف بنجاح',

    'success_order_updated' => 'تم تعديل الطلبية #:order_id بنجاح',
    'success_order_created' => 'تم إنشاء الطلبية بنجاح',
    'success_order_deleted' => 'تم حذف الطلبية `#:order_id` بنجاح',

    'success_region_updated' => 'تم تعديل إعدادات الولاية `:region_name` بنجاح',

    'success_reset_link_sent' => 'تم إرسال رابط إعادة تعيين كلمة المرور',
    'success_password_updated' => 'تم تغيير كلمة المرور بنجاح',

    'success_review_added_admin' => 'تم إضافة مراجعتك بنجاح',
    'success_review_updated_admin' => 'تم تعديل مراجعتك بنجاح',
    'success_review_added' => 'تم إرسال مراجعتك وهي قيد المراجعة من قبل الإدارة.',
    'success_review_updated' => 'تم تحديث مراجعتك وستخضع للمراجعة من قبل الإدارة قبل نشرها.',
    'success_review_deleted' => 'تم حذف مراجعتك بنجاح',

    'error_banned_from_reviewing' => 'لقد تم حضرك عن إضافة مراجعات أو تعديل مراجعاتك السابقة أو حذفها، إتصل بالدعم الخاص بنا إذا كنت تعتقد أن خطأ ما قد حصل.',
    'success_user_banned' => 'لقد تم منع المستخدم من إضافة مراجعات أو حذف مراجعاته السابقة أو تعديلها.',
    'success_user_unbanned' => 'لقد تم رفع الحضر على المستخدم بنجاح.',

    'success_admin_deleted_review' => 'لقد قمت بحذف مراجعة :user_name بنجاح',

    'error_empty_fields' => 'بعض الحقول قد تم تجاهلها',
    'error_details_not_set' => 'لم يتم إدخال أي تفاصيل',

    'success_like_book' => 'لقد أضفت إعجابك ل :book_title بنجاح',
    'success_unlike_book' => 'لقد قمت بإلغاء إعجابك ب :book_title بنجاح',
    'error_like_book' => 'أنت بالفعل معجب ب :book_title',
    'error_unlike_book' => 'أنت بالفعل غير معجب ب :book_title',

    'success_upvote_review' => 'لقد قمت بالتصويت على المراجعة بنجاح',
    'success_downvote_review' => 'لقد قمت بإلغاء تصويتك على المراجعة بنجاح',
    'error_upvote_review' => 'لقد قمت بالفعل بالتصويت على المراجعة',
    'error_downvote_review' => 'أنت لم تصوت على المراجعة بعد',

    'error_shipping_not_possible' => 'التوصيل إلى منطقتك غير ممكن',
    'success_your_order_created' => 'تم إنشاء طلبيتك بنجاح',

    'success_publish_review' => 'تم نشر المراجعة بنجاح',
    'success_unpublish_review' => 'تم إلغاء نشر المراجعة بنجاح',

    'error_update_unpublished_review' => 'لا يمكنك تحديث مراجعة لم يتم نشرها بعد',
    'error_delete_unpublished_review' => 'لا يمكنك حذف مراجعة لم يتم نشرها بعد',
];

