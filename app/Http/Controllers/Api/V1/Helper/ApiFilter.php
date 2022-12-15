<?php
namespace App\Http\Controllers\Api\V1\Helper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
trait ApiFilter{

    public $column_name='id';
    public $sort = "desc";
    public $show_per_page=20;
    public $start_date, $end_date;
    public $account_id;
    public $query;

    public function setFilterProperty($request){

        $this->setSortBy($request->sort_by);
        $this->setShowPerPage($request);
        
        $this->setAccountId(Auth::user()->account_id);
    }

    public function setDate($request){
        $this->start_date = Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay();
        $this->end_date = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay();
    }
    public function setSortBy($sort_by){
        
        if (!empty($sort_by)) {
            foreach ($sort_by as $column_name => $sort) {
               $this->column_name = $column_name;
                $this->sort = $sort;
            }
        }
    }
    public function setShowPerPage($request){
        
        if ($request->has('show_per_page')) {
            
                $this->show_per_page = $request->show_per_page;
        }
    }
    
    public function setAccountId($account_id){
        $this->account_id=$account_id;

    }
    public function dateRangeQuery($request,$query,$query_column){
        if( $request->has('start_date') && $request->has('end_date')){
            $this->setDate($request);
            $query=$query->whereBetween($query_column,[$this->start_date,$this->end_date]);
            $this->query=$query;
        }
        $this->query=$query;
    }

    public function wareHouseQuery($request,$query,$query_colum){
        if($request->has('warehouse_id')){
            $query=$query->where($query_colum, $request->warehouse_id);
            $this->query=$query;
        }
        $this->query=$query;
    }
}