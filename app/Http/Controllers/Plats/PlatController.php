<?php

namespace App\Http\Controllers\Plats;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plat;
use App\Http\Requests\PlatRequest;
use Illuminate\Support\Facades\File;
use App\Models\PlatImage;

class PlatController extends Controller
{

public function liste(Request $request)
{
    try {
        $query = Plat::query();
        $parPage = 1;
        $page = $request->input('page', 1);
        $search = $request->input('search');

        if($search)
        {
            $query->whereRaw("name LIKE.'%".$search."%'");
        }
        $total = $query->count();
        $resultat = $query->offset(($page -1)* $parPage)
        ->limit($parPage)->get();

        return response()->json([
            'success'=> 1,
            'Message'=>'Bravo Enregistrement s\'est bien passé',
            'current_page'=>$page,
            'last_page'=>ceil($total / $parPage),
            'items'=>$resultat
        ]);
    } catch (Exception $e) {
        throw new Exception(Response()->json([
            'code_status'=> 0,
            'success'=> 0,
            'message'=>'Erreur. Aucune donnee trouvee',

        ]));
    }
}
public function store(PlatRequest $request)
{
    try {

        $plat = new Plat();

        $plat->name = $request->name;
        $plat->category_id = $request->category_id;
        $plat->price = $request->price;

        if($request->hasFile('image')){

            $file= $request->file('image');

            $image= $request->image;

            $filename = time().'.'.$file->getClientOriginalExtension();

            $uploadFile = public_path('uploads/plats/');

            // dd($image->move($uploadFile, $filename));

            $finalImagePathName = $uploadFile.$filename;

            $plat->image = $finalImagePathName;


        }
        $plat->description = $request->description;
        $plat->status = $request->status;

       // dd($plat);
        $plat->save();

        return Response()->json([
            'success'=> 1,
            'Message'=>'Bravo Enregistrement du plat s\'est bien passé',
            'Resultat'=>$plat,
        ]);
    } catch (Exception $e) {
        throw new Exception(Response()->json([
            'success'=> 0,
            'message'=>'Erreur d\'enregistrement',
        ]));

    }
}
    public function update($id, Request $request)
    {
        try {
            // dd($request);
            $plat = Plat::find($id);;

            $plat->name = $request->name;
            $plat->category_id = $request->category_id;
            $plat->price = $request->price;

            if($request->hasFile('image')){

                $file= $request->file('image');

                $image= $request->image;

                $filename = time().'.'.$file->getClientOriginalExtension();

                $uploadFile = public_path('uploads/plats/');

                // dd($image->move($uploadFile, $filename));

                $finalImagePathName = $uploadFile.$filename;

                $plat->image = $finalImagePathName;


            }
            $plat->description = $request->description;
            $plat->status = $request->status;

           // dd($plat);
            $plat->update();

            return Response()->json([
                'success'=> 1,
                'Message'=>'Bravo la modification du plat s\'est bien passé',
                'Resultat'=>$plat,
            ]);
        } catch (Exception $e) {
            throw new Exception(Response()->json([
                'success'=> 0,
                'message'=>'Erreur de modification',
            ]));

        }
    }
    public function delete(Plat $plat)
    {
        try {

            $plat->delete();

            return response()->json([
                'success'=>1,
                'message'=>'Le plat a été supprimé avec success',
            ]);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la Suppression");

        }
    }
}
