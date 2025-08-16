<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PublicPageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('public.pages.show', compact('page'));
    }

    public function index()
    {
        $pages = Page::where('status', 'published')
            ->orderBy('order')
            ->paginate(12);

        return view('public.pages.index', compact('pages'));
    }
}
