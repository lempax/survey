<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saspayout extends Model
{
    public $table = 'sas_payout';
    public $fillable = ['month', 'sales_date', 'cw', 'contract_id', 'customer_id', 
        'person_id', 'fname', 'lname', 'product_id', 'product_desc', 'prev_product_id', 
        'prev_product_desc', 'tc_value', 'upside_down', 'country', 'cd_team_id',
        'service_provider', 'location', 'mc_check', 'ops_sales_cluster', 'ops_sales_cluster_compact',
        'transaction', 'department', 'upsells', 'full_name', 'remarks', 'comments',
        'product_price', 'invoice', 'logged_by', 'validation_date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'person_id');
    }
    
    public function scopeDateRange($query, $start, $end) {
        return $query->whereBetween('sales_date', [$start, $end]);
    }
    
    public function scopeWeekly($query, $week = false) {
        $yearweek = $week ? date('oW') - (date('W') - $week) : date('oW');
        return $query->where(\DB::raw('WEEK(sales_date, 1)'), '=', $yearweek);
    }
    
    //Scope for Remarks Column
    public function scopeSoftLock($query){
        return $query->where('remarks', 'softlock');
    }
    
    public function scopeValid($query){
        return $query->where('remarks', 'valid');
    }
    
    public function scopeNoInvoice($query){
        return $query->where('remarks', 'no invoice');
    }
    
    public function scopeGesperrt($query){
        return $query->where('remarks', 'Gesperrt Buha');
    }
    
    public function scopeInvalid($query){
        return $query->where('remarks', 'invalid');
    }
    
    public function scopeFraud($query){
        return $query->where('remarks', 'Fraud-Detection');
    }
    
    public function scopeMindersaldo($query){
        return $query->where('remarks', 'Mindersaldo');
    }
    //End Scope for Remarks Column
    
    //Scope for Transaction Column
    public function scopeGo($query){
        return $query->where('transaction', 'GO');
    }
    
    public function scopeFo($query){
        return $query->where('transaction', 'FO');
    }
    
    public function scopeTc($query){
        return $query->where('transaction', 'TC');
    }
    //End Scope for Transaction Column
    
    //Scope for Ops Sales Cluster Column
    public function scopeNtld($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'nTLD');
    }
    
    public function scopeDomain($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'Domain');
    }
    
    public function scopeMSExchange($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'MS Exchange LO');
    }
    
    public function scopeSSL($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'SSL');
    }
    
    public function scopeVirusScanner($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'Virus Scanner');
    }
    
    public function scopeClassicHosting($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'Classic Hosting');
    }
    
    public function ScopeCDN($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'CDN');
    }
    
    public function ScopeEshop($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'E-Shops');
    }
    
    public function ScopeListlocal($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'List Local');
    }
    
    public function ScopeOnlineMarketing($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'Online-Marketing');
    }
    
    public function ScopeMailBasic($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'Mail Basic (FT)');
    }
    
    public function ScopeMailBusiness($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'Mail Business LO');
    }
    
    public function ScopeMailQuota($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'Mail Quota');
    }
    
    public function ScopeMWP($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'MWP Feature');
    }
    
    public function ScopeMSB($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'MSB Feature');
    }
    
    public function ScopeSEO($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'SEO-Tool');
    }
    
    public function ScopeSiteLock($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'SiteLock');
    }
    
    public function ScopeVPS($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'VPS');
    }
    
    public function ScopeMyWFeature($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'MyW Feature');
    }
    
    public function ScopeMyWebsite($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'MyWebsite');
    }
    
    public function ScopeNAV($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'NAV');
    }
    
    public function ScopeDedicated($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'Dedicated Server');
    }
    
    public function ScopeDesignService($query){
        return $query->where('ops_sales_cluster', 'LIKE', 'Design Service');
    }
    //End Scope for Ops Sales Cluster Column
    
    //Scope for Upside Down Column
    public function ScopeUpgrade($query){
        return $query->where('upside_down', 'Upgrade');
    }
    //End Scope for Upside Down Column
}
