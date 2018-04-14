@extends('layouts.app2')

@section('adventure')
active
@endsection

@section('css')
<style type="text/css">
	.image-home {
        max-height: 110px;
        border-top-right-radius: 15px;
        border-top-left-radius: 15px;
        object-fit: cover;
    }

    .image-profile {
        max-width: 80px; 
        margin-top: 70px;
        margin-left: 150%;
        border: 2px solid;
        border-color: #FFFFFF;
        object-fit: cover;
    }

    /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 250px;
      }
      /* Optional: Makes the sample page fill the window. */
      /*html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }*/
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      /*#pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }*/

      /*#pac-input:focus {
        border-color: #4d90fe;
      }*/

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
</style>
@endsection

@section('section')
<form method="get" action="">
	@csrf
	<div class="container" style="margin-top: 80px;">
		<div class="card" style="background-color: #fff">
			<div class="card-header" style="background-color: #fff">
				<div class="row">
					<div class="col-sm-7">
						Draft
						<h4>Create An Adventure</h4>
					</div>	
					<div class="col-sm-5">
						<div class="pull-right">
							<button class="btn btn-outline-success" type="button">Draft</button>
							<button class="btn btn-success" type="submit">Post</button>	
						</div>
					</div>	
				</div>
			</div>

			<div class="card-body">
				<div class="row">
					<div class="col-md-4">
						<div class="card card-rounded">
			                <img style="position: relative;" class="image-home" src="{{asset('img/nearby-1.jpg')}}"> 
			                <div style="position: absolute;">
			                    <img class="rounded-circle image-profile" src="{{asset('img/profile.jpg')}}">
			                </div>
			                <div class="card-body">
			                    <div class="green-text">
			                        <br>
			                        <h5><b>{{Auth::user()->first_name.' '.Auth::user()->last_name}}</b></h5>
			                        <small>"Living Like Larry"</small>
			                    </div>
			                </div>
			            </div>

			            <div>
			            	<div class="card" style="margin-top: 24px; ">
			            		<div class="card-header" style="font-weight: bold;">
			            			Daftar Destinasi Yang Dipilih
			            		</div>
			            		<div class="list-group" id="destination-list">

			            		</div>
			            	</div>
			            	{{-- <ul class="list-group">
							  <li class="list-group-item d-flex justify-content-between align-items-center">
							    asdadas asdasdas dasd asdasd asdasdas d asdasd asdasdasd asdas
							    <span class="fa fa-times" style="cursor: pointer;"></span>
							  </li>
							</ul>	 --}}
			            </div>
			            
					</div>

					<div class="col-md-8">
						<div style="margin-left: 20px;">
							<div class="form-group">
								<label for="adventure_name">Judul Petulangan</label>
								<input type="text" name="adventure_name" class="form-control" id="adventure_name" placeholder="Judul Petualangan">
							</div>

							<div class="row mb-2">
								<div class="col-md-6">
									Mulai
									<div class="row">
										<div class="col-md-7">
											<input type="date" name="starting_date" class="form-control">	
										</div>
										<div class="col-md-5">
											<input type="time" name="starting_time" class="form-control">	
										</div>
									</div>
								</div>

								<div class="col-md-6">
									Berakhir
									<div class="row">
										<div class="col-md-7">
											<input type="date" name="ending_date" class="form-control">	
										</div>
										<div class="col-md-5">
											<input type="time" name="ending_time" class="form-control">	
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="description">Deskripsi Adventure</label>
								<textarea class="form-control" name="description" placeholder="deskripsi petualangan anda"></textarea>
							</div>

							<div class="form-group">
								<label for="image">Unggah Gambar</label>
								<input type="file" name="image" class="form-control">
							</div>

							<div class="form-group">
								<label for="destination">Destinasi</label>
								<input type="text" name="destination" class="form-control" id="pac-input" placeholder="cari destinasi disini...">
							</div>

							<div id="destination-hidden">
								
							</div>
							<input type="hidden" name="destination_count" value="0" id="destination-count">

						    <div id="map"></div>
						    <div id="infowindow-content">
						      <img src="" width="16" height="16" id="place-icon">
						      <span id="place-name"  class="title"></span><br>
						      <span id="place-address"></span>
						    </div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>	
@endsection

@section('script')
<script>
	$(document).ready(function() {
		$(window).keydown(function(event){
			if(event.keyCode == 13) {
			event.preventDefault();
			return false;
			}
		});
	});
	      // This example requires the Places library. Include the libraries=places
	      // parameter when you first load the API. For example:
	      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

	      function initMap() {
	        var map = new google.maps.Map(document.getElementById('map'), {
	          center: {lat: -33.8688, lng: 151.2195},
	          zoom: 13
	        });
	        var card = document.getElementById('pac-card');
	        var input = document.getElementById('pac-input');
	        var types = document.getElementById('type-selector');
	        var strictBounds = document.getElementById('strict-bounds-selector');

	        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

	        var autocomplete = new google.maps.places.Autocomplete(input);

	        // Bind the map's bounds (viewport) property to the autocomplete object,
	        // so that the autocomplete requests use the current map bounds for the
	        // bounds option in the request.
	        autocomplete.bindTo('bounds', map);

	        var infowindow = new google.maps.InfoWindow();
	        var infowindowContent = document.getElementById('infowindow-content');
	        infowindow.setContent(infowindowContent);
	        var marker = new google.maps.Marker({
	          map: map,
	          anchorPoint: new google.maps.Point(0, -29)
	        });

	        var destination_count = 0;

	        autocomplete.addListener('place_changed', function() {
		        infowindow.close();
		        marker.setVisible(false);
		        var place = autocomplete.getPlace();
		        if (!place.geometry) {
		          // User entered the name of a Place that was not suggested and
		          // pressed the Enter key, or the Place Details request failed.
		          window.alert("No details available for input: '" + place.name + "'");
		          return;
		        }

		        // If the place has a geometry, then present it on a map.
		        if (place.geometry.viewport) {
		          map.fitBounds(place.geometry.viewport);
		        } else {
		          map.setCenter(place.geometry.location);
		          map.setZoom(17);  // Why 17? Because it looks good.
		        }
		        marker.setPosition(place.geometry.location);
		        marker.setVisible(true);

		        var lat = place.geometry.location.lat();
		        var lng = place.geometry.location.lng();
		        var location = place.name;
		        var full_location  = place.formatted_address;

		        var destination = 
		        	"<div class='list-group-item'>" +
						"<div class='row'>" +
							"<div class='col-md-10'>" +
								"<div style='font-weight: bold;'>"+ location +"</div>" +
								"<div>"+ full_location +"</div>" +
							"</div>" +
							"<div class='col-md-2'>" +
								"<span class='fa fa-times pull-right' style='margin-top: 55%'></span>" +
							"</div>" +
						"</div>" +
					"</div>";

				var destination_hidden = 
					"<input type='hidden' name='location"+ destination_count +"' value='"+ location +"'></input>" +
					"<input type='hidden' name='full_location"+ destination_count +"' value='"+ full_location +"'></input>" +
					"<input type='hidden' name='lat"+ destination_count +"' value='"+ lat +"'></input>" +
					"<input type='hidden' name='lng"+ destination_count +"' value='"+ lng +"'></input>";
				
	          	$('#destination-list').append(destination);
	          	$('#destination-hidden').append(destination_hidden);
	          	$('#pac-input').val('');

	          	destination_count += 1;
	          	$('#destination-count').val(destination_count);

	 	       	var address = '';
	          	if (place.address_components) {
	            	address = [
		              (place.address_components[0] && place.address_components[0].short_name || ''),
		              (place.address_components[1] && place.address_components[1].short_name || ''),
		              (place.address_components[2] && place.address_components[2].short_name || '')
		            ].join(' ');
		          }

	          	infowindowContent.children['place-icon'].src = place.icon;
	          	infowindowContent.children['place-name'].textContent = place.name;
	          	infowindowContent.children['place-address'].textContent = address;
	          	infowindow.open(map, marker);
	        });

	        // Sets a listener on a radio button to change the filter type on Places
	        // Autocomplete.
	        function setupClickListener(id, types) {
	          var radioButton = document.getElementById(id);
	          radioButton.addEventListener('click', function() {
	            autocomplete.setTypes(types);
	          });
	        }

	        setupClickListener('changetype-all', []);
	        setupClickListener('changetype-address', ['address']);
	        setupClickListener('changetype-establishment', ['establishment']);
	        setupClickListener('changetype-geocode', ['geocode']);

	        document.getElementById('use-strict-bounds')
	            .addEventListener('click', function() {
	              console.log('Checkbox clicked! New state=' + this.checked);
	              autocomplete.setOptions({strictBounds: this.checked});
	            });
     	}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuzok_jxa1DYFbm0C8xlmt3y4pZW92v9w&libraries=places&callback=initMap"
        async defer></script>
@endsection