<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use Illuminate\Support\Facades\Storage;
use InterventionImage;
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;

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
        //phpinfo();
        //$ownerId = Auth::id();
        $shops = Shop::where('owner_id', Auth::id())->get();

        return view('owner.shops.index', compact('shops'));
    }

    public function edit($id)
    {
        $shop = Shop::findOrFail($id);
        return view('owner.shops.edit', compact('shop'));
    }

    public function update(UploadImageRequest $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'information' => 'required|string|max:1000',
            'is_selling' => 'required',
        ]);
        //一時保存
        $imageFile = $request->image;
        if (!is_null($imageFile) && $imageFile->isValid()) {
            //リサイズなしの場合
            //Storage::putFile('public/shops', $imageFile);
            // $fileName = uniqid(rand() . '_');
            // $extension = $imageFile->extension();
            // $fileNameToStore = $fileName . '.' . $extension;
            // $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();
            // Storage::put('public/shops/' . $fileNameToStore, $resizedImage);
            $fileNameToStore = ImageService::upload($imageFile, 'shops');
        }

        $shop = Shop::findOrFail($id);
        $shop->name = $request->name;
        $shop->information = $request->information;
        $shop->is_selling = $request->is_selling;

        if (!is_null($imageFile) && $imageFile->isValid()) {
            $shop->filename = $fileNameToStore;
        }

        $shop->save();

        return redirect()->route('owner.shops.index')
            ->with([
                'message' => '店舗情報を更新しました。',
                'status' => 'info'
            ]);
    }
}
