<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>jquery.pep dropppable advanced</title>

		<!-- Load jQuery. -->
		<script src="script/jquery-2.0.2.js"></script>

		<!-- Load lib and tests. -->
		<script src="script/jquery.pep.js"></script>

		<script type="text/javascript">
			var currentPage = 1;
			var jsonData;
			$(document).ready(function() {
				
				getJSONmod('json/v7.json.php');
				
				$('.pep').pep({
					droppable: ".droppable",
					overlapFunction: false,
					useCSSTranslation: false,
					start: function(ev, obj) {
						obj.noCenter = false;
					},
					drag: function(ev, obj) {
						var vel = obj.velocity();
						var rot = (vel.x)/5;
						rotate(obj.$el, rot)         
					},
					stop: function(ev, obj) {
						handleCentering(ev, obj);
						rotate(obj.$el, 0);
						//for (var key in obj.$container) {
						//	console.log(key);
						//}
						//console.log(obj.$container);
					},
					rest: handleCentering
				});

				function handleCentering(ev, obj) {
					if ( obj.activeDropRegions.length > 0 ) { 
						centerWithin(obj);
					}   
				}

				function centerWithin(obj) {
					var $parent = obj.activeDropRegions[0];
					var pTop    = $parent.offset().top;
					var pLeft   = $parent.offset().left;
					var pHeight = $parent.outerHeight();
					var pWidth  = $parent.outerWidth();

					var oTop    = obj.$el.offset().top;
					var oLeft   = obj.$el.offset().left;
					var oHeight = obj.$el.outerHeight();
					var oWidth  = obj.$el.outerWidth();

					var cTop    = pTop + (pHeight/2);
					var cLeft   = pLeft + (pWidth/2);

					
					if ( !obj.noCenter ) {
						//console.log("drop2 "+ obj);
						console.log("on "+ $parent.context.innerHTML);
						//for (var key in obj.$el   ) {
						//	console.log(key);
						//}
						
						if ( !obj.shouldUseCSSTranslation() ) {
							var moveTop = cTop - (oHeight/2);
							var moveLeft = cLeft - (oWidth/2);
							obj.$el.animate({ top: moveTop, left: moveLeft }, 50);
						} else {
							var moveTop   = (cTop - oTop) - oHeight/2;
							var moveLeft  = (cLeft - oLeft) - oWidth/2;

							console.log(oTop, oLeft);
							obj.moveToUsingTransforms( moveTop, moveLeft );
						}

						obj.noCenter = true;
						return;
					}

					obj.noCenter = false;
				}

				function rotate($obj, deg) {
					$obj.css({ 
						"-webkit-transform": "rotate("+ deg +"deg)",
						"-moz-transform": "rotate("+ deg +"deg)",
						"-ms-transform": "rotate("+ deg +"deg)",
						"-o-transform": "rotate("+ deg +"deg)",
						"transform": "rotate("+ deg +"deg)" 
					}); 
				}
				
				function getJSONmod(filename) {
					//alert("call json:" + filename);
					
					jQuery.ajax({
						url: filename,
						type: 'GET',
						dataType: 'json',
						//dataCharset: 'json',
						success: function (data) {
							//alert(data.mainTitle);
							jsonData = data;
							$("#main-title").html(data.mainTitle);
							constructView(currentPage);
						},
						error: function (textStatus) {
							alert("ferror"+textStatus);
						}
					});
					
					/*
					$.getJSON(filename, function(data) {
						var items = [];
						var content = $.parseJSON(data);
						alert(content.mainTitle);
						$("#main-title").html(content.mainTitle);
					});
					*/
				}
			});
			
			function constructView(page) {
				console.log("page "+ (page));
				$("#page-title").html(jsonData.pages[page-1].title);
				$(".pep.qz1").css({"top":"20%", "left":"10%"});
				$(".pep.qz1").html(jsonData.pages[page-1].content.option[0]);
				$(".pep.qz2").css({"top":"20%", "left":"30%"});
				$(".pep.qz2").html(jsonData.pages[page-1].content.option[1]);
				$(".pep.qz3").css({"top":"20%", "left":"50%"});
				$(".pep.qz3").html(jsonData.pages[page-1].content.option[2]);
				$(".pep.qz4").css({"top":"20%", "left":"70%"});
				$(".pep.qz4").html(jsonData.pages[page-1].content.option[3]);
				$(".droppable.hz1").html(jsonData.pages[page-1].content.hold[0]);
				$(".droppable.hz2").html(jsonData.pages[page-1].content.hold[1]);
				$(".droppable.hz3").html(jsonData.pages[page-1].content.hold[2]);
				$(".droppable.hz4").html(jsonData.pages[page-1].content.hold[3]);
				
			}
			
			function nextPage() {
				if(currentPage == jsonData.pages.length)
					return;
				//alert("nextPage"+currentPage+":"+jsonData.pages.length);
				constructView(++currentPage);
			}
			
			function previousPage() {
				if(currentPage !== 1) {
					//alert("previousPage");
					constructView(--currentPage);
				}
			}

			function logOnMouseUp(obj) {
				console.log("drop "+ obj.innerHTML);
			}

			function logOnMouseDown(obj) {
				console.log("choose "+ obj.innerHTML);
			}
			
		</script>

		<style type="text/css">
			.pep{
				width: 100px;
				height: 100px;
				background: blue;
				z-index: 10;
				color: White;
				/*margin: 10px 2%;*/
				cursor: move;
				text-align: center;
				vertical-align: middle;
				-moz-border-radius: 1em;
				-webkit-border-radius: 1em;
				border-radius: 1em;
				position: absolute;
			}
			
			.pep.qz1 { top: 20%; left: 10%;}
			.pep.qz2 { top: 20%; left: 30%;}
			.pep.qz3 { top: 20%; left: 50%;}
			.pep.qz4 { top: 20%; left: 70%;}
			
			.droppable{   width: 120px; height: 120px; 
				position: absolute; 
				border: 5px solid #ccc; 
				z-index: -1;
			}

			.droppable.hz1 { bottom: 20%; left: 10%;}
			.droppable.hz2 { bottom: 20%; left: 30%;}
			.droppable.hz3 { bottom: 20%; left: 50%;}
			.droppable.hz4 { bottom: 20%; left: 70%;}
			.pep-dpa{ border-color: blue; }

			#nev-previousPage:hover {
				cursor: pointer;
				background-color: #BBBBFF;
			}

			#nev-nextPage:hover {
				cursor: pointer;
				background-color: #BBBBFF;
			}
		</style>


	</head>


	<body>
		<div class="pep qz1" onmousedown="logOnMouseDown(this)" onmouseup="logOnMouseUp(this)">drag me 1</div>
		<div class="pep qz2" onmousedown="logOnMouseDown(this)" onmouseup="logOnMouseUp(this)">drag me 2</div>
		<div class="pep qz3" onmousedown="logOnMouseDown(this)" onmouseup="logOnMouseUp(this)">drag me 3</div>
		<div class="pep qz4" onmousedown="logOnMouseDown(this)" onmouseup="logOnMouseUp(this)">drag me 4</div>
		<div class="droppable hz1"></div>
		<div class="droppable hz2"></div>
		<div class="droppable hz3"></div>
		<div class="droppable hz4"></div>
		<div id="main-title">...</div>
		<div id="page-title">..</div>
		<div>
			<span id="nev-previousPage" onclick="previousPage()">&lt;&lt;&lt; previous page</span>
			<span id="nev-nextPage" onclick="nextPage()">next page &gt;&gt;&gt; </span>
		</div>
		<div>
			v7 change log:<br/>
			1. show collected activities in java script console<br/>
			2. change json constract from static json to dynamic php<br/>
		</div>
		
		
	</body>


</html>