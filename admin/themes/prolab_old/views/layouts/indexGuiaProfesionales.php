

<div class="fondo">

	<!-- END MENU -->

	<!-- CUERPO -->
	<div class="lateralDer" style="background-color: white;">
		<div class="pagina"></div>
	</div>
	<!-- END CUERPO -->
	<!-- END BAJO ENCABEZADO -->


	<!-- FOOTER -->
	<div style="clear: right; vertical-align: top;">

		<div class="rbroundbox" id="footer">
			<div class="rbtop">
				<div></div>
			</div>
			<div class="rbcontent">
				<div>
					<span style="color: navy;">Para comunicarse con nosotros:</span>
					prolab@presi.unlp.edu.ar - www.prolab.unlp.edu.ar
				</div>
				<hr>
				<!--					<div><span style="color: navy;">Consultas T?cnicas:</span> prolab.consultas@presi.unlp.edu.ar</div><hr>-->
				<div>
					<span style="color: navy;"> Calle 7 Nro. 776 (UNLP - Presidencia) |
						La Plata - Buenos Aires - Argentina - CP 1900 | Tel&eacute;fonos:
						(0221) 427-7196 - 424-5420 </span>
				</div>
			</div>
			<!-- /rbcontent -->
			<div class="rbbot">
				<div></div>
			</div>
		</div>

	</div>
	<!-- FIN FOOTER -->
</div>
<script language="javascript">

function tamanoClass(name) {
  var results = new Array();
  var elems = document.getElementsByTagName("div");
  for (var i=0; i<elems.length; i++) {
    if (elems[i].className.indexOf(name) != -1) {
      results[results.length] = elems[i];
      elems[i].style.width = 535;
      elems[i].style.height = 132;
      elems[i].style.background = "white";
      //elems[i].style.background = url("http://www.prolab.unlp.edu.ar/prolabBeta/img/cuadro.JPG") no-repeat scroll transparent; 
      elems[i].innerHTML = "<img src='./img/cuadro3.jpg' HEIGHT='129' WIDTH='405'> ";
    }
  }
  return results;
};

function tamanoFont(name) {
	  var results = new Array();
	  var elems = document.getElementsByTagName("a");
	  for (var i=0; i<elems.length; i++) {
	    if (elems[i].className.indexOf(name) != -1) {
	      results[results.length] = elems[i];
	      elems[i].style.fontSize = "16px";	      
	    }
	  }
	  return results;
	};
	
tamanoClass('cabecera');
tamanoFont('texto');
var persistclose=0; //set to 0 or 1. 1 means once the bar is manually closed, it will remain closed for browser session
var startX = 5; //set x offset of bar in pixels
var startY = 5; //set y offset of bar in pixels
var verticalpos="fromtop"; //enter "fromtop" or "frombottom"

	if (window.addEventListener)
	   window.addEventListener("load", staticbar, false)
	else if (window.attachEvent)
	   window.attachEvent("onload", staticbar)
	else if (document.getElementById)
	   window.onload=staticbar;
</script>

<!-- FIN CLASS FONDO -->
<div style="visibility: visible; left: 0px; top: 5px;" id="anuncio">
	<!-- <a href='Javascript:void' onClick='closebar(); return false'><img align='right' border='0' src='http://4.bp.blogspot.com/_dsEG33PDaHw/S66y-66sXXI/AAAAAAAAAOk/0GDe7kdQj4A/s200/icono-cerrar.png'/>
</a><br /> -->
	<a href="http://www.prolab.unlp.edu.ar"><img width="35" height="60"
		src="inicio.jpeg"></a>
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42947085-1', 'unlp.edu.ar');
  ga('send', 'pageview');

</script>
<!-- FIN CLASS FONDO -->
</body>
</html>
