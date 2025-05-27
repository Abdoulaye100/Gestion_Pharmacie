@extends('layouts.admin')

@section('title', 'Medicaments')

@section('content')
    <section style="width: 100%; display: flex; flex-direction: column">
        <h1 style="text-align: center; margin-bottom: 40px">Liste des medicaments</h1>
        <div style="display: flex; justify-content: space-around; width: 100%;">
           <div style="display: flex">
                <form action="">
                    <input type="text">
                </form>
                <button>Rechercher</button>
           </div>
           <div>
               <button>Ajouter un médicament</button>
           </div>
        </div>
        <div style="width: 100%" class="tableMedicament">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Categorie</th>
                        <th>Prix</th>
                        <th>date d'expiration</th>
                        <th>date d'entrée</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nom</td>
                        <td>Categorie</td>
                        <td>Prix</td>
                        <td>date d'expiration</td>
                        <td>date d'entrée</td>
                        <td>
                            <button>Modifier</button>
                            <button>Suprimer</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Nom</td>
                        <td>Categorie</td>
                        <td>Prix</td>
                        <td>date d'expiration</td>
                        <td>date d'entrée</td>
                        <td>
                            <button>Modifier</button>
                            <button>Suprimer</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Nom</td>
                        <td>Categorie</td>
                        <td>Prix</td>
                        <td>date d'expiration</td>
                        <td>date d'entrée</td>
                        <td>
                            <button>Modifier</button>
                            <button>Suprimer</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
@endsection 