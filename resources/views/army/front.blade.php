@extends('layout.main')

@section('title')
  <title>Battlefront</title>
@endsection

@section('content')


  <div class="col-4">
    <h3>Create an Army</h3>

    <form id="army-form" name="army-form">
      @csrf


      <div class="form-group">
        <label for="army-name">Army Name</label>
        <input type="text"
               class="form-control"
               id="name"
               value=""
               name="name">

        <p class="text-danger" id="name-error"></p>

      </div>

      <div class="form-group">
        <label for="units">Number of Units</label>
        <br>
        <small>(Your army can have from 80 to 100 units)</small>
        <input type="number"
               class="form-control"
               id="units"
               value=""
               name="units">

        <p class="text-danger" id="units-error"></p>

      </div>

      <div class="form-group">
        <label for="attack-strategy">Attack Strategy</label>
        <select class="form-control"
                id="attack-strategy-id"
                name="strategy">
          @foreach($strategies as $strategy)
            <option value="{{ $strategy->id }}">
              {{ $strategy->title }}
            </option>
          @endforeach
        </select>

      </div>
      <p class="text-danger" id="attack-strategy-id-error"></p>

      <input type="hidden" id="game-id" value="{{$game->id}}">

      <button type="submit"
              class="btn btn-primary" id="add-army-button">
        Add Army
      </button>
    </form>

  </div>

  <div class="col-8">

    <h3>Battle:</h3>
    <div class="row">
      <div class="col-6">
        <p>Game ID: <b>{{ $game_id }}</b> Turn: <b><span id="game-turn">{{ $game->turn }}</span></b></p>
      </div>

      <div class="col-3">
        <button class="btn btn-danger btn-sm" id="run-attack">
          Attack!
        </button>
      </div>

      <div class="col-3">
        <button class="btn btn-outline-danger btn-sm" id="autorun">
          Autorun...
        </button>
      </div>

    </div>

    <div class="row">
      <div class="col-12">

        <h5 id="armies-number-error" class="text-danger"></h5>
        <h5 id="battle-finished" class="text-success"></h5>

        <table class="table table-sm">
          <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Units Left</th>
            <th scope="col">Status</th>
          </tr>
          </thead>
          <tbody id="army-table">

            @forelse($armies as $army)
              <tr>
              <th>{{ $army->id }}</th>
              <td>{{ $army->name }}</td>
              <td>{{ $army->units_number }}</td>
              <td>{{ $army->army_state->title }}</td>
            </tr>
            @empty

            @endforelse

          </tbody>
        </table>
      </div>
    </div>



  </div>
@endsection


@section('script')

  <script>

    // Autorun Button
    $(document).on('click', '#autorun', function(e) {
      e.preventDefault();

      let url = "{{route('autorun', $game->id)}}";

      $.ajax({
        url: url,
        method: 'POST',
        data: {
        },
        dataType: 'JSON',
        cache: false
        // processData: false,
        // contentType: false,
      }).done(function(data) {



        // Handling form errors
        if (data.error) {
          $('#armies-number-error').text(data.error);
        } else {
          $('#armies-number-error').empty();
        }

        if (data.game) {

          $("#army-table").empty();
          $(function() {
            $.each(data.game.armies, function(i, item) {
              var $tr = $('<tr>').append(
                $('<th>').text(item.id),
                $('<td>').text(item.name),
                $('<td>').text(item.units_number),
                $('<td>').text(item.army_state.title)
              ).appendTo('#army-table');
            });
          });
        }

        if (data.turn) {
          $('#game-turn').empty().append(data.turn);
        }

        if (data.message) {
          $('#battle-finished').text(data.message);
        }


      });


    });



    // Run Attack Button:
    $(document).on('click', '#run-attack', function(e) {
      e.preventDefault();

      runAttack();

    });


    function runAttack() {

      let url = "{{route('run-attack', $game->id)}}";

      $.ajax({
        url: url,
        method: 'POST',
        data: {
        },
        dataType: 'JSON',
        cache: false,
        async: false,
        // processData: false,
        // contentType: false,
      }).done(function(data) {


        // Handling form errors
        if (data.error) {
          $('#armies-number-error').text(data.error);
        } else {
          $('#armies-number-error').empty();
        }

        if (data.game) {
          $("#army-table").empty();
          $(function() {
            $.each(data.game.armies, function(i, item) {
              var $tr = $('<tr>').append(
                $('<th>').text(item.id),
                $('<td>').text(item.name),
                $('<td>').text(item.units_number),
                $('<td>').text(item.army_state.title)
              ).appendTo('#army-table');
            });
          });
        }

        if (data.turn) {
          $('#game-turn').empty().append(data.turn);
        }

        if (data.message) {
          $('#battle-finished').text(data.message);
        } else {
          $('#battle-finished').empty();
        }


      });


    }




    // Add an Army button:
    $(document).on('click', '#add-army-button', function(e){
      e.preventDefault();
      let url = "{{route('add.army')}}";
      let game_id = $("#game-id").val();
      let name = $("#name").val();
      let units = $("#units").val();
      let attack_strategy_id = $("#attack-strategy-id").val();

      $.ajax({
        url: url,
        method: 'POST',
        data: {
          game_id: game_id,
          name: name,
          units: units,
          attack_strategy_id: attack_strategy_id
        },
        dataType: 'JSON',
        cache: false
        // processData: false,
        // contentType: false,
      }).done(function(data) {

        if (data.message) {
          $('#battle-finished').text(data.message);
        }

        // Handling form errors
        if (data.errors.name) {
          $('#name-error').text(data.errors.name);
        } else {
          $('#name-error').empty();
        }

        if (data.errors.units) {
          $('#units-error').text(data.errors.units);
          $('#units').val("")
        } else {
          $('#units-error').empty();
        }

        if (data.errors.attack_strategy_id) {
          $('#attack-strategy-id-error').text(data.errors.attack_strategy_id);
        } else {
          $('#attack').empty();
        }

        // Adding the newly create army to the list
        if (data.army) {

          $("#army-table").append(
            '<tr>\n' +
            '<th>' + data.army.id + '</th>\n' +
            '<td>' + data.army.name + '</td>\n' +
            '<td>' + data.army.units_number + '</td>\n' +
            '<td>' + 'fighting' + '</td>\n' +
            // '<td>' + data.army.army_state + '</td>\n' +
            '</tr>'
          );

        }

      });
    });

  </script>

@endsection


