<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;

class ShopController extends Controller
{
    /**
     * 新しいUserControllerインスタンスの生成
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function ($request, $next) {
            //shop idの取得
            $id = $request->route()->parameter('shop');
            //null判定
            if (!is_null($id)) {
                $shopsOwnerId = Shop::findOrFail($id)->owner->id;
                //文字列→数値に型変換
                $shopId = (int)$shopsOwnerId;
                $ownerId = Auth::id();
                if ($shopId !== $ownerId) {
                    abort(404);
                }
            }
            return $next($request);
        });
    }

    public function index()
    {
        //$ownerId = Auth::id();
        $shops = Shop::where('owner_id', Auth::id())->get();

        return view('owner.shops.index', compact('shops'));
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }
}
