<?php
namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller {
    public function index() {
        $services = Service::where('is_active', true)->get();
        return view('home', compact('services'));
    }
    public function about() { return view('about'); }
    public function portfolio() { return view('portfolio'); }
    public function contact() { return view('contact'); }
}
