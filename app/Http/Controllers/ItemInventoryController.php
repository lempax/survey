<?php

namespace App\Http\Controllers;

use App\ItemInventory; 
use App\ItemHistory;
use App\ItemCategories;
use App\ItemSerials;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Mail;
use Session;
use App\Employee as Employee;

class ItemInventoryController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        if (Auth::check()) {
            $_team = Auth::user()->teams();
            if ($_team->count() == 1 && $_team->first()->departmentid = 21395000) {
                $this->teams = \App\Department::where('name', 'like', 'U%')->get();
            } else {
                $this->teams = Auth::user()->teams();
                $this->exemptions = Auth::user()->settings()->type('filtered_list')->first() ? json_decode(Auth::user()->settings()->type('filtered_list')->first()->entries) : [];
            }
        }
    }
    
    public function display() {

        $breakdown = [
            'name' => 'Item Inventory',
            'headers' => ['Item Name', 'Serial No.', 'Suppplier', 'Date Updated', 'Unit Price', 'Stocks'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];
        
        $inventory = new ItemInventory();
        $categories = new ItemCategories();
        $data['rows'] = $inventory->get();
        
        $data['categories'] = $categories->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Item Inventory';
        $data['perfurl'] = 'iteminventory';
        return view('iteminventory.iteminventory', $data);
    }
    
    public function manage() {

        $breakdown = [
            'name' => 'Item Inventory',
            'headers' => ['Item Name', 'Serial No.', 'Suppplier', 'Date Updated', 'Unit Price', 'Stocks'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];
        
        $inventory = new ItemInventory();
        $categories = new ItemCategories();
        $data['rows'] = $inventory->get();
        
        $data['categories'] = $categories->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Item Inventory';
        $data['perfurl'] = 'iteminventory';
        return view('iteminventory.iteminventorymanage', $data);
    }
    
    public function category() {

        $breakdown = [
            'name' => 'Item Inventory',
            'headers' => ['Item Name', 'Serial No.', 'Suppplier', 'Date Updated', 'Unit Price', 'Stocks'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];
        
        $inventory = new ItemInventory();
        $categories = new ItemCategories();
        $data['rows'] = $inventory->get();
        
        $data['categories'] = $categories->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Item Inventory';
        $data['perfurl'] = 'iteminventory';
        return view('iteminventory.iteminventorycategory', $data);
    }
    
    public function add(Request $request) {
        $this->validate($request, 
            [   'name' => 'required',
                'price' => 'required',
                'quantity' => 'required',
                'supplier' => 'required',
                'date_delivered' => 'required'
            ]
        );

        $temp = $request->get('category');
        $tempcid = DB::table('item_categories')->where('category', $temp)->first();
        $cid = $tempcid->cid;
        
        $itemsData = array(
            'name' => $request->get('name'),
            'type' =>$request->get('type'),
            'price' =>$request->get('price'),
            'quantity' => $request->get('quantity'),
            'cid' => $cid,
            'supplier' =>$request->get('supplier'),
            'date_delivered' => date('Y-m-d', strtotime( $request->get('date_delivered'))),
            'warranty_date' => empty($request->get('warranty_date')) ? '' : date('Y-m-d', strtotime( $request->get('warranty_date'))),
            'addn_details' => $request->get('addn_details')
        );
        ItemInventory::create($itemsData);
        
        $temp_id = DB::table('items')->where('name', $request->get('name'))->where('date_delivered', date('Y-m-d', strtotime( $request->get('date_delivered'))))->first();
        $serial = $request->get('serial');
        $serialData = array();
        for ($i = 0; $i < count($serial); $i++) {
            $now = date("Y-m-d");
            $temp_id->id;
            $serialData = array(
                'item_id' => $temp_id->id,
                'serial' => $serial[$i]
            );
            if($serial[$i]!=''){
                ItemSerials::create($serialData);
            }     
        }
        
        $historyData = array(
            'item_id' => $temp_id->id,
            'history_type' => 'ADD',
            'description' => 'Added a new item',
            'changed_by' => Auth::user()->username
        );
        
        ItemHistory::create($historyData);
        Session::flash('flash_message', 'Item successfully added.');
        
        $data['name'] = $request->get('name');
        $data['category'] = $request->get('category');
        $data['price'] = $request->get('price');
        $data['quantity'] = $request->get('quantity');
        $data['supplier'] = $request->get('supplier');
        $data['date_delivered'] = $request->get('date_delivered');

        $user = Auth::user();
        Mail::send('iteminventory.iteminventorymail', $data, function ($message) use ($user) {
            $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
            $message->to($user->superior->email, $user->superior->name)->subject('1&1 Item Inventory');
            $message->cc($user->email, $user->name);
            $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
        });
       
        return redirect('iteminventory/new');
    }
    
    public function addcategory(Request $request) {
       $this->validate($request, 
           [   'category' => 'required'
           ]
       );
       $categoryData = array(
           'category' =>$request->get('category')
       );
       ItemCategories::create($categoryData);
       Session::flash('category_message', 'Category successfully added.');
       return redirect('iteminventory/display');

    }
    
    public function removecategory(Request $request) {
       $toremove = $request->get('ctgry');
       DB::table('item_categories')->where('category', $toremove)->delete();
       Session::flash('category_message', 'Category successfully removed.');
       return redirect('iteminventory/display');
    }

    public function retrieve($id) {
       $breakdown = [
           'data' => []
       ];

       $items = new ItemInventory();
       $categories = new ItemCategories();

       $data['categories'] = $categories->get();
       $data['rows'] = $items->where('id', $id)->first();
       $data['breakdown'] = $breakdown;
       $data['page_title'] = 'Manage Item Inventory';
       $data['perfurl'] = 'iteminventory';
       
       $history = new ItemHistory();
       $data['histories'] = $history->where('item_id', $id)->get();

       return view('iteminventory.iteminventoryedit', $data);
    }

    public function updatestocks(Request $request) {
       $id = $request->get('id');
       $stocks = $request->get('stock_count');
       $qty = DB::table('items')->where('id', $id)->first();
       $final_qty = $stocks + $qty->quantity;
       DB::table('items')->where('id', $id)->update(['quantity' => $final_qty]);
       
       $historyData = array(
            'item_id' => $id,
            'history_type' => 'UPDATE',
            'description' => 'Updated stocks count by: '.$stocks,
            'changed_by' => Auth::user()->username
        );
        ItemHistory::create($historyData);
       
       return redirect('iteminventory/viewitem/'.$id);
    }
    
    public function changecategory(Request $request) {
       $id = $request->get('id');
       $category = $request->get('new_ctgry');
       $new_category = DB::table('item_categories')->where('category', $category)->first();
       DB::table('items')->where('id', $id)->update(['cid' => $new_category->cid]);
       return redirect('iteminventory/viewitem/'.$id);
    }
    
    public function update(Request $request) {
        $this->validate($request, 
            [   'name' => 'required',
                'price' => 'required',
                'supplier' => 'required',
                'date_delivered' => 'required'
            ]
        );
        
        $id = $request->get('id');
        $itemsData = array(
            'name' => $request->get('name'),
            'price' =>$request->get('price'),
            'supplier' =>$request->get('supplier'),
            'date_delivered' => date('Y-m-d', strtotime( $request->get('date_delivered'))),
            'warranty_date' => empty($request->get('warranty_date')) ? '' : date('Y-m-d', strtotime( $request->get('warranty_date')))
        );
        $items = ItemInventory::find($id);
        $items->update($itemsData);
        
        $historyData = array(
            'item_id' => $id,
            'history_type' => 'UPDATE',
            'description' => 'Item details was changed or updated.',
            'changed_by' => Auth::user()->username
        );
        ItemHistory::create($historyData);
        
        return redirect('iteminventory/viewitem/'.$id);
    }
    public function sort(Request $request) {

        $breakdown = [
            'name' => 'Item Inventory',
            'headers' => ['Item Name', 'Serial No.', 'Suppplier', 'Date Updated', 'Unit Price', 'Stocks'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];
        
        $sort = $request->get('sortcategory');
        
        $inventory = new ItemInventory();
        $categories = new ItemCategories();
        if($sort=='Show All')  {$data['rows'] = $inventory->get();}
        else {$data['rows'] = $inventory->where('cid', $sort)->get();}
        
        $data['categories'] = $categories->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Item Inventory';
        $data['perfurl'] = 'iteminventory';
        return view('iteminventory.iteminventorymanage', $data);
    }
    
}
