<?php

namespace Bredi\BrediDashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class BrediDashboardController extends Controller
{
    public function __construct()
    {
        $this->vendor = config('bredidashboard.templates')[config('bredidashboard.default')];
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        // return view('bredidashboard::index');
        // dd();
        return view($this->vendor['name'] . '::controle.index.index');
    }
    public function formLogin()
    {
        return view($this->vendor['name'] . '::login');
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('bredidashboard::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('bredidashboard::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('bredidashboard::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
