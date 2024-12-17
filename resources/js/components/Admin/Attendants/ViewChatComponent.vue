<template>
    <div class="container-fluid px-4 mt-2">
        <div class="card">
            <div class="card-header" style="height: 80px;">
                <div class="row align-items-center h-100">
                    <div class="col text-start">
                        <a type="button" :href="urlMyChats" class="btn btn-secondary btn-sm">Voltar</a>
                    </div>
                    <div class="col text-end">
                        <div class="d-inline-block me-3 text-center">
                            <a class="btn">
                                <i style="color:#87CEFA;" class="bi bi-person-fill-gear h5"></i>
                            </a>
                            <p class="small text-muted mb-0">Transferir</p>
                        </div>
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
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <section v-else class="message-area">
                    <div class="chat-area">
                        <div class="msg-head">
                            <div class="row">
                                <div class="col-md-8 col-sm-12">
                                    <h3 class="protocol">Protocolo: {{ chat.protocol }}</h3>
                                    <p class="client-name">Cliente: {{ clientData.name }}</p>
                                    <p class="client-cpf">
                                        {{ clientData.cpf_cnpj.length > 11 ? 'CNPJ: ' + clientData.cpf_cnpj : 'CPF: ' +
                                            clientData.cpf_cnpj }}
                                    </p>
                                    <p class="client-phone">Telefone: {{ clientData.phone }}</p>
                                </div>
                                <div class="col-md-4 col-sm-12 text-md-end text-center">
                                    <button class="btn btn-sm btn-outline-secondary" @click="endChat">
                                        Finalizar Chat
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="chat-body">
                            <ul>
                                <li v-for="message in chat.messages" :key="message.id"
                                    :class="message.client_id !== null ? 'client-message' : 'attendant-message'">
                                    <div class="message-bubble">
                                        <p>{{ message.message }}</p>
                                        <span class="time">{{ formatDate(message.created_at) }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="send-box">
                            <form @submit.prevent="sendMessage">
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="newMessage"
                                        placeholder="Escreva uma mensagem..." required />
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fa fa-paper-plane" aria-hidden="true"></i> Enviar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
import dayjs from "dayjs";

export default {
    props: {
        chatById: Object,
        urlMyChats: String,
    },
    data() {
        return {
            chat: [],
            messages: [],
            clientData: {
                id: "",
                name: "",
                cpf_cnpj: "",
                phone: "",
            },
            newMessage: "",
            loading: null,
        };
    },
    mounted() {
        this.getMessagesByClient();
    },
    methods: {
        getMessagesByClient() {
            this.chat = this.chatById;
            this.messages = this.chat.messages;
            this.clientData = this.chatById.client;
        },
        formatDate(date) {
            return dayjs(date).format("DD/MM/YYYY HH:mm:ss");
        },
        sendMessage() {
            this.chat.messages.push({
                id: Date.now(),
                message: this.newMessage,
                created_at: new Date(),
                client_id: null,
            });

            axios.post('admin/attendants/send-message/' + this.chat.protocol, {
                message: this.newMessage,
            }).then((response) => {
                this.getMessagesByClient();
            }).catch((error) => {
                console.error('Erro ao enviar mensagem', error.response || error.message);
            });

            this.newMessage = "";
        },
        endChat() {
            alert("Chat finalizado!");
        },
    },
};
</script>
