<?php



use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AjaxRequestController;
use App\Http\Controllers\client\ClientProductController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\community\CommunityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\superadmin\ProtocolController;
use App\Http\Controllers\superadmin\SettingController;
use App\Http\Controllers\superadmin\SuperAdminDashboardController;
use App\Http\Controllers\superadmin\SuperAdminUserController;
use App\Http\Controllers\user\OrderController;
use App\Http\Controllers\user\UserDashboardController;
use App\Http\Controllers\vendor\VendorDashboardController;
use App\Http\Controllers\vendor\VendorProductController;
use App\Models\shop_info;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

#.1. For root directory for general user/Home page+++++++++++++++++++++++++++++++
Route::controller(HomeController::class)->group(function (){
    Route::match(['get','post'],'/','index')->name('root');
    Route::match(['get','post'],'about','about')->name('about');
    Route::match(['get','post'],'contact','contact')->name('contact');
});


Route::group(['prefix'=>'hidden-dirr'],function (){
    Route::controller(AjaxRequestController::class)->group(function (){
        Route::match(['get','post'],'get-division','getDivision')->name('get.division');
        Route::match(['get','post'],'get-district','getDistrict')->name('get.district');
        Route::match(['get','post'],'get-upazila','getUpazila')->name('get.upazila');
        Route::match(['get','post'],'get-zip','getZip')->name('get.zip');
        Route::match(['post'],'location-type','LocationType')->name('get.location.type');
//        Route::post('get-shipping','getShipping');
        Route::match(['post','get'],'get-shipping','changeAddress');
        Route::middleware('auth')->group(function (){
            Route::controller(OrderController::class)->group(function (){
                Route::post('cancel-product-order','cancelProductOrder');
                Route::post('cancel-order','cancelOrder');
            });
        });

    });
});

//Front site start here
Route::controller(ClientProductController::class)->group(function (){
    Route::match(['get','post'],'single-view-product/{productSingleID}','index')->name('client.single.product.view');
    Route::match(['get','post'],'shop','show')->name('client.product.list');
    Route::match(['get','post'],'shop/{vendorId}','showByVendorProduct')->name('byVendor.product.list');
    Route::match(['get','post'],'add-to-cart','addToCart')->name('name.add.to.cart');
    Route::match(['get','post'],'shop-cart','viewCart')->name('view.cart');
    Route::match(['post'],'change-address','changeAddress')->name('change.address');
    Route::patch('update-cart','updateCart')->name('update.cart');
    Route::delete('remove-from-cart','deleteCart')->name('delete.cart');
    Route::middleware('auth')->group(function (){
        Route::match(['get','post'],'checkout','checkOut')->name('order.checkout');
        Route::match(['post','get'],'invoice','Invoice')->name('invoice');
        Route::match(['post','get'],'invoice-pdf/{orderID}/{userID}','InvoicePDF')->name('invoice.pdf');
    });
});



#.2. Group for Authenticate User Access+++++++++++++++++++++++++++++++++++++++++
Route::get('admin',function (){
    return redirect()->route('login');
});
Route::get('user',function (){
    return redirect()->route('login');
});
Route::middleware('auth')->group(function () {
    #.2.1.For Redirect Auth of role page++++++++++++++++++++++++++++++++++++++
    Route::get('route-controller',[RouteController::class,'index'])->name('route.controller');
    //--------------------End 2.1 Redirect Auth of role page-----------------

    #.2.2.Group For Super Admin role access++++++++++++++++++++++++++++++++++++++++
    Route::group(['middleware' => ['auth','role:superadmin'],'prefix' => 'superadmin'],function(){
        Route::controller(SuperAdminDashboardController::class)->group(function (){
            Route::match(['get','post'],'dashboard','index')->name('super.admin.dashboard');
        });

        Route::group(['prefix'=>'user'],function (){
            Route::controller(SuperAdminUserController::class)->group(function (){
                Route::match(['get','post'],'add','create')->name('super.admin.add.user');
                Route::match(['get'],'list','show')->name('super.admin.list.user');
                Route::match(['get','post'],'user-view/{UserID}','singleViewUser')->name('super.single.view.user');
                Route::match(['get','post','put'],'user-edit/{UserID}','edit')->name('super.edit.single.user');
                Route::put('user-password-update','passwordUpdate')->name('super.admin.user.password.update');
                Route::put('user-status-update','statusUpdate')->name('super.admin.user.status.update');
                Route::delete('delete-user','destroy')->name('super.admin.delete.user');
                Route::put('rollback-user','rollback')->name('super.admin.rollback.user');
            });
        });

        Route::group(['prefix'=>'setting'],function (){
            Route::group(['prefix'=>'landing-page'],function (){
                Route::group(['prefix'=>'slider'],function (){
                    Route::controller(SettingController::class)->group(function (){
                        Route::match(['get','post'],'add','createSlider')->name('setting.slider.create');
                    });
                });
            });
        });

        Route::group(['prefix'=>'protocol'],function (){
            Route::group(['prefix'=>'shipping'],function (){
                Route::controller(ProtocolController::class)->group(function (){
                    Route::match(['get','post'],'set-shipping-charge','setShippingCharge')->name('set.shipping.charge');
                    Route::match(['get','post'],'edit-shipping-charge/{ID}','editShippingCharge')->name('edit.shipping.charge');
                    Route::delete('delete-shipping','destroyShipping')->name('delete.shipping');
                });
            });
        });

        Route::controller(\App\Http\Controllers\superadmin\OrderController::class)->group(function (){
            Route::match(['get','post'],'my-order','myOrder')->name('super.my.order');
            Route::match(['post','get'],'order-single/{orderID}','orderSingle')->name('super.my.order.single');
        });
    });

    #.2.3.Group For admin role access++++++++++++++++++++++++++++++++++++++++
    Route::group(['middleware' => ['auth','role:admin'],'prefix' => 'admin'],function(){
        Route::controller(AdminUserController::class)->group(function (){
            Route::match(['get','post'],'dashboard','index')->name('admin.dashboard');
        });

        Route::group(['prefix'=>'user'],function (){
            Route::controller(AdminUserController::class)->group(function (){
                Route::match(['get','post'],'add','create')->name('admin.add.user');
                Route::match(['get'],'list','show')->name('admin.list.user');
                Route::delete('delete-user','destroy')->name('admin.delete.user');
            });
        });
        Route::controller(\App\Http\Controllers\admin\OrderController::class)->group(function (){
            Route::get('my-order-list','myOrder')->name('admin.my.order');
            Route::match(['post','get'],'order-single/{orderID}','orderSingle')->name('admin.my.order.single');
        });

    });

    #.2.4.Group For vendor role access++++++++++++++++++++++++++++++++++++
    Route::group(['middleware' => ['auth','role:vendor'],'prefix' => 'vendor'],function (){
        Route::controller(VendorDashboardController::class)->group(function (){
            Route::match(['get','post'],'dashboard','index')->name('vendor.dashboard');
            Route::match(['get','post'],'my-shop','myShop')->name('my.shop');
            Route::match(['get','post'],'create-shop','createShop')->name('create.shop');
            Route::match(['get','post'],'edit-shop','editShop')->name('edit.shop');
            Route::match(['get','post'],'my-shop','myShop')->name('my.shop');
        });

        Route::group(['prefix'=>'product'],function (){
            Route::controller(VendorProductController::class)->group(function (){
                Route::match(['get','post'],'add-product','create')->name('vendor.add.product'); //url like localhost/vendor/product/add-product
                Route::match(['get'],'list','show')->name('vendor.list.product'); //url like localhost/vendor/product/list
                Route::match(['get','post'],'edit-product/{productID}','edit')->name('vendor.edit.product');
                Route::match(['get'],'view-product/{productID}','viewProduct')->name('vendor.view.product');
                Route::delete('delete-product','destroy')->name('vendor.delete.product');

                Route::match(['get','post'],'add-category','createCategory')->name('vendor.add.category');
                Route::match(['get'],'list-category','showCategory')->name('vendor.list.category');
                Route::match(['get','post'],'edit-category/{categoryID}','editCategory')->name('vendor.edit.category');
                Route::match(['get'],'view-category/{categoryID}','viewCategory')->name('vendor.view.category');
                Route::delete('delete-category','destroyCategory')->name('vendor.delete.category');

            });

            Route::controller(\App\Http\Controllers\vendor\orderController::class)->group(function (){
                //Shop order start
                Route::get('primary-order-list','primaryOrder')->name('primary.order.list');

                Route::get('accepted-order-list','acceptedOrder')->name('accepted.order.list');
                Route::put('accepted-order','acceptedOrder')->name('accepted.order');

                Route::match(['get'],'view-order/{orderID}','viewOrder')->name('vendor.view.order');
                Route::match(['post','get'],'invoice-pdf-product-wise/{orderID}','InvoicePDF')->name('vendor.invoice.pdf.product');

                Route::match(['get'],'view-invoice/{invoiceID}','viewInvoice')->name('vendor.view.invoice');
                Route::match(['get'],'view-invoice-pdf/{invoiceID}','viewInvoicePdf')->name('vendor.view.invoice.pdf');

                Route::put('submit-order','submitAdmin')->name('submit.order.admin');

                Route::get('cancel-order-list','canceledOrder')->name('cancel.order.list');
                Route::delete('cancel-order','destroy')->name('vendor.delete.order');

                Route::match(['get'],'complete-order-list','completeOrderList')->name('vendor.complete.order.list');

                // Shop order end
                Route::get('my-order-list','myOrder')->name('vendor.my.order');
                Route::match(['post','get'],'order-single/{orderID}','orderSingle')->name('vendor.my.order.single');
            });
        });
    });

    #.2.5.Group For user role access
    Route::group(['middleware' => ['auth','role:user'],'prefix' => 'user'],function (){
        Route::controller(UserDashboardController::class)->group(function (){
            Route::match(['get','post'],'dashboard','index')->name('user.dashboard');
        });

        Route::controller(OrderController::class)->group(function (){
            Route::get('my-order-list','myOrder')->name('my.order.list');
            Route::match(['post','get'],'order-single/{orderID}','orderSingle')->name('order.single');
        });
    });
    #.2.6.Group For community/messenger role access
    Route::group(['middleware' => ['auth','role:community'],'prefix' => 'community'],function (){
        Route::controller(CommunityController::class)->group(function (){
            Route::match(['get','post'],'dashboard','index')->name('community.dashboard');
            Route::match(['get','post'],'my-community','myCommunity')->name('my.community');
            Route::match(['get','post'],'create-community','createCommunity')->name('create.community');
            Route::match(['get','post'],'edit-community','editCommunity')->name('edit.community');
//            Route::match(['get','post'],'my-community','myCommunity')->name('my.community');
        });
        // Community self order (My order)
        Route::controller(\App\Http\Controllers\community\OrderController::class)->group(function (){
            Route::match(['get','post'],'my-order','myOrder')->name('community.my.order');
            Route::match(['post','get'],'order-single/{orderID}','orderSingle')->name('community.order.single');
        });

        // Community order (Order for delivery)

//        Route::controller(OrderController::class)->group(function (){
//            Route::get('my-order-list','myOrder')->name('my.order.list');
//        });
    });
});

require __DIR__.'/auth.php';
