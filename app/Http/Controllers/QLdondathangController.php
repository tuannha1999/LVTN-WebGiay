<?php

namespace App\Http\Controllers;

use App\Dondathang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class QLdondathangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
    if ($request->ajax()) {
        $ddh = Dondathang::latest()->get();
        return Datatables::of($ddh)
            ->addColumn('action', function ($ddh) {
               return '<a class="btn btn-default"  id="edit-user" data-toggle="tooltip" href="' . URL('/admin//'.$ddh->id) . '"><i class="fa fa-eye"></i></a>
                <a class="btn btn-default" id="detail-user" data-toggle="tooltip" href="' . URL('/admin//'.$ddh->id) . '"><i class="far fa-edit"></i> </a>
                <a class="btn btn-default" href="javascript:void(0);" id="delete-user" data-toggle="tooltip" data-original-title="Delete" data-id="' . $ddh->id . 
                '" class="delete"> <i class="fas fa-trash-alt"></i></a>
                ';
            
            })->rawColumns(['action'])->make(true);
        
        //
    }
    return view('pages_admin.dondathang.list_donhang');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
