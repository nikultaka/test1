<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <script src="http://fabricjs.com/lib/fabric.js"></script>
  <script type='text/javascript' src='http://cdn.scaledrone.com/scaledrone.min.js'></script>
  <script src="script.js"></script>
  <style>
  	
  </style>	
</head>
<body> 

	<video id="localVideo" width="300" style="position: absolute;left: 168px;top:16px;height: auto;max-height: 187px;" autoplay muted></video>
  	<video id="remoteVideo" style="display: none"></video> 
	<canvas id="c" style="border: 1px solid black;"></canvas>  	   
	
  	<script>
  	(function() {	

	  		var canvas = this.__canvas = new fabric.Canvas('c',{ selection: true });

	  		var rect1 = { left: 160, top: 0, stroke:"#FFC000",strokeWidth:3,fill:'',width: 300, height: 200, id:"user_one" };
	  		var rect2 = { left: 920, top: 0,fill: 'white', width: 300, height: 200 , id:"user_two",lockMovementX:true,lockMovementY:true,stroke:"#305496",strokeWidth:3 };
	  		var rect3 = { left: 160, top: 390, fill: 'white', width: 300, height: 200 , id:"user_three",lockMovementX:true,lockMovementY:true,stroke:"#A9C099",strokeWidth:3};
	  		var rect4 = { left: 920, top: 390, fill: 'white', width: 300, height: 200 , id:"user_four",lockMovementX:true,lockMovementY:true,stroke:"#DE7E7E",strokeWidth:3,};  

	  		var rect1obj = new fabric.Rect( rect1 )
	  		var rect2obj = new fabric.Rect( rect2 ) 
	  		var rect3obj = new fabric.Rect( rect3 )
	  		var rect4obj = new fabric.Rect( rect4 )



	  		canvas.add(rect1obj);   
	  		canvas.add(rect2obj);       
	  		canvas.add(rect3obj);
	  		canvas.add(rect4obj);
	  		
	  		

			var objectsLength = [];
	  		var objs = canvas.getObjects().map(function(o) {
	  			console.log(o);
	  			objectsLength.push({left:o.left,width:o.width,top:o.top,height:o.height,}); 
			  	return o.set('active', true);
			});   

			canvas.forEachObject(function(o){ o.hasBorders = o.hasControls = o.hasRotatingPoint = false; }); 
 
			fabric.Image.fromURL('https://img.icons8.com/windows/2x/macos-close.png', function(myImg) {
				myImg.id = "bullet";
			 	canvas.add(myImg); 
			 	canvas.forEachObject(function(o){ o.hasBorders = o.hasControls = false; }); 
			});      

			canvas.on({
				/*'object:scaling': function(e) {
			    	var obj = e.target
					obj.set({width: obj.width* obj.scaleX, height: obj.height* e.target.scaleY});
					obj.scaleX = obj.scaleY = 1;
					obj.setCoords();
			    },*/  
			    'object:moving': function(e) {
			    	//console.log(e.target.canvas);	  
			    },
			    'object:modified': function(options) {

			      	
			    },
			    'object:moved': function(e) {          
    				console.log(e.target);
    				//console.log(e.target.left,e.target.top);
    				//console.log(objectsLength);

    				var movedClientX = e.target.left;	
					var movedClientY = e.target.top;
					
					var is_element_exist = 0;
					for(var n=0; n<objectsLength.length; n++) {
						var objectLeft =  objectsLength[n].left;
						var objectWidth = objectsLength[n].width;
						var objectTop = objectsLength[n].top;
						var objectHeight = objectsLength[n].height;
						//var cacheTranslationX = objectsLength[n].cacheTranslationX;
						//var cacheTranslationY = objectsLength[n].cacheTranslationY;

						var totlaHeightCompare = objectHeight+objectTop;
						var totlaWidthCompare = objectWidth+objectLeft;

						if( (movedClientX>=objectLeft && movedClientX<=totlaWidthCompare) && (movedClientY>=objectTop && movedClientY<=totlaHeightCompare)  ) {

							var centerX = objectLeft + (objectWidth/2.5);
							var centerY = objectTop + (objectHeight/2.5);
							var imageURL = 'https://img.icons8.com/windows/2x/macos-close.png';
							fabric.Image.fromURL(imageURL, function(myImg) {
							 	canvas.add(myImg.set({left: centerX, top: centerY})); 
							 	canvas.forEachObject(function(o){ o.hasBorders = o.hasControls = false; }); 
							});
							is_element_exist = 1;
						}    
					}

					if(is_element_exist == 0) {    
						canvas.getObjects().map(function(o) {
							if(o.id == "bullet") {
						        o.set({
						          left: 10,
						          top: 10
						        });
						        o.setCoords({
						          left: 10,
						          top: 10
						        });
							}
						});
					}
					

			    },
			 });

			
			/************************************/	

			//canvas.renderAll();

			window.addEventListener('resize', resizeCanvas, false);

			
			  function resizeCanvas() {
			  		var innerWidth = window.innerWidth - 50;

			  		console.log(window.innerWidth);
			  		console.log(window.innerHeight);


				    canvas.setHeight(window.innerHeight);
				    canvas.setWidth(innerWidth);



				    var originalWidth = 1300;
				    var originalHeight = 980;

				    canvas.setZoom(innerWidth/originalWidth);
					//canvas.setWidth(originalWidth * canvas.getZoom());
					//canvas.setHeight(originalHeight * canvas.getZoom());

				    //canvas.calcOffset();
				    canvas.renderAll(); //innerWidth
				    console.log("zoom:"+canvas.getZoom());
			  }

			  // resize on init
			  resizeCanvas();
	  			
	})();  

  	</script>	
</body>
</html>       
