//========================================== Funcion crea ventana ==========================================
var INNERDIV_MOD = {
	maxZ : 0,
	profundidad : [],
	newInnerDiv : function (id,x,y,w,h,miUrl,titulo,miCSS){
		arrayindex=INNERDIV_MOD.profundidad.length;
		//**************** comprueba que no haya una ventana con el mismo id ***************************
		if (!INNERDIV_MOD.existe(id)){
			var docBody = document.getElementsByTagName("body").item(0);
			var nuevoDiv = document.createElement("div");
			this.profundidad[arrayindex] = nuevoDiv;
			//*********************************************** contenedor principal ********************************
				//******* asigna la id a la ventana **********//
				nuevoDiv.id =id;
				nuevoDiv.style.position = "absolute";
				//******* posicion x **********//
				nuevoDiv.style.left = x+"px";
				//******* posicion y **********//
				nuevoDiv.style.top  = y+"px";
				//******* ancho **************//
				nuevoDiv.style.width = w+"px";
				//******* alto **************//
				nuevoDiv.style.height = h+"px";
				if(!miCSS){
					//******* color de fondo **********//
					nuevoDiv.style.backgroundColor = "#EEEEEE";
					//******* borde **********//
					nuevoDiv.style.border = "1px solid #333";
				}
				
				
			//******************************************** fin contenedor principal *******************************
		
			//******************************************** barra de la ventana ************************************
				var barra = document.createElement("div");
				barra.id = "handle";
				barra.style.color = "#FFFFFF";
				barra.style.fontFamily = "Verdana";
				barra.style.fontSize = "10px";
				barra.style.backgroundColor = "#CC0000";
				barra.style.margin = "2px";
				barra.style.padding = "2px";
				//barra.style["cursor"] = "url('drag.ani')";
				barra.innerHTML = titulo;
			//******************************************** fin de la barra de la ventana **************************
			
			//********************************************* boton de cerrar ***************************************
				//*****************crear un <a>,meter boton dentro y en el attributo href llamar a la funcion de cerrar ****
				var enlace = document.createElement("a");
				enlace.onclick = function(){INNERDIV_MOD.cerrar(id);}
				enlace.style.cursor = "pointer";
				enlace.style.display = "inline";
				enlace.style.position = "absolute";
				enlace.style.right = "4px";
				enlace.style.top = "4px";
				
				var boton = document.createElement("img");
				boton.setAttribute("src","cerrar.gif");
				boton.setAttribute("border","0");
				boton.id = "btn_cerrar";
				enlace.appendChild(boton);
				
	
			//******************************************* fin boton de cerrar *************************************
				
			//************************************ scrollcontainer *************************************
				var scroll_container = document.createElement("div");
				scroll_container.id = "scrollContainer";
				scroll_container.clear ="both";
				//scroll_container.style.backgroundColor = "#FFCC00";
				scroll_container.style.height = (h-27)+ "px";
				scroll_container.style.width = (w-8)+ "px";
				scroll_container.style.overflow = "auto";
			//************************************ fin de scrollcontainer ******************************
			
			//************************************ scrollContent *************************************
				var scroll_content = document.createElement("div");
				scroll_content.id = "scrollContent_" +id;
				scroll_content.style.fontFamily = "Verdana";
				scroll_content.style.fontSize = "10px";
				//scroll_content.style.backgroundColor = "#33CC33";
				scroll_container.style.margin = "2px";
				scroll_container.style.padding = "2px";
			//************************************ fin de scrollContent *************************************
			
			//*********** añado la barra a la ventana **************
			nuevoDiv.appendChild(barra);
			//*********** añado el boton de cerrar a la barra *******
			barra.appendChild(enlace);
			//*********** añado el contenido del scroll al container **************
			scroll_container.appendChild(scroll_content);
			//*********** añado el container, con el contenido a la ventana **************
			nuevoDiv.appendChild(scroll_container);
			//*********** añado la ventana al documento **************
			docBody.appendChild(nuevoDiv);
			//********** pongo la ventana por encima de las demas **************
			nuevoDiv.style.zIndex=INNERDIV_MOD.cuentaventanas(INNERDIV_MOD.profundidad.length)+1;
			//*********** le pongo la funcionalidad de drag a la barra********
			Drag.init(barra, nuevoDiv);
			//*********** cargo el contenido en la ventana *******************
			//cargarContenido(scroll_content,miUrl);
			if(miUrl != null){
				CargarContenido(scroll_content.id,miUrl,null);
			}
		}
	},
   cuentaventanas : function(total){
	   maximo = 0;	
		for (var ind=0; ind<total; ind++) {
			if(this.profundidad[ind].style.zIndex > maximo){ maximo = this.profundidad[ind].style.zIndex };
		}
		return eval(maximo);
   },
   cerrar : function(mi_id){
	mi_ventana=document.getElementById(mi_id)
	//*********** borra el objeto INNERDID del arbol DOM, es decir lo quita de la pantalla del navegador
	mi_ventana.parentNode.removeChild(mi_ventana);
	total=INNERDIV_MOD.profundidad.length;
	//*********** recorre el array de profundidad y elimina tb el objeto del array de profundidad **********
	for (var ind=0; ind<total; ind++) {
		if( mi_id == INNERDIV_MOD.profundidad[ind].id){
			var resto = INNERDIV_MOD.profundidad.splice(ind,1);
			break;
		}
	}
	
   },

	existe: function(id){
		//************ recorre el array de ventanas y compara las id's para ver si la ventana ya existe **********
		//arrayindex=INNERDIV_MOD.profundidad.length;
		for (var ind=0; ind<arrayindex; ind++) {
			if( id == INNERDIV_MOD.profundidad[ind].id){
				//alert("ya existe la ventana " + INNERDIV_MOD.profundidad[ind].id);
				return(true);
			}
		}
	},
	cargar : function (id,miUrl,params){
			//************ si existe alguna ventana... **********
			if(INNERDIV_MOD.profundidad.length>0){
				//******** ..... y esa ventana tiene el id que queremos hace la carga **********************
				if (document.getElementById(id)!=null){
					//****** obtengo  "mi_ventana" que es  ni mas ni menos que el div scrollcontent_id ***********
					var mi_ventana=document.getElementById(id).childNodes[1].childNodes[0];
					if(!params){ params='1=1' }
					var params = params +'&';
					//********** obtengo todos los mi_ventanas input de mi_ventana ************
					var variables = mi_ventana.getElementsByTagName("input");
					//********** y los recorro obteniendo sus valores ***********************
					for (var i=0; i<variables.length;i++) {
						//********** si la avriable input es de tipo checkbox o radiobutton solo obtengo los seleccionados *******
						if((variables[i].type == 'checkbox' || variables[i].type == 'radio') && variables[i].checked){ 
							params = params + variables[i].name + "=" + variables[i].value + "&";
						//********** sino obtengo el valor tal cual *********
						} else if(variables[i].type != 'checkbox' && variables[i].type != 'radio'){
							params = params + variables[i].name + "=" + variables[i].value + "&";
						}
					}
					//********** obtengo todos los mi_ventanas select de mi_ventana ************
					var variables = mi_ventana.getElementsByTagName("select");
					//********** y los recorro obteniendo sus valores ***********************
					for (var i=0; i<variables.length;i++) {
						params = params + variables[i].name + "=" + variables[i].value + "&";
					}
					//********** obtengo todos los mi_ventanas textarea de mi_ventana ************
					var variables = mi_ventana.getElementsByTagName("textarea");
					//********** y los recorro obteniendo sus valores ***********************
					for (var i=0; i<variables.length;i++) {
						params = params + variables[i].name + "=" + variables[i].value + "&";
					}
					//****** finalmente cargo el contenido ************
					CargarContenido(mi_ventana.id,miUrl,params);
				}
	}
	this.className = id;
	//document.getElementById(id).className = id;
	}
};
//======================================= fin funcion crea ventana =============================================


//======================================= funciones drag =======================================================
/**************************************************
 * dom-drag.js
 * 09.25.2001
 * www.youngpup.net
 **************************************************
 * 10.28.2001 - fixed minor bug where events
 * sometimes fired off the handle, not the root.
 **************************************************/

var Drag = {

	obj : null,
	init : function(o, oRoot, minX, maxX, minY, maxY, bSwapHorzRef, bSwapVertRef, fXMapper, fYMapper)
	{
		
		o.onmousedown	= Drag.start; 
		o.hmode			= bSwapHorzRef ? false : true ;
		o.vmode			= bSwapVertRef ? false : true ;

		o.root = oRoot && oRoot != null ? oRoot : o ;
		if (o.hmode  && isNaN(parseInt(o.root.style.left  ))) o.root.style.left   = "0px";
		if (o.vmode  && isNaN(parseInt(o.root.style.top   ))) o.root.style.top    = "0px";
		if (!o.hmode && isNaN(parseInt(o.root.style.right ))) o.root.style.right  = "0px";
		if (!o.vmode && isNaN(parseInt(o.root.style.bottom))) o.root.style.bottom = "0px";

		o.minX	= typeof minX != 'undefined' ? minX : null;
		o.minY	= typeof minY != 'undefined' ? minY : null;
		o.maxX	= typeof maxX != 'undefined' ? maxX : null;
		o.maxY	= typeof maxY != 'undefined' ? maxY : null;

		o.xMapper = fXMapper ? fXMapper : null;
		o.yMapper = fYMapper ? fYMapper : null;

		o.root.onDragStart	= new Function();
		o.root.onDragEnd	= new Function();
		o.root.onDrag		= new Function();
	},

	
	start : function(e)
	{
		
		var o = Drag.obj = this;
		e = Drag.fixE(e);
		var y = parseInt(o.vmode ? o.root.style.top  : o.root.style.bottom);
		var x = parseInt(o.hmode ? o.root.style.left : o.root.style.right );
		o.root.onDragStart(x, y);

		o.lastMouseX	= e.clientX;
		o.lastMouseY	= e.clientY;
		//**************** modificacion para la profundidad ***********
		//*            modificado por Ivan Gascon => HARTUM           *
		//*                        25/05/2005                         *
		//*                    hartum@hotmail.com                     *
		//*************************************************************
		o.root.style.zIndex = INNERDIV_MOD.cuentaventanas(INNERDIV_MOD.profundidad.length)+1;
		//o.root.style.zIndex = 4;
		if (o.hmode) {
			if (o.minX != null)	o.minMouseX	= e.clientX - x + o.minX;
			if (o.maxX != null)	o.maxMouseX	= o.minMouseX + o.maxX - o.minX;
		} else {
			if (o.minX != null) o.maxMouseX = -o.minX + e.clientX + x;
			if (o.maxX != null) o.minMouseX = -o.maxX + e.clientX + x;
		}

		if (o.vmode) {
			if (o.minY != null)	o.minMouseY	= e.clientY - y + o.minY;
			if (o.maxY != null)	o.maxMouseY	= o.minMouseY + o.maxY - o.minY;
		} else {
			if (o.minY != null) o.maxMouseY = -o.minY + e.clientY + y;
			if (o.maxY != null) o.minMouseY = -o.maxY + e.clientY + y;
		}

		document.onmousemove	= Drag.drag;
		document.onmouseup		= Drag.end;
		return false;
	},

	drag : function(e)
	{
		e = Drag.fixE(e);
		var o = Drag.obj;

		var ey	= e.clientY;
		var ex	= e.clientX;
		var y = parseInt(o.vmode ? o.root.style.top  : o.root.style.bottom);
		var x = parseInt(o.hmode ? o.root.style.left : o.root.style.right );
		var nx, ny;

		if (o.minX != null) ex = o.hmode ? Math.max(ex, o.minMouseX) : Math.min(ex, o.maxMouseX);
		if (o.maxX != null) ex = o.hmode ? Math.min(ex, o.maxMouseX) : Math.max(ex, o.minMouseX);
		if (o.minY != null) ey = o.vmode ? Math.max(ey, o.minMouseY) : Math.min(ey, o.maxMouseY);
		if (o.maxY != null) ey = o.vmode ? Math.min(ey, o.maxMouseY) : Math.max(ey, o.minMouseY);

		nx = x + ((ex - o.lastMouseX) * (o.hmode ? 1 : -1));
		ny = y + ((ey - o.lastMouseY) * (o.vmode ? 1 : -1));

		if (o.xMapper)		nx = o.xMapper(y)
		else if (o.yMapper)	ny = o.yMapper(x)

		Drag.obj.root.style[o.hmode ? "left" : "right"] = nx + "px";
		Drag.obj.root.style[o.vmode ? "top" : "bottom"] = ny + "px";
		Drag.obj.lastMouseX	= ex;
		Drag.obj.lastMouseY	= ey;

		Drag.obj.root.onDrag(nx, ny);
		return false;
	},

	end : function()
	{
		
		document.onmousemove = null;
		document.onmouseup   = null;
		Drag.obj.root.onDragEnd(	parseInt(Drag.obj.root.style[Drag.obj.hmode ? "left" : "right"]), 
									parseInt(Drag.obj.root.style[Drag.obj.vmode ? "top" : "bottom"]));
		Drag.obj = null;
	},

	fixE : function(e)
	{
		if (typeof e == 'undefined') e = window.event;
		if (typeof e.layerX == 'undefined') e.layerX = e.offsetX;
		if (typeof e.layerY == 'undefined') e.layerY = e.offsetY;
		return e;
	}
};
//======================================= fin funciones drag =======================================================


//====================================== funcion de carga ============================================
function XHConn()
{
  var xmlhttp, bComplete = false;
  try { xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); }
  catch (e) { try { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); }
  catch (e) { try { xmlhttp = new XMLHttpRequest(); }
  catch (e) { xmlhttp = false; }}}
  if (!xmlhttp) return null;
  this.connect = function(sURL, sMethod, sVars, fnDone)
  {
    if (!xmlhttp) return false;
    bComplete = false;
    sMethod = sMethod.toUpperCase();

    try {
      if (sMethod == "GET")
      {
        xmlhttp.open(sMethod, sURL+"?"+sVars, true);
        sVars = "";
      }
      else
      {
        xmlhttp.open(sMethod, sURL, true);
        xmlhttp.setRequestHeader("Method", "POST "+sURL+" HTTP/1.1");
        xmlhttp.setRequestHeader("Content-Type",
          "application/x-www-form-urlencoded");
      }
      xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState == 4 && !bComplete)
        {
          bComplete = true;
          fnDone(xmlhttp);
        }};
      xmlhttp.send(sVars);
    }
    catch(z) { return false; }
    return true;
  };
  return this;
}

function CargarContenido(targetId,url,params) {
	target= document.getElementById(targetId);
	target.innerHTML = url;
	
}
//========================================== fadomatic ====================================================//

// Fade interval in milliseconds
// Make this larger if you experience performance issues
Fadomatic.INTERVAL_MILLIS = 50;

// Creates a fader
// element - The element to fade
// speed - The speed to fade at, from 0.0 to 100.0
// initialOpacity (optional, default 100) - element's starting opacity, 0 to 100
// minOpacity (optional, default 0) - element's minimum opacity, 0 to 100
// maxOpacity (optional, default 0) - element's minimum opacity, 0 to 100
function Fadomatic (element, rate, initialOpacity, minOpacity, maxOpacity) {
  this._element = element;
  this._intervalId = null;
  this._rate = rate;
  this._isFadeOut = true;
  // Set initial opacity and bounds
  // NB use 99 instead of 100 to avoid flicker at start of fade
  this._minOpacity = 0;
  this._maxOpacity = 99;
  this._opacity = 99;

  if (typeof minOpacity != 'undefined') {
    if (minOpacity < 0) {
      this._minOpacity = 0;
    } else if (minOpacity > 99) {
      this._minOpacity = 99;
    } else {
      this._minOpacity = minOpacity;
    }
  }

  if (typeof maxOpacity != 'undefined') {
    if (maxOpacity < 0) {
      this._maxOpacity = 0;
    } else if (maxOpacity > 99) {
      this._maxOpacity = 99;
    } else {
      this._maxOpacity = maxOpacity;
    }

    if (this._maxOpacity < this._minOpacity) {
      this._maxOpacity = this._minOpacity;
    }
  }
  
  if (typeof initialOpacity != 'undefined') {
    if (initialOpacity > this._maxOpacity) {
      this._opacity = this._maxOpacity;
    } else if (initialOpacity < this._minOpacity) {
      this._opacity = this._minOpacity;
    } else {
      this._opacity = initialOpacity;
    }
  }

  // See if we're using W3C opacity, MSIE filter, or just
  // toggling visiblity
  if(typeof element.style.opacity != 'undefined') {

    this._updateOpacity = this._updateOpacityW3c;

  } else if(typeof element.style.filter != 'undefined') {

    // If there's not an alpha filter on the element already,
    // add one
    if (element.style.filter.indexOf("alpha") == -1) {

      // Attempt to preserve existing filters
      var existingFilters="";
      if (element.style.filter) {
        existingFilters = element.style.filter+" ";
      }
      element.style.filter = existingFilters+"alpha(opacity="+this._opacity+")";
    }

    this._updateOpacity = this._updateOpacityMSIE;
    
  } else {

    this._updateOpacity = this._updateVisibility;
  }

  this._updateOpacity();
}

// Initiates a fade out
Fadomatic.prototype.fadeOut = function () {
  this._isFadeOut = true;
  this._beginFade();
}

// Initiates a fade in
Fadomatic.prototype.fadeIn = function () {
  this._isFadeOut = false;
  this._beginFade();
}

// Makes the element completely opaque, stops any fade in progress
Fadomatic.prototype.show = function () {
  this.haltFade();
  this._opacity = this._maxOpacity;
  this._updateOpacity();
}

// Makes the element completely transparent, stops any fade in progress
Fadomatic.prototype.hide = function () {
  this.haltFade();
  this._opacity = 0;
  this._updateOpacity();
}

// Halts any fade in progress
Fadomatic.prototype.haltFade = function () {

  clearInterval(this._intervalId);
}

// Resumes a fade where it was halted
Fadomatic.prototype.resumeFade = function () {

  this._beginFade();
}

// Pseudo-private members

Fadomatic.prototype._beginFade = function () {

  this.haltFade();
  var objref = this;
  this._intervalId = setInterval(function() { objref._tickFade(); },Fadomatic.INTERVAL_MILLIS);
}

Fadomatic.prototype._tickFade = function () {

  if (this._isFadeOut) {
    this._opacity -= this._rate;
    if (this._opacity < this._minOpacity) {
      this._opacity = this._minOpacity;
      this.haltFade();
    }
  } else {
    this._opacity += this._rate;
    if (this._opacity > this._maxOpacity ) {
      this._opacity = this._maxOpacity;
      this.haltFade();
    }
  }

  this._updateOpacity();
}

Fadomatic.prototype._updateVisibility = function () {
  
  if (this._opacity > 0) {
    this._element.style.visibility = 'visible';
  } else {
    this._element.style.visibility = 'hidden';
  }
}

Fadomatic.prototype._updateOpacityW3c = function () {
  
  this._element.style.opacity = this._opacity/100;
  this._updateVisibility();
}

Fadomatic.prototype._updateOpacityMSIE = function () {
  
  this._element.filters.alpha.opacity = this._opacity;
  this._updateVisibility();
}

Fadomatic.prototype._updateOpacity = null;
//========================================== fin del fadomatic ====================================================//