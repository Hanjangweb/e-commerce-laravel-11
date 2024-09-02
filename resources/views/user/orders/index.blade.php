@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-5"></div>
    <section class="my-account container">
      <h2 class="page-title">Orders</h2>
      <div class="row">
       @include('user.account-nav')
        <div class="col-sm-10">
            <div class="row">
                <div class="col-lg-12">
                    <div class="wg-table table-all-user">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th class="text-center"">OrderNo</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Phone</th>
                                        <th class="text-center">Subtotal</th>
                                        <th class="text-center">Tax</th>
                                        <th class="text-center">Total</th>

                                        <th class="text-center">Status</th>
                                        <th class="text-center">Order Date</th>
                                        <th class="text-center">Items</th>
                                        <th class="text-center">Delivered On</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order )
                                    <tr>
                                        <td class="text-center">{{ $order->id }}</td>
                                        <td class="text-center">{{$order->name}}</td>
                                        <td class="text-center">{{$order->phone}}</td>
                                        <td class="text-center">{{$order->subtotal}}</td>
                                        <td class="text-center">{{$order->tax}}</td>
                                        <td class="text-center">{{$order->total}}</td>

                                        <td class="text-center">
                                            @if ($order->status == 'ordered')
                                                <span class="badge bg-success" style="color: green">Ordered</span>
                                            @elseif($order->status == 'canceled')
                                                <span class="badge bg-danger">Canceled</span>
                                            
                                            @endif
                                            
                                        </td>
                                        <td class="text-center">{{$order->created_at}}</td>
                                        <td class="text-center"></td>
                                        <td class="text-center">{{$order->delivered_date}}</td>
                                        <td class="text-center">
                                            <a href="{{route('order.order-details',['order_id'=>$order->id])}}">
                                                <div class="list-icon-function view-icon">
                                                    <div class="item eye">
                                                        <i class="fa fa-eye"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        {{$orders->links('pagination::bootstrap-5')}}
                    </div>
                </div>

            </div>
        </div>
      </div>
    </section>
</main>
@endsection
