if (!window.WebSocket){
    alert("Ваш браузер неподдерживает веб-сокеты!");
}

var webSocket = new WebSocket("ws://front.yii2:8080");

document.getElementById("chat_form")
    .addEventListener('submit', function(event){
        var textMessage = this.message.value;
        webSocket.send(textMessage);
        event.preventDefault();
        return false;
    });

webSocket.onmessage = function (event) {
    var data = event.data;
    var messageContainer = document.createElement('div');
    var textNode = document.createTextNode(data);
    messageContainer.appendChild(textNode);
    document.getElementById("root_chat")
        .appendChild(messageContainer);
};