<!DOCTYPE html>
<html lang="en">

<head>
  <title>invoice</title>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">


</head>
<body>
<div class="container">
  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <?php $set = App\Model\Common\Setting::where("id", "1")->first(); ?>

      <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> {{ucfirst($set->company)}}
            <small class="pull-right">Date: {{$invoice->created_at}}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong>{{$set->company}}</strong><br>
            {{$set->address}}<br>
            Phone: {{$set->phone}}<br/>
            Email: {{$set->email}}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong>{{$user->first_name}} {{$user->last_name}}</strong><br>
            {{$user->address}}<br/>
            {{$user->town}}<br/>
            @if(key_exists('name',App\Http\Controllers\Front\CartController::getStateByCode($user->state)))
              {{App\Http\Controllers\Front\CartController::getStateByCode($user->state)['name']}}
            @endif
            {{$user->zip}}<br/>
            Country : {{App\Http\Controllers\Front\CartController::getCountryByCode($user->country)}}<br/>

            Mobile: @if($user->mobile_code)<b>+</b>{{$user->mobile_code}}@endif{{$user->mobile}}<br/>
            Email : {{$user->email}}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Invoice #{{$invoice->number}}</b><br>
          <br>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th></th>
              <th>Product</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Taxes</th>
              <th>Tax Rates</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>

            @foreach($invoiceItems as $item)
              <tr>

                <td>{{$item->product_name}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->regular_price}}</td>
                <td>
                  <?php $taxes = explode(',', $item->tax_name); ?>
                  <ul class="list-unstyled">
                    @forelse($taxes as $tax)
                      <li>{{$tax}}</li>
                    @empty
                      <li>No Tax</li>
                      @endif
                  </ul>
                </td>
                <td>
                  <?php $taxes = explode(',', $item->tax_percentage); ?>
                  <ul class="list-unstyled">
                    @forelse($taxes as $tax)
                      <li>{{$tax}}</li>
                    @empty
                      <li>No Tax Rates</li>
                      @endif
                  </ul>
                </td>
                <td>{{$item->subtotal}}</td>
              </tr>
            @endforeach


            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="col-xs-6 pull-right">
        <p class="lead">Amount</p>

        <div class="table-responsive">
          <table class="table">
            <?php
            $tax_name = [];
            $tax_percentage = [];
            foreach ($invoiceItems as $key => $item) {
              if (str_finish(',', $item->tax_name)) {
                $name = substr_replace($item->tax_name, '', -1);
              }
              if (str_finish(',', $item->tax_percentage)) {
                $rate = substr_replace($item->tax_percentage, '', -1);
              }
              $tax_name = explode(',', $name);
              $tax_percentage = explode(',', $rate);
            }
            ?>
            @for($i=0;$i < count($tax_name);$i++)

              @if($tax_name[$i]!='null')
                <tr>
                  <th>
                    <strong>{{ucfirst($tax_name[$i])}}<span>@</span>{{$tax_percentage[$i]}}%</strong>
                  </th>
                  <td>
                    <small>{!! $invoice->currency !!}</small>
                    &nbsp;{{App\Http\Controllers\Front\CartController::taxValue($tax_percentage[$i],$invoice->grand_total)}}
                  </td>

                </tr>
              @endif
            @endfor
            <tr>
              <th style="width:50%">Total:</th>
              <td>
                <small>{!! $invoice->currency !!}</small>
                &nbsp;{{$invoice->grand_total}}</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- this row will not appear when printing -->

    </section>
    <!-- /.content -->

  </div>
</div>
<!-- /.content-wrapper -->


<!-- ./wrapper -->


</body>
</html>
