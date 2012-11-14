// common variables
var iMaxFilesize = 2097152; // 2MB

function fileSelected() {

    // hide different warnings
    document.getElementById('error').style.display = 'none';
    document.getElementById('error2').style.display = 'none';
    document.getElementById('abort').style.display = 'none';
    document.getElementById('warnsize').style.display = 'none';

    // get selected file element
    var oFile = document.getElementById('image_file').files[0];

    // filter for image files
    var rFilter = /^(image\/bmp|image\/gif|image\/jpeg|image\/png|image\/tiff)$/i;
    if (! rFilter.test(oFile.type)) {
	console.log
        document.getElementById('error').style.display = 'block';
        return;
    }

    // little test for filesize
    if (oFile.size > iMaxFilesize) {
        document.getElementById('warnsize').style.display = 'block';
        return;
    }
}

function startUploading() {
    // cleanup all temp states
    document.getElementById('error').style.display = 'none';
    document.getElementById('error2').style.display = 'none';
    document.getElementById('abort').style.display = 'none';
    document.getElementById('warnsize').style.display = 'none';
    document.getElementById('progress_percent').innerHTML = '';
    var oProgress = document.getElementById('progress');
    oProgress.style.display = 'block';
    oProgress.style.width = '0px';

    // get form data for POSTing
    //var vFD = document.getElementById('upload_form').getFormData(); // for FF3
    var vFD = new FormData(document.getElementById('upload_form')); 

    // create XMLHttpRequest object, adding few event listeners, and POSTing our data
    var oXHR = new XMLHttpRequest();        
    oXHR.open('POST', 'submit.php');
    oXHR.send(vFD);
    
    /*
    from other:
    // create XMLHttpRequest object, adding few event listeners, and POSTing our data
    var oXHR = new XMLHttpRequest();        
    oXHR.upload.addEventListener('progress', uploadProgress, false);
    oXHR.addEventListener('load', uploadFinish, false);
    oXHR.addEventListener('error', uploadError, false);
    oXHR.addEventListener('abort', uploadAbort, false);
    oXHR.open('POST', 'upload.php');
    oXHR.send(vFD);
    */
    
}

function uploadProgress(e) { // upload process in progress
    if (e.lengthComputable) {
        var iPercentComplete = Math.round(e.loaded * 100 / e.total);

        document.getElementById('progress_percent').innerHTML = iPercentComplete.toString() + '%';
        document.getElementById('progress').style.width = (iPercentComplete * 2.8).toString() + 'px';
    } else {
        document.getElementById('progress').innerHTML = 'unable to compute';
    }
}

function uploadFinish(e) { // upload successfully finished
    $.mobile.changePage('read.php?sort=new&ascending=0&lat='+localStorage.getItem("latitude")+'&lon='+localStorage.getItem("longitude"));
}

function uploadError(e) { // upload error
    document.getElementById('error2').style.display = 'block';
    clearInterval(oTimer);
}  

function uploadAbort(e) { // upload abort
    document.getElementById('abort').style.display = 'block';
    clearInterval(oTimer);
}