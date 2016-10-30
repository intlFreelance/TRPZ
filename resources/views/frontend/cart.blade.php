@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="col-md-12">
                <h1 class="blue-header">Your Cart</h1>
                @if(Cart::count() == 0)
                <p>Your cart is currently empty</p>
                <p>
                    <a href="{!!  url('/') !!}" class="btn btn-primary btn-lg">Return to shop <i class="fa fa-shopping-basket" aria-hidden="true"></i></a>
                </p>
                @else
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>Package</th>
                            <th class="text-right">Price</th>
                            <th class="text-right">Subtotal</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(Cart::content() as $row)
                            <tr>
                                <td>
                                    <p><strong>{!! $row->name !!}</strong></p>
                                    <p>Start Date: {!! ($row->options->has('startDate') ? $row->options->startDate : '') !!}</p>
                                    <p>End Date: {!! ($row->options->has('endDate') ? $row->options->endDate : '') !!}</p>
                                </td>
                                <td class="text-right">${!! $row->price(2) !!}</td>
                                <td class="text-right">${!! $row->total(2) !!}</td>
                                <td class="text-right">
                                    {!! Form::open(['route' => ['cart.destroy', $row->rowId], 'method' => 'delete']) !!}
                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td class="text-right">Subtotal</td>
                            <td class="text-right">{!! Cart::subtotal(2) !!}</td>
                        </tr>
                        <!--tr>
                            <td colspan="2">&nbsp;</td>
                            <td>Tax</td>
                            <td>{!! Cart::tax() !!}</td>
                        </tr-->
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td class="text-right">Total</td>
                            <td class="text-right">{!! Cart::total(2) !!}</td>
                        </tr>
                    </tfoot>
                </table>
                <p class="pull-right">
                    <a href="{!!  url('/') !!}" class="btn btn-primary">Return to shop <i class="fa fa-shopping-basket" aria-hidden="true"></i></a>
                    <a href="{!!  url('/payment') !!}" class="btn btn-warning">Checkout <i class="fa fa-sign-out" aria-hidden="true"></i></a>
                </p>
            @endif
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    @include('frontend.additional')    
</div>
@endsection