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
use App\Http\Controllers\superadmin\StatusController;
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

            Route::group(['prefix'=>'status'],function (){
                Route::controller(StatusController::class)->group(function (){
                    Route::match(['get','post'],'set-order-status','setOrderStatus')->name('set.order.status');
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
                Route::match(['get','post'],'user-view/{UserID}','singleViewUser')->name('admin.single.view.user');
                Route::match(['get','post','put'],'user-edit/{UserID}','edit')->name('admin.edit.single.user');
                Route::put('user-password-update','passwordUpdate')->name('admin.user.password.update');
                Route::put('user-status-update','statusUpdate')->name('admin.user.status.update');
//                Route::delete('delete-user','destroy')->name('admin.delete.user');
            });
        });
        Route::controller(\App\Http\Controllers\admin\OrderController::class)->group(function (){
            //Admin Order
            Route::match(['get'],'admin-order-list','adminOrderList')->name('admin.to.admin.order.list');
            Route::match(['get'],'admin-order-view/{orderID}','adminOrderView')->name('admin.to.admin.order.view');
            Route::put('admin-to-admin-received-order','adminToAdminOrderReceived')->name('admin.to.admin.order.received');
//#####################################################################################
            //Shop Order
            Route::match(['get'],'shop-order-list','shopOrderList')->name('admin.shop.order.list');
            Route::match(['get'],'shop-order-view/{orderID}','shopOrderView')->name('admin.shop.order.view');
            Route::put('admin-order-received-from-shop','adminOrderReceivedShop')->name('admin.received.order.from.shop');
            Route::put('shop-order-send-to-admin','shopOrderSendAdmin')->name('admin.shop.order.admin');
            Route::put('shop-order-received-to-admin','shopOrderReceivedAdmin')->name('admin.shop.order.received.admin');
            Route::put('shop-order-send-request-community','shopOrderSendRequestCommunity')->name('admin.shop.order.request.delivery.community');
//##############################################################################
            //Community Order
            Route::match(['get'],'community-order-list','communityOrderList')->name('community.to.admin.order.list');
            Route::match(['get'],'community-order-view/{orderID}','communityOrderView')->name('community.to.admin.order.view');
            Route::put('community-to-admin-received-order','communityToAdminOrderReceived')->name('community.to.admin.order.received');
//##########################################################
//            All Order
            Route::match(['get'],'all-order-list','allOrderList')->name('all.order.list');
            Route::match(['get'],'order-view/{orderID}','OrderView')->name('order.view');
            //My Order
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
            Route::match(['get','post'],'my-community','myCommunity')->name('vendor.my.community');
            Route::delete('delete-vendor-community','deleteCommunity')->name('vendor.delete.community');
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
//                Route::delete('delete-category','destroyCategory')->name('vendor.delete.category');

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

                Route::get('sending-admin-list','sendingAdminOrder')->name('sending.admin.order.list');
                Route::put('submit-order','submitAdmin')->name('submit.order.admin');

                Route::get('sending-community-list','sendingCommunityOrder')->name('sending.community.order.list');
                Route::post('submit-order-community','submitOrderCommunity')->name('vendor.submit.order.community');

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
            Route::match(['post','get'],'order-single-view/{orderID}','orderSingle')->name('customer.order.single.view');
            Route::put('user-accept-order-submit','userAcceptOrder')->name('user.accept.order.submit');
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
        // Orders
        Route::controller(\App\Http\Controllers\community\OrderController::class)->group(function (){
            //Shop order start
            Route::get('shop-request-list','ShopRequestList')->name('community.shop.request.list');
            Route::match(['get','post'],'shop-request-view/{orderID}','ShopOrderView')->name('community.shop.request.view');
            Route::put('shop-order-accepted','shopOrderAccepted')->name('shop.order.accepted');
            Route::get('accepted-shop-order-list','shopAcceptedOrderList')->name('community.accepted.shop.order.list');
            Route::get('shop-complete-order-list','shopCompleteOrderList')->name('community.complete.order.list');
            Route::get('all-customer-acceptance-list','waitingCustomerAcceptanceList')->name('community.all.for.customer.acceptance');
            Route::put('delivery-direct-customer','deliveryDirectCustomer')->name('delivery.direct.customer');
            Route::put('send-to-admin','sendAdmin')->name('send.to.admin');

            //Admin order start
            Route::get('admin-request-list','adminRequestList')->name('admin.to.community.request.list');
            Route::get('admin-accepted-list','adminAcceptedList')->name('admin.to.community.accepted.list');
            Route::get('all-for-customer-receiving-list','waitingCustomerReceivingList')->name('community.to.customer.request.list');
            Route::match(['get','post'],'admin-order-view/{orderID}','AdminOrderView')->name('admin.to.community.request.view');
            Route::put('accepted-order-from-admin','communityAcceptedOrderAdmin')->name('community.accepted.order.from.admin');


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
