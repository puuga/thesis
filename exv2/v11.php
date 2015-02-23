<?php include "db_connect_oo.php"; ?>
<?php
  // v11.php
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include "head_meta.php"; ?>
    <title>v11a</title>

    <?php include "head_include.php"; ?>

    <!-- Load lib and tests. -->
    <?php include "head_pep.php"; ?>

    <script type="text/javascript">
      var currentPage = 1;
      var jsonData;
      var studentName = "";
      var sequenceNumber = 0;
      var accessId = (new Date()).valueOf().toString();
      var documentHeight = 0;
      var documentWidth = 0;

      $(document).ready(function() {

        documentHeight = $(document).height();
        documentWidth = $(document).width();

        $.material.init();

        getJSONmod('json/v11.json.php');

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
          $(window).off("resize", moveWhenResize);
        }
        else if ( jsonData.pages[page-1].question_type == "1" ) {
          $("#nev-area").show();
          makeDrop(jsonData.pages[page-1].content);
          makePep(jsonData.pages[page-1].content);
          $(window).resize( moveWhenResize );
        }

      }

      function moveWhenResize() {
        // move pep to new position
        // 1. detect how many pep
        // 2. move pep one by one

        var numberOfPep = jsonData.pages[currentPage-1].content.option.length
        for (i=1; i<=numberOfPep; i++) {
          // read old pos
          var oldTop = $(".pep.qz"+i).position().top;
          var oldLeft = $(".pep.qz"+i).position().left;

          // cal new pos
          var newTop = oldTop * $(document).height() / documentHeight;
          var newLeft = oldLeft * $(document).width() / documentWidth;

          // move to new pos
          $(".pep.qz"+i).css({"top":newTop,"left":newLeft});
        }

        documentHeight = $(document).height();
        documentWidth = $(document).width();
      }

      function resetPep() {
        var numberOfPep = jsonData.pages[currentPage-1].content.option.length;
        var margin = 100/(numberOfPep+1);
        for (i=0; i<numberOfPep; i++) {
          $(".pep.qz"+(i+1)).css({"top":$(".droppable.hz"+(i+1)).position().top-120});
          $(".pep.qz"+(i+1)).css({"left":(i*margin+10)+"%"});

        }
        track("reset","pep");
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
        output += "<div class='form-group input-center1'>"
        output += "<input type='text' class='form-control input-lg' onkeyup='setStudentName(this)' placeholder='"+content.placeholder+"'>";
        output += "</div>"
        output += "<button onclick='nextPage()' class='btn btn-primary input-center2'>Ready to GO</button>";
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
            $(".pep.qz"+(i+1)).css({"background":"#4CAF50"});
          }
          $(".pep.qz"+(i+1)).css({"top":$(".droppable.hz"+(i+1)).position().top-120});
          $(".pep.qz"+(i+1)).css({"left":""+(i*margin+10)+"%"});
          $(".pep.qz"+(i+1)).css({"border":"1"});
          $(".pep.qz"+(i+1)).css({"padding":"10px"});
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
          $(".droppable.hz"+(i+1)).css({"bottom":"10%"});
          $(".droppable.hz"+(i+1)).css({"left":""+(i*margin+10)+"%"});
          $(".droppable.hz"+(i+1)).css({"border":"1"});
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
      <div class="aligncenter bigfont">
        <span id="output"></span>
      </div>
      <div id="nev-area">
        <button class="btn btn-fab btn-raised btn-material-red mdi-av-replay" onclick="resetPep()"></button>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button class="btn btn-fab btn-raised btn-material-red mdi-navigation-arrow-forward" onclick="nextPage()"></button>
      </div>
    </div>

    <script>

    </script>


  </body>


</html>
<?php $conn->close(); ?>
