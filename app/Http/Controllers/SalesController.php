<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuickSalesRequest;
use App\Http\Requests\SubmitSalesRequest;
use App\Http\Requests\SubmitSendOfApprovalRequest;
use App\Http\Requests\SubmitSendOfStatusRequest;
use App\Models\Bank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\QuickSales;
use App\Models\CarMaster;
use App\Models\Branch;
use App\Models\Discount;
use App\Models\Insurance;
use App\Models\SaleAccesoriesFile;
use App\Models\Sales;
use App\Models\Taxes;
use App\Services\CarMasterStatusService;
use App\Services\LogService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $branch = Branch::all();
            $status = [
                ['text' => 'All', 'value' => ''],
                ['text' => 'Approved', 'value' => '1'],
                ['text' => 'Rejected', 'value' => '2'],
                ['text' => 'Pending', 'value' => '3']
            ];
            $car = CarMaster::all();

            $query = Sales::query()->where('Status', '!=', '4');

            if ($request->FromDateOfSales) {
                $query->Where('DateOfSales', '>=', $request->FromDateOfSales);
            }

            if ($request->ToDateOfSales) {
                $query->Where('DateOfSales', '<=', $request->ToDateOfSales);
            }

            if ($request->invoiceNo) {
                $query->Where('InvoiceNo', $request->invoiceNo);
            }

            if ($request->status) {
                if ($request->status == '1') {
                    $query->where('status','1');
                }

                if ($request->status == '2') {
                    $query->where('status','2');
                }

                if ($request->status == '3') {
                    $query->whereIn('status',['0','5']);
                }
            }

            if ($request->name) {
                $query->whereRaw('CONCAT(FirstName, " ", LastName) LIKE ?', ['%' . $request->name . '%']);
            }
            

            if ($request->chasisNo) {
                $query->Where('ChasisNo', 'like', '%' . $request->chasisNo . '%');
            } 

            $query->orderBy('id', 'desc');
            
            $result = $query->paginate(10)->appends($request->all());

            $data = ['status' => $status, 'branch' => $branch, 'car' => $car, 'result' => $result];
            return view('view-sales')->with(['title' => 'View Sales', 'data' => $data]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-sales')->with('error', 'Record not found.');
        }
    }

    public function quickSalesIndex(Request $request){
        $car = CarMaster::whereIn('PhysicalStatus', ['QUICK BOOKED'])->get();
        $branch = Branch::all();
        $data = ['car' => $car, 'branch' => $branch];

        $query = QuickSales::query();
        if($request->input('branch')){
            $query->where('Branch', $request->input('branch'));
        }
        if($request->input('car')){
            $query->where('ChasisNo', $request->input('car'));
        }
        if($request->input('name')){
            $query->where('CustomerName','like', '%'. $request->input('name'). '%');
        }
        $query->orderBy('created_at', 'desc');
        $result = $query->paginate(10)->appends($request->all());
        $data['result'] = $result;
        return view('view-quick-booking')->with(['title'=>'View Quick Booking', 'data' => $data]);
    }

    public function show(Request $request, string $id = null)
    {
        $car = CarMaster::whereNotIn('PhysicalStatus', ['SOLD','QUICK BOOKED'])->get();
        $branch = Branch::all();
        $data = ['car' => $car, 'branch' => $branch];
        if($id){
            $query = QuickSales::query();
            $query->where('id', $id);
            $result = $query->first();
            $data['result'] = $result;
        }
        return view('quick-booking')->with(['title' => 'Quick Booking', 'data' => $data]);
    }

    public function store(QuickSalesRequest $request, string $id = null)
    {
        try {
            if (!$id) {
                $user = Auth::user();
                $validatedData = $request->validated();
                $branch = Branch::where('id', $request->input('Branch'))->first();
                $count = QuickSales::where('Branch', $request->input('Branch'))->count();
                $salesId = strtoupper(substr($branch->name, 0, 3)) . $count + 1;
                $validatedData['SalesId'] = $salesId;
                $validatedData['TMInvoiceNo'] = CarMaster::where('ChasisNo', $request->input('ChasisNo'))->first()->CommercialInvoiceNo;
                $newRecord = QuickSales::create($validatedData);
                CarMaster::where('ChasisNo', $request->input('ChasisNo'))->update(['PhysicalStatus' => 'QUICK BOOKED']);
                LogService::insertlog($newRecord->id,'Add','Quick Booking '.$newRecord->id,'quick_sales');
                Session::put('message', $request->input('ChasisNo') .' has been booked for quick sales. - '.$salesId);
                return response()->json([
                    'id' => $newRecord->id
                ]);
            }else{
                $user = Auth::user();
                $validatedData = $request->validated();
                $data = QuickSales::where('id', $id)->first();
                $data->update($validatedData);
                LogService::insertlog($id,'Update','Quick Booking '.$id,'quick_sales');
                Session::put('message', $request->input('ChasisNo') .' has been Updated. - '.$data->SalesId);
                return response()->json([
                    'id' => $id
                ]);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('quick-booking')->with('error', 'Error occurred while submitting!');
        }
    }

    public function getQuickSalesGatePass(Request $request, string $id)
    {
        try {
            $message = '';
            $quickSales = QuickSales::with(['CarMaster'])->findOrFail($id);
            if (isset($request->input()['from']) == 'quick-sales') {
                $message = 'On ' . Carbon::today()->format('d-m-Y') . ', ' . $quickSales->ChasisNo . ' cars were sold from ' . $quickSales->SalesBranch->name;
                session(['message' => $message]);
            }
            return view('quick-sale-gate-pass')->with(['title' => 'Quick Sales Gate Pass', 'data' => $quickSales]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-sales')->with('error', 'Record not found.');
        }
    }

    public function generateQuickSalesGatePassPDF(Request $request, string $id)
    {
        try {
            $message = '';
            $quickSales = QuickSales::with(['CarMaster'])->findOrFail($id);
            $pdf = Pdf::loadView('pdf.quick-sales-gate-pass', ['title' => 'Gate Pass', 'data' => $quickSales]);

            return $pdf->stream('TF' . $id . '.pdf');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-sales')->with('error', 'Record not found.');
        }
    }

    public function salesForm(Request $request, string $id = null)
    {
        $car = CarMaster::whereIn('PhysicalStatus', ['RECEIVED APPROVED', 'RECEIVED REJECTED'])->get();
        $branch = Branch::all();
        $insurance = Insurance::all();
        $bank = Bank::all();
        $discount = Discount::all();

        if ($id) {
            $sales = Sales::with(['accessoriesFile'])->where('id', $id)->first();

            if (!$sales) {
                return redirect()->route('view-sales')->with('error', 'Record not found.');
            }
        }

        $data = ['car' => $car, 'branch' => $branch, 'insurance' => $insurance, 'bank' => $bank, 'discount' => $discount, 'data' => (isset($sales)) ? $sales : null];
        return view('sales-form')->with(['title' => 'Sales', 'data' => $data]);
    }

    public function submitSalesForm(SubmitSalesRequest $request, string $id = null)
    {
        try {
            if (!$id) {
                $validatedData = $request->validated();
                CarMaster::where('ChasisNo', $validatedData['ChasisNo'])->update(['PhysicalStatus' => 'PENDING SOLD']);
                $newRecord = Sales::create($validatedData);
                if ($request->hasfile('accesoriesFile')) {
                    foreach ($request->file('accesoriesFile') as $index => $file) {
                        $result = Storage::disk('s3')->put("sales/".$newRecord->ID."/" . $newRecord->ID . "_Accessories_".$index."_" . $file->getClientOriginalName(), file_get_contents($file));
                        if ($result) {
                            $image['filename'] = config('constants.image_url') . "/sales/".$newRecord->ID."/" . $newRecord->ID . "_Accessories_".$index."_" . $file->getClientOriginalName();
                            $image['salesId'] =  $newRecord->ID;
                            SaleAccesoriesFile::create($image);
                        }
                    }
                }
                LogService::insertlog($newRecord->ID,'Add','Create New Sales '.$newRecord->ID,'sales');
                return redirect()->route('view-sales')->with('message', 'Submitted successfully!');
            }else{
                $validatedData = $request->validated();
                CarMaster::where('ChasisNo', $validatedData['ChasisNo'])->update(['PhysicalStatus' => 'PENDING SOLD']);
                $sales = Sales::where('id', $id)->first();
                $sales->update($validatedData);
                SaleAccesoriesFile::whereIn('id',explode(',', $request->toArray()['deleteAccesoriesFile']))->delete();
                if ($request->hasfile('accesoriesFile')) {
                    foreach ($request->file('accesoriesFile') as $index => $file) {
                        $result = Storage::disk('s3')->put("sales/".$id."/" . $id . "_Accessories_".$index."_" . $file->getClientOriginalName(), file_get_contents($file));
                        if ($result) {
                            $image['filename'] = config('constants.image_url') . "/sales/".$id."/" . $id . "_Accessories_".$index."_" . $file->getClientOriginalName();
                            $image['salesId'] =  $id;
                            SaleAccesoriesFile::create($image);
                        }
                    }
                }
                LogService::insertlog($sales->ID,'Update','Update Sales '.$sales->ID,'sales');
                return redirect()->route('view-sales')->with('message', 'Updated successfully!');
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-sales')->with('error', 'Record not found.');
        }
    }

    public function sendOfApproval(Request $request, string $id){
        try{
        $cgst = $sgst = $igst = $rate = $discount = $amount = $total = $cess = 0;
            if($id) {
                $sales = Sales::where('id', $id)->first();
                
                $calculate = $this->calculateTotal($sales->carmaster);
                if($calculate){
                    $rate = $calculate['rate'];
                    $discount = $calculate['discount'];
                    $amount = $calculate['taxableValue'];
                    $cgst = $calculate['cgst'];
                    $sgst = $calculate['sgst'];
                    $cess = $calculate['cess'];
                    $total = $calculate['total'];
                }

                $rateDetails = ['Rate' => number_format($rate) ,
                                'Amount' => number_format($amount,2), 
                                'Discount' => number_format($discount,2), 
                                'Total' => number_format($total,2), 
                                'CGST' => number_format($cgst,2), 
                                'SGST' => number_format($sgst,2), 
                                'IGST' => number_format($sgst,2), 
                                'CESS' => number_format($cess,2)];

                return view('send-of-approval-form')->with(['title' => 'Send of Approval', 'data' => $sales, 'rateDetails'=> $rateDetails]);
            }else{
                return redirect()->route('view-sales')->with('error', 'Record not found.');
            }
        }catch(Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('view-sales')->with('error', 'Record not found.');
        }
    }

    public function submitSendOfApproval(SubmitSendOfApprovalRequest $request, $id = null){
        try {
                $validatedData = $request->validated();
                $validatedData['status'] = '5';
                $updatedData=Sales::where('id', $id)->update($validatedData);
                LogService::insertlog($id,'Update','Submit of Approval '.$id,'sales');
                return redirect()->route('view-sales')->with('message', 'Send of Approval submitted successfully!');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-sales')->with('error', 'Record not found.');
        }
    }

    public function statusForm(Request $request, string $id = null){
        try {
            try{
                $cgst = $sgst = $igst = $rate = $discount = $amount = $total = $cess = 0;
                    if($id) {
                        $sales = Sales::where('id', $id)->first();
                        $calculate = $this->calculateTotal($sales->carmaster);
                        if($calculate){
                            $rate = $calculate['rate'];
                            $discount = $calculate['discount'];
                            $amount = $calculate['taxableValue'];
                            $cgst = $calculate['cgst'];
                            $sgst = $calculate['sgst'];
                            $cess = $calculate['cess'];
                            $total = $calculate['total'];
                        }

                        $rateDetails = ['Rate' => number_format($rate) ,
                                        'Amount' => number_format($amount,2), 
                                        'Discount' => number_format($discount,2), 
                                        'Total' => number_format($total,2), 
                                        'CGST' => number_format($cgst,2), 
                                        'SGST' => number_format($sgst,2), 
                                        'IGST' => number_format($sgst,2), 
                                        'CESS' => number_format($cess,2)];
        
                        return view('status-form')->with(['title' => 'Invoice Status', 'data' => $sales, 'rateDetails'=> $rateDetails]);
                    }else{
                        return redirect()->route('view-sales')->with('error', 'Record not found.');
                    }
                }catch(Exception $e){
                    return redirect()->route('view-sales')->with('error', 'Record not found.');
                }
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-sales')->with('error', 'Record not found.');
        }
    }

    public function submitSatusForm(SubmitSendOfStatusRequest $request, $id = null){
        try {
            $action = $request->input('action');
            $validatedData = $request->validated();

            if ($action === 'approve') {
                $sale = Sales::where('id', $id)->first();
                Sales::where('id', $id)->update(['Note'=>$validatedData['Note'],'status'=>'1']);
                CarMasterStatusService::insertStatus($sale->ChasisNo,'SALES APPROVED');
                LogService::insertlog($id,'Update','Approve Sales '.$id,'sales');
                return redirect()->route('view-sales')->with(['message' => 'Approved successfully']);
            } elseif ($action === 'reject') {
                Sales::where('id', $id)->update(['Note'=>$validatedData['Note'],'status'=>'2']);
                LogService::insertlog($id,'Update','Reject Sales '.$id,'sales');
                return redirect()->route('view-sales')->with(['message' => 'Rejected successfully']);
            }
                return redirect()->route('view-sales')->with('message', 'Submit Error!');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-sales')->with('error', 'Record not found.');
        }
    }

    public function deleteSalesForm($id = null){
        try {
            $sales = Sales::findOrFail($id);
            $delete = $sales->update(['Status' => '4']);
            if ($delete) {
                LogService::insertlog($id,'Delete','Delete Sales '.$id,'sales');
                return 'success';
            } else {
                return 'failed';
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-sales')->with('error', 'Record not found.');
        }
    }

    public function salesCertificate($id = null){
        // Sample data (replace with your database query)
        $query = Sales::query();
        $query->with(['carMaster','transferStock']);
        $query->where('id', $id);
        $invoice = $query->first();

        // Load the Blade view and pass data
        $pdf = Pdf::loadView('pdf.sales-certificate', ['invoice' => $invoice]);

        // Optional: Set PDF options
        $pdf->setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        // Download the PDF
        return $pdf->stream('invoice_' . 1 . '.pdf');
    }

    public function taxInvoice($id = null){
        // Sample data (replace with your database query)
        $cgst = $sgst = $igst = $rate = $discount = $amount = $total = $cess = 0;
        $query = Sales::query();
        $query->with(['carMaster','transferStock']);
        $query->where('id', $id);
        $invoice = $query->first();

        $rate = $invoice->carMaster->Rate ? $invoice->carMaster->Rate : 0;
        $discountvalue = $invoice->discount ? $invoice->discount : 0;
        if($rate != 0){
            $discount = $rate * $discountvalue/100;
            $amount = $rate - $discount;

            if($invoice->TypeofGST == '1'){
                $cgst = $rate * 14/100;
                $sgst = $rate * 14/100;
                $total = $rate + $cgst + $sgst;
            }else{
                $igst = $rate * 28/100;
                $total = $rate + $igst;
            }

            $cess = $rate * 1/100;
            $total = $total + $cess;
        }
        $rateDetails = ['Amount' => number_format($amount,2), 'Discount' => number_format($discount,2), 'Total' => number_format($total,2), 'CGST' => number_format($cgst,2), 'SGST' => number_format($sgst,2), 'IGST' => number_format($igst,2), 'CESS' => number_format($cess,2)];

        // Load the Blade view and pass data
        $pdf = Pdf::loadView('pdf.tax-invoice', ['invoice' => $invoice,'rateDetails' => $rateDetails]);

        // Optional: Set PDF options
        $pdf->setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        // Download the PDF
        return $pdf->stream('invoice_' . $id . '_'.date('Y-m-d').'.pdf');
    }

    public static function calculateTotal($carmaster){
        $total = 0;
        $cgst = $sgst = $igst = $cess = 0;
        if(!$carmaster->Model || !$carmaster->TypeOfFuel){
            return null;
        }
       
        $taxes = Taxes::where(DB::raw('LOWER(car_model)'), 'LIKE', '%' . strtolower($carmaster->Model) . '%')
                ->where(DB::raw('LOWER(type_of_fuel)'), 'LIKE', '%' . strtolower($carmaster->TypeOfFuel) . '%')
                ->first();

        if(!$taxes){
            return null;
        }

        $rate = $carmaster->Amount * 100 / $taxes->rate;
        $discount = $carmaster->Discount  * 100 / $taxes->rate;
        $taxableValue = $rate - $discount;
        $cgst = $taxableValue * $taxes->cgst;
        $sgst = $taxableValue * $taxes->sgst;
        $cess = $taxableValue * $taxes->cess;
        $total = $taxableValue + $cgst + $sgst + $cess;
        return ['rate' => $rate, 'discount' => $discount, 'taxableValue' => $taxableValue, 'cgst' => $cgst,'sgst' => $sgst, 'cess' => $cess, 'total' => $total];
        
    }

}
