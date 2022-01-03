// カレンダー生成
(function($){
    $.fn.cehckcalendar = function(options) {
      var settings = $.extend( {
        'week'      : ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
        'roop'      : 1,
        'delimiter' : '-',        //送信時の日付の区切り文字 yyy/mm/dd
      }, options);

    $(this).html('');//カレンダー展開場所の中身をクリア

    var $div      = $(this);
    var str_Date = null;
    var end_Date  = null;

  /*
   * 開始日を設定
   */
    if(settings.start){
      var s_Date     = settings.start.split("-");
          str_Date = new Date(s_Date[0],s_Date[1]-1,1);
    }else{
      var sdate = new Date();
      var s_yy  = sdate.getFullYear();
      var s_mm  = sdate.getMonth()+1;
      var s_dd  = sdate.getDate();
          str_Date = new Date(s_yy,s_mm-1,s_dd);
    }

    var y = str_Date.getFullYear();
    var m = str_Date.getMonth()+1;

  /*
   * カレンダー展開
   */
    var Calendar = function(obj,yyyy,mmmm){
        var week = settings.week;
        var html = '';

        for(var i=0; i<settings.roop; i++){
          var sdate = new Date(yyyy,(mmmm-1)+i,1);
          var s_yy  = sdate.getFullYear(); //年
          var s_mm  = sdate.getMonth()+1;  //月
          var blank = sdate.getDay()|0;           //月始めの空白欄数
          var last = lastDay(s_yy,s_mm)|0;        //月末の日
          var cal  = Math.ceil( (blank+last)/7 ); //行数を求める
          var dayOfWeekStr = [ "日", "月", "火", "水", "木", "金", "土" ]

          var table_ID = settings.prefix+''+s_yy+''+s_mm;

            html +='<div>';
            html +='<table class="table">';
            html +='<caption>'+s_yy+'年'+s_mm+'月'+'</caption>'

            html +='<tr>';
            html +='  <th>'+settings.week[0]+'</th>';
            html +='  <th>'+settings.week[1]+'</th>';
            html +='  <th>'+settings.week[2]+'</th>';
            html +='  <th>'+settings.week[3]+'</th>';
            html +='  <th>'+settings.week[4]+'</th>';
            html +='  <th>'+settings.week[5]+'</th>';
            html +='  <th>'+settings.week[6]+'</th>';
            html +='</tr>';

            //settings.prefix   delimiter

            //行数分をループ
              var setDay = 0;
              for(var r = 0; r<cal; r++){
                html +='<tr>';
                //一週間分をループ
                  for(var d=0; d<7; d++){
                    var day = '';
                    if(r==0 && d<blank){
                      day = '';
                    }else{
                      setDay++;
                      if(setDay <= last){
                        day = setDay;
                      }else{
                        day = '';
                      }
                    }
                    if (day == '') {
                      html +='  <td></td>';
                    } else {
                      html +='  <td><label><input type="checkbox" name="date[]" value="'+s_mm+'月'+day+'日（'+dayOfWeekStr[d]+'）"><span>'+day+'</span></label></td>';
                    }
                  }
                html +='</tr>';
              }
            html +='</table>';
            html +='</div>';
        }

        obj.html(html);//HTMLを挿入

    };

  /*
   * 月末を得る
   */
    var lastDay = function(y, m){
      var dt = new Date(y, m, 0);
      return dt.getDate();
    };

    return Calendar($(this),y,m);
  };
})(jQuery);

// カレンダー表示の実行
$(function(){
  function formatDate(dt) {
    let y = dt.getFullYear();
    let m = ('00' + (dt.getMonth()+1)).slice(-2);
    // var d = ('00' + dt.getDate()).slice(-2);
    return (y + '-' + m);
  }
  const now_month = formatDate(new Date());

  $('#js-calender').cehckcalendar({
    'start'     : now_month,
    'week'      : ["日", "月", "火", "水", "木", "金", "土"],
    'roop'      : 12,          //何ヶ月分表示するか
    'delimiter' : '/',        //送信時の日付の区切り文字 yyy/mm/dd
  });

  $('#js-calender').slick({
    infinite: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    prevArrow: '<img src="img/chevron-left.svg" class="slide-arrow prev-arrow" width="24" height="24">',
    nextArrow: '<img src="img/chevron-right.svg" class="slide-arrow next-arrow" width="24" height="24">',
    adaptiveHeight: true,
  });

 });
