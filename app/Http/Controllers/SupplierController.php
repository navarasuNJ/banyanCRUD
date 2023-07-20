<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use Illuminate\Http\Request;
use DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['suppliers']=Supplier::get();
        return view('supplier.index',$data);
    }

    public function getSuppliers(Request $request)
    {
        if ($request->ajax()) {
            $data = Supplier::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-danger" href="javascript:;" onclick="deleteSupplier('.$row->id.')">Delete</a>';
                    // $actionBtn = '<a class="btn btn-primary" href="'.route("supplier.edit",$row->id).'">Edit</a> <a class="btn btn-danger" href="javascript:;" onclick="deleteSupplier('.$row->id.')">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $supplier=Supplier::get()->last();
        if(isset($supplier)){
            $lastID=$supplier->id+1;
        }else{
            $lastID=1;
        }
        $data['code']='BANYAN-'.$lastID;
        $data['countries']=$this->getCountry();

        return view('supplier.create',$data);
    }

    private function getCountry()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            'X-CSCAPI-KEY: UTRsZEpSWTdkSFZ3WjBFanlWY0ttR1FvbWVwZG93MjIwRkV2S2dnRg=='
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        // $html='';
        // foreach(json_decode($response) as $row){
        //     $html.='<option value="'.$row->name.'" data-iso2="'.$row->iso2.'">'.$row->name.'</option>';
        // }

        return json_decode($response);
    }

    public function getState($iso2)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$iso2.'/states',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            'X-CSCAPI-KEY: UTRsZEpSWTdkSFZ3WjBFanlWY0ttR1FvbWVwZG93MjIwRkV2S2dnRg=='
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        $html='';
        foreach(json_decode($response) as $row){
            $html.='<option value="'.$row->name.'" data-iso2="'.$row->iso2.'">'.$row->name.'</option>';
        }

        return $html;
    }

    public function getCity($iso2,$ciso2)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$iso2.'/states/'.$ciso2.'/cities',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            'X-CSCAPI-KEY: UTRsZEpSWTdkSFZ3WjBFanlWY0ttR1FvbWVwZG93MjIwRkV2S2dnRg=='
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        $html='';
        foreach(json_decode($response) as $row){
            $html.='<option value="'.$row->name.'">'.$row->name.'</option>';
        }

        return $html;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        try {
            $details=array('address1' => $request->address1, 'address2' => $request->address2,'country'=>$request->country,'state'=>$request->state,'city'=>$request->city,'postal_code'=>$request->postal_code,'email_id'=>$request->email_id,'mobile_number'=>$request->mobile_number,'website_url'=>$request->website_url,'credit_period'=>$request->credit_period);
            $contact=[];
            $count=count($request->salutation);
            for($i=0;$i<$count;$i++){
                $contact[]=array(
                    'salutation' => $request->salutation[$i],
                    'name' => $request->name[$i],
                    'designation' => $request->designation[$i],
                    'department' => $request->department[$i],
                    'email' => $request->email[$i],
                    'mobile' => $request->mobile[$i],
                    'profile_picture' => $request->profile_picture[$i]
                );
            }
            $data=array(
                'code' => $request->supplier_code,
                'group' => $request->supplier_group,
                'name' => $request->company_name,
                'details' => json_encode($details),
                'contact' => json_encode($contact)
            );
            $supplier=Supplier::create($data);
            if($supplier){
                return redirect(url('supplier'));
            }
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
    }
}
