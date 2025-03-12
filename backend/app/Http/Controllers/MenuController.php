<?php
namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Lấy tất cả banner
    public function index()
    {
        $banners = Menu::all();
        return response()->json($banners);
    }
}
