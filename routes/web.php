<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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
use App\Http\Controllers\VoteController;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Request;



// root /////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/', function (Request $request){
    return redirect()->route('browse.index');
})->middleware('setLocale')->name('root');

// browse bookstore /////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/browse/index', function(){

    // open home view
    return view('browse/index' , [
        'bookshelf_books' => Book::withCount(['likes' => fn($query) => $query->where('user_id' , '=' , auth()->user()->id ?? -1)])
            ->where('bookshelf' , true)->where('quantity', '>' , 0)->latest()->limit(15)->get(),
        'bestsellers' => Book::withCount(['likes' => fn($query) => $query->where('user_id' , '=' , auth()->user()->id ?? -1)])
            ->where('bestseller' , true)->where('quantity' , '>' , 0)->limit(10)->latest()->get(),
        'novels' => Book::withCount(['likes' => fn($query) => $query->where('user_id' , '=' , auth()->user()->id ?? -1)])
            ->where('genre_id' , '=' , '2')->where('quantity' , '>' , 0)->latest()->limit(15)->get(),
        'newly_added' => Book::withCount(['likes' => fn($query) => $query->where('user_id' , '=' , auth()->user()->id ?? -1)])
            ->where('quantity' , '>' , 0)->latest()->limit(10)->get(),
    ]);

})->middleware('setLocale')->name('browse.index');

Route::get('/browse/shop', function(){

    // get params
    $search = request()->input('search');
    $gid = request()->input('gid');
    $filters = request()->only(['search' , 'gid']);

    // fetch books
    $books = Book::withCount(['likes' => fn($query) => $query->where('user_id' , '=' , auth()->user()->id ?? -1)])
        ->where('quantity' , '>' , 0)->filter($filters)->latest()->paginate(20);

    // open shop view
    return view('browse/shop', [
        'search' => $search,
        'gid' => $gid,
        'genres' => Genre::all(),
        'books' => $books,
    ]);

})->middleware('setLocale')->name('browse.shop');

Route::get('/browse/cart', function(){

    // open cart view
    return view('browse/cart');

})->middleware('setLocale')->name('browse.cart');

Route::get('/browse/{book}', function(Book $book){

    // open book view
    return view('browse/book' , [
        'book' => Book::withCount(['likes' => fn($q) => $q->where('user_id' , '=', auth()->user()->id ?? -1)])->find($book->id),
        'admin_reviews' => Review::withCount('upvotes')->withCount(['upvotes as upvoted' => fn($query) => $query->where('user_id' , '=' , auth()->user()->id ?? -1)])
            ->where('book_id' , '=' , $book->id)->whereHas('user', fn($query) => $query->where('role', '=', 1))->get(),
        'reviews' => Review::withCount('upvotes')->withCount(['upvotes as upvoted' => fn($query) => $query->where('user_id' , '=' , auth()->user()->id ?? -1)])
            ->where('published', true)->where('book_id' , '=' , $book->id)->whereHas('user', fn($query) => $query->where('role', '=', 0))->top(5)->get(),
        'related_books' => Book::withCount(['likes' => fn($query) => $query->where('user_id' , '=' , auth()->user()->id ?? -1)])
            ->where('quantity' , '>' , 0)->where('genre_id' , '=' , $book->genre->id)->limit(30)->latest()->get(),
    ]);

})->middleware('setLocale')->name('browse.book');

// like / unlike book
Route::post('/books/{book}/like', [LikeController::class, 'like'])->middleware(['setLocale', 'auth'])->name('book.like');
Route::post('/books/{book}/unlike', [LikeController::class, 'unlike'])->middleware(['setLocale', 'auth'])->name('book.unlike');

// upvote / downvote review
Route::post('/reviews/{review}/upvote', [VoteController::class, 'upvote'])->middleware(['setLocale', 'auth'])->name('review.upvote');
Route::post('/reviews/{review}/downvote', [VoteController::class, 'downvote'])->middleware(['setLocale', 'auth'])->name('review.downvote');

// place order
Route::post('/orders/place-order' , [PlaceOrderController::class , 'placeOrder' ])->middleware(['setLocale', 'auth'])->name('place.order');

// user authentication ////////////////////////////////////////////////////////////////////////////////////////

Route::get('/redirect/login', fn() => to_route('auth.loginPage'))->name('login');
Route::get('/login' , [AuthController::class , 'loginPage'])->middleware(['setLocale', 'guest'])->name('auth.loginPage');
Route::post('/login' , [AuthController::class , 'login'])->middleware(['setLocale', 'guest'])->name('auth.login');

Route::delete('/logout' , [AuthController::class , 'logout'])->middleware(['setLocale', 'auth'])->name('auth.logout');

Route::get('/register' , [AuthController::class , 'registerPage'])->middleware(['setLocale', 'guest'])->name('auth.registerPage');
Route::post('/register' , [AuthController::class , 'register'])->middleware(['setLocale', 'guest'])->name('auth.register');

// edit user information /////////////////////////////////////////////////////////////////////////////////////

Route::put('/edit/{user}' , [EditInfoController::class , 'update'])->middleware(['setLocale', 'auth'])->name('edit.info');

// reset password ////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/forgot', [ResetPassController::class , 'forgotPage'])->middleware(['setLocale', 'guest'])->name('password.request');
Route::post('/forgot', [ResetPassController::class , 'email'])->middleware(['setLocale', 'guest'])->name('password.email');
Route::get('/reset/{token}', [ResetPassController::class , 'reset'])->middleware(['setLocale', 'guest'])->name('password.reset');
Route::post('/reset', [ResetPassController::class , 'update'])->middleware(['setLocale', 'guest'])->name('password.update');

// email verification ////////////////////////////////////////////////////////////////////////////////////////

Route::get('/email/verify', [EmailVerifController::class , 'notice'])->middleware(['setLocale', 'auth'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [EmailVerifController::class , 'verify'])->middleware(['setLocale', 'auth', 'signed'])->name('verification.verify');
Route::post('/email/verification', [EmailVerifController::class , 'send'])->middleware(['setLocale', 'auth', 'throttle:email'])->name('verification.send');

// reviews //////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/browse/{book}/book/reviews', [ReviewController::class , 'index'])->middleware('setLocale')->name('reviews.index');

Route::get('/browse/{book}/reviews/create/review', [ReviewController::class , 'create'])->middleware(['setLocale','auth'])->name('reviews.create');

Route::post('/browse/{book}/reviews', [ReviewController::class , 'store'])->middleware(['setLocale','auth'])->name('reviews.store');

Route::get('/browse/{book}/reviews/{review}/edit', [ReviewController::class, 'edit'])->middleware(['setLocale','auth'])->name('reviews.edit');

Route::put('/browse/{book}/reviews/{review}', [ReviewController::class, 'update'])->middleware(['setLocale','auth'])->name('reviews.update');
Route::delete('/browse/{book}/reviews/{review}/delete', [ReviewController::class, 'destroy'])->middleware(['setLocale','auth'])->name('reviews.delete');

// user ///////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/user/wishlist' , function(){

    // open wishlist view
    return view('user/wishlist' , [
        'books' => Book::withCount(['likes' => fn($query) => $query->where('user_id' , "=" ,
            auth()->user()->id ?? -1)])->having('likes_count' , '>' , 0)->latest()->paginate(20),
    ]);

})->middleware(['setLocale', 'auth'])->name('user.wishlist');

Route::get('/user/account' , function(){

    // get params
    $intended = request()->input('intended');
    $tab = request()->input('tab');
    $action = request()->input('action');
    $order_id = request()->input('order_id');

    // redirect to route
    if($tab == 'orders'){
        return redirect()->route('user.orders');
    }elseif($tab == 'order_details'){
        return redirect()->route('order.details' , ['order' => $order_id ]);
    }else{
        return redirect()->route('account.info' , ['action' => $action , 'intended' => $intended]);
    }

})->middleware(['setLocale', 'auth'])->name('user.account');

Route::get('/user/information' , function(){

    // get params
    $intended = request()->input('intended');
    $action = request()->input('action');

    // open account view
    return view('user/account' , [
        'tab' => 'account_info',
        'action' => $action,
        'intended' => $intended,
    ]);

})->middleware(['setLocale', 'auth'])->name('account.info');

Route::get('/user/orders' , function(){

    // open account view
    return view('user/account' , [
        'tab' => 'orders',
        'orders' => Order::where('user_id' , '=' , auth()->user()->id)->latest()->paginate(12),
    ]);

})->middleware(['setLocale', 'auth'])->name('user.orders');

Route::get('/user/orders/details/{order}' , function(Order $order){

    // user is owner of the order / admin
    if($order->user_id === auth()->user()->id || auth()->user()->role === 1){

        // open account view
        return view('user/account' , [
            'tab' => 'order_details',
            'order' => $order,
        ]);
    }else{
        abort(401);
    }

})->middleware(['setLocale', 'auth'])->name('order.details');


// lanuguage //////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/language/reset' , function(Request $request) {

    // validate data
    $data = request()->validate([
        'language' => 'required|in:en,ar,fr',
        'intended' => 'required',
    ]);

    return redirect($data['intended'])->withCookie(cookie('locale', $data['language'], 60 * 24 * 30));

})->name('language.reset');

// admin ///////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/admin/orders/index' , [OrderController::class , 'index'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.orders');
Route::delete('/admin/orders/{order}/delete' , [OrderController::class , 'destroy'])->middleware(['setLocale','auth', 'admin'])->name('admin.orders.delete');
Route::get('/admin/orders/{order}/edit' , [OrderController::class , 'edit'])->middleware(['setLocale','auth', 'admin'])->name('admin.orders.edit');
Route::put('/admin/orders/{order}/update' , [OrderController::class , 'update'])->middleware(['setLocale','auth', 'admin'])->name('admin.orders.update');
Route::get('/admin/orders/{order}/show' , [OrderController::class , 'show'])->middleware(['setLocale','auth', 'admin'])->name('admin.orders.show');
Route::get('/admin/orders/create' , [OrderController::class , 'create'])->middleware(['setLocale','auth', 'admin'])->name('admin.orders.create');
Route::post('/admin/orders/store' , [OrderController::class , 'store'])->middleware(['setLocale','auth', 'admin'])->name('admin.orders.store');


Route::get('/admin/books/index' , [BookController::class , 'index'])->middleware(['setLocale','auth', 'admin'])->name('admin.books');
Route::get('/admin/books/create' , [BookController::class , 'create'])->middleware(['setLocale','auth', 'admin'])->name('admin.books.create');
Route::post('/admin/books/store', [BookController::class , 'store'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.books.store');
Route::get('/admin/books/{book}/edit' , [BookController::class , 'edit'])->middleware(['setLocale','auth', 'admin'])->name('admin.books.edit');
Route::put('/admin/books/{book}/update', [BookController::class , 'update'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.books.update');
Route::delete('/admin/books/{book}/delete' , [BookController::class , 'destroy'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.books.delete');

Route::get('/admin/genres/create' ,[GenreController::class , 'create'])->middleware(['setLocale','auth', 'admin'])->name('admin.genres.create');
Route::get('/admin/genres/{genre}/edit' , [GenreController::class , 'edit'])->middleware(['setLocale','auth', 'admin'])->name('admin.genres.edit');
Route::put('/admin/genres/{genre}/update', [GenreController::class , 'update'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.genres.update');
Route::post('/admin/genres/store', [GenreController::class , 'store'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.genres.store');
Route::delete('/admin/genres/{genre}/delete', [GenreController::class , 'destroy'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.genres.delete');

Route::get('/admin/regions/index' , [RegionController::class , 'index'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.regions');
Route::get('/admin/regions/{region}/edit' , [RegionController::class , 'edit'])->middleware(['setLocale','auth', 'admin'])->name('admin.regions.edit');
Route::put('/admin/regions/{region}/update' ,[RegionController::class , 'update'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.regions.update');

Route::get('/admin/users/index', [UserController::class , 'index'])->middleware(['setLocale', 'auth', 'admin'])->name('admin.users');
Route::put('/user/{user}/ban' , function(User $user){

    $user->update([
        'banned' => true,
    ]);

    return redirect()->back()->with('success', __('messages.success_user_banned'));

})->middleware(['setLocale','auth', 'admin'])->name('admin.ban.user');

Route::put('/user/{user}/unban' , function(User $user){

    $user->update([
        'banned' => false,
    ]);

    return redirect()->back()->with('success', __('messages.success_user_unbanned'));

})->middleware(['setLocale','auth', 'admin'])->name('admin.unban.user');

Route::delete('/reviews/{review}/delete' , function(Review $review){

    $review->delete();

    return redirect()->back()->with('success', __('messages.success_admin_deleted_review', ['user_name' => $review->user->name]));

})->middleware(['setLocale','auth', 'admin'])->name('admin.delete.review');


Route::get('/admin/reviews/index' ,  function(){

    $unpublishedReviews = Review::withCount('upvotes')->withCount(['upvotes as upvoted' => fn($query) => $query->where('user_id' , '=' , auth()->user()->id)])
        ->where('published', false)->latest()->paginate(10);

    return view('/admin/reviews/index', ['reviews'=> $unpublishedReviews]);

})->middleware(['setLocale', 'auth', 'admin'])->name('admin.reviews');

Route::put('/reviews/{review}/publish' , function(Review $review){

    $review->update([
        'published' => true,
    ]);

    return redirect()->back()->with('success', __('messages.success_publish_review'));

})->middleware(['setLocale','auth', 'admin'])->name('admin.publish.review');

Route::put('/reviews/{review}/unpublish' , function(Review $review){

    $review->update([
        'published' => false,
    ]);

    return redirect()->back()->with('success', __('messages.success_unpublish_review'));

})->middleware(['setLocale','auth', 'admin'])->name('admin.unpublish.review');

