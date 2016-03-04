function popUp(url, target, width, height) {
    x = screen.width/2 - width/2;
    y = screen.height/2 - height/2;
    window.open(url, target, 'width='+width+',height='+height+',left='+x+',top='+y+',screenX='+x+',screenY='+y+',scrollbars=YES,location=YES,status=YES');
}



/**
* From http://www.massless.org/mozedit/
*/
function mozWrap(txtarea, open, close)
{
        var selLength = txtarea.textLength;
        var selStart = txtarea.selectionStart;
        var selEnd = txtarea.selectionEnd;
        var scrollTop = txtarea.scrollTop;

        if (selEnd == 1 || selEnd == 2)
        {
                selEnd = selLength;
        }

        var s1 = (txtarea.value).substring(0,selStart);
        var s2 = (txtarea.value).substring(selStart, selEnd);
        var s3 = (txtarea.value).substring(selEnd, selLength);

        txtarea.value = s1 + open + s2 + close + s3;
        txtarea.selectionStart = selEnd + open.length + close.length;
        txtarea.selectionEnd = txtarea.selectionStart;
        txtarea.focus();
        txtarea.scrollTop = scrollTop;
}


//////////////////////////////////////////////////////////////////////////////////////
//Einfachen Code einf�gen (B,I,U, etc.) => Keine Abfrage
//////////////////////////////////////////////////////////////////////////////////////
function insert(eName, aTag, eTag) {
  var input = document.getElementById(eName);
  input.focus();
  /* f�r Internet Explorer */
  if(typeof document.selection != 'undefined') {
    /* Einf�gen des Formatierungscodes */
    var range = document.selection.createRange();
    var insText = range.text;
    range.text = aTag + insText + eTag;
    /* Anpassen der Cursorposition */
    range = document.selection.createRange();
    if (insText.length == 0) {
      range.move('character', -eTag.length);
    } else {
      range.moveStart('character', aTag.length + insText.length + eTag.length);
    }
    range.select();
  }
  /* f�r neuere auf Gecko basierende Browser */
  else if(typeof input.selectionStart != 'undefined')
  {
    /* Anpassen der Cursorposition nach dem einf�gen */
    var selection_start = input.selectionStart;
    var selection_end = input.selectionEnd;
    var insText = input.value.substring(selection_start, selection_end);
    var pos;
    if (insText.length == 0) {
      pos = selection_start + aTag.length;
    } else {
      pos = selection_start + aTag.length + insText.length + eTag.length;
    }
    mozWrap(input, aTag, eTag);
    input.selectionStart = pos;
    input.selectionEnd = pos;
  }
  /* f�r die �brigen Browser */
  else
  {
    /* Abfrage der Einf�geposition */
    var pos = input.value.length;
    /* Einf�gen des Formatierungscodes */
    var insText = prompt("Bitte gib den zu formatierenden Text ein:");
    input.value = input.value.substr(0, pos) + aTag + insText + eTag + input.value.substr(pos);
  }
}
//////////////////////////////////////////////////////////////////////////////////////
//Mittel Komplexen Code einf�gen (IMG, CIMG, etc.) => Abfrage bei nicht Markiertem Text
//////////////////////////////////////////////////////////////////////////////////////
function insert_mcom(eName, aTag, eTag, Frage, Vorgabe) {
  var input = document.getElementById(eName);
  input.focus();
  /* f�r Internet Explorer */
  if(typeof document.selection != 'undefined') {
    /* Einf�gen des Formatierungscodes */
    var range = document.selection.createRange();
    var insText = range.text;
    if (insText.length == 0) {
      /* Ermittlung des einzuf�genden Textes*/
      insText = prompt(Frage, Vorgabe);
      if (insText == null) {
        insText = "";
      }
    }
    range.text = aTag + insText + eTag;
    /* Anpassen der Cursorposition */
    range = document.selection.createRange();
    if (insText.length == 0) {
      range.move('character', -eTag.length);
    } else {
      range.moveStart('character', aTag.length + insText.length + eTag.length);
    }
    range.select();
  }
  /* f�r neuere auf Gecko basierende Browser */
  else if(typeof input.selectionStart != 'undefined')
  {
    /* Anpassen der Cursorposition nach dem einf�gen */
    var selection_start = input.selectionStart;
    var selection_end = input.selectionEnd;
    var insText = input.value.substring(selection_start, selection_end);
    var addText = "";

    /* Ermittlung des einzuf�genden Textes*/
    if (insText.length == 0) {
      addText = prompt(Frage, Vorgabe);
      if (addText == null) {
        addText = "";
      }
      insText = addText;
    }

    var pos;
    if (insText.length == 0) {
      pos = selection_start + aTag.length;
    } else {
      pos = selection_start + aTag.length + insText.length + eTag.length;
    }

    mozWrap(input, aTag+addText, eTag);
    input.selectionStart = pos;
    input.selectionEnd = pos;
  }
  /* f�r die �brigen Browser */
  else
  {
    /* Abfrage der Einf�geposition */
    var pos = input.value.length;
    /* Einf�gen des Formatierungscodes */
    var insText = prompt(Frage, Vorgabe);
    if (insText == null) {
      insText = "";
    }
    input.value = input.value.substr(0, pos) + aTag + insText + eTag + input.value.substr(pos);
  }
}
//////////////////////////////////////////////////////////////////////////////////////
//Komplexen Code einf�gen (FONT, SIZE, COLOR, etc.) => Abfrage wird immer durchgef�hrt
//////////////////////////////////////////////////////////////////////////////////////
function insert_com(eName, Tag, Frage, Vorgabe) {
  var input = document.getElementById(eName);
  input.focus();
  /* Ermittlung des einzuf�genden Textes*/
  var attText = prompt(Frage, Vorgabe);
  if (attText == null) {
    attText = "";
  }
  /* f�r Internet Explorer */
  if(typeof document.selection != 'undefined') {
    /* Einf�gen des Formatierungscodes */
    var range = document.selection.createRange();
    var insText = range.text;
    range.text = "["+Tag+"="+attText+"]"+ insText +"[/"+Tag+"]";
    /* Anpassen der Cursorposition */
    range = document.selection.createRange();
    if (insText.length == 0) {
      range.move('character', -(Tag.length + 2));
    } else {
      range.moveStart('character', Tag.length + 3 + attText.length + insText.length + Tag.length + 3);
    }
    range.select();
  }
  /* f�r neuere auf Gecko basierende Browser */
  else if(typeof input.selectionStart != 'undefined')
  {
    /* Tags definieren */
    var aTag = "["+Tag+"="+attText+"]";
    var eTag = "[/"+Tag+"]";

    /* Anpassen der Cursorposition nach dem einf�gen */
    var selection_start = input.selectionStart;
    var selection_end = input.selectionEnd;
    var insText = input.value.substring(selection_start, selection_end);

    var pos;
    if (insText.length == 0) {
      pos = selection_start + aTag.length;
    } else {
      pos = selection_start + aTag.length + insText.length + eTag.length;
    }

    mozWrap(input, aTag, eTag);
    input.selectionStart = pos;
    input.selectionEnd = pos;
  }
  /* f�r die �brigen Browser */
  else
  {
    /* Abfrage der Einf�geposition */
    var pos = input.value.length;
    /* Einf�gen des Formatierungscodes */
    var insText = prompt("Bitte gib den zu formatierenden Text ein:");
    input.value = input.value.substr(0, pos) +"["+Tag+"="+attText+"]"+ insText +"[/"+Tag+"]"+ input.value.substr(pos);
  }
}
