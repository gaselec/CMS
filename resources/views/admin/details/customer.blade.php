@extends('admin.layouts.app')

@section('pageTitle', 'Customer Details: '.$customer->firstName .' '. $customer->surname)

@section('breadcrumb')
    <li><a href="{{ route('dashboard.home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#"><i class="fa fa-user"></i> Customer: {!! $customer->firstName !!} {!! $customer->surname !!}</a></li>
@endsection

@section('content')

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            <b>SUCCESS:</b> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            <b>ERROR:</b> {{ session('error') }}
        </div>
    @endif

    <p>Here are the details of {!! $customer->firstName !!} {!! $customer->surname !!}.</p>

    <div class="row">
        <div class="col-xs-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Details</h3>
                </div>
                <div class="panel-body">
                    <strong>First Name:</strong> {!! $customer->firstName!!}<br />
                    <strong>Surname:</strong> {!! $customer->surname !!}<br />
                    <strong>Telephone:</strong> {!! $customer->telephone !!}<br />
                    <strong>Email:</strong> {!! $customer->email !!}<br />
                    <strong>Member Since:</strong> {!! $customer->created_at !!}
                </div>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Orders</h3>
                </div>
                <div class="panel-body">
                    <strong>Number of Orders:</strong> {!! count($customer->orders) !!}<br />
                    <strong>Number of Open Carts:</strong> {!! count($customer->carts) !!}<br />
                    <strong>Total Earnings:</strong>
                    <?php
                        $total = null;
                        foreach($customer->orders as $order){
                            $total = $total + $order->products->sum(function($item) { return $item->price * $item->quantity; }) / 100;
                        }
                    ?>

                    &pound;{!! $total !!}
                </div>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Leads</h3>
                </div>
                <div class="panel-body">
                    <strong>Number of Leads:</strong> {!! count($customer->leads) !!}<br />
                    <strong>Number of ECIS Jobs:</strong> {!! count($customer->leads->where('ecisJobNumber', '<>', '')) !!}<br />
                    <strong>Money from Leads:</strong> {!! $customer->leads->sum(function($item) { return $item->jobPrice; })!!}<br />
                </div>
            </div>
        </div>
    </div>


    <h2>Leads</h2>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>ID</th>
                            <th>Enquired</th>
                            <th>Contact Numbers</th>
                            <th>Address</th>
                            <th>Service Required</th>
                            <th>Area</th>
                            <th>Page</th>
                            <th>Affiliate</th>
                            <th>Campaign</th>
                            <th>Forward</th>
                            <th>Action</th>
                        </tr>
                        @foreach($customer->leads as $lead)
                            <tr>
                                <td>#{!! $lead->id !!}</td>
                                <td>{!! $lead->created_at !!}</td>
                                <td>@if($lead->mobile != "")Mobile "{!! $lead->mobile !!}" <br /> @endif
                                    @if($lead->landline != "")Landline "{!! $lead->landline !!}"@endif </td>
                                <td>{!! $lead->addressLine1 !!}<br /> {!! $lead->postcode !!}</td>
                                <td>{!! $lead->serviceRequired !!}</td>
                                <td>{!! $lead->area !!}</td>
                                <td>{!! $lead->pageId !!}</td>
                                <td>{!! $lead->affiliateId !!}</td>
                                <td>{!! $lead->campaignId !!}</td>
                                <td>{!! $lead->forwardedId !!}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                    <a href="#" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>


    @if(count($customer->orders) > 0)
        <h2>Orders</h2>
        @foreach($customer->orders as $order)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">#{{ $order->id }}</h3>
                </div>
                <div class="panel-body">

                    <div class="row" >
                        <div class="col-xs-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Delivery Address</h3>
                                </div>
                                <div class="panel-body">
                                    {!! $order->delivery->firstName !!} {!! $order->delivery->surname !!}<br />
                                    {!! $order->delivery->addressLine1 !!}<br />
                                    {!! $order->delivery->addressLine2 !!}<br />
                                    {!! $order->delivery->town !!}<br />
                                    {!! $order->delivery->county !!}<br />
                                    {!! $order->delivery->postcode !!}
                                </div>
                            </div>

                        </div>
                        <div class="col-xs-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Invoice Details</h3>
                                </div>
                                <div class="panel-body">
                                    Invoice: {!! $order->invoice->location !!}<br />
                                    Created: {!! $order->created_at !!}<br />
                                    Paid: {{ $order->invoice->created_at }}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Totals</h3>
                                </div>
                                <div class="panel-body">
                                    Product Total: &pound;{{ $order->products->sum(function($item) { return $item->price * $item->quantity; }) / 100 }}<br />
                                    Delivery Total: &pound;{{ $order->products->sum(function($item) { return $item->delivery * $item->quantity; }) / 100 }}<br />
                                    VAT: &pound;{{
                    ($order->products->sum(function($item) { return $item->price * $item->quantity; }) / 100 * 0.2) }}<br />
                                    Total: &pound;{{
                    ($order->products->sum(function($item) { return $item->price * $item->quantity; }) / 100  * 1.2) +
                    ($order->products->sum(function($item) { return $item->delivery * $item->quantity; }) / 100) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Delivery</th>
                                            <th>Total</th>
                                        </tr>
                                        @foreach($order->products as $product)
                                            <tr>
                                                <td>
                                                    {!! $product->product->name !!}
                                                </td>
                                                <td>
                                                    &pound;{!! $product->price / 100 !!}
                                                </td>
                                                <td>
                                                    {!! $product->quantity !!}
                                                </td>
                                                <td>
                                                    &pound;{!! $product->delivery / 100 !!}
                                                </td>
                                                <td>
                                                    &pound;{!! ($product->price / 100 * $product->quantity) + ($product->delivery / 100 * $product->quantity) !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif


    @if(count($customer->carts) > 0)
        <h2>Shopping Baskets</h2>
        @foreach($customer->carts as $cart)

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">#{{ $cart->id }}</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Cart Info</h3>
                                </div>
                                <div class="panel-body">
                                    <ul>
                                        <li>Created: {!! $cart->created_at !!}</li>
                                        <li>Product Total: </li>
                                        <li>Delivery Total: </li>
                                        <li>VAT: </li>
                                        <li>Total:</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Cart</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover">
                                            <tr>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Delivery</th>
                                            </tr>
                                            @foreach($cart->products as $product)
                                                <tr>
                                                    <td>{!! $product->product->name !!}</td>
                                                    <td>&pound;{!! $product->price / 100 !!}</td>
                                                    <td>&pound;{!! $product->delivery / 100 !!}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif


    <h2>Tracking</h2>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>ID</th>
                            <th>Page ID</th>
                            <th>Forward ID</th>
                            <th>Referer</th>
                            <th>Timestamp</th>
                        </tr>
                        @foreach($customer->trackings as $tracking)
                            <tr>
                                <td>{{ $tracking->id }}</td>
                                <td>{{ $tracking->pageIdToName($tracking->pageId, $tracking->type_id) }}</td>
                                <td>{{ $tracking->forwardId }}</td>
                                <td>{{ substr($tracking->referer, 0 , 10) }}</td>
                                <td>{{ $tracking->created_at }}</td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    @if(count($tracking->trackingClicks) > 0)

                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box">
                                                    <div class="box-body table-responsive no-padding">
                                                        <table class="table table-hover" style="background-color: #ccc;">
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Action</th>
                                                                <th>Type</th>
                                                                <th>Name</th>
                                                                <th>When</th>
                                                            </tr>
                                                            @foreach($tracking->trackingClicks as $trackingClick)
                                                                <tr>
                                                                    <td>{{ $trackingClick->id }}</td>
                                                                    <td>{{ $trackingClick->action }}</td>
                                                                    <td>{{ $trackingClick->type }}</td>
                                                                    <td>{{ $trackingClick->name }}</td>
                                                                    <td>{{ $trackingClick->created_at }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
