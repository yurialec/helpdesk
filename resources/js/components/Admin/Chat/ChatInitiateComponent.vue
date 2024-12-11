<template>
    <div class="container-fluid px-4 mt-2">
        <div class="card">
            <div class="card-header" style="height: 80px;">
                <div class="row align-items-center h-100">
                    <div class="col-12 col-md-8 text-md-start text-center">
                        <h3 class="mb-0">Iniciar Chat</h3>
                    </div>
                    <div
                        class="col-12 col-md-4 text-md-end text-center d-flex justify-content-md-end justify-content-center gap-3">
                        <div class="text-center">
                            <a class="btn">
                                <i style="color:#87CEFA;" class="bi bi-person-fill-gear h3"></i>
                            </a>
                            <p class="small text-muted mb-0">Transferir</p>
                        </div>
                        <div class="text-center">
                            <a class="btn">
                                <i style="color:#87CEFA;" class="bi bi-file-earmark-ruled h3"></i>
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
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="chat-area">
                                    <!-- Chat Header -->
                                    <div class="msg-head">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 ms-3">
                                                        <h3>{{ clientData.name }}</h3>
                                                        <p>
                                                            {{ clientData.cpf_cnpj.length > 11 ? 'CNPJ: ' +
                                                                clientData.cpf_cnpj : 'CPF: ' + clientData.cpf_cnpj }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <button class="btn btn-sm btn-outline-secondary" @click="endChat">
                                                    Finalizar Chat
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-body">
                                        <div class="msg-body">
                                            <ul>
                                                <li v-for="message in chat.messages" :key="message.id" :class="{
                                                    sender: message.client_id === clientData.id,
                                                    repaly: !message.client_id
                                                }">
                                                    <p>{{ message.message }}</p>
                                                    <span class="time">{{ formatDate(message.created_at) }}</span>
                                                </li>
                                            </ul>
                                        </div>
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
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary btn-sm mt-2"
                                onclick="window.history.back();">
                                Voltar
                            </button>
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
    },
    data() {
        return {
            chat: [],
            clientData: {
                id: "",
                name: "",
                cpf_cnpj: "",
                phone: "",
            },
            newMessage: "", // Campo para nova mensagem
            loading: null,
        };
    },
    mounted() {
        this.getMessagesByClient();
    },
    methods: {
        getMessagesByClient() {
            this.chat = this.chatById;
            this.clientData = this.chatById.client;
        },
        formatDate(date) {
            return dayjs(date).format("DD/MM/YYYY HH:mm:ss");
        },
        sendMessage() {
            if (this.newMessage.trim()) {
                // Adiciona a nova mensagem ao array (mock)
                this.chat.messages.push({
                    id: Date.now(), // Mock para ID
                    message: this.newMessage,
                    created_at: new Date(),
                    client_id: null, // Representa a mensagem do atendente
                });

                // Limpa o campo de mensagem
                this.newMessage = "";
            }
        },
        endChat() {
            alert("Chat finalizado!");
        },
    },
};
</script>
