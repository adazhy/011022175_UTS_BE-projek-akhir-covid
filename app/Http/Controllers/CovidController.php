<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class CovidController extends Controller
{
    //method index - get all resource
    public function index()
    {
        //menggunakan model Patient untuk select data
        $patient = Patient::all();

        if($patient){
            $data = [
                'message' => 'Get all patient',
                'data' => $patient
            ];

            return response()->json($data, 200);
        }
            else{
                $data = [
                    'message' => 'Data patient is empty'
                ];
    
                return response()->json($data, 200);
            }
        }

        //method show - mendapatkan detail patient
        public function show($id){
            $patient = Patient::find($id);

            if($patient){
                $data = [
                    'message' => 'Get detail patient id' . $id,
                    'data' => $patient
                ];

                //mengembalikan data (json) status code 200
                return response()->json($data, 200);
            }

                else{
                    $data = [
                        'message' => 'Data patient id' . 'not found'
                    ];

                    return response()->json($data, 404);
                }
        }

        // method store - menambahkan resource
        public function store(Request $request)
        {
            $validateData = $request->validate([
            'name' => 'required',
            'phone' => 'numeric|required',
            'address' => 'required',
            'status' => 'required',
            'in_date_at' => 'required|date',
            'out_date_at' => 'required|date|after:in_date_at'
            ]);

            //menggunakan variable patient untuk insert data
            $patient = Patient::create($validateData);

            $data = [
                'message' => 'patient is created succesfully',
                'data' => $patient
            ];

            return response()->json($data, 201);
        }

        //method update - mengupdate resource
        public function update(Request $request, $id){
            $patient = Patient::find($id);

            if($patient){
                $input = [
                    'name' => $request->name ?? $patient->name,
                    'phone' => $request->phone ?? $patient->phone,
                    'address' => $request->address ?? $patient->address,
                    'status' => $request->status ?? $patient->status,
                    'in_date_at' => $request->in_date_at ?? $patient->in_date_at,
                    'out_date_at' => $request->out_date_at ?? $patient->out_date_at    
                ];

            $patient->update($input);

            $data = [
                'message' => 'Patient id' . $id . 'is updated',
                'data' => $patient
            ];

            return response()->json($data, 404);
            }
        }

        //method destory - menghapus resource (id)
        public function destroy($id)
        {
            $patient = Patient::find($id);

            if($patient){
                $patient->delete();
    
                $data = [
                    'message' => 'Petient with id ' . $id . 'is removed'
                ];
    
                return response()->json($data, 200);
            } else{
                $data = [
                    'message' => 'Data patient id' . $id . 'not found'
                ];
    
                return response()->json($data, 404);
            }
        }

        //method positive - mencari data patient yang statusnya positive
        public function search($name)
        {
            $patient = Patient::where('name', $name)->get();
            $countPatient = count($patient);

            if($countPatient > 0){
                $data = [
                    'message' => 'Get petient resource by name' . $name,
                    'total' => $countPatient,
                    'data' => $patient
                ];

                return response()->json($data, 200);
            }
            else{
                $data = [
                    'message' => 'Data patient' . $name . 'not found'
                ];

                return response()->json($data, 404);
            }
        }

        //method positive - mencari data patient yang statusnya positive
        public function positive()
        {
            $patient = Patient::where('status', 'positive')->orderBy('name')->get();

            $data = [
                'message' => 'Get resource positive patient',
                'total' => $patient->count(),
                'data' => $patient
            ];

            return response()->json($data, 200);
        }

        //method recovered - mencari data patient yang statusnya recovered
        public function recovered()
        {
            $patient = Patient::where('status', 'recovered')->orderBy('name')->get();

            $data = [
                'message' => 'Get resource recovered patient',
                'total' => $patient->count(),
                'data' => $patient
            ];

            return response()->json($data, 200);
        }

        //method dead - mencari data patient yang statusnya dead
        public function dead()
        {
            $patient = Patient::where('status', 'dead')->orderBy('name')->get();

            $data = [
                'message' => 'Get resource dead patient',
                'total' => $patient->count(),
                'data' => $patient
            ];

            return response()->json($data, 200);
        }
}

