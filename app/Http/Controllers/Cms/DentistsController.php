<?php

namespace App\Http\Controllers\Cms;

use Exception;
use App\Models\Dentist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DentistRequest;

use Facades\App\Helpers\ListingHelper;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DentistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $searchFields = ['first_name', 'last_name'];
    
    public function index()
    {
        $dentists = ListingHelper::simple_search(Dentist::class, $this->searchFields);
        $filter = ListingHelper::get_filter($this->searchFields);

        $searchType = 'simple_search';

        return view('admin.dentist.index', compact(
            'dentists', 
            'filter',
            'searchType'

        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $dentistSpecialties = [
            "AESTHETIC DENTISTRY",
            "BIOMIMETIC DENTISTRY",
            "CRANIODONTICS",
            "DENTAL IMPLANTS",
            "DENTIST ANESTHESIOLOGISTS",
            "ENDODONTICS",
            "GENERAL DENTISTRY",
            "ORAL AND MAXILLOFACIAL PATHOLOGIST",
            "ORAL AND MAXILLOFACIAL RADIOLOGIST",
            "ORAL AND MAXILLOFACIAL SURGEON",
            "ORAL MAXILLOFACIAL SURGERY",
            "ORAL MEDICINE",
            "ORAL SURGERY",
            "OROFACIAL PAIN (OFP)",
            "ORTHODONTICS",
            "PEDIATRIC DENTISTRY",
            "PEDODONTIST",
            "PERIODONTICS",
            "PERIODONTIST",
            "PROSTHODONTIST",
            "TMJ DISORDER SPECIALIST"
        ];
        return view('admin.dentist.create', compact('dentistSpecialties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DentistRequest $request)
    {
        $request['specialization'] = implode("/", $request['specialization']);

        $dentist =  Dentist::create($request->all());
        return redirect()->route('dentists.index')->with('success', 'New dentist added.');
        
        //dd($request->all());
        // $dentist =  Dentist::create($request->all());
        // return redirect()->route('dentists.index')->with('success', 'New dentist added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dentist  $dentist
     * @return \Illuminate\Http\Response
     */
    public function show(Dentist $dentist)
    {
        return view('admin.dentist.view', compact('dentist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dentist  $dentist
     * @return \Illuminate\Http\Response
     */
    public function edit(Dentist $dentist)
    {
        $dentistSpecialties = [
            "AESTHETIC DENTISTRY",
            "BIOMIMETIC DENTISTRY",
            "CRANIODONTICS",
            "DENTAL IMPLANTS",
            "DENTIST ANESTHESIOLOGISTS",
            "ENDODONTICS",
            "GENERAL DENTISTRY",
            "ORAL AND MAXILLOFACIAL PATHOLOGIST",
            "ORAL AND MAXILLOFACIAL RADIOLOGIST",
            "ORAL AND MAXILLOFACIAL SURGEON",
            "ORAL MAXILLOFACIAL SURGERY",
            "ORAL MEDICINE",
            "ORAL SURGERY",
            "OROFACIAL PAIN (OFP)",
            "ORTHODONTICS",
            "PEDIATRIC DENTISTRY",
            "PEDODONTIST",
            "PERIODONTICS",
            "PERIODONTIST",
            "PROSTHODONTIST",
            "TMJ DISORDER SPECIALIST"
        ];
        return view('admin.dentist.edit', compact('dentist', 'dentistSpecialties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dentist  $dentist
     * @return \Illuminate\Http\Response
     */
    public function update(DentistRequest $request, Dentist $dentist)
    {
        //dd($dentist);
        $request['specialization'] = implode("/", $request['specialization']);
        
        $dentist->update($request->all());
        return redirect()->route('dentists.index')->with('success', 'Dentist details updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dentist  $dentist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dentist $dentist)
    {
        $dentist->delete();
        return redirect()->route('dentists.index')->with('success', 'Dentist deleted successfully.');
    }

    public function delete(Request $request){

        $pages = explode("|", $request->pages);

        foreach ($pages as $pageId) {
            $dentist = Dentist::find($pageId);

            if ($dentist) {
                $dentist->delete();
            }
        }
        return back()->with('success', "Dentists deleted.");

    }

    public function import_dentists(Request $request){
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();

            if ($extension === 'xlsx' || $extension === 'xls') {
                try {
                    $spreadsheet = IOFactory::load($file);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $rows = $worksheet->toArray();
                    $headers = ["FIRSTNAME", "LASTNAME", "REGION", "PROVINCE", "CITY", "FULL ADDRESS", "SPECIALIZATION", "CONTACT NUMBER", "CLINIC NAME"];
                    $fileHeaders = array_map('strtoupper', array_map('trim', $rows[0]));

                    if ($fileHeaders !== array_map('strtoupper', $headers)) {
                        return back()->with('error', "Headers not valid!");
                    }

                    for ($i = 1; $i < count($rows); $i++) {
                        $dentist = Dentist::where('first_name', $rows[$i][0])->where('last_name', $rows[$i][1])->first();
                    
                        if ($dentist) {
                            $dentist->update([
                                'region' => $rows[$i][2],
                                'province' => $rows[$i][3],
                                'city' => $rows[$i][4],
                                'full_address' => $rows[$i][5],
                                'specialization' => $rows[$i][6],
                                'contact_number' => $rows[$i][7],
                                'clinic_name' => $rows[$i][8],
                            ]);
                        } else {
                            Dentist::create([
                                'first_name' => $rows[$i][0],
                                'last_name' => $rows[$i][1],
                                'region' => $rows[$i][2],
                                'province' => $rows[$i][3],
                                'city' => $rows[$i][4],
                                'full_address' => $rows[$i][5],
                                'specialization' => $rows[$i][6],
                                'contact_number' => $rows[$i][7],
                                'clinic_name' => $rows[$i][8],
                            ]);
                        }
                    }

                    Storage::disk('public')->putFileAs("excel_files", $file, "Dentist-Upload-Template.xlsx");

                    return back()->with('success', "Import success!");
                } catch (Exception $e) {
                    return back()->with('error', "Error reading the Excel file: " . $e->getMessage());
                }
            } else {
                return back()->with('error', "Invalid file format. Only .xls and .xlsx files are allowed.");
            }
        }
    
        return back()->with('error', "No file uploaded.");
    }

    public function searchDentist(Request $dentist) {

        $query = Dentist::query();

        foreach ($dentist->all() as $key => $value) {
            if (!empty($value)) {
                $query->where($key, 'like' , '%' . $value . '%');
            }
        }

        $dentist_tb = $query->get();
       
        if(!empty($dentist_tb)) {
            return response()->json([
                'message'=>'data has been found',
                'data'=> $dentist_tb
            ], 200);
        }else {
            return response()->json([
                'message'=>'Not Found',
            ], 404);
        }
    }

}
