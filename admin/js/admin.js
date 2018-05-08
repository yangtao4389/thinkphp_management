function showDiv(id){
//var arr = new Array(1,4,5,6,7,1,2,3);
//    for(k=1;k<=7;k++){
//        if(arr[k] == id){
            document.getElementById('popDiv_'+id).style.display='block';
   //     }else{
//            document.getElementById('popDiv_'+arr[k]).style.display='none';
//        }
//    }
}
function closeDiv(id){
document.getElementById('popDiv_'+id).style.display='none';
}

function _openwindow(url){
	window.open(url, 'newwindow','height=500, width=500,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no, status=no');
}