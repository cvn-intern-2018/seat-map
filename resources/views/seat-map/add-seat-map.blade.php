@extends("frame")

@section("title")
Add seat map
@endsection
@section("scripts")
@endsection
@section("main")
<h1>Add new seat map</h1>
<form action="" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="seatmap_name">Seat map name:</label><input type="text" name="seatmap_name" id="seatmap_name" required>
    </div>
    <div class="form-group">
        <label for="seatmap_img">Seat map:</label><input type="file" name="seatmap_img" id="seatmap_img" accept="image/jpeg, image/png" required>
    </div>
    <input type="submit" value="Upload">
</form>
@endsection
