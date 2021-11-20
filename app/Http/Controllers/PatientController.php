<?php

namespace App\Http\Controllers;

// mengimport model Patients
// digunakan untuk berinteraksi dengan database
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    # membuat method index
    function index()
    {
        # menggunakan model Patient untuk select data
        $patients = Patient::all();

        $total = count($patients);

        if ($total > 0){
            $data = [
                'message' => 'Get All Resource',
                'total' => $total,
                'data' => $patients,
            ];
            
            # mengembalikan data json, pesan dan kode 200
            return response()->json($data, 200);
        }
        else {
            $data = [
                'message' => "Data is empty"
            ];

            # mengembalikan pesan dan kode 404
            return response()->json($data, 404);
        }
    }

    # membuat method store
    function store(Request $request)
    {
        # memvalidasi data yang akan dimasukkan ke database
        $validateData = $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'status' => [
                'required', # membuat class Rule untuk membatasi inputan status
                Rule::in(['positif', 'Positif', 'negatif', 'Negatif','recovered', 'Recovered', 'dead', 'Dead'])
            ],
            'in_date_at' => 'required',
            'out_date_at' => 'nullable|date'            
        ]);

        # menggunakan model patient untuk memasukkan data
        $patients = Patient::create($validateData);

        $data = [
            'message' => 'Resource is added successfully',
            'data' => $patients,
        ];

        # mengembalikan data json, pesan dan kode 201
        return response()->json($data, 201);
    }
    
    # membuat method show
    function show($id)
    {
        # mencari id yang ingin di tampilkan 
        $patient = Patient::find($id);

        if ($patient) {
            $data = [
                'message' => "Get Detail Resource",
                'data' => $patient
            ];

            # mengembalikan nilai json, pesan dan kode 200
            return response()->json($data, 200);
        }
        else {
            $data = [
                'message' => "Resource not found"
            ];

            # mengembalikan pesan dan kode 404
            return response()->json($data, 404);
        }
    }

    # membuat method update
    function update(Request $request, $id)
    {
        # mencari id pasien yang ingin di update
        $patient = Patient::find($id);

        if ($patient) {
            $patient->update([
                'name' => $request->name ?? $patient->name,
                'phone' => $request->phone ?? $patient->phone,
                'address' => $request->address ?? $patient->address,
                'status' => $request->status ?? $patient->status,
                'in_date_at' => $request->in_date_at ?? $patient->in_date_at,
                'out_date_at' => $request->out_date_at ?? $patient->out_date_at
            ]);
            $data = [
                'message' => 'Resource is update successfully',
                'data' => $patient
            ];

            # mengembalikan data json, pesan dan kode 200
            return response()->json($data, 200);
        }
        else {
            $data = [
                'message' => 'Resource not found'
            ];

            # mengembalikan pesan dan kode 404
            return response()->json($data, 404);
        }

    }

    # membuat method destroy
    function destroy($id)
    {
        # mencari id pasien yang ingin di hapus
        $patient = Patient::find($id);

        if ($patient) {
            $patient->delete();

            $data = [
                'message' => 'Resource is delete successfully'
            ];

            # mengembalikan data json, pesan dan kode 200
            return response()->json($data, 200);
        }
        else {
            $data = [
                'message' => 'Resource not found'
            ];
            
            # mengembalikan peasn daan kode 404
            return response()->json($data, 404);
        }
    }

    # membuat method search 
    function search($name)
    {
        # mencari data patient berdasarkan nama
        $patients = Patient::where('name', $name)->get();

        if (count($patients) > 0) {
            $data = [
                'message' => "Get searched resource",
                'data' => $patients
            ];

            # mengembalikan data json, pesan dan kode 200
            return response()->json($data, 200);
        } 
        else {
            $data = [
                'message' => "Resource not found"
            ];

            # mengembalikan pesan dan kode 404
            return response()->json($data, 404);
        }
    }

    # membuat method searchByStatus
    public function searchByStatus($status)
    {           
        # mencari pasien berdasarkan status      
        $patients = Patient::where('status', $status) 
                ->orderBy('name', 'asc')                  
                ->get();
        
        # menghitung jumlah pasien  
        $total = count($patients);

        if ($total > 0 ){
            $data = [
                'message' => 'Get'. $status. 'Resource',
                'total' => $total,
                'data' => $patients ,
            ];

            # mengembalikan data json, pesan dan kode 200
            return response()->json($data, 200);        
        }       
        else{
            $data = [
                'message' => 'Resource not found',                
            ];

            # mengembalikan pesan kode 404
            return response()->json($data, 404);        
        }
    }

}
