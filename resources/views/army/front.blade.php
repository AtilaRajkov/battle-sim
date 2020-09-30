<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
{{--  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">--}}
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <title>Army Front</title>
</head>
<body>


<div class="container">
  <div class="row">
    <div
{{--        style="background-color: lightskyblue;" --}}
        class="col-6">
      <h2>Create an Army</h2>

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
          <small>(Your army can have 80 to 100 units)</small>
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

        <input type="hidden" id="game-id" value="{{$game_id}}">

        <button type="submit"
                class="btn btn-primary" id="add-army-button">
          Add Army
        </button>
      </form>

    </div>

    <div style="background-color: lightcoral;" class="col-6">

      <h2>Battle (army list)</h2>

    </div>
  </div>
</div>

{{--<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>


$(document).on('click', '#add-army-button', function(e){
  e.preventDefault();

  let url = "{{route('add.army')}}";

  let game_id = $("#game-id").val();
  let name = $("#name").val();
  let units = $("#units").val();
  let attack_strategy_id = $("#attack-strategy-id").val();

  console.log('game_id: ' + game_id);
  console.log('name: ' + name);
  console.log('units: ' + units);
  console.log('strategy: ' + attack_strategy_id);

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
    console.log("OK");
    console.log(data);

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







    // if (data.errors.length === 0) {
    //   $('#name-error').empty();
    // }


  });
});




</script>

</body>
</html>