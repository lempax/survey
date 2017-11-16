<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Employee;
use App\Department;
use App\FoodItems;
use App\FoodCategory;
use App\FoodMenu;
use App\MenuDetails;
use App\ItemCategories;

class CafeteriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        if(\Auth::check() == null)
        {
            return redirect('login');
        }
    }
    
    public function index(Request $request)
    {
        $date = \Carbon\Carbon::now();
        $week = $date->format("W");
//        $menuForTheWeek = FoodMenu::where('week', $date->format('W'))->first();
//        $page_title = 'Cafeteria Tool'; 
//        
//        $dessertItems = FoodMenu::join('foodmenu_details', 'food_menu.menu_id', '=', 'foodmenu_details.m_id')
//                ->join('food_items', 'foodmenu_details.item_id', '=', 'food_items.id')
//                ->where('week', $date->format('W'))
//                ->where('cat_id', 1)
//                ->get();
//        $snackItems = FoodMenu::join('foodmenu_details', 'food_menu.menu_id', '=', 'foodmenu_details.m_id')
//                ->join('food_items', 'foodmenu_details.item_id', '=', 'food_items.id')
//                ->where('week', $date->format('W'))
//                ->where('cat_id', 2)
//                ->get();
//        $beverageItems = FoodMenu::join('foodmenu_details', 'food_menu.menu_id', '=', 'foodmenu_details.m_id')
//                ->join('food_items', 'foodmenu_details.item_id', '=', 'food_items.id')
//                ->where('week', $date->format('W'))
//                ->where('cat_id', 3)
//                ->get();
//        $viandItems = FoodMenu::join('foodmenu_details', 'food_menu.menu_id', '=', 'foodmenu_details.m_id')
//                ->join('food_items', 'foodmenu_details.item_id', '=', 'food_items.id')
//                ->where('week', $date->format('W'))
//                ->where('cat_id', 4)
//                ->get();
//        $agent = \Auth::user()->uid;
//        $department = \Auth::user()->department()->get();
        
        //return view('cafeteria.index', compact('menuForTheWeek','page_title' , 'dessertItems', 'snackItems', 'beverageItems', 'viandItems' , 'department', 'agent'));
        
        return redirect('cafeteria/'.$week);
    }
    
    public function viewMenu($id)
    {
        $week = $id;
        $menuForTheWeek = FoodMenu::where('week', $id)->first();
        $page_title = 'Cafeteria Tool'; 
        if($menuForTheWeek)
        {
            $items = \DB::table('foodmenu_details')->where('m_id', $menuForTheWeek->menu_id)->count();
        }
        
        $date = \Carbon\Carbon::now();
        if($id > $date->format("W"))
        {
            return redirect('cafeteria/'.$date->format("W"));
        }

        $dessertItems = FoodMenu::join('foodmenu_details', 'food_menu.menu_id', '=', 'foodmenu_details.m_id')
                ->join('food_items', 'foodmenu_details.item_id', '=', 'food_items.id')
                ->where('week', $id)
                ->where('cat_id', 1)
                ->get();
        $snackItems = FoodMenu::join('foodmenu_details', 'food_menu.menu_id', '=', 'foodmenu_details.m_id')
                ->join('food_items', 'foodmenu_details.item_id', '=', 'food_items.id')
                ->where('week', $id)
                ->where('cat_id', 2)
                ->get();
        $beverageItems = FoodMenu::join('foodmenu_details', 'food_menu.menu_id', '=', 'foodmenu_details.m_id')
                ->join('food_items', 'foodmenu_details.item_id', '=', 'food_items.id')
                ->where('week', $id)
                ->where('cat_id', 3)
                ->get();
        $viandItems = FoodMenu::join('foodmenu_details', 'food_menu.menu_id', '=', 'foodmenu_details.m_id')
                ->join('food_items', 'foodmenu_details.item_id', '=', 'food_items.id')
                ->where('week', $id)
                ->where('cat_id', 4)
                ->get();
        $agent = \Auth::user()->uid;
        $department = \Auth::user()->department()->get();
        
        return view('cafeteria.index', compact('menuForTheWeek','page_title' , 'dessertItems', 'snackItems', 'beverageItems', 'viandItems' , 'department', 'agent','week','items'));
    }
    public function createMenu(Request $request, $id) {
        $page_title = 'Cafeteria Tool';
        $items = FoodItems::with('category')->get();
        $week = $id;
        $menu = FoodMenu::where('week', $id)->first();
        return view('cafeteria.cafeteria', compact('page_title', 'items', 'display','week','menu'));
    }
    public function editMenu($id)
    {
        $page_title = 'Cafeteria Tool';
        $items = FoodItems::with('category')->get();
        $menuItems = FoodMenu::join('foodmenu_details', 'food_menu.menu_id', '=', 'foodmenu_details.m_id')
                ->join('food_items', 'foodmenu_details.item_id', '=', 'food_items.id')
                ->where('week', $id)
                ->get();
        $tableItems = array();
        $week = $id;
        $menu = FoodMenu::where('week', $id)->first();
        if($menu)
        {
            $count = \DB::table('foodmenu_details')->where('m_id', $menu->menu_id)->count();
        }
        foreach ($items as $item)
        {
            $bool = false;
            
            foreach ($menuItems as $menuItem)
            {
                if($menuItem['id'] == $item['id'])
                {
                    $bool = true;
                }
            }
            
            if (!$bool)
            {
                array_push($tableItems,$item);
            }
        }
        
        return view('cafeteria.cafeteria', compact('page_title', 'menuItems', 'tableItems','week','menu','count', 'items'));
    }
    
    public function updateMenu(Request $request, $id)
    {
        $items = FoodMenu::join('foodmenu_details', 'food_menu.menu_id', '=', 'foodmenu_details.m_id')
                ->join('food_items', 'foodmenu_details.item_id', '=', 'food_items.id')
                ->where('week', $id)
                ->get();
                
        foreach ($items as $item)
        {
            \DB::table('foodmenu_details')->where('item_id', $item->id)->delete();
        }
        
        $items = $request->input('itemID');
        $menu = FoodMenu::where('week', $id)->first();
        if($request->input('itemID')) {
            foreach($items as $item) {
                $details = MenuDetails::create([
               'm_id' => $menu->menu_id,
               'item_id' => $item
            ]);
            }
        }
        
        return redirect ('cafeteria/'.$id);
    }
    
    public function addItem(Request $request, $id)
    {
        $agent = \Auth::user()->uid;
        $departmentid = Employee::find($agent)->departmentid;
        $itemname = $request->input('itemname');
        $category = $request->input('category');
        $price = $request->input('price');
        
        
        if ($request->category == 'Dessert')
        {
            $create = FoodItems::create([
            'item_name' => $itemname,
            'cat_id' => 1,
            'price' => $price,      
        ]);
        }
        else if ($request->category == 'Snack')
        {
            $create = FoodItems::create([
            'item_name' => $itemname,
            'cat_id' => 2,
            'price' => $price,      
        ]);
        }
        else if ($request->category == 'Beverage')
        {
            $create = FoodItems::create([
            'item_name' => $itemname,
            'cat_id' => 3,
            'price' => $price,      
        ]);
        }
        else
        {
            $create = FoodItems::create([
            'item_name' => $itemname,
            'cat_id' => 4,
            'price' => $price,      
        ]);
       
        }
        return redirect('cafeteria/editmenu/'.$id);
}
    
    public function deleteItem(Request $request)
    {
        $id = $request->input('id');
        $delete = FoodItems::destroy($id);
        
        return response ()-> json ($delete);
    }
    
    public function updateItem(Request $request, $id)
    {
        $newItemName = $request->input('eitemname');
        $newItemCategory = $request->input('ecategory');
        $newItemPrice = $request->input('eprice');
        $newCreator = \Auth::user()->uid;
        $newDepartmentId =  Employee::find($newCreator)->departmentid;;
        $fid = $request->input('eid');
        
        if ($request->ecategory == 'Dessert')
        {
        $new = FoodItems::where('id' , $fid)->update([
            'item_name' => $newItemName,
            'cat_id' => 1,
            'price' => $newItemPrice,
        ]);

        
        }
        else if ($request->ecategory == 'Snack')
        {
        $new = FoodItems::where('id' , $fid)->update([
            'item_name' => $newItemName,
            'cat_id' => 2,
            'price' => $newItemPrice,
        ]);

        
        }
        else if ($request->ecategory == 'Beverage')
        {
        $new = FoodItems::where('id' , $fid)->update([
            'item_name' => $newItemName,
            'cat_id' => 3,
            'price' => $newItemPrice,
        ]);

        
        }
        else
        {
        $new = FoodItems::where('id' , $fid)->update([
            'item_name' => $newItemName,
            'cat_id' => 4,
            'price' => $newItemPrice,
        ]);

        }   
        return redirect('cafeteria/editmenu/'.$id);
    }
    
    public function addToMenu(Request $request, $id) {
        $items = $request->input('itemID');
        $menu = FoodMenu::create([
            'week' => $id,
            'creator' => \Auth::user()->uid
        ])->id;
        
 

        if($request->input('itemID')) {
            foreach($items as $item) {
                $details = MenuDetails::create([
               'm_id' => $menu,
               'item_id' => $item
            ]);
            }
        }
       
       
          return redirect('cafeteria');
    }
    
   
            
}