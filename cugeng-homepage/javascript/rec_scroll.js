/**
 * Created by SYL on 2017/7/30.
 */
function ScrollImgLeft(){
    var speed=10;
    var scroll_begin = document.getElementById("scroll_begin");
    var scroll_end = document.getElementById("scroll_end");
    var rec_box = document.getElementById("rec_box");
    scroll_end.innerHTML=scroll_begin.innerHTML;
    function Marquee(){
        if(scroll_end.offsetWidth-rec_box.scrollLeft<=0)
        {
            rec_box.scrollLeft-=scroll_begin.offsetWidth;
        }
        else
        {
            rec_box.scrollLeft++;
        }
    }
    var MyMar=setInterval(Marquee,speed);
    rec_box.onmouseover=function()
    {
        clearInterval(MyMar);
    }
    rec_box.onmouseout=function()
    {
        MyMar=setInterval(Marquee,speed);
    }
}