// 본인확인 인증창 호출
function certify_win_open(type, url)
{
    if(type == 'kcb-ipin')
    {
        var popupWindow = window.open( url, "kcbPop", "left=200, top=100, status=0, width=450, height=550" );
        popupWindow.focus();
    }
    else if(type == 'kcb-hp')
    {
        var popupWindow = window.open( url, "auth_popup", "left=200, top=100, width=430, height=590, scrollbar=yes" );
        popupWindow.focus();
    }
    else if(type == 'kcp-hp')
    {
        var return_gubun;
        var width  = 410;
        var height = 500;

        var leftpos = screen.width  / 2 - ( width  / 2 );
        var toppos  = screen.height / 2 - ( height / 2 );

        var winopts  = "width=" + width   + ", height=" + height + ", toolbar=no,status=no,statusbar=no,menubar=no,scrollbars=no,resizable=no";
        var position = ",left=" + leftpos + ", top="    + toppos;
        var AUTH_POP = window.open(url,'auth_popup', winopts + position);
    }
    else if(type == 'lg-hp')
    {
        var popupWindow = window.open( url, "auth_popup", "left=200, top=100, width=400, height=400, scrollbar=yes" );
        popupWindow.focus();
    }
}

// 인증체크
function cert_confirm()
{
    var type;
    var val = document.fregisterform.cert_type.value

    switch(val) {
        case "ipin":
            type = g5_msg_ipin;
            break;
        case "hp":
            type = g5_msg_hphone;
            break;
        default:
            return true;
    }

    if(confirm(g5_msg_confirm_completed + "(" + type + ").\n\n" + g5_msg_reconfirm))
        return true;
    else
        return false;
}
