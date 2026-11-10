<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\EditInfoController;
use App\Http\Controllers\EmailVerifController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PlaceOrderController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ResetPassController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// root /////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/', fn () => to_route('browse.index'))->middleware('setLocale')->name('root');

// browse bookstore /////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/browse/index', function () {
    return view('browse/index', [
        'bookshelf_books' => Book::withUserLikes()->available()->where('bookshelf', true)->latest()->limit(15)->get(),
        'bestsellers' => Book::withUserLikes()->available()->where('bestseller', true)->latest()->limit(10)->get(),
        'novels' => Book::withUserLikes()->available()->where('genre_id', 2)->latest()->limit(15)->get(),
        'newly_added' => Book::withUserLikes()->available()->latest()->limit(10)->get(),
    ]);
})->middleware('setLocale')->name('browse.index');

Route::get('/browse/shop', function (Request $request) {
    $filters = $request->only(['search', 'gid']);

    return view('browse/shop', [
        'search' => $request->input('search'),
        'gid' => $request->input('gid'),
        'genres' => Genre::withCount('books')->get(),
        'books' => Book::withUserLikes()->available()->filter($filters)->latest()->paginate(20)->withQueryString(),
    ]);
})->middleware('setLocale')->name('browse.shop');

Route::get('/browse/cart', fn () => view('browse/cart', [
    'regions' => \App\Models\Region::all(),
]))->middleware('setLocale')->name('browse.cart');

Route::get('/browse/{book}', function (Book $book) {
    $book->loadCount([
        'likes' => fn ($q) => $q->where('user_id', auth()->id() ?? -1),
        'likes as total_likes_count',
    ]);

    return view('browse/book', [
        'book' => $book,
        'admin_reviews' => $book->reviews()->with('user')->withUpvotesData()
            ->whereHas('user', fn ($query) => $query->where('role', 1))->get(),
        'reviews' => $book->reviews()->with('user')->withUpvotesData()
            ->where('published', true)->whereHas('user', fn ($query) => $query->where('role', 0))->top(5)->get(),
        'related_books' => Book::withUserLikes()->available()
            ->where('genre_id', $book->genre_id)->latest()->limit(30)->get(),
    ]);
})->middleware('setLocale')->name('browse.book');

// like / unlike book
Route::post('/books/{book}/like', [LikeController::class, 'like'])->middleware(['setLocale', 'auth'])->name('book.like');
Route::post('/books/{book}/unlike', [LikeController::class, 'unlike'])->middleware(['setLocale', 'auth'])->name('book.unlike');

// upvote / downvote review
Route::post('/reviews/{review}/upvote', [VoteController::class, 'upvote'])->middleware(['setLocale', 'auth'])->name('review.upvote');
Route::post('/reviews/{review}/downvote', [VoteController::class, 'downvote'])->middleware(['setLocale', 'auth'])->name('review.downvote');

// place order
Route::post('/orders/place-order', [PlaceOrderController::class, 'placeOrder'])->middleware('setLocale')->name('place.order');

// user authentication ////////////////////////////////////////////////////////////////////////////////////////

Route::get('/redirect/login', fn () => to_route('auth.loginPage'))->name('login');
Route::get('/login', [AuthController::class, 'loginPage'])->middleware(['setLocale', 'guest'])->name('auth.loginPage');
Route::post('/login', [AuthController::class, 'login'])->middleware(['setLocale', 'guest'])->name('auth.login');

Route::delete('/logout', [AuthController::class, 'logout'])->middleware(['setLocale', 'auth'])->name('auth.logout');

Route::get('/register', [AuthController::class, 'registerPage'])->middleware(['setLocale', 'guest'])->name('auth.registerPage');
Route::post('/register', [AuthController::class, 'register'])->middleware(['setLocale', 'guest'])->name('auth.register');

// edit user information /////////////////////////////////////////////////////////////////////////////////////

Route::put('/edit/{user}', [EditInfoController::class, 'update'])->middleware(['setLocale', 'auth'])->name('edit.info');

// reset password ////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/forgot', [ResetPassController::class, 'forgotPage'])->middleware(['setLocale', 'guest'])->name('password.request');
Route::post('/forgot', [ResetPassController::class, 'email'])->middleware(['setLocale', 'guest'])->name('password.email');
Route::get('/reset/{token}', [ResetPassController::class, 'reset'])->middleware(['setLocale', 'guest'])->name('password.reset');
Route::post('/reset', [ResetPassController::class, 'update'])->middleware(['setLocale', 'guest'])->name('password.update');

// email verification ////////////////////////////////////////////////////////////////////////////////////////

Route::get('/email/verify', [EmailVerifController::class, 'notice'])->middleware(['setLocale', 'auth'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [EmailVerifController::class, 'verify'])->middleware(['setLocale', 'auth', 'signed'])->name('verification.verify');
Route::post('/email/verification', [EmailVerifController::class, 'send'])->middleware(['setLocale', 'auth', 'throttle:email'])->name('verification.send');

// reviews //////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/browse/{book}/book/reviews', [ReviewController::class, 'index'])->middleware('setLocale')->name('reviews.index');
Route::get('/browse/{book}/reviews/create/review', [ReviewController::class, 'create'])->middleware(['setLocale', 'auth'])->name('reviews.create');
Route::post('/browse/{book}/reviews', [ReviewController::class, 'store'])->middleware(['setLocale', 'auth'])->name('reviews.store');
Route::get('/browse/{book}/reviews/{review}/edit', [ReviewController::class, 'edit'])->middleware(['setLocale', 'auth'])->name('reviews.edit');
Route::put('/browse/{book}/reviews/{review}', [ReviewController::class, 'update'])->middleware(['setLocale', 'auth'])->name('reviews.update');
Route::delete('/browse/{book}/reviews/{review}/delete', [ReviewController::class, 'destroy'])->middleware(['setLocale', 'auth'])->name('reviews.delete');

// user ///////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/user/wishlist', function () {
    return view('user/wishlist', [
        'books' => Book::withUserLikes()->whereHas('likes', fn ($q) => $q->where('user_id', auth()->id()))
            ->latest()->paginate(20)->withQueryString(),
    ]);
})->middleware(['setLocale', 'auth'])->name('user.wishlist');

Route::get('/user/account', function (Request $request) {
    return match ($request->input('tab')) {
        'orders' => to_route('user.orders'),
        'order_details' => to_route('order.details', ['order' => $request->input('order_id')]),
        default => to_route('account.info', $request->only(['action', 'intended'])),
    };
})->middleware(['setLocale', 'auth'])->name('user.account');

Route::get('/user/information', function (Request $request) {
    return view('user/account', [
        'tab' => 'account_info',
        'action' => $request->input('action', 'edit'),
        'intended' => $request->input('intended'),
    ]);
})->middleware(['setLocale', 'auth'])->name('account.info');

Route::get('/user/orders', function (Request $request) {
    return view('user/account', [
        'tab' => 'orders',
        'orders' => $request->user()->orders()->with('orderStatus')->latest()->paginate(12)->withQueryString(),
    ]);
})->middleware(['setLocale', 'auth'])->name('user.orders');

Route::get('/user/orders/details/{order}', function (Request $request, Order $order) {
    abort_unless($order->user_id === $request->user()->id || $request->user()->role === 1, 401);

    return view('user/account', [
        'tab' => 'order_details',
        'order' => $order->load('orderDetails'),
    ]);
})->middleware(['setLocale', 'auth'])->name('order.details');

// language //////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/language/reset', function (Request $request) {
    $data = $request->validate([
        'language' => 'required|in:en,ar,fr',
        'intended' => 'required',
    ]);

    return redirect($data['intended'])->withCookie(cookie('locale', $data['language'], 60 * 24 * 30));
})->name('language.reset');

// admin ///////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/admin/orders/index', [OrderController::class, 'index'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.orders');
Route::delete('/admin/orders/{order}/delete', [OrderController::class, 'destroy'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.orders.delete');
Route::get('/admin/orders/{order}/edit', [OrderController::class, 'edit'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.orders.edit');
Route::put('/admin/orders/{order}/update', [OrderController::class, 'update'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.orders.update');
Route::get('/admin/orders/{order}/show', [OrderController::class, 'show'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.orders.show');
Route::get('/admin/orders/create', [OrderController::class, 'create'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.orders.create');
Route::post('/admin/orders/store', [OrderController::class, 'store'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.orders.store');

Route::get('/admin/books/index', [BookController::class, 'index'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.books');
Route::get('/admin/books/create', [BookController::class, 'create'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.books.create');
Route::post('/admin/books/store', [BookController::class, 'store'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.books.store');
Route::get('/admin/books/{book}/edit', [BookController::class, 'edit'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.books.edit');
Route::put('/admin/books/{book}/update', [BookController::class, 'update'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.books.update');
Route::delete('/admin/books/{book}/delete', [BookController::class, 'destroy'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.books.delete');

Route::get('/admin/genres/create', [GenreController::class, 'create'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.genres.create');
Route::get('/admin/genres/{genre}/edit', [GenreController::class, 'edit'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.genres.edit');
Route::put('/admin/genres/{genre}/update', [GenreController::class, 'update'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.genres.update');
Route::post('/admin/genres/store', [GenreController::class, 'store'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.genres.store');
Route::delete('/admin/genres/{genre}/delete', [GenreController::class, 'destroy'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.genres.delete');

Route::get('/admin/regions/index', [RegionController::class, 'index'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.regions');
Route::get('/admin/regions/{region}/edit', [RegionController::class, 'edit'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.regions.edit');
Route::put('/admin/regions/{region}/update', [RegionController::class, 'update'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.regions.update');

Route::get('/admin/users/index', [UserController::class, 'index'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.users');

Route::put('/user/{user}/ban', function (User $user) {
    $user->update(['banned' => true]);

    return back()->with('success', __('messages.success_user_banned'));
})->middleware(['setLocale', 'auth', 'admin'])->name('admin.ban.user');

Route::put('/user/{user}/unban', function (User $user) {
    $user->update(['banned' => false]);

    return back()->with('success', __('messages.success_user_unbanned'));
})->middleware(['setLocale', 'auth', 'admin'])->name('admin.unban.user');

Route::delete('/reviews/{review}/delete', function (Review $review) {
    $userName = $review->user->name;
    $review->delete();

    return back()->with('success', __('messages.success_admin_deleted_review', ['user_name' => $userName]));
})->middleware(['setLocale', 'auth', 'admin'])->name('admin.delete.review');

Route::get('/admin/reviews/index', function () {
    $unpublishedReviews = Review::with(['user', 'book'])->withUpvotesData()
        ->where('published', false)->latest()->paginate(10)->withQueryString();

    return view('/admin/reviews/index', ['reviews' => $unpublishedReviews]);
})->middleware(['setLocale', 'auth', 'admin'])->name('admin.reviews');

Route::put('/reviews/{review}/publish', function (Review $review) {
    $review->update(['published' => true]);

    return back()->with('success', __('messages.success_publish_review'));
})->middleware(['setLocale', 'auth', 'admin'])->name('admin.publish.review');

Route::put('/reviews/{review}/unpublish', function (Review $review) {
    $review->update(['published' => false]);

    return back()->with('success', __('messages.success_unpublish_review'));
})->middleware(['setLocale', 'auth', 'admin'])->name('admin.unpublish.review');
