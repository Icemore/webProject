var arr, n, cur;
var firstUrl = "http://localhost/api/getAdvIds.php?block_id="+String(block_id);
var oElem = null;


function sendJSONP(url, callback) {
    if (!url || !callback)
        return;

    url += '&callback='+callback;

    // выполняем запрос JSONP
    if (oElem) {
        oElem.parentNode.removeChild(oElem);
    }

    oElem = document.createElement('script');
    oElem.setAttribute('type','text/javascript');
    document.getElementsByTagName('head')[0].appendChild(oElem);
    oElem.setAttribute('src', url);
}

sendJSONP(firstUrl,"init");

function shuffle(arr){
    for(var i=0; i<arr.length; ++i){

        var rnd_i=Math.floor( Math.random()*(arr.length-i) + i );
        var tmp=arr[i];

        arr[i]=arr[rnd_i];
        arr[rnd_i]=tmp;
    }
}


function init(array, a){
    cur=0;
    n = a;
    arr = array;
    shuffle(arr);
    getBlock();

}



function displayBlock(html){
    //alert(html);
    var oldElem=document.getElementById("post_it_adv");
    if(oldElem) oldElem.parentNode.removeChild(oldElem);

    document.getElementsByTagName("body")[0].innerHTML=document.getElementsByTagName("body")[0].innerHTML.concat(html);
}



function getBlock(){
    var myUrl = "http://localhost/api/getBlock.php?block_id="+String(block_id)+"&adv_ids=";
    var myCur = cur;
    for(var i = 0; i < n; ++i){
       if(myCur >= arr.length){
           myCur = 0;
       }
       if(i+1<n){
           myUrl = myUrl + String(arr[myCur]) + ",";
       }
        else{
           myUrl = myUrl + String(arr[myCur]);
       }
        myCur++;
    }

    sendJSONP(myUrl, "displayBlock");
}




function getNext(){
    cur = cur + 1;
    if(cur==arr.length) cur=0;
    getBlock();
}



function getPrev(){
    cur = cur - 1;
    if(cur<0) cur=arr.length-1;
    getBlock();
}