var postions = new Array();
var marker = new Array();
var GcenterLat = 0;
var GcenterLng = 0;
var map;
var infowindow = null;
var th;

setTimeout(function(){ 

	if($('.map_info').attr('valTable') == "tourinfo"){
      zoom_num = 17;
    }else{
      zoom_num = 15;
    }


	if($('.map_address').attr('valaddress')){
		$.ajax({
			url: "https://maps.googleapis.com/maps/api/geocode/json?address="+$('.map_address').attr('valaddress')+"&key=AIzaSyCIX9g1T3yPSC5_ewJO25c7mCiRs0clTU8",
			success: function(data){
				var zooms = $('.map_zoom').attr('valzoom'); 
				map = new google.maps.Map(document.getElementById('map'), {
					 zoom: parseInt(zooms),
					 center: { lat: data.results[0].geometry.location.lat, lng: data.results[0].geometry.location.lng }
				});	
				setMarkers_area_init(map);
			}	
		})
	}else{
		map = new google.maps.Map(document.getElementById('map'), {
		  zoom: zoom_num,
		  center: { lat: GcenterLat, lng: GcenterLng }
		});	

		if($('.infoarea').attr('valinfo') == 'benefitarea'){
			setMarkers_area_init_m(map);
		}else{
			setMarkers(map);
		}
	}

	

    //setPositions();
    
}, 500);

// function initMap() {  //시작하자마자 실행되는 함수
//   map = new google.maps.Map(document.getElementById('map'), {
//     zoom: 10,
//     center: { lat: GcenterLat, lng: GcenterLng }
//   });
//   //setPositions();
//   setMarkers(map);
// }



function resetPositon(test,info, id, link) {
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 17,
      center: test
    });
    //setPositions();
    infoWindow1 = new google.maps.InfoWindow();
    setMarkers1(map, infoWindow1, test,id, link);

}

function resetPositon_area_m(test,info, id, link, areacnt) {
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 17,
      center: test
    });
    //setPositions();
    infoWindow1 = new google.maps.InfoWindow();
    setMarkers_area_m(map, infoWindow1, test,id, link, areacnt);

}
function resetPositon_area(test,info, id, link, areacnt) {
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 17,
      center: test
    });
    //setPositions();
    infoWindow1 = new google.maps.InfoWindow();
    setMarkers_area(map, infoWindow1, test,id, link, areacnt);

}

function resetPositon2(test,info, id, link) {
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 17,
      center: test
    });
    //setPositions();
    infoWindow1 = new google.maps.InfoWindow();
    setMarkers2(map, infoWindow1, test,id, link);

}

function resetPositon_add(test,info, id, link, src) {
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 17,
      center: test
    });
    //setPositions();
    infoWindow1 = new google.maps.InfoWindow();
    setMarkers_add(map, infoWindow1, test,id, link,info, src);

}


function resetPositon1(test) {
  map.setZoom(17);
  map.setCenter(test);
}












function setMarkers_add(map, infoWindow, test,id, link,info, src) {   // 마커 만드는 함수

  pinurl = "/skin/board/map/img/pin1.png";
  
  var image = {
    url: pinurl,
    // This marker is 20 pixels wide by 32 pixels high.
  //size: new google.maps.Size(71, 71),
  origin: new google.maps.Point(0, 0),
  anchor: new google.maps.Point(17, 34),
  scaledSize: new google.maps.Size(27, 36)
  };
  // Shapes define the clickable region of the icon. The type defines an HTML
  // <area> element 'poly' which traces out a polygon as a series of X,Y points.
  // The final coordinate closes the poly by connecting to the first coordinate.

  
	if(t_lang == ""){
		t_lang == "ko";
	}

    var po = link;
    if( link.match("/img/map/") ){
        link = link+t_lang+".jpg";
    }


	var panel_detail = "";

	if(t_lang == 'ko'){
		panel_detail = "자세히보기";
	}else if(t_lang == 'en'){
		panel_detail = "Check for details";
	}else if(t_lang == 'ja'){
		panel_detail = "詳細を見る";
	}else if(t_lang == 'ch1'){
		panel_detail = "查看详情";
	}else if(t_lang == 'ch2'){
		panel_detail = "查看詳情";
	}



    if(!link){
      var text1 = '<div id="content" style="min-width:100px; min-height:20px; text-align:center;"><img src="'+src+'" style="width:114px;" ><h1 id="firstHeading"  class="firstHeading"  >'+info+'</h1></div>';
    }else{
      var text1 = '<div id="content" style="min-width:150px; min-height:35px; text-align:center;"><img src="'+src+'" style="width:114px;" ><h1 id="firstHeading"  class="firstHeading">'+info+'</h1>';
      text1 += '</div>';
      text1 += '<a href="'+link+'" target="_blank"><div class="mapViewBtn" style="float:right; width:150px; height:30px; line-height:30px; border:1px solid black; text-align:center;">'+panel_detail+'</div></a>';
    }

    link = po;
    //$('.info_num_'+i).text(i+1);
      var marker = new google.maps.Marker({
        position: test,
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP,
        html: text1
      });
  
  var latint = new Object();
  latint['lat'] = test['lat'] + 0.00031;
  latint['lng'] = test['lng'] - 0.00005;

  infoWindow.setOptions({
      content: text1,
      position: {  lat:latint['lat'],lng:latint['lng'] },
  });

  infoWindow.open(map);
       
}




function setMarkers_area_m(map, infoWindow, test,id, link, areacnt) {   // 마커 만드는 함수

  var size_h = 33;
  var size_w = 27;
  var size_p = 0;
  var pinurl = "/skin/board/map/img/pin_b.png";



  
  var image = {
    url: pinurl,
    // This marker is 20 pixels wide by 32 pixels high.
  //size: new google.maps.Size(71, 71),
  origin: new google.maps.Point(size_p, 0),
  anchor: new google.maps.Point(17, 34),
  scaledSize: new google.maps.Size(size_w, size_h)
  };
  // Shapes define the clickable region of the icon. The type defines an HTML
  // <area> element 'poly' which traces out a polygon as a series of X,Y points.
  // The final coordinate closes the poly by connecting to the first coordinate.


  var arrayval = new Array();
  
  for (var i = 0; i < postions.length; i++) {
    var position = postions[i];
    var contentString = position[0];
    //infowindow = new google.maps.InfoWindow();
    var po = position[4];

	if(t_lang == ""){
		t_lang == "ko";
	}


    if( $('.map_info').attr('valTable') != "tourinfo" ){
      if( position[4].match("/img/map/") ){
          position[4] = position[4]+t_lang+".jpg";
      }
    }


	var panel_detail = "";

	if(t_lang == 'ko'){
		panel_detail = "자세히보기";
	}else if(t_lang == 'en'){
		panel_detail = "Check for details";
	}else if(t_lang == 'ja'){
		panel_detail = "詳細を見る";
	}else if(t_lang == 'ch1'){
		panel_detail = "查看详情";
	}else if(t_lang == 'ch2'){
		panel_detail = "查看詳情";
	}


    if(position[5]){
   
      if(position[4]){
			var text1 = '<div style="font-size: 13px; text-align: center; color: #b8b8b8; margin: 5px auto 10px auto;">'+position[6]+'</div>';
			text1 += '<div id="content" style="min-width:100px; min-height:35px; text-align:center; "><h1 id="firstHeading"  class="firstHeading" style="font-size: 16px; color: #333; margin: 0 auto; margin-bottom: 15px;  max-width: 170px;  ">'+position[0]+'</h1>';
			text1 += '</div>';
			text1 += '<a href="'+position[4]+'" target="_blank"><div style="border:1px solid black; text-align:center; border-radius: 3px; padding: 2px 0px; font-weight: 600; margin-bottom: 5px; width: 120px; margin: 0 auto;" >'+panel_detail+'</div></a>';
      }else{
        
        var text1 = '<div id="content" style="min-width:100px; min-height:20px; text-align:center;"><img src="'+position[5]+'" style="width:114px;"><h1 id="firstHeading"  class="firstHeading"  >'+position[0]+'</h1></div>';
      }
    }else{
  
      if(position[4]){
			var text1 = '<div style="font-size: 13px; text-align: center; color: #b8b8b8; margin: 5px auto 10px auto;">'+position[6]+'</div>';
			text1 += '<div id="content" style="min-width:100px; min-height:35px; text-align:center; "><h1 id="firstHeading"  class="firstHeading" style="font-size: 16px; color: #333; margin: 0 auto; margin-bottom: 15px;  max-width: 170px;  ">'+position[0]+'</h1>';
			text1 += '</div>';
			text1 += '<a href="'+position[4]+'" target="_blank"><div style="border:1px solid black; text-align:center; border-radius: 3px; padding: 2px 0px; font-weight: 600; margin-bottom: 5px; width: 120px; margin: 0 auto;" >'+panel_detail+'</div></a>';
      }else{
        var text1 = '<div id="content" style="min-width:100px; min-height:20px; text-align:center;"><h1 id="firstHeading"  class="firstHeading"  >'+position[0]+'</h1></div>';
      }   
    }

    position[4] = po;

    arrayval[i] = text1;
    //var arrayval1 = new object();

    labels = "";
    if($('.map_info').attr('valTable') == "cardbenefit"){
      labels = "";
    }else{
      labels = (i + 1).toString();
    }   

	if(areacnt == i){
	   pinurl = "/skin/board/map/img/pin1.png";
	   size_h = 27;
	   size_w = 26;
	   size_p = -6;

	  var image = {
		url: pinurl,
		// This marker is 20 pixels wide by 32 pixels high.
	  //size: new google.maps.Size(71, 71),
  //size: new google.maps.Size(71, 71),
  origin: new google.maps.Point(0, 0),
  anchor: new google.maps.Point(17, 34),
  scaledSize: new google.maps.Size(27, 36)
	  };



    //$('.info_num_'+i).text(i+1);
	   var marker = new google.maps.Marker({
        position: { lat: position[1], lng: position[2] },
        map: map,
        icon: image,
        title: position[0],
        label: labels,
        animation: google.maps.Animation.DROP,
        zIndex: position[3],
        html: text1
      });



      if(i == id){
        infoWindow.open(map,marker);
      }


	}else{
	   pinurl = "/skin/board/map/img/pin_b.png";
	   size_h = 35;
	   size_w = 41;
	   size_p = -6;
	  


	  var image = {
		url: pinurl,
		// This marker is 20 pixels wide by 32 pixels high.
	  //size: new google.maps.Size(71, 71),
	  origin: new google.maps.Point(size_p, 0),
	  anchor: new google.maps.Point(19, 34),
	  scaledSize: new google.maps.Size(size_w, size_h)
	  };


	   var marker = new google.maps.Marker({
        position: { lat: position[1], lng: position[2] },
        map: map,
        icon: image,
        title: position[0],
        label: labels,
        animation: google.maps.Animation.DROP,
        zIndex: position[3],
        html: text1
      });



      if(i == id){
        infoWindow.open(map,marker);
      }

	
	
	
	}


      
      google.maps.event.addListener(marker,'click', function() {
        infowindow.setContent(this.html);
        infowindow.open(map, this); 
        infoWindow1.close(map); 
      });
  }

  infoWindow.setOptions({
      content: arrayval[id],
      position: test,
  });

  //infoWindow.open(map);
}

function setMarkers_area(map, infoWindow, test,id, link, areacnt) {   // 마커 만드는 함수

  var size_h = 33;
  var size_w = 27;
  var size_p = 0;
  var pinurl = "/skin/board/map/img/pin_b.png";



  
  var image = {
    url: pinurl,
    // This marker is 20 pixels wide by 32 pixels high.
  //size: new google.maps.Size(71, 71),
  origin: new google.maps.Point(size_p, 0),
  anchor: new google.maps.Point(17, 34),
  scaledSize: new google.maps.Size(size_w, size_h)
  };
  // Shapes define the clickable region of the icon. The type defines an HTML
  // <area> element 'poly' which traces out a polygon as a series of X,Y points.
  // The final coordinate closes the poly by connecting to the first coordinate.


  var arrayval = new Array();
  
  for (var i = 0; i < postions.length; i++) {
    var position = postions[i];
    var contentString = position[0];
    //infowindow = new google.maps.InfoWindow();
    var po = position[4];

	if(t_lang == ""){
		t_lang == "ko";
	}


    if( $('.map_info').attr('valTable') != "tourinfo" ){
      if( position[4].match("/img/map/") ){
          position[4] = position[4]+t_lang+".jpg";
      }
    }


	var panel_detail = "";

	if(t_lang == 'ko'){
		panel_detail = "자세히보기";
	}else if(t_lang == 'en'){
		panel_detail = "Check for details";
	}else if(t_lang == 'ja'){
		panel_detail = "詳細を見る";
	}else if(t_lang == 'ch1'){
		panel_detail = "查看详情";
	}else if(t_lang == 'ch2'){
		panel_detail = "查看詳情";
	}


    if(position[5]){
   
      if(position[4]){
			var text1 = '<div style="font-size: 13px; text-align: center; color: #b8b8b8; margin: 5px auto 10px auto;">'+position[6]+'</div>';
			text1 += '<div id="content" style="min-width:100px; min-height:30px; text-align:center;"><h1 id="firstHeading"  class="firstHeading" style="font-size: 16px; color: #333; margin: 0 auto; margin-bottom: 15px;  min-width: 150px; max-width: 170px;">'+position[0]+'</h1>';
			text1 += '</div>';
			text1 += '<a href="'+position[4]+'" target="_blank"><div style="border:1px solid black; text-align:center; border-radius: 3px; padding: 2px 0px; font-weight: 600; margin-bottom: 5px; width: 120px; margin: 0 auto;" >'+panel_detail+'</div></a>';
      }else{
        
        var text1 = '<div id="content" style="min-width:100px; min-height:20px; text-align:center;"><img src="'+position[5]+'" style="width:114px;"><h1 id="firstHeading"  class="firstHeading"  >'+position[0]+'</h1></div>';
      }
    }else{
  
      if(position[4]){
			var text1 = '<div style="font-size: 13px; text-align: center; color: #b8b8b8; margin: 5px auto 10px auto;">'+position[6]+'</div>';
			text1 += '<div id="content" style="min-width:100px; min-height:30px; text-align:center;"><h1 id="firstHeading"  class="firstHeading" style="font-size: 16px; color: #333; margin: 0 auto; margin-bottom: 15px;  min-width: 150px; max-width: 170px;">'+position[0]+'</h1>';
			text1 += '</div>';
			text1 += '<a href="'+position[4]+'" target="_blank"><div style="border:1px solid black; text-align:center; border-radius: 3px; padding: 2px 0px; font-weight: 600; margin-bottom: 5px; width: 120px; margin: 0 auto;" >'+panel_detail+'</div></a>';
      }else{
        var text1 = '<div id="content" style="min-width:100px; min-height:20px; text-align:center;"><h1 id="firstHeading"  class="firstHeading"  >'+position[0]+'</h1></div>';
      }   
    }

    position[4] = po;

    arrayval[i] = text1;
    //var arrayval1 = new object();

    labels = "";
    if($('.map_info').attr('valTable') == "cardbenefit"){
      labels = "";
    }else{
      labels = (i + 1).toString();
    }   


	   pinurl = "/skin/board/map/img/pin_b.png";
	   size_h = 35;
	   size_w = 42;
	   size_p = -6;
	  


	  var image = {
		url: pinurl,
		// This marker is 20 pixels wide by 32 pixels high.
	  //size: new google.maps.Size(71, 71),
	  origin: new google.maps.Point(size_p, 0),
	  anchor: new google.maps.Point(19, 34),
	  scaledSize: new google.maps.Size(size_w, size_h)
	  };


	   var marker = new google.maps.Marker({
        position: { lat: position[1], lng: position[2] },
        map: map,
        icon: image,
        title: position[0],
        label: labels,
        animation: google.maps.Animation.DROP,
        zIndex: position[3],
        html: text1
      });



      if(i == id){
        infoWindow.open(map,marker);
      }

	
	


      
      google.maps.event.addListener(marker,'click', function() {
        infowindow.setContent(this.html);
        infowindow.open(map, this); 
        infoWindow1.close(map); 
      });
  }

  infoWindow.setOptions({
      content: arrayval[id],
      position: test,
  });

  //infoWindow.open(map);
}







function setMarkers2(map, infoWindow, test,id, link) {   // 마커 만드는 함수
  var size_h = 33;
  var size_w = 27;
  var size_p = 0;
  var pinurl = "/skin/board/map/img/pin_b.png";
   size_w = 40;
   size_p = -6;
  if($('.map_info').attr('valTable') == "cardbenefit"){
   pinurl = "/skin/board/map/img/pin1.png";
   size_h = 36;
   size_p = 0;
   size_w = 27;
  }
  
  var image = {
    url: pinurl,
    // This marker is 20 pixels wide by 32 pixels high.
  //size: new google.maps.Size(71, 71),
  origin: new google.maps.Point(size_p, 0),
  anchor: new google.maps.Point(17, 34),
  scaledSize: new google.maps.Size(size_w, size_h)
  };
  // Shapes define the clickable region of the icon. The type defines an HTML
  // <area> element 'poly' which traces out a polygon as a series of X,Y points.
  // The final coordinate closes the poly by connecting to the first coordinate.


  var arrayval = new Array();
  
  for (var i = 0; i < postions.length; i++) {
    var position = postions[i];
    var contentString = position[0];
    //infowindow = new google.maps.InfoWindow();
    var po = position[4];



    if(position[5]){
   
      if(position[4]){
        var text1 = '<div id="content" style="min-width:150px; min-height:35px; text-align:center;"><img src="'+position[5]+'" style="width:114px;" ><h1 id="firstHeading"  class="firstHeading">'+position[0]+'</h1>';
        text1 += '</div>';
        text1 += '<a href="'+position[4]+'" target="_blank"><div class="mapViewBtn" style="float:right; width:150px; height:30px; line-height:30px; border:1px solid black; text-align:center;">자세히 보기</div></a>';
      }else{
        
        var text1 = '<div id="content" style="min-width:100px; min-height:20px; text-align:center;"><img src="'+position[5]+'" style="width:114px;" ><h1 id="firstHeading"  class="firstHeading"  >'+position[0]+'</h1></div>';
      }
    }else{
  
      if(position[4]){
        var text1 = '<div id="content" style="min-width:100px; min-height:35px; text-align:center;"><h1 id="firstHeading"  class="firstHeading"  >'+position[0]+'</h1>';
        text1 += '</div>';
        text1 += '<a href="'+position[4]+'" target="_blank"><div style="float:right; width:100px; height:30px; line-height:30px; border:1px solid black; text-align:center;">자세히 보기</div></a>';
      }else{
        var text1 = '<div id="content" style="min-width:100px; min-height:20px; text-align:center;"><h1 id="firstHeading"  class="firstHeading"  >'+position[0]+'</h1></div>';
      }   
    }

    position[4] = po;

    arrayval[i] = text1;
    //var arrayval1 = new object();

    labels = "";
    if($('.map_info').attr('valTable') == "cardbenefit"){
      labels = "";
    }else{
      labels = (i + 1).toString();
    }   


    //$('.info_num_'+i).text(i+1);
      var marker = new google.maps.Marker({
        position: { lat: position[1], lng: position[2] },
        map: map,
        icon: image,
        title: position[0],
        label: labels,
        animation: google.maps.Animation.DROP,
        zIndex: position[3],
        html: text1
      });



      //marker[i] = marker;
      
      google.maps.event.addListener(marker,'click', function() {
        infowindow.setContent(this.html);
        infowindow.open(map, this); 
        infoWindow1.close(map); 
      });
  }

  infoWindow.setOptions({
      content: arrayval[id],
      position: test,
  });

  //infoWindow.open(map);
}












function setMarkers1(map, infoWindow, test,id, link) {   // 마커 만드는 함수
  var size_h = 33;
  var size_w = 27;
  var size_p = 0;
  var pinurl = "/skin/board/map/img/pin_b.png";
   size_w = 40;
   size_p = -6;
  if($('.map_info').attr('valTable') == "cardbenefit"){
   pinurl = "/skin/board/map/img/pin1.png";
   size_h = 36;
   size_p = 0;
   size_w = 27;
  }
  
  var image = {
    url: pinurl,
    // This marker is 20 pixels wide by 32 pixels high.
  //size: new google.maps.Size(71, 71),
  origin: new google.maps.Point(size_p, 0),
  anchor: new google.maps.Point(17, 34),
  scaledSize: new google.maps.Size(size_w, size_h)
  };
  // Shapes define the clickable region of the icon. The type defines an HTML
  // <area> element 'poly' which traces out a polygon as a series of X,Y points.
  // The final coordinate closes the poly by connecting to the first coordinate.


  var arrayval = new Array();
  
  for (var i = 0; i < postions.length; i++) {
    var position = postions[i];
    var contentString = position[0];
    //infowindow = new google.maps.InfoWindow();
    var po = position[4];

	if(t_lang == ""){
		t_lang == "ko";
	}


    if( $('.map_info').attr('valTable') != "tourinfo" ){
		//alert(position[4]);
      if( position[4].match("/img/map/") ){
          position[4] = position[4];
      }
    }

	var panel_detail = "";

	if(t_lang == 'ko'){
		panel_detail = "자세히보기";
	}else if(t_lang == 'en'){
		panel_detail = "Check for details";
	}else if(t_lang == 'ja'){
		panel_detail = "詳細を見る";
	}else if(t_lang == 'ch1'){
		panel_detail = "查看详情";
	}else if(t_lang == 'ch2'){
		panel_detail = "查看詳情";
	}




    if(position[5]){
   
      if(position[4]){
		var text1 = '<div>'+position[6]+'</div>';
        text1 += '<div id="content" style="min-width:150px; min-height:35px; text-align:center;"><img src="'+position[5]+'" style="width:114px;"><h1 id="firstHeading"  class="firstHeading">'+position[0]+'</h1>';
        text1 += '</div>';
        text1 += '<a href="'+position[4]+'" target="_blank"><div class="mapViewBtn" style="float:right; width:150px; height:30px; line-height:30px; border:1px solid black; text-align:center;">'+panel_detail+'</div></a>';
      }else{
        var text1 = '<div>'+position[6]+'</div>';
        text1 += '<div id="content" style="min-width:100px; min-height:20px; text-align:center;"><img src="'+position[5]+'" style="width:114px;"><h1 id="firstHeading"  class="firstHeading"  >'+position[0]+'</h1></div>';
      }
    }else{
  
      if(position[4]){
		var text1 = '<div>'+position[6]+'</div>';
        text1 += '<div id="content" style="min-width:100px; min-height:35px; text-align:center;"><h1 id="firstHeading"  class="firstHeading"  >'+position[0]+'</h1>';
        text1 += '</div>';
        text1 += '<a href="'+position[4]+'" target="_blank"><div style="float:right; width:100px; height:30px; line-height:30px; border:1px solid black; text-align:center;">'+panel_detail+'</div></a>';
      }else{
		var text1 = '<div>'+position[6]+'</div>';
        text1 += '<div id="content" style="min-width:100px; min-height:20px; text-align:center;"><h1 id="firstHeading"  class="firstHeading"  >'+position[0]+'</h1></div>';
      }   
    }

    position[4] = po;

    arrayval[i] = text1;
    //var arrayval1 = new object();

    labels = "";
    if($('.map_info').attr('valTable') == "cardbenefit"){
      labels = "";
    }else{
      labels = (i + 1).toString();
    }   


    //$('.info_num_'+i).text(i+1);
      var marker = new google.maps.Marker({
        position: { lat: position[1], lng: position[2] },
        map: map,
        icon: image,
        title: position[0],
        label: labels,
        animation: google.maps.Animation.DROP,
        zIndex: position[3],
        html: text1
      });



      
      google.maps.event.addListener(marker,'click', function() {
        infowindow.setContent(this.html);
        infowindow.open(map, this); 
        infoWindow1.close(map); 
      });

      //alert(id)

      if(i == id){
        infoWindow.open(map,marker);
      }
  }

  var windowLatLng = new google.maps.LatLng(test['lat'],test['lng']);
  infoWindow.setOptions({
      content: arrayval[id],
      position: windowLatLng,
      center: windowLatLng,
  });

  //th.trigger('click');
  //infoWindow.open(map,marker[0]);
  
}


function setMarkers(map) {   // 마커 만드는 함수
  var size_h = 33;
  var size_w = 27;
  var size_p = 0;
  var pinurl = "/skin/board/map/img/pin_b.png";
   size_w = 40;
   var size_p = -6;
  if($('.map_info').attr('valTable') == "cardbenefit"){
   pinurl = "/skin/board/map/img/pin1.png";
   size_h = 36;
   size_p = 0;
   size_w = 27;
  }
  var image = {
    url: pinurl,
    // This marker is 20 pixels wide by 32 pixels high.
  //size: new google.maps.Size(71, 71),
  origin: new google.maps.Point(size_p, 0),
  anchor: new google.maps.Point(17, 34),
  scaledSize: new google.maps.Size(size_w, size_h)
  };
  // Shapes define the clickable region of the icon. The type defines an HTML
  // <area> element 'poly' which traces out a polygon as a series of X,Y points.
  // The final coordinate closes the poly by connecting to the first coordinate.


  

  for (var i = 0; i < postions.length; i++) {

    var position = postions[i];
    var contentString = position[0];
    infowindow = new google.maps.InfoWindow();


    if( $('.map_info').attr('valTable') != "tourinfo" ){
      if( position[4].match("/img/map/") ){
          position[4] = position[4]+t_lang+".jpg";
      }
    }


	var panel_detail = "";

	if(t_lang == 'ko'){
		panel_detail = "자세히보기";
	}else if(t_lang == 'en'){
		panel_detail = "Check for details";
	}else if(t_lang == 'ja'){
		panel_detail = "詳細を見る";
	}else if(t_lang == 'ch1'){
		panel_detail = "查看详情";
	}else if(t_lang == 'ch2'){
		panel_detail = "查看詳情";
	}


	if( !position[6] ){

		if(position[5]){
		  if(position[4]){
			var text1 = '<div>'+position[6]+'</div>';
			text1 += '<div id="content" style="min-width:100px; min-height:35px; text-align:center;"><img src="'+position[5]+'" style="width:114px;" ><h1 id="firstHeading"  class="firstHeading" >'+position[0]+'</h1>';
			text1 += '</div>';
			text1 += '<a href="'+position[4]+'" target="_blank"><div style="float:right; width:100px; height:30px; line-height:30px; border:1px solid black; text-align:center;" >'+panel_detail+'</div></a>';
		  }else{
			var text1 = '<div>'+position[6]+'</div>';
			text1 += '<div id="content" style="min-width:100px; min-height:20px; text-align:center;"><img src="'+position[5]+'" style="width:114px;" ><h1 id="firstHeading"  class="firstHeading" >'+position[0]+'</h1></div>';
		  }
		}else{
		  if(position[4]){
			var text1 = '<div>'+position[6]+'</div>';
			text1 += '<div id="content" style="min-width:100px; min-height:35px; text-align:center;"><h1 id="firstHeading"  class="firstHeading"  >'+position[0]+'</h1>';
			text1 += '</div>';
			text1 += '<a href="'+position[4]+'" target="_blank"><div style="float:right; width:100px; height:30px; line-height:30px; border:1px solid black; text-align:center;">'+panel_detail+'</div></a>';
		  }else{
			var text1 = '<div>'+position[6]+'</div>';
			text1 = '<div id="content" style="min-width:100px; min-height:20px; text-align:center;"><h1 id="firstHeading"  class="firstHeading"  >'+position[0]+'</h1></div>';
		  }   
		}

	}else{

		if(position[5]){
		  if(position[4]){


			var text1 = '<div style="font-size: 13px; text-align: center; color: #b8b8b8; margin: 5px 0 10px 0; ">'+position[6]+'</div>';
			text1 += '<div id="content" style="min-width:100px; min-height:35px; text-align:center;"><h1 id="firstHeading"  class="firstHeading" style="font-size: 16px; color: #333; width: 150px;  margin-bottom: 10px;">'+position[0]+'</h1>';
			text1 += '</div>';
			text1 += '<a href="'+position[4]+'" target="_blank"><div style="border:1px solid black; text-align:center; border-radius: 3px; padding: 2px 0px; font-weight: 600; margin-bottom: 5px;" >'+panel_detail+'</div></a>';


		  }else{
			var text1 = '<div>'+position[6]+'</div>';
			text1 += '<div id="content" style="min-width:100px; min-height:20px; text-align:center;"><img src="'+position[5]+'" style="width:114px;" ><h1 id="firstHeading"  class="firstHeading" >'+position[0]+'</h1></div>';
		  }
		}else{
		  if(position[4]){


			var text1 = '<div style="font-size: 13px; text-align: center; color: #b8b8b8; margin: 5px 0 10px 0; ">'+position[6]+'</div>';
			text1 += '<div id="content" style="min-width:100px; min-height:35px; text-align:center;"><h1 id="firstHeading"  class="firstHeading" style="font-size: 16px; color: #333; width: 150px;  margin-bottom: 10px;">'+position[0]+'</h1>';
			text1 += '</div>';
			text1 += '<a href="'+position[4]+'" target="_blank"><div style="border:1px solid black; text-align:center; border-radius: 3px; padding: 2px 0px; font-weight: 600; margin-bottom: 5px;" >'+panel_detail+'</div></a>';


		  }else{
			var text1 = '<div>'+position[6]+'</div>';
			text1 = '<div id="content" style="min-width:100px; min-height:20px; text-align:center;"><h1 id="firstHeading"  class="firstHeading"  >'+position[0]+'</h1></div>';
		  }   
		}


	}

    labels = "";
    if($('.map_info').attr('valTable') == "cardbenefit"){
      labels = "";
    }else{
      labels = (i + 1).toString();
    }   


    //$('.info_num_'+i).text(i+1);
      var marker = new google.maps.Marker({
        position: { lat: position[1], lng: position[2] },
        map: map,
        icon: image,
        title: position[0],
        label: labels,
        animation: google.maps.Animation.DROP,
        zIndex: position[3],
        html: text1
      });
      

      //marker[i] = marker;

      if(!window.location.href.match('cardbenefit') || !window.location.href.match('cardbenefitarea')){
        google.maps.event.addListener(marker,'click', function() {
          infowindow.setContent(this.html);
          infowindow.open(map, this); 
          th = this;
        });
      }
  }
}


function setMarkers_area_init(map) {   // 마커 만드는 함수
  var size_h = 33;
  var size_w = 27;
  var size_p = 0;
  var pinurl = "/skin/board/map/img/pin_b.png";
   size_w = 40;
   var size_p = -6;
  if($('.map_info').attr('valTable') == "cardbenefit"){
   pinurl = "/skin/board/map/img/pin1.png";
   size_h = 36;
   size_p = 0;
   size_w = 27;
  }
  var image = {
    url: pinurl,
    // This marker is 20 pixels wide by 32 pixels high.
  //size: new google.maps.Size(71, 71),
  origin: new google.maps.Point(size_p, 0),
  anchor: new google.maps.Point(17, 34),
  scaledSize: new google.maps.Size(size_w, size_h)
  };
  // Shapes define the clickable region of the icon. The type defines an HTML
  // <area> element 'poly' which traces out a polygon as a series of X,Y points.
  // The final coordinate closes the poly by connecting to the first coordinate.


  

  for (var i = 0; i < postions.length; i++) {

    var position = postions[i];
    var contentString = position[0];
    infowindow = new google.maps.InfoWindow();


    if( $('.map_info').attr('valTable') != "tourinfo" ){
      if( position[4].match("/img/map/") ){
          position[4] = position[4]+t_lang+".jpg";
      }
    }


	var panel_detail = "";

	if(t_lang == 'ko'){
		panel_detail = "자세히보기";
	}else if(t_lang == 'en'){
		panel_detail = "Check for details";
	}else if(t_lang == 'ja'){
		panel_detail = "詳細を見る";
	}else if(t_lang == 'ch1'){
		panel_detail = "查看详情";
	}else if(t_lang == 'ch2'){
		panel_detail = "查看詳情";
	}


	if( !position[6] ){

		if(position[5]){
		  if(position[4]){
			var text1 = '<div>'+position[6]+'</div>';
			text1 += '<div id="content" style="min-width:100px; min-height:35px; text-align:center;"><img src="'+position[5]+'" style="width:114px;" ><h1 id="firstHeading"  class="firstHeading" >'+position[0]+'</h1>';
			text1 += '</div>';
			text1 += '<a href="'+position[4]+'" target="_blank"><div style="float:right; width:100px; height:30px; line-height:30px; border:1px solid black; text-align:center;" >'+panel_detail+'</div></a>';
		  }else{
			var text1 = '<div>'+position[6]+'</div>';
			text1 += '<div id="content" style="min-width:100px; min-height:20px; text-align:center;"><img src="'+position[5]+'" style="width:114px;" ><h1 id="firstHeading"  class="firstHeading" >'+position[0]+'</h1></div>';
		  }
		}else{
		  if(position[4]){
			var text1 = '<div>'+position[6]+'</div>';
			text1 += '<div id="content" style="min-width:100px; min-height:35px; text-align:center;"><h1 id="firstHeading"  class="firstHeading"  >'+position[0]+'</h1>';
			text1 += '</div>';
			text1 += '<a href="'+position[4]+'" target="_blank"><div style="float:right; width:100px; height:30px; line-height:30px; border:1px solid black; text-align:center;">'+panel_detail+'</div></a>';
		  }else{
			var text1 = '<div>'+position[6]+'</div>';
			text1 = '<div id="content" style="min-width:100px; min-height:20px; text-align:center;"><h1 id="firstHeading"  class="firstHeading"  >'+position[0]+'</h1></div>';
		  }   
		}

	}else{

		if(position[5]){
		  if(position[4]){


			var text1 = '<div style="font-size: 13px; text-align: center; color: #b8b8b8; margin: 5px 0 10px 0;">'+position[6]+'</div>';
			text1 += '<div id="content" style="min-height:30px; text-align:center;"><h1 id="firstHeading"  class="firstHeading" style="font-size: 16px; color: #333; width: 150px; margin-bottom: 10px;">'+position[0]+'</h1>';
			text1 += '</div>';
			text1 += '<a href="'+position[4]+'" target="_blank"><div style="border:1px solid black; text-align:center; border-radius: 3px; padding: 2px 0px; font-weight: 600; margin-bottom: 5px;" >'+panel_detail+'</div></a>';


		  }else{
			var text1 = '<div>'+position[6]+'</div>';
			text1 += '<div id="content" style="min-width:100px; min-height:20px; text-align:center;"><img src="'+position[5]+'" style="width:114px;" ><h1 id="firstHeading"  class="firstHeading" >'+position[0]+'</h1></div>';
		  }
		}else{
		  if(position[4]){


			var text1 = '<div style="font-size: 13px; text-align: center; color: #b8b8b8; margin: 5px 0 10px 0;">'+position[6]+'</div>';
			text1 += '<div id="content" style="min-height:30px; text-align:center;"><h1 id="firstHeading"  class="firstHeading" style="font-size: 16px; color: #333; width: 150px; margin-bottom: 10px;">'+position[0]+'</h1>';
			text1 += '</div>';
			text1 += '<a href="'+position[4]+'" target="_blank"><div style="border:1px solid black; text-align:center; border-radius: 3px; padding: 2px 0px; font-weight: 600; margin-bottom: 5px;" >'+panel_detail+'</div></a>';


		  }else{
			var text1 = '<div>'+position[6]+'</div>';
			text1 = '<div id="content" style="min-width:100px; min-height:20px; text-align:center;"><h1 id="firstHeading"  class="firstHeading"  >'+position[0]+'</h1></div>';
		  }   
		}


	}

    labels = "";
    if($('.map_info').attr('valTable') == "cardbenefit"){
      labels = "";
    }else{
      labels = (i + 1).toString();
    }   


    //$('.info_num_'+i).text(i+1);
      var marker = new google.maps.Marker({
        position: { lat: position[1], lng: position[2] },
        map: map,
        icon: image,
        title: position[0],
        label: labels,
        animation: google.maps.Animation.DROP,
        zIndex: position[3],
        html: text1
      });
      

      //marker[i] = marker;

      if(!window.location.href.match('cardbenefit') || !window.location.href.match('cardbenefitarea')){
        google.maps.event.addListener(marker,'click', function() {
          infowindow.setContent(this.html);
          infowindow.open(map, this); 
          th = this;
        });
      }
  }
}
// var postions = new Array();
// var GcenterLat = 0;
// var GcenterLng = 0;
// var map;
// function initMap() {  //시작하자마자 실행되는 함수
//   map = new google.maps.Map(document.getElementById('map'), {
//     zoom: 10,
//     center: { lat: GcenterLat, lng: GcenterLng }
//   });
//   setMarkers(map);
// }

// function resetPositon(test) {
//   map.setZoom(16);
//   map.setCenter(test);
// }

// function setMarkers(map) {   // 마커 만드는 함수
//   var image = {
//     url: '/skin/board/map/img/marker.png',
//     // This marker is 20 pixels wide by 32 pixels high.
//     //size: new google.maps.Size(40, 64),
//     // The origin for this image is (0, 0).
//     // origin: new google.maps.Point(0, -20),
//     // The anchor for this image is the base of the flagpole at (0, 32).
//     // anchor: new google.maps.Point(0, 32)
//   };
//   // Shapes define the clickable region of the icon. The type defines an HTML
//   // <area> element 'poly' which traces out a polygon as a series of X,Y points.
//   // The final coordinate closes the poly by connecting to the first coordinate.
//   var shape = {
//     coords: [1, 1, 1, 20, 18, 20, 18, 1],
//     type: 'poly'
//   };
//   for (var i = 0; i < postions.length; i++) {
//     var position = postions[i];
//     //$('.info_num_'+i).text(i+1);
//     var marker = new google.maps.Marker({
//       position: { lat: position[1], lng: position[2] },
//       map: map,
//       icon: image,
//       title: position[0],
//       label: (i + 1).toString(),
//       zIndex: position[3]
//     });
//   }
// }
 



$(function () {




  var lang = $('.lang').attr('valLang');

  //if(lang){
    if(lang == "ko_KR"){
      t_lang = "ko";
    }else if(lang == "en_US"){
      t_lang = "en";
    }else if(lang == "zh_CN"){
      t_lang = "ch1";
    }else if(lang == "zh_TW"){
      t_lang = "ch2";
    }else if(lang == "ja_JP"){
      t_lang = "ja";
    }else{
      t_lang = "ko";
    }
  //}


  var centerLat = 0;
  var centerLng = 0;
  //var cnt = 0;

  $.fn.setPositions = function () {

    $('.map_info').each(function (index) {
      postions[index] = new Array();

      if(lang){
        postions[index][0] = $(this).attr('valInfoName' + t_lang);
      }else{
        postions[index][0] = $(this).attr('valInfoName' + lang); 
      }


      //alert($(this).attr('valInfoName' + t_lang));
      postions[index][1] = parseFloat($(this).attr('valInfoLat'));
      postions[index][2] = parseFloat($(this).attr('valInfoLng'));
      postions[index][3] = parseInt($(this).attr('valId'));
      postions[index][4] = $(this).attr('valLink');
      postions[index][5] = $(this).attr('valSrc');
	
		if( $(this).attr('vallocal1') ){
			postions[index][6] = $(this).attr('vallocal1');
		}else{
			postions[index][6] = "";
		}

	  

      // centerLat += parseFloat($(this).attr('valInfoLat'));
      // centerLng += parseFloat($(this).attr('valInfoLng'));

      if(index == 0){
        GcenterLat = parseFloat($(this).attr('valInfoLat'));
        GcenterLng = parseFloat($(this).attr('valInfoLng'));
      }

     // cnt++;
    })

   // GcenterLat = centerLat / cnt;
   // GcenterLng = centerLng / cnt;

  }


  // $( function() {    //텝 
  //     $( "#tabs" ).tabs();
  // } );

  $.fn.setPositions();
 // setMarkers(map);
  //resetPositon({ lat: GcenterLat, lng: GcenterLng })
  function runEffect() {
    // get effect type from
    var selectedEffect = "blind";

    //  var selectedEffect = $( "#effectTypes" ).val();

    // Most effect types need no options passed by default
    var options = {};
    // some effects have required parameters
    if (selectedEffect === "scale") {
      options = { percent: 50 };
    } else if (selectedEffect === "size") {
      options = { to: { width: 200, height: 60 } };
    }

    // Run the effect
    $("#effect").toggle(selectedEffect, options, 500);
  };

  //callback function to bring a hidden box back
  function callback() {
    setTimeout(function () {
      $("#effect:visible").removeAttr("style").fadeOut();
      //$(".toggler").css('border-top','0px solid #666');
      //$(".toggler").css('border-bottom','0px solid #666');
    });
  };

  // Set effect from select menu value
  $("#button").on("click", function () {
    runEffect();
  });

  $("#effect").hide();

  $('.show-close').click(function () {
    callback();
  })

  $('.tab1-option-toggler').css('left', '1357px');
  //$('.select-btn').css('left','1728px');


  $('.return-ck').click(function () {

    $('.sub21_popCheck input').removeAttr('checked');
  })

  $('.ui-icon-close').click(function () {
    //$(".toggler").css('border-top','0px solid #666');
    //$(".toggler").css('border-bottom','0px solid #666');
  })

  $('.service_val').each(function (index) {
    $th = $(this);
    if($(this).attr('val')){
      $len = $(this).attr('val').split(',').length - 1;
      $str = "<ul>";
      $(this).attr('val').split(',').forEach(function (element, index) {
        $str += "<li><img src='/" + $('.service_img_src_' + element).attr('val') + "'></li>";
        if ($len == index) {
          $str += "</ul>";
        }
      });
      $th.append($str);
    }
  })

  $('.service_val2').each(function (index) {
    $th = $(this);
    if($(this).attr('val')){
      $len = $(this).attr('val').split(',').length - 1;
      $(this).attr('val').split(',').forEach(function (element, index) {
        $str += "<li><img src='/" + $('.service_img_src_' + element).attr('val') + "'></li>";
        if ($len == index) {
        }
      });
      $th.append($str);
    }
  })

  $('.info_focus').click(function () {
    var lats = parseFloat($(this).attr('valInfoLat'))//; + 0.00031;
    var lngs = parseFloat($(this).attr('valInfoLng'))//; + 0.00001;
    resetPositon({ lat: lats, lng:lngs }  ,  $(this).attr('valInfoName' + t_lang) ,  parseInt($(this).attr('valCnt')) , $(this).attr('valLink')  );
  })


  $('.info_focus_area_m').click(function () {
    var lats = parseFloat($(this).attr('valInfoLat')) + 0.00031;
    var lngs = parseFloat($(this).attr('valInfoLng')) + 0.00001;
    resetPositon_area_m({ lat: lats, lng:lngs }  ,  $(this).attr('valInfoName' + t_lang) ,  parseInt($(this).attr('valCnt')) , $(this).attr('valLink'), $(this).attr('valCnt')  );
  })

  $('.info_focus_area').click(function () {
    var lats = parseFloat($(this).attr('valInfoLat')) + 0.00031;
    var lngs = parseFloat($(this).attr('valInfoLng')) + 0.00001;
    resetPositon_area({ lat: lats, lng:lngs }  ,  $(this).attr('valInfoName' + t_lang) ,  parseInt($(this).attr('valCnt')) , $(this).attr('valLink'), $(this).attr('valCnt')  );
  })

  $('.info_focus5').click(function () {
    var lats = parseFloat($(this).attr('valInfoLat')) + 0.00031;
    var lngs = parseFloat($(this).attr('valInfoLng')) + 0.00001;

  setTimeout(function(){ 
    resetPositon2({ lat: lats, lng:lngs }  ,  $(this).attr('valInfoName' + t_lang) ,  parseInt($(this).attr('valCnt')) , $(this).attr('valLink')  );
  }, 500);

    
  })



  $('.info_option').each(function () {
    var option = $(this).attr('val');
    $('.option_ck').each(function () {
      var option1 = $(this).attr('value');
      var op = $(this);
      if (option == option1) {
        op.attr('checked', 'checked');
      }
    })
  })



  $('.page').click(function () {
    var url = $('.url').attr('valUrl');
    var true_url = url.split('&currentPage');
    if ($(this).attr('id') == "first") {
      location.href = true_url[0] + '&currentPage=1';
    } else if ($(this).attr('id') == "last") {
      var last = $('.map_info').attr('valTotalpage');
      location.href = true_url[0] + '&currentPage=' + last;
    } else {
      location.href = true_url[0] + '&currentPage=' + $(this).attr('val');
    }
  })


  $('#Address_D').change(function () {
    jQuery.ajax({
      type: "POST",
      url: "../skin/board/map/juso/2.php",
      data: "Name=" + $(this).val(),
      success: function (msg) {
        $('#Address_S').html(msg);
      },
    });
  });

 $('.search_btn_address').click(function(){
   if($('.Address_D').val() == ""){
      alert('검색 조건을 선택하세요.');
      return false;
   }else{
      $('#tab2_word').attr('value',$('.Address_D').val());
      $('#tab2_word1').attr('value',$('.Address_S').val());
      return true;
   }
   
 })


  $('#tab-1').click(function () {
    location.href = "/map/map_shop.php?lang=" + $('.lang').attr('valLang');
  })

  $('#tab-2').click(function () {
    location.href = "/map/map_local.php?lang=" + $('.lang').attr('valLang');
  })



  $('.search-btn').click(function () {
    $('#word').attr('value', $('.Address_D').val() + ' ' + $('.Address_S').val());
  })

  $('#search_btn').click(function () {
    $('.option_ck').each(function(){
        //$(this).remove();
    })
  })

  // $('.newimg').each(function () { new
  //   if($(this).attr('valNewimg') != '0'){
  //     //$('#'+$(this).attr('valName')).append('<img src="new">');
  //     $('#'+$(this).attr('valName')).append(' <span style="color:red; font-size:8px;">&nbsp;NEW</span>');
  //   }

  // })


$('#btnPrint').click(function(){
  $('.tabContents1').printThis({
    debug: false,
    importCss: true,
    printContainer:true,
    loadCSS: "/tmpl/theme_basic/css/sub.css",
    pageTitle:"",
    removeInline:false 
  })
})

$('.popBtn2').click(function(){
  $('.map_search').submit();
  //$('.Address_D').remove();
  //$('.Address_S').remove();
  //$('#word').remove();  
})

$('.search21_btn').click(function(){
    var str = "";
    var ck = 0;
   $('.option_ck').each(function(index){
       if($(this).is(':checked')){
            if(ck == 0){
                str = $(this).attr('value');
                ck++;
            }else{
                str += ","+$(this).attr('value');
            }
       }
   })
   $('.option_value').attr('value',str);
   $('.search_check').submit();
})



        $('.option_ck').click(function(){


        if( $(this).is(':checked') ){

          var str = "";
          var ck = 0;
          $('.option_ck').each(function(index){
              if($(this).is(':checked')){
                      if(ck == 0){
                          str = $(this).attr('value');
                          ck++;
                      }else{
                          str += ","+$(this).attr('value');
                      }
              }
          })
            $('.option_value').attr('value',str);
            $('.search_check').submit();
            
        }




        })



    $('.Address_S').change(function(){
        var str = "";
        var ck = 0;
        $('.option_ck').each(function(index){
            if($(this).is(':checked')){
                    if(ck == 0){
                        str = $(this).attr('value');
                        ck++;
                    }else{
                        str += ","+$(this).attr('value');
                    }
            }
        })
       $('.option_value').attr('value',str);
       $('.search_check').submit();
    })


	var select = $("select#color");
    
	var infos = $('.infoarea').attr('valinfo');

    select.change(function(){
		var classname = $(this).attr('class');
		
        var select_name = $(this).children("option:selected").text();
        $(this).siblings("label").text(select_name);
		
		jQuery.ajax({
			type: "POST",
			url: "../skin/board/map/juso/2.php",
			data: "Name=" + $('.Address_D').val() + "&word1="+$('.Address_S').val() + "&info="+infos,
			success: function (msg) {
				//$('.Address_S').html(msg);
				if("Address_D" == classname){
					$('#tab2_word').attr('value',$('.'+classname).val());
				}else{
					$('#tab2_word1').attr('value',$('.'+classname).val());
				}
				
			},
		});	
    });






});







