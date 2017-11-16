<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SASUpsells extends Model
{

    protected $table = 'sas_tracking';
    protected $fillable = [
        'sales_date', 'cw', 'contract_id', 'customer_id', 'person_id',
        'firstname', 'lastname', 'product_id', 'product_desc', 'country',
        'previous_product_id', 'previous_product_desc', 'tc_value',
        'up_side_down', 'serviceprovider', 'location', 'cd_team_id',
        'mc_check', 'ops_sales_cluster', 'ops_sales_cluster_compact',
        'transaction', 'department', 'sac', 'net', 'bulk', 'tid'
    ];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'person_id');
    }

    public function scopeValid($query) {
        return $query->where('mc_check', 'SaS_MC')
                        ->where('transaction', '!=', 'TC');
    }

    public function scopeInValid($query) {
        return $query->where('net', 0)
                        ->orWhere('mc_check', '!=', 'SaS_MC')
                        ->orWhere('transaction', 'TC');
    }
    
    public function scopeDateRange($query, $start, $end) {
        return $query->whereBetween('sales_date', [$start, $end]);
    }
    
    public function scopeFo($query){
        return $query->where('transaction', 'FO');
    }
    
    public function scopeGo($query){
        return $query->where('transaction', 'GO');
    }
    
    public function scopeTransaction($query){
        return $query->where('transaction', 'FO')
                    ->orWhere('transaction', 'GO');
    }
    
    public function scopeSastc($query){
        return $query->where('mc_check', 'SaS_MC')
                        ->where('transaction', 'TC');
    }
    
    public function scopeNet($query){
        return $query->where('net', 1);
    }
    
    public function scopeListlocal($query){
        return $query->where('ops_sales_cluster_compact', 'ListLocal');
    }
    
    public function scopeCloudserver($query){
        return $query->where('ops_sales_cluster_compact', 'Cloud Server');
    }
    
    public function scopeDedicated($query){
        return $query->where('ops_sales_cluster_compact', 'Dedicated Server');
    }
    
    public function scopeVps($query){
        return $query->where('ops_sales_cluster_compact', 'VPS');
    }
    
    public function scopeClassic($query){
        return $query->where('ops_sales_cluster_compact', 'Classic Hosting');
    }
    
    public function scopeMywebsite($query){
        return $query->where('ops_sales_cluster_compact', 'MyWebsite');
    }
    
    public function scopeEmail($query){
        return $query->where('ops_sales_cluster_compact', 'E-Mail');
    }
    
    public function scopeEbusiness($query){
        return $query->where('ops_sales_cluster_compact', 'E-Business');
    }
    
    public function scopeMarketing($query){
        return $query->where('ops_sales_cluster_compact', 'Online-Marketing');
    }
    
    public function scopeOffice($query){
        return $query->where('ops_sales_cluster_compact', 'Office');
    }
    
    public function scopeDomains($query){
        return $query->where('ops_sales_cluster_compact', 'Domains');
    }
    
    public function scopeDifm($query){
        return $query->where('ops_sales_cluster_compact', 'DIFM');
    }
    
    public function scopeYearweek($query){
        return $query->groupBy(\DB::raw('YEARWEEK(sales_date)'));
    }

    public function scopeWeekly($query, $week = false) {
        $yearweek = $week ? date('oW') - (date('W') - $week) : date('oW');
        return $query->where(\DB::raw('YEARWEEK(sales_date,1)'), '=', $yearweek);
    }

    public function scopeMonthly($query, $month = false) {
        if ($month) {
            $mo = $month <= 9 ? '0' . $month : $month;
            return $query->whereMonth('sales_date', '=', $mo);
        } else
            return $query->whereMonth('sales_date', '=', date('m'));
    }

}
