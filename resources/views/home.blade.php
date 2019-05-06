@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h2>{{ money($total, true, '€ ') }}</h2>
                        Totaal budget beschikbaar
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h2>{{ money($discharge, true, '€ ') }}</h2>
                        Totaal afschrijving
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h2>{{ $lines }}</h2>
                        Aantal lijnen
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            @foreach($grouped as $group)
                <div class="col-12 col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h2>{{ money($group->total, true, '€ ') }}</h2>
                            {{ $group->type }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Overzicht</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="/" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="description">Type</label>
                                <select class="form-control" name="type">
                                    <option>4300 Verbruiksmateriaal</option>
                                    <option>4301 Leermiddelen</option>
                                    <option>4311 Aanschaf kleine middelen</option>
                                    <option>4495 Overige algemene kosten</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Beschrijving</label>
                                <textarea class="form-control" name="description" id="description">{{ old('description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="total">Totaal</label>
                                <input type="number" step="any" value="{{ old('total') }}" name="total" class="form-control" id="total">
                            </div>
                            <button type="submit" class="btn btn-primary">Opslaan</button>
                        </form>

                        <hr/>

                        <div class="table-responsive">
                            <table class="table table-borderless table-hover">
                                <thead>
                                <tr>
                                    <th>Gebruiker</th>
                                    <th>Beschrijving</th>
                                    <th>Type</th>
                                    <th>Totaal</th>
                                    <th>Datum</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($paginatedLines as $paginatedLine)
                                    <tr>
                                        <td>{{ $paginatedLine->user->name }}</td>
                                        <td>{{ $paginatedLine->description }}</td>
                                        <td>{{ $paginatedLine->type }}</td>
                                        <td>{{ money($paginatedLine->total, true, '€ ') }}</td>
                                        <td>{{ $paginatedLine->created_at }}</td>
                                        <td>
                                            <form method="POST"
                                                  action="{{ url('/line/' . $paginatedLine->id .'/destroy') }}">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">

                                                <button class="btn btn-danger btn-sm">
                                                    Verwijder
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row justify-content-center">
                            {!! $paginatedLines->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
