<?php
namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    // Lấy tất cả banner
    public function index()
    {
        $banners = Banner::all();
        return response()->json($banners);
    }
}
