@extends('layout.main')

@section('title')
  <title>Game Lobby</title>
@endsection

@section('content')

  <div
      {{--        style="background-color: lightcoral;"--}}
      class="col-12">

    <div class="row">
      <div class="col-5">
        <h2>Game Lobby</h2>
      </div>
      <div class="col-7">
        <button class="btn btn-success" id="add-game-button">
          Create a Game
        </button>
        <p id="create-game-error" class="text-danger"></p>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <table class="table table-sm">
          <thead>

          <tr>
            <th scope="col">ID</th>
            <th scope="col">Status</th>
            <th scope="col">Turn</th>
            <th scope="col">Armies</th>
            <th></th>
          </tr>
          </thead>
          <tbody id="army-table">

          @foreach($games as $game)
            <tr>
              <th>{{ $game->id }}</th>
              <td>{{ $game->game_status->title }}</td>
              <td>{{ $game->turn }}</td>
              <td>{{ $game->armies()->count() }}</td>
              <td>

                <a href="{{ route('army.create', $game->id) }}">
                  <button class="btn btn-outline-danger btn-sm"
                          id="go-to-battle-button">
                    Go to battle
                  </button>
                </a>

              </td>

            <tr>
          @endforeach

          </tbody>
        </table>
      </div>
    </div>

  </div>
@endsection


@section('script')

  <script>

    $(document).on('click', '#add-game-button', function(e){
      e.preventDefault();

      let url = "{{route('create.game')}}";

      $.ajax({
        url: url,
        method: 'GET',
        data: {

        },
        dataType: 'JSON',
        cache: false
        // processData: false,
        // contentType: false,
      }).done(function(data) {

        console.log(data);
        console.log(data.data.error);

        // Handling  errors:
        if (data.data.error) {
          $('#create-game-error').text(data.data.error);
        } else {
          // No errors
          location.reload();
          $('#create-game-error').empty();
        }

      });
    });

    {{--$(document).on('click', '#go-to-battle-button', function(e){--}}
    {{--  e.preventDefault();--}}

    {{--  window.location.replace("{{route('army.create', $game->id)}}");--}}

    {{--});--}}

  </script>

@endsection


