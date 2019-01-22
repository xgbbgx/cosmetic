function gup(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(window.location.href);
    if (results === null){
            return "";
    }else{
            return decodeURI(results[1]);
    }
}

function padStart(num){
    if(parseInt(num)<10){
        return "0"+num;
    }
    return num+"";
}

jQuery(document).ready(function () {
    

    function run() {
        if (!$('#currentPageIndexTextField').val()) {
            return setTimeout(function () {
                run();
            }, 1000);
        }

        //On book ready
        console.log("Book Ready");
        
        if( gup("bid") === ""){
            document.body.innerText = "Error: No bid";
        }
        if( gup("cid") === ""){
            document.body.innerText = "Error: No cid";
        }


        //Create page change event
        var lastPage = $('#currentPageIndexTextField').val();
        setInterval(function () {
            if (lastPage !== $('#currentPageIndexTextField').val()) {
                var event = document.createEvent('Event');
                event.initEvent('pageChange', true, true);
                document.getElementById('currentPageIndexTextField').dispatchEvent(event);
                lastPage = $('#currentPageIndexTextField').val();
            }
        }, 1000);

        //Listen to page event
        document.addEventListener('pageChange', function (e) {
            console.log("pageChange");
            var currentPages = $('#currentPageIndexTextField').val().split('/')[0].split('-')
            console.log(currentPages);
            var pageWithRecored = window.pageWithRecored;

            for (var i = 0; i < currentPages.length; i++) {
                //console.log("A");
                if (pageWithRecored.indexOf(parseInt(currentPages[i])) !== -1) {

                    (function run() {

                        //console.log("B");
                        var pageId = currentPages[i];
                        var currentContent = $('#pageMask' + pageId + ' .side-content');

                        currentContent.find('.audio-record').remove();
                        currentContent.append(
                            '<div class="audio-record">\
                            <audio id="audio' + pageId + '" controls></audio><br/>\
                            <a href="javascript:void(0);" target="_blank" class="button button-microphone" ><i class="fa fa-microphone"></i></a>\
                            <a href="javascript:void(0);" target="_blank" class="button button-play disabled" ><i class="fa fa-play"></i></a>\
                            <a href="javascript:void(0);" target="_blank" class="button button-check disabled" ><i class="fa fa-check"></i></a>\
                            <span class="button button-score" ></a>\
                        </div>'
                        );

                        var recorder, stream;
                        var audio = document.querySelector('#audio' + pageId);

                        var theBtnEvent = "click touchstart";
                        var allBtns = currentContent.find('.audio-record .button').off(theBtnEvent);
                        var microphone = currentContent.find('.audio-record .button-microphone').off(theBtnEvent);
                        var play = currentContent.find('.audio-record .button-play').off(theBtnEvent);
                        var check = currentContent.find('.audio-record .button-check').off(theBtnEvent);
                        var score = currentContent.find('.audio-record .button-score').off(theBtnEvent);

                        allBtns.on(theBtnEvent, function (e) {
                            e.preventDefault();
                            console.log($(this).attr('class'));
                        });

                        microphone.on(theBtnEvent, function (e) {
                            e.preventDefault();
                            if ($(this).hasClass("disabled")) {
                                return;
                            }

                            $(this).find('i').toggleClass("fa-microphone").toggleClass("fa-stop");

                            //Recording stoped
                            if ($(this).find('i').hasClass("fa-microphone")) {

                                recorder.stop();
                                stream.getAudioTracks().forEach(function (track) {
                                    track.stop();
                                });
                                console.log("recorder.stop()");

                                play.removeClass('disabled').off(theBtnEvent);
                                check.removeClass('disabled').off(theBtnEvent);

                                recorder.play(audio); //Place the source, we disabled the autoplay

                                play.on(theBtnEvent, function (e) {
                                    e.preventDefault();
                                    if ($(this).hasClass("disabled")) {
                                        return;
                                    }
                                    //alert();   
                                    document.getElementById("audio" + pageId).play();
                                });

                                check.on(theBtnEvent, function (e) {
                                    e.preventDefault();
                                    if ($(this).hasClass("disabled")) {
                                        return;
                                    }

                                    microphone.addClass('disabled');
                                    check.addClass('disabled');

                                    var config = {
                                        url: "/speech/dingdong",
                                        book_id: gup("bid"),
                                        cid: gup("cid"),
                                        //file_name: "ebook001-p01-01",
                                        file_name: window.bookFileName+"-p"+padStart(pageId)+"-01",
                                        type: "0"
                                    };
                                    console.log(config);
                                    recorder.uploadRM(config, function (state, e) {
                                        switch (state) {
                                            case 'uploading':
                                                break;
                                            case 'ok':
                                                var res = JSON.parse(e.target.responseText);
                                                console.log(res);
                                                microphone.off(theBtnEvent);
                                                check.off(theBtnEvent);
                                                if(res.data && res.data.score){
                                                    score.text(res.data.score + '/10');
                                                }else{
                                                    score.text('0/10');
                                                    console.log(res.msg);
                                                }
                                                break;
                                            case 'error':
                                                alert("上传失败");
                                                microphone.removeClass('disabled');
                                                check.removeClass('disabled');
                                                break;
                                            case 'cancel':
                                                alert("上传被取消");
                                                microphone.removeClass('disabled');
                                                check.removeClass('disabled');
                                                break;
                                        }
                                    });

                                });

                            } else {
                                HZRecorder.get(function (rec, _stream) {
                                    recorder = rec;
                                    stream = _stream;
                                    recorder.start();
                                    console.log("recorder.start()");
                                });

                            }

                        });

                        /*
                    var theBtn = currentContent.find('.audio-record .button');
                    var theBtnEvent = "click touchstart";
                    theBtn.off(theBtnEvent);
                    theBtn.on(theBtnEvent, function (e) {
                        e.preventDefault();
                        console.log('clicked');
                        if($(this).hasClass('rec-effect-4')){
                            currentContent.append('<div class="bs-lightbox"><div class="inner">\
                            Your Score: <h1>7/10</h1>\
                            Your Recording:<br/><br/>\
                            <audio controls>\
  <source src="http://47.52.60.152/storytime/Book03_Why_Should_I_Wash_Free_Trial/files/pageConfig/testing%20(online-audio-converter.com).mp3?181009133428" type="audio/mpeg">\
</audio>\
</div></div>');
                        }
                        $(this).toggleClass("rec-effect-4");
                    });
                    */

                    })();



                }
            }




        }, false);


    }
    run();

});