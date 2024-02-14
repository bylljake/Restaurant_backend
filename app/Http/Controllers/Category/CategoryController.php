<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Models\Plat;


class CategoryController extends Controller
{
    public function liste(Request $request)
    {
        try {
            $query = Category::query();
            $parPage = 1;
            $page = $request->input('page', 1);
            $search = $request->input('search');

            if($search)
            {
                $query->whereRaw("nom_category LIKE.'%".$search."%'");
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
    public function store(CategoryRequest $request)
    {
       try {

            $categorie = new Category();

            $categorie->nom_category = $request->nom_categorie;

            $categorie->save();

            return response()->json([

                'success'=> 201,
                'Message'=>'Bravo Enregistrement de la categorie s\'est bien passée',
                'Resultat'=>$categorie,

            ]);
       } catch (Exception $e) {

         throw new Exception(Response()->json([
            'success'=> 0,
            'message'=>'Erreur d\'enregistrement',

        ]));

       }
    }
    public function update($id, CategoryRequest $request)
    {
       try {
        $categorie = Category::find($id);
        // dd($categorie);
        $categorie->nom_category = $request->nom_categorie;

        $categorie->update();

        return response()->json([
            'success'=> 201,
            'Message'=>'Enregistrement est mis à jour',
            'data'=>$categorie
        ]);

       } catch (Exception $e) {
        throw new Exception(response()->json([
            'success'=> 0,
            'message'=> 'Impossible d\'effectuer les mises à jour'
        ]));

       }

    }
    public function delete($id)
    {
        try {

            $categorie = Category::find($id);

            $plat = Plat::where('category_id', $id)->first();

                if($plat->category_id ?? '' == $categorie->id)
                {

                    return response()->json([
                        'success'=>1,
                        'message'=>'Vous ne pouvez pas supprimé cette category car
                        elle est liée à un plat',
                    ]);

                }
               elseif ($id == $categorie->id)
                {
                    $categorie->delete();
                    return response()->json([
                        'success'=>1,
                        'message'=>'Bravo!, la categorie a été supprimé',
                    ]);
                }
                else{

                    return response()->json([
                        'success'=>1,
                        'message'=>'Bravo!, la categorie n\'existe pas',
                    ]);
                }
            }

        catch (Exception $e)
        {
            throw new Execption (response()->json([
                'success'=>0,
                'message'=>'Je suis dans l\'exception'
            ]));
        }
    }
}
