function showMap() {
    var styles = [{}];
    var styledMap = new google.maps.StyledMapType(styles,
      {name: "Styled Map"});
    var mapOptions = {
      zoom: 10,
      center: new google.maps.LatLng(54.917, 23.9875),
      disableDefaultUI: true,
      scrollwheel: false,
      draggable: false,
      mapTypeControlOptions: {
        mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
      }
    };
    
    var map = new google.maps.Map(document.getElementById('map'), mapOptions);
  
    var iconBase = 'http://www.dts-solutions.com/img/';
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(54.917, 23.9875),
        map: map,
        icon: iconBase + 'pin_icon.png',
        shadow: iconBase + 'pin_icon.png'
      });
    map.mapTypes.set('map_style', styledMap);
    map.setMapTypeId('map_style');
  }
  
  
  //BIG MAP
  
  function showBigMap() {
    var styles = [{}];
    var styledMap = new google.maps.StyledMapType(styles,
      {name: "Styled Map"});
    var mapOptions = {
      zoom: 13,
      disableDefaultUI: true,
      center: new google.maps.LatLng(54.917, 23.9875),
      mapTypeControlOptions: {
        mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
      }
    };
    
    var map = new google.maps.Map(document.getElementById('map-fs'), mapOptions);
  
    var iconBase = 'http://www.dts-solutions.com/img/';
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(54.917, 23.9875),
        map: map,
        icon: iconBase + 'pin_icon.png',
        shadow: iconBase + 'pin_icon.png'
      });
    map.mapTypes.set('map_style', styledMap);
    map.setMapTypeId('map_style');
  }