function rekursivText(arr, path, level = 0) {
    var mylevel = level;
    var nodeText;
    var  thisPath = path;
    path_arr_cnt++; 
    path_arr[path_arr_cnt] = thisPath;
    nodeText = '<div class="filternode">'
             + '<input type="checkbox" onchange="toogleFilterStatus(this, ' + path_arr_cnt + ');"' + ((arr.include == 'Y') ? 'checked="checked"' : '') + '/>'
             + '<div class="' + (arr.hasOwnProperty('nodes') ? 'bold-' : '') + 'tnode" onclick="toogleTreeNode(this);">' + arr.name + '</div>';
    
    if (arr.hasOwnProperty('nodes')) {
        if (mylevel == 0)
            nodeText += '<div class="nodecont">';
        else
            nodeText += '<div class="nodecont-closed">';            
        var subnodes = arr.nodes;
        for(var i in subnodes) {
            var wn = subnodes[i];
            nodeText += rekursivText(wn, thisPath + '/' + subnodes[i].name , (mylevel + 1));
        } 
        nodeText += '</div>';
    }
    return nodeText + '</div>';    
}
function populateFilter(arr, level = 0) {
    var node = document.getElementById('filter');
    tabdesc.filter = arr.mesg.title;
    node.innerHTML = rekursivText(arr, '', 0);
}
function populateStatus(arr) {
    for (var i in arr) {
        var msg = arr[i];
        if (i == 'status')
            setStatus('flex', arr[i]);
        else    
            setStatus("Ajax error");
    }
}
function populateGeneral(arr, level = 0) {
    var node = document.getElementById('general');
    var nodetext;
    nodetext = '';
    for (var i in arr) {
        tabdesc.general = arr.mesg.titel;
        var sub = arr[i];
        switch(i) {
        case 'general':
            nodetext += '<h2>' + arr.mesg.general +'</h2>';
            for (var v in sub)
                nodetext +=  sub[v] + '<br/>';
            break;
        case 'fs':
            nodetext += '<h2>' + arr.mesg.level1 +'</h2>';        
            nodetext +=  '<table>';
            nodetext +=  '<th>' + arr.mesg.col1 + '</th><th>' + arr.mesg.col2 + '</th>';
            for (var v in sub) {
                nodetext +=  '<tr><td>' + sub[v][0] + '</td><td>' + sub[v][1] + '</td></tr>';
            }
            nodetext +=  '</table>';
            break;
        }
    }
    node.innerHTML = nodetext;
}
function newXMLHttpRequest() {
   var obj = false;
   if (window.XMLHttpRequest) {
        obj = new XMLHttpRequest();
   } else if (window.ActiveXObject) {
		alert("Your browser does not support Javascript/Ajax or is to old, this page will not work");
	    return false;
   }
   return obj;
}
function getPage(pPage, pDivDest)
{
    var rObject = false;
    rObject = newXMLHttpRequest();
//    alert('Get:' + pPage + ' to:' + pDivDest);
    if (rObject) {
	rObject.open("GET", pPage, true);
	rObject.onreadystatechange = function()
	{
	   	if (rObject.readyState == 4 && rObject.status == 200) {
        //  alert('Got result' + pPage + ' to:' + pDivDest);
 			var jsonDoc = JSON.parse(rObject.responseText);
			switch(pDivDest) {
			case 'filter':
				populateFilter(jsonDoc);
				break;
			case 'general':
				populateGeneral(jsonDoc);
				break;
			case 'status':
				populateStatus(jsonDoc);
				break;
			default:
				alert("No handler for:" + pDivDest);
				break;
			}
		}
	}
	rObject.send(null);
    }
}

