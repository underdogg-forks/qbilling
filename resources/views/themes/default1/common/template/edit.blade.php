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
        {!! Form::model($template,['url'=>'templates/'.$template->id,'method'=>'patch']) !!}
        <h4>{{Lang::get('message.template')}}  {!! Form::submit(Lang::get('message.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

    </div>

    <div class="box-body">

      <div class="row">

        <div class="col-md-12">


          <div class="row">

            <div class="col-md-4 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
              <!-- first name -->
              {!! Form::label('name',Lang::get('message.name'),['class'=>'required']) !!}
              {!! Form::text('name',null,['class' => 'form-control']) !!}

            </div>

            <div class="col-md-4 form-group {{ $errors->has('type') ? 'has-error' : '' }}">
              <!-- last name -->
              {!! Form::label('type',Lang::get('message.template-types'),['class'=>'required']) !!}
              {!! Form::select('type',[''=>'Select','Type'=>$type],null,['class' => 'form-control']) !!}

            </div>
            <div class="col-md-4 form-group {{ $errors->has('url') ? 'has-error' : '' }}">
              <!-- first name -->
              {!! Form::label('url',Lang::get('message.url')) !!}
              {!! Form::text('url',null,['class' => 'form-control']) !!}

            </div>

          </div>

          <div class="row">
            <div class="col-md-12 form-group">

              <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
              <script>
                tinymce.init({
                  selector: 'textarea',
                  height: 500,
                  theme: 'modern',
                  relative_urls: true,
                  remove_script_host: false,
                  convert_urls: false,
                  plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                  ],
                  toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                  toolbar2: 'print preview media | forecolor backcolor emoticons',
                  image_advtab: true,
                  templates: [
                    {title: 'Test template 1', content: 'Test 1'},
                    {title: 'Test template 2', content: 'Test 2'}
                  ],
                  content_css: [
                    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
                    '//www.tinymce.com/css/codepen.min.css'
                  ]
                });
              </script>

              {!! Form::label('data',Lang::get('message.content'),['class'=>'required']) !!}
              {!! Form::textarea('data',null,['class'=>'form-control','id'=>'textarea']) !!}

            </div>


          </div>

        </div>

      </div>

    </div>

  </div>


  {!! Form::close() !!}
@stop