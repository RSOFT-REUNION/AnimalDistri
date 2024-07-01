    <div class="row m-2">
        <div class="col">
            <div class="card border-left-dark shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">Adresse</h6>
                </div>

                <div class="card-body">

                    <div class="table-responsive mb-3">
                        <table id="datatable" class="table datatable table-hover table-bordered w-100">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center">Nom</th>
                                <th scope="col" class="text-center">Adresse</th>
                                <th scope="col" class="text-center">Suite</th>
                                <th scope="col" class="text-center">Autre</th>
                                <th scope="col" class="text-center">Code Postal</th>
                                <th scope="col" class="text-center">Ville</th>
                                <th scope="col" class="text-center">Téléphone</th>
                                <th scope="col" class="text-center">Autre Téléphone</th>
                            </tr>
                            </thead>

                            @foreach ($client->adresses as $address)
                                <tr>
                                    <td class="text-center">{{ $address->alias }}</td>
                                    <td class="text-center">{{ $address->address }}</td>
                                    <td class="text-center">{{ $address->address2 }}</td>
                                    <td class="text-center">{{ $address->other }}</td>
                                    <td class="text-center">{{ $address->cities }}</td>
                                    <td class="text-center">
                                        @foreach($cities as $city)
                                            @if($city->postal_code == $address->cities) {{ $city->city }} @endif
                                        @endforeach
                                    </td>
                                    <td class="text-center">{{ $address->phone }}</td>
                                    <td class="text-center">{{ $address->other_phone }}</td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
