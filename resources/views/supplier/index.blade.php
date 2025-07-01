@extends('layouts.app')

@section('content')
<div class="container">
    <h2 style="color:green;">Overzicht Suppliers</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Contactpersoon</th>
                <th>Email</th>
                <th>Mobiel</th>
                <th>Supplier Number</th>
                <th>Product Details</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suppliers as $supplier)
                @foreach($supplier->contacts as $contact)
                <tr>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->mobile }}</td>
                    <td>{{ $supplier->supplier_number }}</td>
                    <td>
                        <a href="{{ route('manager.suppliers.products', $supplier->id) }}">
                            <i class="bi bi-clipboard"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
                @if($supplier->contacts->isEmpty())
                <tr>
                    <td>{{ $supplier->name }}</td>
                    <td colspan="4">No contact</td>
                    <td>
                        <a href="{{ route('manager.suppliers.products', $supplier->id) }}">
                            <i class="bi bi-clipboard"></i>
                        </a>
                    </td>
                </tr>
                @endif
            @empty
                <tr>
                    <td colspan="6">No suppliers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('manager.dashboard') }}" class="btn btn-primary">Home</a>
</div>
@endsection
