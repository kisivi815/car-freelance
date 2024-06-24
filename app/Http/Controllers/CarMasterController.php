<?php

namespace App\Http\Controllers;

use App\Events\ImportCompleted;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CarMasterImport;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Exception;

class CarMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title']= 'Car Master Upload';
        return view('car-master-upload')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            $request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);

            $today = Carbon::today()->format('dmY');
            $message = '';
            $missingDetails = [];
           
            if ($request->file('file')) {
                Excel::import(new CarMasterImport($missingDetails), $request->file('file'));
                $extension = $request->file('file')->getClientOriginalExtension();
                // Get all files from a specific directory (or root directory)
                $allFiles = Storage::disk('s3')->allFiles('car-inventory');
    
                // Filter files that include the keyword
                $filteredFiles = array_filter($allFiles, function($filename) use ($today) {
                    return stripos($filename, $today) !== false;
                });
                
                $version = count($filteredFiles) + 1;
                //$result = Storage::disk('s3')->put("car-inventory/" . $today . "_car_inventory_v" . $version . ".".$extension, file_get_contents($request->file('file')));

                foreach ($missingDetails as $missingDetail) {
                    $message .= $missingDetail . '<br>';
                }

                $message .= 'not found in product details.';
            }
            return back()->with('message', 'Data imported successfully. <br>'.$message);

        }catch(Exception $e){
            return back()->with('error', 'Error occurred while importing data. Please try again later.');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
