<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;

// Frontend routes
Route::get('/', [HomeController::class, 'index']);

Route::get('/account', function () {
    return view('account');
})->name('account');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::post('/checkout', function () {
    return view('checkout');
})->name('checkout.process');

Route::get('/login', function () {
    return view('auth.login-register');
})->name('login');

Route::get('/register', function () {
    return view('auth.login-register');
})->name('register');
Route::post('/logout',[AuthController::class ,'destroy'])->name('auth.destroy');
Route::post('login-process',AuthController::class . '@handleLogin')->name('login.process');
Route::post('register-process',AuthController::class . '@handleregister')->name('register.process');
Route::post('forgot-password', AuthController::class . '@handleForgotPassword')->name('forgot-password');

Route::view('/cart', 'cart');

Route::get('/search', function () {
    return view('search');
})->name('search');

Route::get('/product-details', function () {
    return view('product-detail');
})->name('product-detail');

Route::get('/category', function () {
    return view('category');
})->name('category');


Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');


Route::prefix('admin/products')->group(function () {
    // Danh sách sản phẩm
    Route::get('/list',[ProductController::class,'index'])->name('admin.products-list');
    // Tạo sản phẩm
    Route::get('/create',[ProductController::class,'create'])->name('admin.products-create');
    Route::post('/store',[ProductController::class,'store'])->name('admin.products-store');

    // Chỉnh sửa sản phẩm
    Route::get('/edit/{id}',[ProductController::class,'edit'])->name('admin.products-edit');
    Route::put('/update/{id}',[ProductController::class,'update'])->name('admin.products-update'); // Thêm route PUT để cập nhật

    // Chi tiết sản phẩm
    Route::get('/detail/{id}',[ProductController::class,'show'])->name('admin.products-detail');

});
Route::get('/admin/category', function () {
    return view('admin.category.index');
})->name('admin.category.index');

Route::get('/admin/category/create', function () {
    return view('admin.category.create');
})->name('admin.category.create');

Route::get('/admin/category/edit', function () {
    return view('admin.category.edit');
})->name('admin.category.edit');
Route::prefix('admin/oders')->group(function () {
    // Danh sách đơn hàng
    Route::get('/list', function(){
        return view('admin.orders.index');
    })->name('admin.orders.index');
    Route::get('/detail/{id?}',function (){
        return view('admin.orders.show');
    })->name('admin.orders.show'); // Chi tiết đơn hàng
});

Route::get('/admin/attributes', function () {
    return view('admin.attributes.index');
})->name('admin.attributes.index');
Route::get('/admin/attributes/create', function () {
    return view('admin.attributes.create');
})->name('admin.attributes.create');
Route::get('/admin/attributes/edit', function () {
    return view('admin.attributes.edit');
})->name('admin.attributes.edit');
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');


// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Attributes
    Route::controller(AttributeController::class)->prefix('attributes')->name('attributes.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // Products
    Route::prefix('products')->name('products.')->group(function () {
        // Danh sách sản phẩm
        Route::get('/', function () {
            return view('admin.products.list');
        })->name('list');

        // Tạo sản phẩm
        Route::get('/create', function () {
            $categories = [
                (object) ['category_id' => 1, 'description' => 'Fashion', 'parent_category_id' => null, 'status' => 'active'],
                (object) ['category_id' => 2, 'description' => 'Electronics', 'parent_category_id' => null, 'status' => 'active'],
                (object) ['category_id' => 3, 'description' => 'Footwear', 'parent_category_id' => 1, 'status' => 'active'],
                (object) ['category_id' => 4, 'description' => 'Smartphones', 'parent_category_id' => 2, 'status' => 'active'],
                (object) ['category_id' => 5, 'description' => 'Watches', 'parent_category_id' => 1, 'status' => 'active'],
            ];

            $attributes = [
                (object) ['attribute_id' => 1, 'name' => 'Color'],
                (object) ['attribute_id' => 2, 'name' => 'Size'],
                (object) ['attribute_id' => 3, 'name' => 'Material'],
                (object) ['attribute_id' => 4, 'name' => 'Brand'],
            ];

            $attributeValues = [
                (object) ['attribute_value_id' => 1, 'value' => 'Red'],
                (object) ['attribute_value_id' => 2, 'value' => 'Blue'],
                (object) ['attribute_value_id' => 3, 'value' => 'Green'],
                (object) ['attribute_value_id' => 4, 'value' => 'XS'],
                (object) ['attribute_value_id' => 5, 'value' => 'S'],
                (object) ['attribute_value_id' => 6, 'value' => 'M'],
                (object) ['attribute_value_id' => 7, 'value' => 'L'],
                (object) ['attribute_value_id' => 8, 'value' => 'Cotton'],
                (object) ['attribute_value_id' => 9, 'value' => 'Leather'],
                (object) ['attribute_value_id' => 10, 'value' => 'Polyester'],
                (object) ['attribute_value_id' => 11, 'value' => 'Nike'],
                (object) ['attribute_value_id' => 12, 'value' => 'Adidas'],
                (object) ['attribute_value_id' => 13, 'value' => 'Samsung'],
            ];
            return view('admin.products.create', compact('categories', 'attributes', 'attributeValues'));
        })->name('create');
        Route::post('/', function () {
            //
        })->name('store');

        // Chỉnh sửa sản phẩm
        Route::get('/{id}/edit', function () {
            return view('admin.products.edit');
        })->name('edit');
        Route::put('/{id}', function () {
            //
        })->name('update');

        // Chi tiết sản phẩm
        Route::get('/{id}', function () {
            return view('admin.products.detail');
        })->name('detail');

        // Upload file (dùng POST thay vì GET)
        Route::post('/upload-file', function () {
            // Xử lý upload file
        })->name('upload-file');
    });

    // Categories
    Route::controller(CategoryController::class)->prefix('categories')->name('categories.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{category}', 'show')->name('show');
        Route::get('/{category}/edit', 'edit')->name('edit');
        Route::put('/{category}', 'update')->name('update');
        Route::delete('/{category}', 'destroy')->name('destroy');
    });
Route::get('/products', [ProductController::class, 'indexClient']);
Route::get('/products/{id}', [ProductController::class, 'showClient'])->name('products.show');
    // Orders
    Route::controller(OrderController::class)->prefix('orders')->name('orders.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // Roles
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', function () {
            return view('admin.roles.index');
        })->name('index');
        Route::get('/create', function () {
            return view('admin.roles.create');
        })->name('create');
        Route::get('/{id}', function ($id) {
            return view('admin.roles.show', ['id' => $id]);
        })->name('show');
        Route::get('/{id}/edit', function ($id) {
            return view('admin.roles.edit', ['id' => $id]);
        })->name('edit');
    });
});

