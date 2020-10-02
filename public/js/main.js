var limit=1;
var counterLimit=-limit;
var nowSend=1;
var lastId=0;
var updateRunning=false;

function createElement(type)
{
   return  document.createElement(type);
}

function getTime(date)
{
    let hours = date.getHours();
    let minutes = date.getMinutes();

    if(minutes<10){
        minutes = '0'+minutes;
    }

    return hours+':'+minutes;
}

function getDate(date)
{
    let arrMonths=['Января','Февраля','Марта','Апреля','Мая','Июня','Июля','Августа','Сентября','Октября','Ноября','Декабря'];
    let now = new Date();
    let day = date.getDate();
    let month = date.getMonth();
    let year = date.getFullYear();

    if(day<10){
        day = '0'+day;
    }

    if(month<10){
        var month0 = '0'+month;
    }

    if(now.getFullYear()==year & now.getMonth()==month & now.getDate()==day)
    {
        return '';
    }else if(now.getFullYear()==year & now.getMonth()==month & (now.getDate()-1)==day)
    {
        return 'Вчера';
    }else if(now.getFullYear()==year)
    {
        return day+' '+arrMonths[month];
    }else
    {
        return day+'.'+month0+'.'+year;
    }
}

$(document).ready(function(){
    $.ajax({
        url: 'show',
        type: 'POST',
        data: {},
        dataType:'json',
            success: function (data) {
                let messageShow = data;
                messageShow.forEach(function (item){
                        userId=item.user.id;
                        var element = document.getElementById('get-first-messages');
                        var div= createElement('div');
                        var userName = createElement('p');
                        var message = createElement('p');
                        var time = createElement('p');
                        var date = createElement('span');
                        var newDate = new Date(item.createdAt);

                                if  (item.user.id  == currentId) {
                                    div.className= "right" ;
                                } else {
                                    div.className= "left";
                                }

                                        userName.className='user-name';
                                        message.className='message';
                                        date.className='date-message';
                                        time.className='time-message';
                                            time.innerHTML=getTime(newDate);
                                            date.innerHTML= getDate(newDate);
                                            userName.innerHTML= item.user.name;
                                            message.innerHTML= item.message;
                                                    element.appendChild(div);
                                                    div.append(userName);
                                                    div.appendChild(message);
                                                    div.appendChild(time);
                                                    time.appendChild(date);
                                                    lastId=item.id;
                    });
            }
    });
});

//Показать еще
$("#link-show-more-messages").on("click",function (){
    counterLimit=counterLimit+limit;
   $.ajax({
    url: 'showMore',
    type: 'POST',
    data: {limit:limit,counterLimit:counterLimit},
    dataType:'json',
       success: function (data) {
           let messages = data;
               if(messages.length==0){
                   $("#link-show-more-messages").addClass('invisible');
               }
           messages.forEach(function (item){
               var element = document.getElementById('get-more-messages');
               var div= createElement('div');
               var userName = createElement('p');
               var message = createElement('p');
               var time = createElement('p');
               var date = createElement('span');
               var newDate = new Date(item.createdAt);

                       if  (item.user.id  == currentId) {
                           div.className= "right" ;
                       } else {
                           div.className= "left";
                       }
                               userName.className='user-name';
                               message.className='message';
                               date.className='date-message';
                               time.className='time-message';
                                       time.innerHTML=getTime(newDate);
                                       date.innerHTML= getDate(newDate);
                                       userName.innerHTML= item.user.name;
                                       message.innerHTML= item.message;
                                               element.insertAdjacentElement('afterBegin', div);
                                               div.append(userName);
                                               div.appendChild(message);
                                               div.appendChild(time);
                                               time.appendChild(date);
           });
       }
    });
});

//Отправка сообщений
$("#message_form_save").on("click",function (){
    var message = $("#message_form_message").val().trim();
    if (message == ""){
    $("#errorMess").text("Введите текст сообщения");
    return false;
    }
    $("#errorMess").text("");
    if (updateRunning === false) {
        updateRunning = true;
        $.ajax({
            url: 'main',
            type: 'POST',
            data: {nowSend: nowSend, message: message},
            dataType: 'json',
            success: function (data) {
                counterLimit++;
                $("#message_form").trigger("reset");
                let message_now_send = data;
                message_now_send.forEach(function (item) {
                    var element = document.getElementById('get-first-messages');
                    var div = createElement('div');
                    var userName = createElement('p');
                    var message = createElement('p');
                    var time = createElement('p');
                    var date = createElement('span');
                    var newDate = new Date(item.createdAt);

                        if (item.user.id == currentId) {
                            div.className = "right";
                        } else {
                            div.className = "left";
                        }

                    userName.className = 'user-name';
                    message.className = 'message';
                    date.className = 'date-message';
                    time.className = 'time-message';
                            time.innerHTML=getTime(newDate);
                            date.innerHTML= getDate(newDate);
                            userName.innerHTML= item.user.name;
                            message.innerHTML= item.message;
                                    element.appendChild(div);
                                    div.append(userName);
                                    div.appendChild(message);
                                    div.appendChild(time);
                                    time.appendChild(date);
                                    lastId = item.id;
                                    updateRunning=false;
                });
            }
        });
    }
});

//Вывод сообщений через период времени
$(document).ready(setInterval(function(){
    if (updateRunning === false) {
        $.ajax({
            url: 'showTimer',
            type: 'POST',
            data: {id: lastId},
            dataType: 'json',
            success: function (data) {
                let messageShowTimer = data;
                messageShowTimer.forEach(function (item) {
                    counterLimit++;
                    var element = document.getElementById('get-first-messages');
                    var div = createElement('div');
                    var userName = createElement('p');
                    var message = createElement('p');
                    var time = createElement('p');
                    var date = createElement('span');
                    var newDate = new Date(item.createdAt);

                        if (item.user.id == currentId) {
                            div.className = "right";
                        } else {
                            div.className = "left";
                        }

                    userName.className = 'user-name';
                    message.className = 'message';
                    date.className = 'date-message';
                    time.className = 'time-message';
                            time.innerHTML=getTime(newDate);
                            date.innerHTML= getDate(newDate);
                            userName.innerHTML= item.user.name;
                            message.innerHTML= item.message;
                                    element.appendChild(div);
                                    div.append(userName);
                                    div.appendChild(message);
                                    div.appendChild(time);
                                    time.appendChild(date);
                                    lastId = item.id;
                });
            }
        });
    }
}, 2000));