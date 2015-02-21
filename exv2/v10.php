<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">

    <link rel="stylesheet" type="text/css" href="css/main.css">

    <title>jquery.pep dropppable advanced</title>

    <!-- Load jQuery. -->
    <script src="script/jquery-2.0.2.js"></script>

    <!-- Load lib and tests. -->
    <script src="script/jquery.pep.js"></script>

    <script type="text/javascript">
      var currentPage = 1;
      var jsonData;
      var studentName = "";
      var sequenceNumber = 0;
      var accessId = (new Date()).valueOf().toString();
      $(document).ready(function() {

        getJSONmod('json/v10.json.php');

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
              //$("#main-title").html(data.mainTitle);
              constructView(currentPage);
            },
            error: function (textStatus) {
              alert("ferror"+textStatus);
            }
          });

        }
      });

      function activatePep() {
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
      }

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
          // track
          track("on",$parent.context.innerHTML);

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

      function constructView(page) {
        console.log("page "+ (page));
        clearView();
        $("#nev-page").html(" pages "+page+" ");
        $("#title").html(jsonData.pages[page-1].title);
        $("#question").html(jsonData.pages[page-1].question);

        if ( jsonData.pages[page-1].question_type == "0" ) {
          makeInput(jsonData.pages[page-1]);
          $("#nev-area").hide();
        }
        else if ( jsonData.pages[page-1].question_type == "1" ) {
          $("#nev-area").show();
          makePep(jsonData.pages[page-1].content);
          makeDrop(jsonData.pages[page-1].content);
        }

      }

      function clearView() {
        //$("#pepZone").html("");
        //$("#dropZone").html("");
        $("#inputZone").html("");
      }

      function setStudentName(obj) {
        studentName = obj.value;
        console.log("studentName: "+ studentName);
        accessId = hashCode(studentName+accessId);
      }

      function makeInput(content) {
        var output="";
        output += "<input type='text' onkeyup='setStudentName(this)' placeholder='"+content.placeholder+"' class='input-center1' autofocus>";
        output += "<button onclick='nextPage()' class='input-center2'>Ready to GO</button>";
        $("#inputZone").html(output);
      }

      function makePep(content) {
        var output="";

        // set data
        for (i=0; i<content.option.length; i++) {
          output += "<div class='pep qz"+(i+1)+"'";
          output += " onmousedown='logOnMouseDown(this)' ";
          output += " ontouchstart='logOnMouseDown(this)' ";
          output += " onmouseup='logOnMouseUp(this)' ";
          output += " ontouchend='logOnMouseUp(this)'>";
          output += "drag me "+(i+1)+"</div>";
        }
        $("#pepZone").html(output);

        // set css
        var margin = 100/(content.option.length+1);
        for (i=0; i<content.option.length; i++) {
          if ( content.option[i]=="A" ||
          content.option[i]=="E" ||
          content.option[i]=="I" ||
          content.option[i]=="O" ||
          content.option[i]=="U" ) {
            $(".pep.qz"+(i+1)).css({"top":"40%", "left":""+(i*margin+10)+"%", "border":"1", "padding":"10px", "background":"#4CAF50"});
          } else {
            $(".pep.qz"+(i+1)).css({"top":"40%", "left":""+(i*margin+10)+"%", "border":"1", "padding":"10px"});
          }
          $(".pep.qz"+(i+1)).html(content.option[i]);
        }

        activatePep();
      }

      function makeDrop(content) {
        var output="";
        // set data
        for (i=0; i<content.option.length; i++) {
          output += "<div class='droppable hz"+(i+1)+"'></div>";
        }
        $("#dropZone").html(output);

        // set css
        var margin = 100/(content.option.length+1);
        for (i=0; i<content.option.length; i++) {
          $(".droppable.hz"+(i+1)).css({"bottom":"10%", "left":""+(i*margin+10)+"%", "border":"1"});
          $(".droppable.hz"+(i+1)).html(content.hold[i]);
        }
      }

      function nextPage() {
        if (studentName=="") {
          alert("Need student name to continue");
          return;
        }
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

        // track
        track("drop",obj.innerHTML);
      }

      function logOnMouseDown(obj) {
        console.log("choose "+ obj.innerHTML);

        // track
        track("choose",obj.innerHTML);
      }

      function track(action, detail) {
        var now = new Date();
        now = now.getFullYear() + '-' +
          ('00' + (now.getMonth()+1)).slice(-2) + '-' +
          ('00' + now.getDate()).slice(-2) + ' ' +
          ('00' + now.getHours()).slice(-2) + ':' +
          ('00' + now.getMinutes()).slice(-2) + ':' +
          ('00' + now.getSeconds()).slice(-2);

        $.ajax({
          type: "POST",
          url: "observe_add.php",
          data: { student_name: studentName,
            question_id: jsonData.pages[currentPage-1].question_id,
            access_id: accessId,
            action: action,
            detail: detail,
            action_at: now,
            action_sequence_number: sequenceNumber++ }
        })
          .done(function( msg ) {
            console.log( "Data Saved: " + msg );
          })
          .fail(function( msg ) {
            console.log( "error: " + msg );
          });
      }

      function hashCode(str) {
        if (str.length == 0) return 0;
        var hash = 0;
        for (i = 0; i < str.length; i++) {
            char = str.charCodeAt(i);
            hash = ((hash<<5)-hash)+char;
            hash = hash & hash; // Convert to 32bit integer
        }
        return hash;
      }

    </script>

    <style type="text/css">
      .pep{
        font-size:40px;
        width: 80px;
        height: 80px;
        background: #2196F3;
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


      .droppable{
        width: 120px;
        height: 120px;
        font-size:40px;
        text-align: center;
        position: absolute;
        border: 5px solid #ccc;
        z-index: -1;
      }

      .pep-dpa{ border-color: #0D47A1; }

      #nev-previousPage:hover {
        cursor: pointer;
        background-color: #E3F2FD;
      }

      #nev-nextPage:hover {
        cursor: pointer;
        background-color: #E3F2FD;
      }

      .input-center1 {
        font-size:40px;
        width: 50%;
        position: absolute;
        top: 40%;
        left: 25%;
      }

      .input-center2 {
        font-size:40px;
        width: 50%;
        position: absolute;
        top: 60%;
        left: 25%;
      }

      #nev-area {
        width: 50%;
        position: absolute;
        top: 5%;
        right: 5%;
        text-align: right;
      }

      .big-button {
        font-size:40px;
      }

      .hidden {
        visibility: hidden;
      }
    </style>


  </head>


  <body>
    <div id="pepZone"></div>
    <div id="dropZone"></div>
    <div id="inputZone"></div>

    <div>
      <span class="hidden" id="nev-previousPage" onclick="previousPage()">&lt;&lt;&lt; previous page</span>
      <span class="hidden" id="nev-page" style="background:#90CAF9"></span>
      <span class="hidden" id="nev-nextPage" onclick="nextPage()">next page &gt;&gt;&gt; </span>
    </div>
    <div>
      <div class="aligncenter bigfont">
        <span id="title"></span>
      </div>
      <div class="aligncenter bigfont">
        <span id="question"></span>
      </div>
      <div id="nev-area">
        <button class="big-button" onclick="nextPage()">Next Question</button>
      </div>
    </div>


  </body>


</html>
