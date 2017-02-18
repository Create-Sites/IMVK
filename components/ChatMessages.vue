<template>
    <div class="row">
        <div class="col m8 offset-m2">
            <div id="messages">
                <div class="card-panel"
                     v-for="message in messages">
                    <div>
                        <a :href="'/user/' + from_user.id" target="_blank" v-if="message.folder === 'outbox'"><img :src="'/uploads/avatars/' + from_user.image" alt="" class="circle responsive-img left" width="50" style="margin-right: 10px;"></a>
                        <a :href="'/user/' + for_user.id" target="_blank" v-else><img :src="'/uploads/avatars/' + for_user.image" alt="" class="circle responsive-img left" width="50" style="margin-right: 10px;"></a>
                        <div class="data_message">
                            <a :href="'/user/' + from_user.id" target="_blank" v-if="message.folder === 'outbox'">{{ from_user.name }}</a>
                            <a :href="'/user/' + for_user.id" target="_blank" v-else>{{ for_user.name }}</a>
                            <div class="text">{{ message.text }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col m10 offset-m1">
            <div class="card-panel">
                <a :href="'/user/' + from_user.id" target="_blank"><img :src="'/uploads/avatars/' + from_user.image" alt="" class="circle responsive-img left col m1"></a>
                <form method="POST" class="col m10">
                    <textarea v-model="message_text"
                              rows="5"
                              v-on:keydown="handleCmdEnter($event)"
                              name="text"> </textarea>
                    <button class="blue submit" @click="sendMessage" v-if="message_text.length">
                        Send
                        <small>[Enter]</small>
                    </button>
                </form>
                <a :href="'/user/' + for_user.id" target="_blank"><img :src="'/uploads/avatars/' + for_user.image" alt="" class="circle responsive-img right col m1"></a>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['messages', 'for_user', 'from_user'],

        data() {
            return {
                message_text: ''
            }
        },

        mounted() {
            var self = this;
            var pusher = new Pusher(pusher_key, {cluster: pusher_cluster});
            var channel = pusher.subscribe('message' + this.for_user.id);

            channel.bind('SendIMVKMessage',
                function(data) {
                    self.getMessages(data.for_user.id);

                    jQuery( document ).ready(function($) {
                        $('#messages').append('<div class="card-panel"><div><img src="/uploads/avatars/' + data.from_user.image + '" alt="" class="circle responsive-img left" width="50" style="margin-right: 10px;"><div class="data_message"><a href="/user/' + data.from_user.id +'" target="_blank">' + data.from_user.name + '</a><div class="text">' + data.message.text + '</div></div></div></div>');

                    });
                }
            );

        },

        methods: {
            addMessage (messageId) {
                this.$http.get('/api/im/' + messageId).then(response => {
                    this.messages.unshift(response.data.data)
                })
            },
            getMessages (dialogId) {
                this.$http.get('/api/im/' + dialogId)
            },
            handleCmdEnter (event) {
                if (event.keyCode == 13) {
                    this.sendMessage(event);
                } else if ((event.metaKey || event.ctrlKey) && event.keyCode == 13) {
                    this.newLine();
                }
            },
            newLine() {
                this.message_text += '<br />';
            },
            sendMessage (event) {
                event.preventDefault()

                this.$http.post('/api/im', {text: this.message_text, for_user_id: this.for_user.id, for_user: this.for_user}).then(response => {
                    if(response.data) {
                        this.getMessages(this.for_user.id)
                        this.message_text = ''
                    }
                })
            },
        }

    }
</script>
