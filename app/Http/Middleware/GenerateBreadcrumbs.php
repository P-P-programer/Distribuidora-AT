<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Breadcrumbs;

class BreadcrumbController extends Controller
{
    protected $breadcrumbs;

    public function __construct(Breadcrumbs $breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    public function generate(Request $request)
    {
        $breadcrumbs = $this->breadcrumbs->generate($request->route()->getName());
        return view('layouts.app', compact('breadcrumbs'));
    }
}