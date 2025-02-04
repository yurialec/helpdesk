<template>
    <div class="container-fluid px-4 mt-2">
        <div class="card">
            <div style="height: 80px; margin-left: 25px; margin-right: 25px;">
                <div class="row align-items-center h-100">
                    <div class="col text-start">
                        <a type="button" :href="urlMyChats" class="btn btn-secondary btn-sm">Voltar</a>
                    </div>
                    <div class="col text-end">
                        <div class="d-inline-block text-center">
                            <a class="btn">
                                <i style="color:#87CEFA;" class="bi bi-file-earmark-ruled h5"></i>
                            </a>
                            <p class="small text-muted mb-0">Histórico</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div v-if="loading" class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                    <p class="mt-2">Carregando mensagens...</p>
                </div>
                <section v-else class="message-area">
                    <div class="chat-area">
                        <div class="msg-head">
                            <div class="row">
                                <div class="col-md-8 col-sm-12">
                                    <h3 class="protocol">Protocolo: {{ chat.protocol }}</h3>
                                    <p class="client-name">Cliente: {{ clientData.name }}</p>
                                    <p class="client-cpf">CPF/CNPJ: {{ clientData.cpf_cnpj }}</p>
                                    <p class="client-phone">Telefone: {{ clientData.phone }}</p>
                                </div>
                                <div v-if="isChatFinished" class="col-md-4 col-sm-12 text-md-end text-center">
                                    O chat foi finalizado.
                                </div>
                                <div v-else v-if="userId === chat.user.id"
                                    class="col-md-4 col-sm-12 text-md-end text-center">
                                    <button class="btn btn-sm btn-outline-secondary" @click="endChat">
                                        Finalizar Chat
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="chatBody" ref="chatBody" class="chat-body" style="overflow-y: auto; height: 400px;">
                            <ul>
                                <li v-for="message in messages" :key="message.id"
                                    :class="message.client_id !== null ? 'client-message' : 'attendant-message'">
                                    <div class="message-bubble">
                                        <p>{{ message.message }}</p>
                                        <span class="time">{{ formatDate(message.created_at) }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div v-show="!isChatFinished">
                            <div class="send-box" v-if="userId === chat.user.id">
                                <form @submit.prevent="sendMessage">
                                    <div class="input-group">
                                        <input type="text" class="form-control" v-model="newMessage"
                                            placeholder="Escreva uma mensagem..." required />
                                        <button type="submit" class="btn btn-primary btn-lg"
                                            :disabled="!newMessage.trim()">
                                            <i class="fa fa-paper-plane" aria-hidden="true"></i> Enviar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
import dayjs from "dayjs";
import axios from "axios";

export default {
    props: {
        id: {
            type: Number,
            required: true,
        },
        userId: {
            type: Number,
            required: true,
        },
        urlMyChats: String,
    },
    data() {
        return {
            chat: {},
            messages: [],
            clientData: {},
            newMessage: "",
            loading: true,
        };
    },
    computed: {
        isChatFinished() {
            return this.chat && this.chat.status && this.chat.status.id === 3;
        }
    },
    mounted() {
        this.getChatById();

        window.Echo
            .private("chat." + this.id)
            .listen(".message-sent", (event) => {
                this.messages.push(event.message);
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            });
    },
    methods: {
        getChatById() {
            axios.get(`/admin/chat/get-chat-by-id/${this.id}`)
                .then((response) => {
                    this.$nextTick(() => {
                        this.scrollToBottom();
                    });

                    this.chat = response.data.chatById;
                    this.clientData = response.data.chatById.client;
                    this.messages = response.data.chatById.messages;
                })
                .catch((error) => {
                    console.log("Erro ao carregar o chat:", error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        sendMessage() {
            if (!this.newMessage.trim()) {
                return;
            }

            axios.post(`admin/chat/send-message/${this.chat.protocol}`, {
                message: this.newMessage,
            }).then(() => {
                this.getChatById();
                this.newMessage = "";
                this.scrollToBottom();
            }).catch((error) => {
                console.error("Erro ao enviar mensagem:", error);
            });
        },
        scrollToBottom() {
            this.$nextTick(() => {
                const chatBody = this.$refs.chatBody;
                if (chatBody) {
                    chatBody.scrollTop = chatBody.scrollHeight;
                }
            });
        },
        formatDate(date) {
            return dayjs(date).format("DD/MM/YYYY HH:mm:ss");
        },
        endChat() {
            axios.post(`admin/chat/end/${this.chat.id}`)
                .then((response) => {
                    this.getChatById();
                }).catch((error) => {
                    console.error("Erro ao finalizar o chat:", error);
                });
        },
    },
};
</script>
