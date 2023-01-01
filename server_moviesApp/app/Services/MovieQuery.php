<?php 

namespace App\Services;
use Illuminate\Http\Request;

class MovieQuery{
    protected $safeParms=[
        'name'=>['eq','like'],
        'description'=>['eq','like']
    ];

    protected $columnMap=[
       'name'=>'name',
       'description'=>'description'
    ];

    protected $operatorMap=[
     'eq'=>'='
    ];

    public function transform(Request $request){
        $eloQuery=[];

        foreach($this->safeParms as $parm=>$operators){
             $query=$request->query($parm);

             if(!isset($query)){
                continue;
             }
             $column=$this->columnMap[$parm] ?? $parm;

             foreach($operators as $operator){
                if(isset($query[$operator])){
                    $eloQuery[]=[$column,$this->operatorMap[$operator],$query[$operator]];
                }
             }
        }
        return $eloQuery;
    }

}