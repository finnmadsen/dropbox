var path_arr = new Array();
var path_arr_cnt = 0;
var menus   = ["general","filter"];
var tabdesc = {general: "General status", filter: "Folder filter"};

var addEvent = function(object, type, callback) {
    if (object == null || typeof(object) == 'undefined') return;
    if (object.addEventListener) {
        object.addEventListener(type, callback, false);
    } else if (object.attachEvent) {
        object.attachEvent("on" + type, callback);
    } else {
        object["on"+type] = callback;
    }
};
function setWinSize() {
  var w = window.innerWidth;
  var h = window.innerHeight;
  var mid = document.getElementById('main');
  mid.style.width = (w - 10) + 'px';
  mid.style.height = (h - 130) + 'px';
}
function selectMenu(menu) {
    for (var i = 0; i <menus.length; i++) {
	    var mid = document.getElementById('m_' + menus[i]);
	    var cid = document.getElementById(menus[i]);
        if (menu == menus[i]) {
           mid.className = "mbutt mbutt-current";		
           cid.className = "content-current";		
        }
        else {
           mid.className = "mbutt";		
           cid.className = "content";		
        }
    }
    switch (menu) {
       case 'general':
            getPage('general.php','general');
            break;
       case 'filter':
            getPage('filter.php','filter');
            break;       
       default:
            break;
    }
}
function setStatus(status, text) {
    var sid = document.getElementById('status');
    if (status == 'flex')	
		sid.innerHTML = text;
	else
		sid.innerHTML = tabdesc[status];
}
function resetStatus() {
   var sid = document.getElementById('status');
   sid.innerHTML = "Ready";
}
function toogleFilterStatus(node, id) {
  var action;
  if (node.checked)  
    action = 'remove';
  else
    action = 'add';    
  if (!confirm("Do you want to " + (node.checked ? "include" : "exclude") + " synchronizing for this folder:\n" + path_arr[id] + "?")) {
    node.checked = (!node.checked);
    return false; 
  }
  getPage(encodeURI('add_remove.php?action=' + action + '&dir=' + path_arr[id]),'status');
  return true;
}
function toogleTreeNode(node) {
  var nc = node.parentNode.getElementsByClassName('nodecont');
  if (nc.length > 0 && nc[0].parentNode == node.parentNode) 
     nc[0].className = 'nodecont-closed';
  else
     nc = node.parentNode.getElementsByClassName('nodecont-closed');
     if (nc.length > 0)
        nc[0].className = 'nodecont';
}
function init() {
  selectMenu('general');
  setWinSize();
  resetStatus();
}
addEvent(window, "resize", function(event) {
  setWinSize();
});
