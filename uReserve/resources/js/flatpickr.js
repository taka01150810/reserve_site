import flatpickr from "flatpickr";

flatpickr("#event_date", {});

//日本語設定
import { Japanese } from "flatpickr/dist/l10n/ja.js"

flatpickr("#event_date", { locale : Japanese, minDate: "today",//今日以降
maxDate: new Date().fp_incr(30)//30日間表示
});

flatpickr("#calendar", {
    locale : Japanese, 
    // minDate: "today",//今日以降 //過去も表示できるようにする
    maxDate: new Date().fp_incr(30)//30日間表示
});

// 時間表示、カレンダー非表示、24時間表記
const setting = {
 "locale" : Japanese,
 enableTime: true, noCalendar: true, dateFormat: "H:i", time_24hr: true,
 minTime: "10:00", maxTime: "20:00", minuteIncrement : 30,//30分単位
}

flatpickr("#start_time", setting);
flatpickr("#end_time", setting); 