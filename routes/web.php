<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TransactionController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/baitap', function () {
    // 1.Truy vấn kết hợp nhiều bảng (JOIN):

    $name = DB::table('users as u')
        ->select('u.name', DB::raw('SUM(p.price) as total_spent'))
        ->join('orders as o', 'u.id', '=', 'o.user_id')
        ->groupBy('u.name')
        ->having('total_spent', '>', 1000);

    $s1 = $name->toSql();

    // 2.Truy vấn thống kê dựa trên khoảng thời gian (Time-based statistics):
    $thongke = DB::table('orders')
        ->select(DB::raw('date(order_date) as date', 'count(*) as order_count', 'sun(total_amount) as total_sales'))
        ->whereBetween('order_date', ['2024-01-01', '2024-09-30'])
        ->groupBy('date');

    $s2 = $thongke->toSql();

    // 3.Truy vấn để tìm kiếm giá trị không có trong tập kết quả khác (NOT EXISTS):
    $ketqua = DB::table('products as p')
        ->select('p.name as product_name')
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('orders as o')
                ->whereRaw('o.product_id = p.id');
        });

    $s3 = $ketqua->toSql();

    // 4.Truy vấn với CTE (Common Table Expression):
    // $pro = DB::select(DB::raw("with product_sales as (
    //     select p.id , p.name, sum(o.quarity) as total_quarity
    //     from products as p
    //     join orders as o on p.id = o.product_id
    //     group by p.id, p.name)
    //     select * from product_sales  
    //     where total_quarity > 100;
    // )"

    // ));   

    // $productModel = collect($pro)->map(function ($item) {

    // });

    // 5. Truy vấn lấy danh sách người dùng đã mua sản phẩm trong 30 ngày qua, cùng với thông tin sản phẩm và ngày mua
    $danhsach = DB::table('users')
        ->select('users.name', 'products.product_name', 'orders.order_date')
        ->join('orders', 'users.id', '=', 'orders.user_id')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->where('orders.order_date', '>', now()->subDays(30));

    $s5 = $danhsach->toSql();

    // 6. Truy vấn lấy tổng doanh thu theo từng tháng, chỉ tính những đơn hàng đã hoàn thành  
    $doanhthu = DB::table('orders')
        ->select(DB::raw("date_format(orders.date, '%Y-%m') as order_month , sum(order_items.quatity * order_items.price) as total_revenue"))
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->where('orders.status', 'completed')
        ->groupBy('order_month', 'DESC');

    $s6 = $doanhthu->toSql();

    // 7.Truy vấn các sản phẩm chưa từng được bán (sản phẩm không có trong bảng order_items)
    $sp = DB::table('products')
        ->select('products.name')
        ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
        ->where('order_items.order_id', null);

    $s7 = $sp->toSql();

    dd($s1, $s2, $s3, $s5, $s6, $s7);
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('client.index');
});
Route::get('/shop-single', function () {
    return view('client.shop-single');
});


Route::get('/admin', function () {
    return view('admin.home');
});

Route::get('/users', function () {
    $data = User::with('phone')->get();
    return view('admin.users.index', compact('data'));
});


Route::get('/post/{id}', function ($id) {

    $post = Post::with('comments')->find($id);
    dd($post->toArray());
});


Route::get('/users/{id}/add-role', function ($id) {

    $role = [1, 5, 6, 8];
    $user = User::find($id);
    $user->roles()->attach($role);
    dd($user->load('roles')->toArray());
});

Route::get('/users/{id}/remove-role', function ($id) {

    $role = [ 5, 6];
    $user = User::find($id);
    $user->roles()->detach($role);
    dd($user->load('roles')->toArray());
});

Route::get('/users/{id}/sync-role', function ($id) {

    $role = [ 3,6,9,10];
    $user = User::find($id);
    $user->roles()->sync($role);
    dd($user->load('roles')->toArray());
});
//////////////////////////////////////////////
// STUDENTS


Route::resource('/admin/students', StudentController::class)->middleware('auth');






/////////////////

Route::resource('admin/customers', CustomerController::class)->middleware('auth');
Route::delete('admin/customers/{customer}/forveDestroy', [CustomerController::class, 'forveDestroy'])
    ->name('admin.customers.forveDestroy');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



///baif 5

Route::get('/transaction', [TransactionController::class, 'startTransaction'])->name('transaction.start');
Route::post('/transaction/process', [TransactionController::class, 'processTransaction'])->name('transaction.process');
Route::post('/transaction/complete', [TransactionController::class, 'completeTransaction'])->name('transaction.complete');
Route::post('/transaction/cancel', [TransactionController::class, 'cancelTransaction'])->name('transaction.cancel');
