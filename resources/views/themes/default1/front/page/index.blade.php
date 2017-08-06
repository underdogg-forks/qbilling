@extends('themes.default1.layouts.master')
@section('content')
  <div class="box box-primary">

    <div class="box-header">
      @if (count($errors) > 0)
        <div class="alert alert-danger">
          <strong>Whoops!</strong> There were some problems with your input.<br><br>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {{Session::get('success')}}
        </div>
        @endif
          <!-- fail message -->
        @if(Session::has('fails'))
          <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{{Lang::get('message.alert')}}!</b> {{Lang::get('message.failed')}}.
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
          </div>
        @endif
        <div id="response"></div>

        <h4>{{Lang::get('message.pages')}}
          <a href="{{url('pages/create')}}" class="btn btn-primary pull-right   ">{{Lang::get('message.create')}}</a>
        </h4>
    </div>


    <div class="box-body">
      <div class="row">

        <div class="col-md-12">
          {!! Datatable::table()
          ->addColumn('<input type="checkbox" class="checkbox-toggle">','Name','Url','Created At','Content','Action')
          ->setUrl('get-pages')
          ->setOptions([

          "dom" => "Bfrtip",
          "buttons" => [
          [
          "text" => "Delete",
          "action" => "function ( e, dt, node, config ) {
          e.preventDefault();
          var answer = confirm ('Are you sure you want to delete from the database?');
          if(answer){
          $.ajax({
          url: 'pages-delete',
          type: 'GET',
          data: $('#check:checked').serialize(),

          beforeSend: function () {
          $('#gif').show();
          },
          success: function (data) {
          $('#gif').hide();
          $('#response').html(data);
          location.reload();
          }

          });
          }
          }"
          ]
          ],

          ])
          ->render() !!}

        </div>
      </div>

    </div>

  </div>



@stop

@section('icheck')
  <script>
    $(function () {


      //Enable check and uncheck all functionality
      $(".checkbox-toggle").click(function () {
        var clicks = $(this).data('clicks');
        if (clicks) {
          //Uncheck all checkboxes
          $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
          $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
        } else {
          //Check all checkboxes
          $(".mailbox-messages input[type='checkbox']").iCheck("check");
          $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
        }
        $(this).data("clicks", !clicks);
      });


    });
  </script>
@stop