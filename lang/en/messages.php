<?php

return [

    'success_logged_in' => 'Logged in successfully.',
    'success_logged_out' => 'Logged out successfully.',

    'error_invalid_credentials' => 'Invalid credentials.',

    'error_password_characters' => 'The password must be at least 8 characters.',
    'error_password_confirmation' => 'The password confirmation does not match.',
    'error_email_characters' => 'The email must not be longer than 100 characters.', // smoother wording
    'error_fullname_characters' => 'The full name must not be longer than 50 characters.', // "full name" spaced
    'error_phone_characters' => 'The phone number must be 10 digits.', // "characters" → "digits" for clarity
    'error_address_characters' => 'The address must not be longer than 255 characters.',
    'error_password_mandatory' => 'The current password is required if you want to set a new password.', // "mandatory" → "required"

    'success_account_created' => 'Account created successfully.',
    'error_unexpected' => 'An unexpected error occurred.', // smoother English

    'error_current_password' => 'The current password is incorrect.',
    'success_account_info' => 'Account information updated successfully.',

    'success_book_added' => 'Book added successfully.',
    'success_book_updated' => 'Book updated successfully.',
    'success_book_deleted' => 'Book `:book_title` deleted successfully.',

    'error_require_verification' => 'This action requires email verification.',
    'success_email_verified' => 'Email address verified successfully.',
    'success_link_sent' => 'Verification link sent!',

    'success_genre_added' => 'Genre added successfully.',
    'success_genre_updated' => 'Genre updated successfully.',
    'error_default_genres' => 'You cannot delete default genres.',
    'success_genre_deleted' => 'Genre deleted successfully.',

    'success_order_updated' => 'Order #:order_id updated successfully.',
    'success_order_created' => 'Order created successfully.',
    'success_order_deleted' => 'Order `#:order_id` deleted successfully.',

    'success_region_updated' => 'Region `:region_name` settings updated successfully.',

    'success_reset_link_sent' => 'Reset email sent successfully.',
    'success_password_updated' => 'Password updated successfully.',

    'success_review_added_admin' => 'Review added successfully.',
    'success_review_updated_admin' => 'Review updated successfully.',
    'success_review_added' => 'Your review has been submitted and is pending administrative approval.',
    'success_review_updated' => 'Your review has been updated and will be reviewed by an administrator before publication.',
    'success_review_deleted' => 'Review deleted successfully.',

    'error_banned_from_reviewing' => 'You are banned from adding, editing, or deleting reviews. Please contact our support team if you believe this is a mistake.', // simplified and clarified
    'success_user_banned' => 'User has been banned from adding, editing, or deleting reviews.',
    'success_user_unbanned' => 'User unbanned successfully.',

    'success_admin_deleted_review' => 'You have successfully deleted :user_name\'s review.',

    'error_empty_fields' => 'Some required fields are missing.', // clearer
    'error_details_not_set' => 'No order details have been set.',

    'success_like_book' => 'You liked :book_title successfully.',
    'success_unlike_book' => 'You unliked :book_title successfully.',
    'error_like_book' => 'You already liked :book_title.', // past tense for consistency
    'error_unlike_book' => 'You have not liked :book_title yet.', // smoother English

    'success_upvote_review' => 'You upvoted the review successfully.',
    'success_downvote_review' => 'You downvoted this review successfully.',
    'error_upvote_review' => 'You have already upvoted this review.',
    'error_downvote_review' => 'You have not upvoted this review yet.', // corrected negative phrasing

    'error_shipping_not_possible' => 'Shipping to your region is not available.', // "possible" → "available" sounds smoother
    'success_your_order_created' => 'Your order has been created successfully.',

    'success_publish_review' => 'Review has been published successfully',
    'success_unpublish_review' => 'Review has been unpublished successfully',

    'error_update_unpublished_review' => 'You cannot update an unpublished review',
    'error_delete_unpublished_review' => 'You cannot delete an unpublished review',


];
