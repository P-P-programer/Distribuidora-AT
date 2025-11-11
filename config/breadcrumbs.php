<?php

namespace App\Http\Controllers;

use App\Services\Breadcrumbs;

class BreadcrumbController extends Controller
{
    protected $breadcrumbs;

    public function __construct(Breadcrumbs $breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs->generate('home');
        return view('pages.home', compact('breadcrumbs'));
    }

    public function products()
    {
        $breadcrumbs = $this->breadcrumbs->generate('products.index');
        return view('pages.products.index', compact('breadcrumbs'));
    }

    public function profile()
    {
        $breadcrumbs = $this->breadcrumbs->generate('account.profile');
        return view('pages.account.profile', compact('breadcrumbs'));
    }
}