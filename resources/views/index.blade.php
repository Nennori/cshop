<!DOCTYPE html>
<head>
    <title>Pusher Test</title>
</head>
<body>
<h1>Pusher Test</h1>
<p>
    Publish an event to channel <code>cshop</code>
    with event name <code>my-event</code>; it will appear below:
</p>
<div id="app">
    <ul>
        <li v-for="message in messages">
            {{message}}
        </li>
    </ul>
</div>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('a0c8c28ca70639572a28', {
        cluster: 'ap2'
    });

    var channel = pusher.subscribe('cshop');
    channel.bind('', function(data) {
        app.messages.push(JSON.stringify(data));
    });

    // Vue application
    const app = new Vue({
        el: '#app',
        data: {
            messages: [],
        },
    });
</script>
</body>
