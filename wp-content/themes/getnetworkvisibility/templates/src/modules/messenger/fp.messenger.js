export class FPMessenger{

    constructor(props) {

    }

    broadcast(channelName, data) {

        var channel = new BroadcastChannel(channelName);
        channel.postMessage(data);

    }

    listen(channelName, listener) {
        var channel = new BroadcastChannel(channelName);
        channel.addEventListener('message', (event) =>{
            listener(event);
        })

    }

}

