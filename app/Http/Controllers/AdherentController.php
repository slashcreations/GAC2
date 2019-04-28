<?php

namespace App\Http\Controllers;

use App\Adherent;
use App\Autorisation;
use App\Autorisations;
use App\Creneau;
use App\Dossier;
use App\Groupe;
use App\Http\Requests\AdherentCreateRequest;
use App\Http\Requests\AdherentUpdateGroupeRequest;
use App\Http\Requests\GroupeUpdateRequest;
use App\Payement;
use App\Remarque;
use App\Section;
use App\Section_adherent;
use App\Telephone;
use Dotenv\Validator;
use Illuminate\Http\Request;

class AdherentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adherents=Adherent::All()->paginate(10);

        $sections=Section_adherent::All();

//        $a=$adherents[0];
//        echo $a->id;
//        $t=$a->telephones;
//        foreach ($t as $tel)
//        {
//            echo($tel->telephone_adherent);
//        }
//        dd($t);

//        $adherents=$adherents->groupBy('section');
        return view('adherent.index',compact('adherents','sections'));

    }

    public function indexRepartition()
    {
        $adherents=Adherent::All();
        $telephones=Telephone::All();
        $sections=Section_adherent::All();
        $groupe=Groupe::all ();

//        $adherents=$adherents->groupBy('section');
        return view('adherent.indexRepartition',compact('adherents','telephones','sections'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections=Section::All();
        return view('adherent.inscription',compact ('sections'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdherentCreateRequest $request)
    {

        $request['nom']=strtoupper ($request['nom']);
        $request['prenom']=ucfirst($request['prenom']);
        $request['ville']=strtoupper($request['ville']);
        $request['adresse']=$request['adresse1']."".$request['adresse2'];
        $request['dateNaissance']=date_create ();
        date_date_set ($request['dateNaissance'],$request['date_naissance_A'],$request['date_naissance_M'],$request['date_naissance_J']);
        Adherent::create ($request->all());
        $adherent = Adherent::orderBy('id','desc')->first();

        $inputTeleUrgen['adherent_id']=$adherent->id;
        $inputTeleUrgen['numero']=$request['telUrgence'];
        $inputTeleUrgen['typeTel_id']='4';
        Telephone::create ($inputTeleUrgen);
        if (isset($request['telephone_adherent'])&&$request['telephone_adherent']!==null)
        {  $inputTeleAdherent['adherent_id']=$adherent->id;
        $inputTeleAdherent['numero']=$request['telephone_adherent'];
        $inputTeleAdherent['typeTel_id']='1';
        Telephone::create ($inputTeleAdherent);}
        if (isset($request['telephone_Resp1'])&&$request['telephone_Resp1']!==null)
        {  $inputTeleResp1['adherent_id']=$adherent->id;
            $inputTeleResp1['numero']=$request['telephone_Resp1'];
            $inputTeleResp1['typeTel_id']='2';
            Telephone::create ($inputTeleResp1);}
        if (isset($request['telephone_Resp2'])&&$request['telephone_Resp2']!==null)
        {  $inputTeleResp2['adherent_id']=$adherent->id;
            $inputTeleResp2['numero']=$request['telephone_Resp2'];
            $inputTeleResp2['typeTel_id']='3';
            Telephone::create ($inputTeleResp2);}

        if (isset($request['entrainement'])&&$request['entrainement']!==null)
        {  $inputEntrainement['adherent_id']=$adherent->id;
            $inputEntrainement['remarque']=$request['entrainement'];
            $inputEntrainement['typeRq_id']='1';
            Remarque::create ($inputEntrainement);}

        if (isset($request['medicales'])&&$request['medicales']!==null)
        {  $inputMedicales['adherent_id']=$adherent->id;
            $inputMedicales['remarque']=$request['medicales'];
            $inputMedicales['typeRq_id']='2';
            Remarque::create ($inputMedicales);}

        $inputAutoMedi['ok']=$request['urgence'];
        $inputAutoMedi['adherent_id']=$adherent->id;
        $inputAutoMedi['typeAuto_id']='1';
        Autorisation::create($inputAutoMedi);

        $inputAutoDepla['ok']=$request['deplacements'];
        $inputAutoDepla['adherent_id']=$adherent->id;
        $inputAutoDepla['typeAuto_id']='2';
        Autorisation::create($inputAutoDepla);

        $inputAutoMedia['ok']=$request['media'];
        $inputAutoMedia['adherent_id']=$adherent->id;
        $inputAutoMedia['typeAuto_id']='3';
        Autorisation::create($inputAutoMedia);

        $inputAutoSortie['ok']=$request['sortie'];
        $inputAutoSortie['adherent_id']=$adherent->id;
        $inputAutoSortie['typeAuto_id']='4';
        Autorisation::create($inputAutoSortie);

//        Dossier::create('inputDossier');
        return redirect ('adherent.confirm');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $adherent=Adherent::find($id);
       $telephone=Telephone::All()->where('adherent_id',$id);
       $remarque=Remarque::All()->where('adherent_id',$id);
       $autorisation=Autorisations::All()->where('adherent_id',$id);
       $payement=Payement::all ()->where('adherent_id',$id);
       //manque groupe et section
        return view('adherent.edit',compact('adherent','telephone','remarque','autorisation','payement'));
    }

    public function updateGroupe(AdherentUpdateGroupeRequest $request,$id)
    {
        Adherent::update ($id,$request->all ());
        return redirect ('groupe')->withOk ("Le gymnaste a bien été ajouté");

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}