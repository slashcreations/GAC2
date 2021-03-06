@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <span class="card-header display-6">Fiche de : {{" "}}   {{$adherent->prenom}} {{$adherent->nom}}  </span>
                        <ul class="nav nav-tabs nav-justified fiche ">
                            <li class="active bandeRose"><a data-toggle="tab" href="#identite"><i class="fas fa-id-card rose"></i><br/>Identité</a></li>
                            <li class="bandeBleu"><a data-toggle="tab" href="#entrainement"><i class="fas fa-dumbbell Bleu"></i><br/>Entrainement</a></li>
                            <li class="bandeRouge"><a data-toggle="tab" href="#urgence"><i class="fas fa-briefcase-medical Rouge"></i><br/> En cas d'urgence</a></li>
                            <li class="bandeHotpink"><a data-toggle="tab" href="#inscription"><i class="fas fa-copy Hotpink"></i><br/> Dossier d'inscription</a></li>
                            <li class="bandeCyan"><a data-toggle="tab" href="#payement"><i class="fas fa-money-bill-wave Cyan"></i><br/> Payement</a></li>
                            <li class="bandeJaune"><a data-toggle="tab" href="#autres"><i class="fas fa-highlighter Jaune"></i><br/> Autres remarques</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">
                            <div id="identite" class="tab-pane fade-in active"> <div id="appIdentite">
                                <form action='{{route('adherent.update',$adherent->id)}}' method="post">
                                    {!!csrf_field ()  !!}
                                    {{method_field ("put")}}
                                    <div class="row ">
                                        <div class="col-10"> Adresse :
                                            <input type="text" class="form-invisible col-4" name="adresse" placeholder="{{$adherent->adresse}}">-
                                            <input type="text" class="form-invisible col-2" name="cp" placeholder="{{$adherent->cp}} ">
                                            <input type="text" class="form-invisible col-3" name="ville"  placeholder="{{$adherent->ville}} ">
                                        </div>
                                        <div class="col-2">
                                            <i class="fas fa-id-card onglet rose"></i>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <p>Date de naissance: {{strftime("%d/%m/%G", strtotime( $adherent->dateNaissance))}}</p>
                                        </div>
                                        <div class="col-4">
                                            à {{$adherent->lieuNaissance}}
                                        </div>
                                        <div class="col-3">
                                            {{$adherent->sexe}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php $resp2 = 0?>
                                        @foreach($adherent->telephones as $telephone )
                                            @if($telephone->typeTel_id==1)
                                                <div class="col-12">
                                                    Téléphone adhérent:
                                                    <input type="text" class="form-invisible" name="telephone_adherent" placeholder="{{$telephone->numero}}" value="{{old ("telephone_adherent","")}}"/>
                                                    @if ($errors->has('telephone_adherent'))
                                                        <small
                                                            class="help-block">{{$errors->first('telephone_adherent',':message') }}</small> @endif
                                                </div>
                                            @elseif($telephone->typeTel_id==2)
                                                <div class="col-6">
                                                    Téléphone responsable legal 1: <input type="text" class="form-invisible " name="telephone_Resp1" placeholder="{{$telephone->numero}}" value="{{old ("telephone_Resp1","")}}"/>
                                                    @if ($errors->has('telephone_Resp1'))
                                                        <small
                                                            class="help-block">{{$errors->first('telephone_Resp2',':message') }}</small> @endif
                                                </div>
                                            @elseif($telephone-> typeTel_id==3)
                                                <?php $resp2 = 1?>
                                                <div class="col-6">
                                                    Téléphone responsable legal 2: <input type="text" class="form-invisible" name="telephone_Resp2"  placeholder="{{$telephone->numero}}">
                                                </div>
                                            @endif
                                        @endforeach
                                          <div id="appIdentite">
                                        <div class="input_tel col-6">
                                            @if($resp2!=1)
                                            <button
                                              v-on:click="showTel"
                                            >Ajouter un numéro
                                              <i class="fas fa-plus-circle"></i>
                                            </button>
                                            <input v-if="displayTel"
                                              type="text"
                                              id="numero"
                                              v-model="numero"
                                              placeholder="numero"
                                            >
                                        @endif
                                    </div>
                                          </div>
                                    <div class="row">
                                        <div class=" col-6">
                                            Email: <input type="email" class="form-invisible" name="email1" placeholder="{{$adherent->email1}}">
                                        </div>
                                        @if(isset($adherent->email2)&&$adherent->email2!='null')
                                            <div class="col-6">
                                                et <input type="email" class="form-invisible" name="email1" placeholder="{{$adherent->email2}}">
                                            </div>
                                        @else
                                            <div class="col-6">
                                                <div class="input_mail">

                                                    <button class="ajouterMail btn-small btn btn-link">
                                                        Ajouter une adresse mail
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-12">
                                            <h5 class="violet">Les champs en italique peuvent être modifiés.</h5>
                                            <button type="submit" class="btn btn-primary btn pull-right">
                                                Enregistrer les modifications
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div id="entrainement" class="tab-pane fade">
                                <form action='{{route('adherent.update',$adherent->id)}}' method="post">
                                    {!!csrf_field ()  !!}
                                    {{method_field ("put")}}
                                    <div class="row">
                                        <div class="col-10">
                                            <h4 class="fonce">
                                                Section :
                                                <input type="text" class="form-invisible" name="groupe" placeholder="{{$adherent->section->nom}}">
                                            </h4>
                                            <h4 class="fonce">Groupe :
                                                @isset($adherent->groupe){{$adherent->groupe->nom}}  ou
                                                @endisset
                                                <select name="groupe" class="form-invisible"id="groupe" cols="10">
                                                    <option value="">Choisir dans la liste</option>
                                                    @foreach($groupes as $groupe)
                                                        <option value="{!!$groupe->id!!}"> {!! $groupe->nom!!}</option>
                                                    @endforeach
                                                </select>
                                            </h4>
                                        </div>
                                        <div class="col-2">
                                            <i class="fas fa-dumbbell  onglet Bleu"></i>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="heureSemaine"> Nombre d'heures par semaine : </label>
                                            <select name="heureSemaine" class="form-invisible" id="heureSemaine" cols="10">

                                                <option
                                                    value="">{{$adherent->heureSemaine}}</option>
                                                <option value="45min">45min</option>
                                                <option value="1h">1h</option>
                                                <option value="1h30">1h30</option>
                                                <option value="2h">2h</option>
                                                <option value="2h30">2h30</option>
                                                <option value="3h">3h</option>
                                                <option value="3h30">3h30</option>
                                                <option value="4h">4h</option>
                                                <option value="4h30">4h30</option>
                                                <option value="5h">5h</option>
                                                <option value="5h30">5h30</option>
                                                <option value="6h">6h</option>
                                                <option value="8h">8h</option>
                                            </select><br/>

                                            {{--                                        @if (count($adherent->creneaux))--}}

                                            {{--                                            @foreach($adherent->creneaux as $creneau)--}}
                                            {{--                                                le:  {{($creneau->jour)}} à {{($creneau->heure_debut)}}--}}
                                            {{--                                                h {{($creneau->min_debut)}}--}}
                                            {{--                                            @endforeach--}}
                                            {{--                                        @endif--}}
                                            Ajouter un créneau
                                            <select name="creneau" id="creneau" class="form-invisible" cols="10">
                                                <option value="">choisir dans la liste</option>
                                                @foreach($creneaux as $creneau)
                                                    <option value="{!!$creneau->id!!}"> le {!!$creneau->jour->jour!!}
                                                        à {{$creneau->heure_debut}}h{{$creneau->min_debut}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            Remarque
                                            @php($rq=0)
                                            @foreach($adherent->remarques as $remarque)
                                                @php($rq=1)
                                                @if (isset($remarque)&& $remarque->typeRq_id==1)
                                                    <textarea name="Rq_entrainement" id="Rq_entrainement" class="form-control form-invisible  col-10"  placeholder="{{$remarque->remarque}}">
                                                    </textarea>
                                                @endif
                                            @endforeach

                                            @if($rq==0)
                                                <textarea name="Rq_entrainement" id="Rq_entrainement"class="form-control form-invisible col-10"  placeholder="">
                                                    </textarea>
                                            @endif
                                        </div>
                                        <div class="col-12">
                                            <h5 class="violet"> Les champs en gris peuvent être modifiés.</h5>
                                            <button type="submit" class="btn btn-primary btn pull-right">
                                                Enregistrer les modifications
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="col-12">
                                    <h4 class="rose">Autorisations</h4>
                                    @foreach($adherent->autorisations as $autorisation)
                                        @if($autorisation->typeAuto_id==2)
                                            <div class="autorisation row">
                                                @if($autorisation->ok==1)
                                                    <div>
                                                        <i class="fas fa-car onglet VertY"></i>
                                                    </div>
                                                    <div>
                                                        Le(la) gymnaste peut etre transporté par un membre du club
                                                    </div>
                                                    <div>
                                                        {!! link_to_route('autorisation.update', 'Modifier',['id'=>$autorisation->id,'adherent_id'=>$adherent->id], ['class' => 'changerAutorisationTransport  btn-autorisation btn btn-link']) !!}
                                                    </div>
                                                @else
                                                    <div>
                                                        <i class="fas fa-car onglet RougeN line"></i>
                                                    </div>
                                                    <div>
                                                        Le(la) gymnaste ne peut pas etre transporté par un membre du club
                                                    </div>
                                                    <div>
                                                        {!! link_to_route('autorisation.update', 'Modifier',['id'=>$autorisation->id,'adherent_id'=>$adherent->id], ['class' => 'changerAutorisationTransport  btn-autorisation btn btn-link']) !!}
                                                    </div>
                                                @endif
                                            </div>
                                        @elseif($autorisation->typeAuto_id==3 )
                                            <div class="autorisation row">
                                                @if($autorisation->ok==1)
                                                    <div>
                                                        <i class="fas fa-camera onglet VertY"></i>
                                                    </div>
                                                    <div>
                                                        Le(la) gymnaste peut etre photographié pour les besoins du club
                                                    </div>
                                                    <div>
                                                        {!! link_to_route('autorisation.update', 'Modifier',['id'=>$autorisation->id,'adherent_id'=>$adherent->id], ['class' => 'changerAutorisationTransport  btn-autorisation btn btn-link']) !!}</div>
                                                @else
                                                    <div>
                                                        <i class="fas fa-camera onglet RougeN line"></i>
                                                    </div>
                                                    <div>
                                                        Le(la) ne peut gymnaste pas etre photographié.
                                                    </div>
                                                    <div>
                                                        {!! link_to_route('autorisation.update', 'Modifier',['id'=>$autorisation->id,'adherent_id'=>$adherent->id], ['class' => 'changerAutorisationTransport  btn-autorisation btn btn-link']) !!}
                                                    </div>
                                                @endif
                                            </div>
                                        @elseif($autorisation->typeAuto_id==4)
                                            <div class="row autorisation">
                                                @if( $autorisation->ok==1)
                                                    <div>
                                                        <i class="fas fa-user-clock onglet VertY"></i>
                                                    </div>
                                                    <div>
                                                        Le(la) gymnaste est autorisé à partir seul à la fin de l'entrainement
                                                    </div>
                                                    <div>
                                                        {!! link_to_route('autorisation.update', 'Modifier',['id'=>$autorisation->id,'adherent_id'=>$adherent->id], ['class' => 'changerAutorisationTransport  btn-autorisation btn btn-link']) !!}
                                                    </div>
                                            </div>
                                        @else
                                            <div>
                                                <i class="fas fa-user-clock onglet RougeN line"></i>
                                            </div>
                                            <div>
                                                Le(la) gymnaste n'est pas autorisé à partir seul à la fin de l'entrainement
                                            </div>
                                            <div>
                                                {!! link_to_route('autorisation.update', 'Modifier',['id'=>$autorisation->id,'adherent_id'=>$adherent->id], ['class' => 'changerAutorisationTransport  btn-autorisation btn btn-link']) !!}
                                            </div>
                                        @endif
                                </div>
                                @endif
                                @endforeach
                            </div>

                            <div id="urgence" class="tab-pane fade">
                                <form action='{{route('adherent.update',$adherent->id)}}' method="post">
                                    {!!csrf_field ()  !!}
                                    {{method_field ("put")}}
                                    <div class="col-8">
                                        <div class="row">
                                            <div class="col-10">
                                                <h4 class="rose">Personne à prevenir en cas d'urgence :
                                                    <input type="text" class="form-invisible" name="urgence" placeholder="{{$adherent->nomUrgence}}">
                                                </h4>
                                            </div>
                                            <div class="col-2">
                                                <i class="fas fa-briefcase-medical onglet Rouge"></i><br/><br/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach($adherent->telephones as $telephone )
                                            @if($telephone->typeTel_id==4)
                                                <div class="col-6">
                                                    <p class="large">
                                                        N° de téléphone:
                                                        <input type="text" class="form-invisible" name="telephone_Urgence" placeholder="{{$telephone->numero}}">
                                                    </p>
                                                </div>
                                            @endif
                                        @endforeach
                                        <div class="col-6">
                                            Remarque
                                            @php($rq=0)
                                            @foreach($adherent->remarques as $remarque)
                                                @php($rq=1)
                                                @if (isset($remarque)&& $remarque->typeRq_id==2)
                                                    <textarea name="Rq_urgence" id="Rq_urgence"
                                                              class="form-control form-invisible  col-10"
                                                              placeholder="{{$remarque->remarque}}">
                                                    </textarea>
                                                @endif
                                            @endforeach

                                            @if($rq==0)
                                                <textarea name="Rq_urgence" id="Rq_urgence"
                                                          class="form-control form-invisible col-10" placeholder="">
                                                    </textarea>
                                            @endif
                                            Les champs en gris peuvent être modifiés.
                                            <button type="submit" class="btn btn-primary btn pull-right">Enregistrer les modifications </button>
                                            <br/><br/>
                                        </div>
                                    </div>
                                </form>

                                <div class="autorisation row">
                                    @foreach($adherent->autorisations as $autorisation)
                                        @if($autorisation->typeAuto_id==1)
                                            @if($autorisation->ok==1)
                                                <div>
                                                    <i class="fas fa-first-aid onglet VertY"></i>
                                                </div>
                                                <div>
                                                    Les animateurs sont autorisés à mettre en œuvre en cas d'urgence, les traitements, hospitalisation et intervention reconnus médicalement nécessaires auprès du gymnaste.
                                                </div>
                                                <div>
                                                    {!! link_to_route('autorisation.update', 'Modifier',['id'=>$autorisation->id,'adherent_id'=>$adherent->id], ['class' => 'changerAutorisationTransport  btn-autorisation btn btn-link']) !!}
                                                </div>
                                            @else
                                                <div>
                                                    <i class="fas fa-first-aid onglet line RougeN"></i>
                                                </div>
                                                <div>
                                                    Les animateurs ne sont pas autorisés à mettre en œuvre en cas d'urgence.
                                                </div>
                                                <div>
                                                    {!! link_to_route('autorisation.update', 'Modifier',['id'=>$autorisation->id,'adherent_id'=>$adherent->id], ['class' => 'changerAutorisationTransport  btn-autorisation btn btn-link']) !!}
                                                </div>
                                            @endif
                                </div>
                                @endif
                                @endforeach
                            </div>

                            <div id="inscription" class="tab-pane fade">
                                <form action='{{route('adherent.updateDocument',$adherent->id)}}' method="get">
                                    {!!csrf_field ()  !!}
                                    {{method_field ("put")}}
                                    <div class="row">
                                        <div class="col-10">
                                            <h4 class="rose">Dossier d'inscription</h4>
                                            <div class="large">
                                                Certificat médical:
                                                @if($adherent->CertifMedical==1)
                                                    <i class="fas fa-check-circle Vert2"></i>
                                                @else
                                                    <input type="checkbox" name="CertifMedical[]"
                                                           value="{{$adherent->CertifMedical}}{{$adherent->id}}">
                                                @endif
                                                <br/>
                                                Photo:
                                                @if($adherent->photo==1)
                                                    <i class="fas fa-check-circle Vert2"></i>
                                                @else
                                                    <input type="checkbox" name="photo[]"
                                                           value="{{$adherent->photo}}{{$adherent->id}}">
                                                @endif
                                                <br/>
                                                Autorisations(Forme papier) :
                                                @if($adherent->autorisationsRendues==1)
                                                    <i class="fas fa-check-circle Vert2"></i>
                                                @else
                                                    <input type="checkbox" name="autorisationsRendues[]"
                                                           value="{{$adherent->autorisationsRendues}}{{$adherent->id}}">
                                                @endif
                                                <br/>
                                                Justificatif de payement demandé
                                                @if($adherent->RecuDemande==1)
                                                    <i class="fas fa-flag Jaune"></i>
                                                @else
                                                    <input type="checkbox" name="RecuDemande[]"
                                                           value="{{$adherent->RecuDemande}}{{$adherent->id}}">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            @if($adherent->autorisationsRendues==1&&$adherent->photo==1&&$adherent->CertifMedical==1)
                                                <i class="fas fa-smile Vert2  onglet"></i>
                                                <br/>
                                                <br/>
                                                <br/>

                                            @else
                                                <i class="fas fa-frown Rouge onglet"></i>
                                                <br/>
                                                <br/>
                                                <br/>

                                            @endif
                                            <button type="submit" class="btn btn-primary btn pull-right">Enregistrer
                                                les modifications
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div id="payement" class="tab-pane fade">
                                <form action='{{route('adherent.update',$adherent->id)}}' method="post">
                                    {!!csrf_field ()  !!}
                                    {{method_field ("put")}}
                                    <div class="row">
                                        <div class="col-10">
                                            <h4 class="rose">Detail des payements</h4>
                                        </div>
                                        <div class="col-2">
                                            <i class="fas fa-money-bill-wave onglet Cyan"></i
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        Remarque
                                        @php($rq=0)
                                        @foreach($adherent->remarques as $remarque)
                                            @php($rq=1)
                                            @if (isset($remarque)&& $remarque->typeRq_id==3)
                                                <textarea name="Rq_payement" id="Rq_payement"
                                                          class="form-control form-invisible  col-10"
                                                          placeholder="{{$remarque->remarque}}">
                                                    </textarea>
                                            @endif
                                        @endforeach
                                        @if($rq==0)
                                            <textarea name="Rq_payement" id="Rq_payement"
                                                      class="form-control form-invisible col-10" placeholder="">
                                                    </textarea>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <h5 class="violet"> Les champs en gris peuvent être modifiés.</h5>
                                        <button type="submit" class="btn btn-primary btn pull-right">
                                            Enregistrer les modifications
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div id="autres" class="tab-pane fade">
                                <form action='{{route('adherent.update',$adherent->id)}}' method="post">
                                    {!!csrf_field ()  !!}
                                    {{method_field ("put")}}
                                    <div class="col-10">
                                        <h4 class="rose">Autres remarques</h4>
                                    </div>
                                    <div class="col-10">
                                        Remarque
                                        @php($rq=0)
                                        @foreach($adherent->remarques as $remarque)
                                            @php($rq=1)
                                            @if (isset($remarque)&& $remarque->typeRq_id==4)
                                                <textarea  name= "Rq_autres" id="Rq_autres"
                                                           class="form-control form-invisible  col-10"
                                                           placeholder="{{$remarque->remarque}}">
                                                    </textarea>
                                            @endif
                                        @endforeach

                                        @if($rq==0)
                                            <textarea name="Rq_autres" id="Rq_autres"
                                                      class="form-control form-invisible col-10" placeholder="">
                                                    </textarea>
                                        @endif
                                    </div>
                                    <div class="col-2">
                                        <i class="fas fa-highlighter Jaune"></i>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn pull-right">
                                            Enregistrer les modifications
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
                <a href="javascript:history.back()" class="btn-back">
                    <span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
                </a>

        </div>
    </div>

@endsection
@section('script')
    <script>
        var appIdentite = new Vue({
          el: '#appIdentite',
          data: {
            displayTel:false,
            adherentdata:{!!$jsonAdherents!!},
            adresse:"",
            },
          methods: {
              showTel: function () {
                displayTel = true;
              },
              }
        })

</script>
@endsection
