  // +---------------------------------------+ //
  // | Variables globables                  | //
  // +--------------------------------------+ //
  var custom= 'custom';
  var map;
  var marker;
  var geocoder;
  var searchinput;
  var kmlcitys;
  var kmlsoils;
  var cuidad;
  var elevation;
  var latitud;
  var longitud;
    // +---------------------------------------+ //
  // | Variables globales del clima            | //
  // +--------------------------------------+ //
  var current_temp;
  var max_temp;
  var min_temp;
  var humidity;
  var pressure;
  var description;
  var icon;
  var cloudiness;
  var wind_speed;
  var wind_degree;
  var wind_compass;

  function initialize() { 
      geocoder= new google.maps.Geocoder();

      var featureOpts =[
        {
          "featureType": "water",
          "elementType": "geometry",
          "stylers": [
            { "visibility": "on" },
            { "color": "#4b7280" }
          ]
        },{
          "featureType": "administrative.country",
          "elementType": "geometry.stroke",
          "stylers": [
            { "color": "#ff3020" },
            { "weight": 1.6 }
          ]
        },{
          "featureType": "administrative.country",
          "elementType": "labels.text",
          "stylers": [
            { "visibility": "off" }
          ]
        },{
          "featureType": "landscape",
          "elementType": "geometry.fill",
          "stylers": [
            { "color": "#d9d9d9" }
          ]
        },{
          "featureType": "administrative.province",
          "elementType": "geometry.stroke",
          "stylers": [
            { "color": "#1d1d1d" },
            { "weight": 1.3 }
          ]
        },{
          "featureType": "administrative.locality",
          "elementType": "labels.icon",
          "stylers": [
            { "color": "#cf2814" }
          ]
        },{
          "featureType": "landscape.man_made",
          "elementType": "geometry.fill",
          "stylers": [
            { "color": "#14211e" }
          ]
        },{
          "featureType": "administrative.neighborhood",
          "stylers": [
            { "visibility": "on" },
            { "color": "#12190f" }
          ]
        },{
          "featureType": "administrative.land_parcel",
          "stylers": [
            { "color": "#060802" }
          ]
        },{
          "featureType": "landscape.natural.landcover",
          "stylers": [
            { "color": "#ece6dd" }
          ]
        },{
          "featureType": "landscape.natural.terrain",
          "stylers": [
            { "color": "#c6ddc3" }
          ]
        },{
          "featureType": "poi",
          "stylers": [
            { "visibility": "off" }
          ]
        },{
          "featureType": "road",
          "elementType": "geometry.fill",
          "stylers": [
            { "color": "#060506" },
            { "weight": 0.9 }
          ]
        },{
          "featureType": "transit",
          "elementType": "geometry.stroke",
          "stylers": [
            { "color": "#716f6d" }
          ]
        },{
          "featureType": "road",
          "elementType": "geometry.stroke",
          "stylers": [
            { "visibility": "on" },
            { "color": "#444545" }
          ]
        },{
          "featureType": "transit.line",
          "stylers": [
            { "color": "#141316" },
            { "visibility": "on" }
          ]
        },{
          "featureType": "water",
          "elementType": "labels",
          "stylers": [
            { "visibility": "off" }
          ]
        },{
          "featureType": "transit",
          "elementType": "geometry.fill",
          "stylers": [
            { "color": "#091310" }
          ]
        },{
          "featureType": "road.highway",
          "elementType": "labels.icon",
          "stylers": [
            { "visibility": "off" }
          ]
        },{
          "elementType": "labels.text.fill",
          "stylers": [
            { "color": "#080809" }
          ]
        },{
          "elementType": "labels.text.stroke",
          "stylers": [
            { "color": "#ebecec" }
          ]
        }
      ];

        var mapOptions = {
          center: new google.maps.LatLng(18.7620130, -96.6470718),
          zoom: 12,

          panControl: false, 
          zoomControl:false,
          scaleControl:false,

          streetViewControl: true,
          streetViewControlOptions: {
             position: google.maps.ControlPosition.LEFT_CENTER  
          },
          
          mapTypeControlOptions: {
            mapTypeIds: [google.maps.MapTypeId.TERRAIN,custom]
          },
          mapTypeId: custom,
          
        };

        map = new google.maps.Map(document.getElementById("map"),mapOptions);

        /**
        Capas KML del mapa 
        **/
        kmlcitys= new google.maps.KmlLayer({
          url: 'https://sites.google.com/site/kmlserviceafgmx/resources/kmlcuidades.kml?attredirects=0&d=1',
          suppressInfoWindows: true,
          map: map
          
        });
        kmlsoils= new google.maps.KmlLayer({
          url: 'https://sites.google.com/site/kmlserviceafgmx/resources/kmlsuelos.kml?attredirects=0&d=1',
          suppressInfoWindows: true,
          map: map
        });
        
        kmlcitys.setZIndex(1);
        kmlsoils.setZIndex(4);
        
        
        /**Fin de las capas KML**/

        var styleMapOptions= {
          name: 'edafólogo'
        };
        // +-------------------------------------------------------------------------------------------------------+ //
        // | Servicio de elevación consultas de un servidor externo para acceder a la altura de determinada región | //
        // +--------------------------------------------------------------------------------------------------------+ //
        
        elevation= new google.maps.ElevationService();

        google.maps.event.addListener(kmlsoils,'click',getElevation);
        


        var customMapType = new google.maps.StyledMapType(featureOpts, styleMapOptions);
        map.mapTypes.set(custom, customMapType);


        var optionPlaces={
          types: ["(regions)"]
        };
        searchinput= /** @type {HTMLInputElement} */(document.getElementById('address'));
        var autocomplete = new google.maps.places.Autocomplete(searchinput,optionPlaces);
        autocomplete.bindTo('bounds', map);

        var zoommore= document.getElementById('more');  
        var zoomless= document.getElementById('less');
        google.maps.event.addDomListener(zoommore,'click',more);
        google.maps.event.addDomListener(zoomless,'click',less);

        google.maps.event.addListener(kmlsoils, 'click', function(kmlEvent){
          
          showData(kmlEvent.featureData.name, kmlEvent.featureData.description);

        });


        $(document).ready(function(){
          $("#close_infowindow").click(function(){
              $("#description").slideToggle("slow");
            });
        });
 };
 function getElevation(event){
  var locations=[];

  var clickedLocation= event.latLng;
  latitud= event.latLng.lat();
  longitud= event.latLng.lng();

  locations.push(clickedLocation);

  getWeather(latitud,longitud);

  var positionalRequest={
    'locations': locations
  }

  elevation.getElevationForLocations(positionalRequest, function(results,status){
    if(status==google.maps.ElevationStatus.OK){
      if(results[0]){
        document.getElementById("op_alture").innerHTML="<li><img src='styles/images/ruler.png' class='ca-icon' style='margin-top:-35px'/><div class='ca-content' style='color: #ededed;font-size: 12px!important; margin-top:-20px;margin-left:30px'>"+
        "<span class='ca-main' style='font-size:12px;margin-left:25px'>Altura: "+Math.round(results[0].elevation * 100) / 100+" metros.</span><div></li>";
      }else{
        alert('No se encontraron resultados de la altura referente a este sitio');
      }
    }else{
      alert('La comunicación con el servidor fallo consulte el estado: '+status);
    }
  });
 }
 // +-----------------------------------------------------------------------+ //
 // | Funcion para obtener el clima de Open Weather Maps                    | //
 // +-----------------------------------------------------------------------+ //
 function getWeather(latitud,longitud){
  if(latitud!='' && longitud !=''){
  
    $.getJSON("http://api.openweathermap.org/data/2.5/weather?lat="+latitud+"&lon="+longitud+"&units=metric&lang=es#16days",function(data){
      current_temp= Math.round(data.main.temp);
      city= data.name;
      max_temp= data.main.temp_max;
      min_temp= data.main.temp_min;
      humidity= data.main.humidity;
      pressure= (data.main.pressure * 0.02961339710085).toFixed(2);
      description= data.weather[0].description;
      icon= data.weather[0].icon;
      cloudiness= data.clouds.all;
      wind_speed= data.wind.speed;
      wind_degree= data.wind.deg;
      data= "data="+city+"/"+humidity+"/"+current_temp+"/"+description+"/"+cloudiness+"/"+wind_speed;
      insertData(data);
      $('#op_c_icon').css("display","none");
      if(icon=="01d"){
        $('#op_clima').html("<li><img class='ca-icon' src='styles/images/sunnyd.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");
      }else if(icon=="02d"){
        $('#op_clima').html("<li><img class='ca-icon' src='styles/images/fcloudsd.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");
      }else if(icon=="03d"){
         $('#op_clima').html("<li><img class='ca-icon' src='styles/images/cloud.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");
      }else if(icon=="04d"){
         $('#op_clima').html("<li><img class='ca-icon' src='styles/images/bcloudsd.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");
      }else if(icon=="09d"){
         $('#op_clima').html("<li><img class='ca-icon' src='styles/images/sraind.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");
      }else if(icon=="10d"){
         $('#op_clima').html("<li><img class='ca-icon' src='styles/images/raind.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");
      }else if(icon=="11d"){
         $('#op_clima').html("<li><img class='ca-icon' src='styles/images/stormd.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");
      }else if(icon=="13d"){
        $('#op_clima').html("<li><img class='ca-icon' src='styles/images/snowd.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");
      }else if(icon=="50d"){
        $('#op_clima').html("<li><img class='ca-icon' src='styles/images/fogd.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");
      }else if(icon=="01n"){
        $('#op_clima').html("<li><img class='ca-icon' src='styles/images/clearSky.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");
      }else if(icon=="02n"){
        $('#op_clima').html("<li><img class='ca-icon' src='styles/images/fcloudsn.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");    
      }else if(icon=="03n"){
        $('#op_clima').html("<li><img class='ca-icon' src='styles/images/cloud.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");        
      }else if(icon=="04n"){
        $('#op_clima').html("<li><img class='ca-icon' src='styles/images/bcloudsd.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");        
      }else if(icon=="09n"){
        $('#op_clima').html("<li><img class='ca-icon' src='styles/images/sraind.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");
      }else if(icon=="10n"){
        $('#op_clima').html("<li><img class='ca-icon' src='styles/images/raind.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");
      }else if(icon=="11n"){
        $('#op_clima').html("<li><img class='ca-icon' src='styles/images/stormd.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");  
      }else if(icon=="13n"){
        $('#op_clima').html("<li><img class='ca-icon' src='styles/images/snowd.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");  
      }else if(icon=="50n"){
        $('#op_clima').html("<li><img class='ca-icon' src='styles/images/fogn.png' style='margin-left: 0px;width:35px!important; height:35px!important;margin-top:-49px!important;padding-top:-20px!important'/>"+
           "<div class=ca-content style='margin-top:-30px'><span class='ca-main' style='font-size: 12px!important'>"+city+"</span><br/><span class='ca-main' style='font-size: 12px;margin-top-18px!important;'>"+description+"</span>"+
        "<span class='ca-main' style='color:#ededed;font-size:12px;margin-left:10px'>"+current_temp+" °C</span></div></li>");
      $('#op_humedad_t').html("<span class='ca-main' style='font-size: 12px!important; color: #ededed!important;margin-left: -10px!important'>Humedad: "+humidity+"%</span>");
      $('#op_viento_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Viento: "+wind_speed+"mps</span>");
      $('#op_cloudy_t').html("<span class='ca-main' style='font-size:12px!important;color:#ededed!important;margin-left:-10px!important'>Nubosidad: "+cloudiness+"%</span>");  
      }
       
    });

  }
 }
 function insertData(data){
      date= new Date();
      day= date.getDate().toString();
      month= (date.getMonth()+1).toString();
      year= date.getFullYear().toString();

      if(day.length==1){
        day='0'+day;
      }
      if(month.length==1){
        month= '0'+month;
      }
      data+="/"+year+"-"+month+"-"+day;
      $.ajax({
        async: true,
        type: "POST",
        url: "ajax/insertData.php",
        data: data,
        success: function(data){
          
        }
      });
 }
 function showData(text,description){
  if(text=='Fluvisol' || description=='tipo de suelo fluvisol'){
    
    $("#close_infowindow").css("display","block");
    $("#description").slideDown("slow");
    document.getElementById('header-window').innerHTML="<legend>"+text+"</legend>";
    document.getElementById('image-window').innerHTML="<img class='soilimg' src='styles/images/dataWindow/fluvisol.png'/>";
    document.getElementById('content-window').innerHTML="<article class='soildescription'>El término fluvisol deriva del vocablo latino \"fluvius\" que significa río, haciendo alusión a que estos suelos están desarrollados sobre depósitos aluviales"+
    " El material original lo constituyen depósitos, predominantemente recientes, de origen fluvial, lacustre o marino,"+
    " los Fluvisoles suelen utilizarse para cultivos de consumo, huertas y, frecuentemente, para pastos.</article><br/>"+
    "<span class='d-url'>Para más información consulte este enlace:  </span><a class='d-link' href='http://www.eweb.unex.es/eweb/edafo/FAO/Fluvisol.htm' target='_blank'>Sitio web</a>";
  }else if(text=='Vertisol' || description=='tipo de suelo vertisol'){
    
    $("#close_infowindow").css("display","block");
    $("#description").slideDown("slow");
    document.getElementById('header-window').innerHTML="<legend>"+text+"</legend>";
    document.getElementById('image-window').innerHTML="<img class='soilimg' src='styles/images/dataWindow/vertisol.png'/>";
    document.getElementById('content-window').innerHTML="<article class='soildescription'>El término vertisol deriva del vocablo latino \"vertere\" que significa verter o revolver, haciendo alusión al efecto de batido y mezcla provocado por la presencia"+
     "de arcillas hinchables.<br/>El material original lo constituyen sedimentos con una elevada proporción de arcillas esmectíticas, o productos de alteración de rocas que las generen."+
     "El perfil es de tipo ABC. La alternancia entre el hinchamiento y la contracción de las arcillas, genera profundas grietas en la estación seca y la formación de superficies de presión y agregados estructurales en forma de cuña en los horizontes subsuperficiales."+
     "Los Vertisoles se vuelven muy duros en la estación seca y muy plásticos en la húmeda. El labrado es muy díficil excepto en los cortos periodos de transición entre ambas estaciones. Con un buen manejo, son suelos muy productivos.</article>"+
     "<span class='d-url'>Para más información consulte este enlace:  </span><a class='d-link' href='http://www.eweb.unex.es/eweb/edafo/FAO/Vertisol.htm' target='_blank'>Sitio web</a>";
  }else if(text=='Leptosol' || description=='tipo de suelo leptosol'){
    
    $("#close_infowindow").css("display","block");
    $("#description").slideDown("slow");
    document.getElementById('header-window').innerHTML="<legend>"+text+"</legend>";
    document.getElementById('image-window').innerHTML="<img class='soilimg' src='styles/images/dataWindow/leptosol.png'/>";
    document.getElementById('content-window').innerHTML="<article class='soildescription'>El término leptosol deriva del vocablo griego \"leptos\" que significa delgado, haciendo alusión a su espesor reducido"+
    "<br/>El material original puede ser cualquiera tanto rocas como materiales no consolidados con menos del 10 % de tierra fina.<br/>"+
    "Aparecen fundamentalmente en zonas altas o medias con una topografía escarpada y elevadas pendientes. Se encuentran en todas las zonas climáticas y, particularmente, en áreas fuertemente erosionadas."+
    " Son suelos poco o nada atractivos para cultivos; presentan una potencialidad muy limitada para cultivos arbóreos o para pastos. Lo mejor es mantenerlos bajo bosque.</article>"+
    "<span class='d-url'>Para más información consulte este enlace:  </span><a class='d-link' href='http://www.eweb.unex.es/eweb/edafo/FAO/Leptosol.htm' target='_blank'>Sitio web</a>";
  }else{
    $("#description").slideUp();
  }
 }


function more(){
  actual_zoom= map.getZoom();
  
  if(actual_zoom>19){
    alert('Se ha llegado al máximo nivel de zoom');
    map.setZoom(19);
  }else{
    map.setZoom(actual_zoom+1);  
  }
}
function less(){
  actual_zoom= map.getZoom();
  if(actual_zoom<9){
    alert('Se ha llegado el mínimo nivel de zoom');
    map.setZoom(9);
  }else{
    map.setZoom(actual_zoom-1);
  }
}


function codeAddress(){
  var address= document.getElementById('address').value+'Veracruz México';
  geocoder.geocode({'address':address}, function(results,status){
    if(status== google.maps.GeocoderStatus.OK){
      map.setCenter(results[0].geometry.location);
      map.setZoom(14);
      marker= new google.maps.Marker({
        icon: 'styles/images/custommarker.png',
        map:map,
        position: results[0].geometry.location,
        draggable: true
      });
    }else{
      alert('No se encontraron resultados consulte el siguiente estado: '+status);
    }
  });
}
function loadScript(){
  var script= document.createElement('script');
  script.type='text/javascript';
  script.src='https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=false&key=AIzaSyCw9gkNrEYYEecNV_RInSsCi81t8JeOGMo&sensor=SET_TO_TRUE_OR_FALSE&language=es&region=mx&libraries=places&callback=initialize';
  document.body.appendChild(script);
}

 window.onload= loadScript;