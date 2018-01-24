<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">Laravel 5</div>
        <button onclick="send()">send</button>
    </div>
</div>

<script src="/public/scripts/ua/test/autobahn.min.js"></script>
<script>
    var get = new ab.connect(
        'ws://localhost:8080',
        function(session){
            session.subscribe('onNewData',function(topic,data){
                console.info('New data:topic_id: "' + topic + '"');
                console.log(data.data);

            });
        },

        function(code,reason,detail){
            console.warn('WebSocket connection closed: code='+ code + '; reason='+ reason + '; detail='+detail);
        },
        {
            'marRetries': 60,
            'retryDelay': 4000,
            'skipSubprotocolCheck': true
        }
    );


    var send = new WebSocket('ws://localhost:8080');
    send.onopen = function (e) {
        console.log('Connection established!');
    };

    send.onmessage = function (e) {
        console.log('data resive: ' + e.data);
    };

    function send() {
        var data = 'Data for send: ' + Math.random();
        send.send(data);
        console.log('Sent: ' + data);
    }

</script>

</body>
</html>