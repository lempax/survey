<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class AssetsIssuanceItems extends Model
{
    protected $table = 'assets_issuance_item';
    protected $fillable = ['issued_id', 'item_id', 'quantity', 'serial'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
    
    public function issueItem($_item_id, $_quantity){
        $issue = DB::table('assets_items')->where('id', $_item_id)->first();
        $updateData = array (
            'category' => $issue->category,
            'name' => $issue->name,
            'serial' => $issue->serial,
            'quantity' => $issue->quantity - $_quantity,
            'supplier' => $issue->supplier,
            'date_delivered' => $issue->date_delivered,
            'warranty_date' => $issue->warranty_date,
            'logged_by' => $issue->logged_by      
        );
        $update = AssetsItems::find($_item_id);
        $update->update($updateData);
    }
}
