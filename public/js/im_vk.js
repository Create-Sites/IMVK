module.exports = {

    data() {
        return {
            chats: [],
            newMsg: '',
        }
    },

    ready() {
        Echo.channel('public-im-room.' + room)
            .listen('SendIMVKMessage', (data) => {

                // Push data to chats list.
                this.chats.push({
                    message: data.chat.text,
                    user: data.user,
                    room: data.room
                });
            });
    },

    methods: {

        press() {

            // Send message to backend.
            this.$http.post('/im/' + room, {message: this.newMsg})
                .then((response) => {

                    // Clear input field.
                    this.newMsg = '';
                });
        }
    }
};