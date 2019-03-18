 <body>
            <div class="column">
            <a target="_blank" href="http://www.facebook.com/sharer.php?u=http%3A%2F%2Fvoyager.dev" title="Facebook Share"><img src="images/facebook.png" class="center"></a>
            </div>

        <div class="container">
        <header>
          <!--   <a href="/"><img src="images/logo.png"></a> -->

        </header>
       <section>
      <div class="container">
   <h1> Subject </h1>

   {{ csrf_field() }}
 {!! Form::open(['action' => 'SubjectController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>

        <div class="form-group">
            {{Form::label('code', 'Code')}}
            {{Form::textarea('code', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Code'])}}
        </div>
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
</div>

        <div class="form-group">
            {{Form::label('body', 'Body')}}
            {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
        </div>
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
</div>
            </section>
             
                @endif
                @endAuth
                @include('footer')
        
    </body>
</html>